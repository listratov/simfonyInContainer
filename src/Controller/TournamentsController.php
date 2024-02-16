<?php
namespace App\Controller;

use App\Entity\Tournaments;
use App\Entity\TournamentsTeams;
use App\Repository\TournamentsTeamsRepository;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentsController extends AbstractController
{
    #[Route('/tournaments', name: 'showTournaments')]
    public function showTournaments(EntityManagerInterface $em): Response
    {
        /** @var Tournaments $teams */
        $tournaments = $em->getRepository(Tournaments::class)->findAll(); // TODO by date

        foreach ($tournaments as $item) {
            $data = $item->getDate() ? $item->getDate()->format('Y-m-d H:i') : '';
            $tourname[$item->getId()] = $item->getName() . '  ' . $data ;
        }

        return $this->render('tournaments.html.twig', [
            'tournaments' => $tourname ?? []
        ]);
    }

    #[NoReturn] #[Route('/tournaments/{slug}/', name: 'definiteTournaments')]
    public function showTournamentsDefinite(string $slug,
                                            TournamentsTeamsRepository $tmr,
                                            ManagerRegistry $doctrine,
                                            Request $request
                                            ): Response
    {
            if(!$id = $request->request->get('key')) {
                $trn = $doctrine->getRepository(Tournaments::class)
                    ->findOneBy(['name' => $slug]);
                if(!$trn)
                    throw new Exception('Турнир не найден');
                $id = $trn->getId();
            }

        $tr = $tmr->findBy(['tournaments'=>$id]);
        $tr_name = '';

        /** @var TournamentsTeams $item */
        foreach ($tr as $item) {

            try{
                $commands =  $item->getTeamsId()->getName() . ' vs ' . $item->getTeamsId2()->getName();
            }
            catch (\Exception){
                $commands = 'Турнир отклонен из-за удаления команды.';
            }
            $tr_name = $item->getTournaments()->getName() ?? '';
            $comand[] = $commands . ' ' . $item->getDate()->format('Y-m-d H:i');
        }

        return $this->render('tournament.html.twig', [
            'tr_name' => $tr_name,
            'teams' => $comand ?? [],
        ]);
    }
}
