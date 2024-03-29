<?php

namespace App\Controller;

use App\Entity\Teams;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamsController extends AbstractController
{
    #[Route('/teams', 'teams')]
    public function showTeams(EntityManagerInterface $em): Response
    {
        /** @var Teams $teams */
        $teams = $em->getRepository(Teams::class)->findAll();

        foreach ($teams as $item) {
            $comand[$item->getId()] = $item->getName();
        }

        return $this->render('teams/teams.html.twig', [
            'teams' => $comand ?? [],
        ]);
    }
}
