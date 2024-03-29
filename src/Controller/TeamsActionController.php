<?php

namespace App\Controller;

use App\Entity\Teams;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TeamsActionController extends AbstractController
{

    #[Route('/teams/add',
        name: 'addTeams')
    ]
    public function addTeam(EntityManagerInterface $em, Request $request, ValidatorInterface $validator): Response
    {
        $team = new Teams();
        $name = trim($request->request->get('name'));

        $team->setName($name . PHP_EOL);
        $team->setDate(new \DateTime('now', new \DateTimeZone('Europe/Moscow')));

        $errors = $validator->validate($team);

        if (count($errors) > 0) {
            return $this->render('teams/validation.html.twig', [
                'errors' => $errors,
            ]);
        }

        $em->persist($team);
        $em->flush();

        return $this->redirectToRoute('teams');
    }

    #[Route('/teams/del',
        name: 'delTeams')
    ]
    public function deleteTeam(EntityManagerInterface $em,
                               Request                $request,
                               TranslatorInterface    $translator): Response
    {
        $id = $request->request->get('key');
        $team = $em->find(Teams::class, $id);

        try {
            if (null != $team) {
                $em->remove($team);
                $em->flush();
            }
        } catch (\Throwable $throwable) {

            return $this->render('teams/validation.html.twig', [
                'errors' => [
                    'error' => [
                        'message' => 'Нельзя удалить команду учавствующую в турнире']
                    ]
            ]);
//            echo (new TeamsException($throwable))->sendAlert();
        }

        return $this->redirectToRoute('teams');
    }
}
