<?php

namespace App\Controller;

use App\Entity\TeamsCard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamsCardController extends AbstractController
{
    #[Route('/teams/{slug}', 'teams_card')]
    public function showTeam(string $slug, EntityManagerInterface $em, Request $request): Response
    {
        /** @var TeamsCard $teams */
        $teams = $em->getRepository(TeamsCard::class)->find($slug);

        if(!$teams)
            return $this->render('teams/validation.html.twig', [
                'errors' => [
                    'error' => [
                        'message' => 'Команда не найдена']
                ]
            ]);

        return $this->render('teams/teams_card.html.twig', [
            'name' => $teams->getName(),
            'desc' => $teams->getDescription() ?? '',
        ]);
    }
}
