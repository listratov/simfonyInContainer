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
            $tourname[$item->getId()] = $item->getName() . '  ' . $data;
        }

        return $this->render('tournaments/tournaments.html.twig', [
            'tournaments' => $tourname ?? []
        ]);
    }

    #[NoReturn] #[Route('/tournaments/{slug}/', name: 'definiteTournaments')]
    public function showTournamentsDefinite(string                     $slug,
                                            TournamentsTeamsRepository $tmr,
                                            ManagerRegistry            $doctrine,
                                            Request                    $request
    ): Response
    {

        $trn = $doctrine->getRepository(Tournaments::class)->findOneBy(['slug' => $slug]);

        if (!$trn)
            throw new Exception('Турнир не найден');

        $tr = $tmr->findBy(['tournaments' => $trn->getId()]);
        $tr_name = '';

        /** @var TournamentsTeams $item */
        foreach ($tr as $item) {

            $id =$item->getId();
            $tr_name = $item->getTournaments()->getName() ?? '';
            $comand[$id]['id_1'] = $item->getTeam()->getId();
            $comand[$id]['id_2'] = $item->getTeam2()->getId();
            $comand[$id]['name1'] = $item->getTeam()->getName();
            $comand[$id]['name2'] = $item->getTeam2()->getName();
            $comand[$id]['date'] = $item->getDate()->format('Y-m-d H:i');
        }

        return $this->render('tournaments/tournament.html.twig', [
            'tr_name' => $tr_name,
            'teams' => $comand ?? [],
        ]);
    }
}
