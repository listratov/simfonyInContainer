<?php
namespace App\Controller;

use App\Entity\Teams;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TeamsActionController extends AbstractController
{

    #[Route('/teams/add',
        name:  'addTeams')
    ]
    public function addTeam(EntityManagerInterface $em, Request $request): Response
    {
        $team = new Teams();
        $name = $request->request->get('name');

        if(null != $name) {
            try{
                $team->setName($name);
                $team->setDate(new \DateTime('now', new \DateTimeZone('Europe/Moscow')));
                $em->persist($team);
                $em->flush();
            }catch (\Throwable $throwable) {
                echo $throwable->getMessage();
            }
        }

        return $this->redirectToRoute('teams');
    }

    /**
     * @throws RandomException
     */
    #[Route('/teams/del',
        name:  'delTeams')
    ]
    public function deleteTeam(EntityManagerInterface $em, Request $request): Response
    {
        $id = $request->request->get('key');
        $team = $em->find(Teams::class, $id);

        try {
        if(null !=$team) {
            $em->remove($team);
            $em->flush();
        }
        }catch (\Throwable $throwable) {
            echo (new TeamsException($throwable))->sendAlert('Нельзя удалить команду учавствующую в турнире');
            die();
        }

        return $this->redirectToRoute('teams');
    }
}
