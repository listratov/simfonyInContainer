<?php

namespace App\Controller;

use App\Entity\Tournaments;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController  extends AbstractController
{
    #[Route('/')]
    function AllTournaments(EntityManagerInterface $em): Response
    {
        /** @var Tournaments $teams */
        $tournaments = $em->getRepository(Tournaments::class)->findAll();

        foreach ($tournaments as $item) {
            $tournament[$item->getId()] =  $item->getName();
        }

        return $this->render('tournaments_all.html.twig', [
            'tournaments' => $tournament ?? [],
        ]);
    }
}
