<?php

namespace App\Controller;


use App\Entity\Teams;
use App\Entity\Tournaments;
use App\Entity\TournamentsTeams;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TournamentsActionController extends AbstractController
{

    /**
     * @throws \Exception
     */
    #[Route('/tournaments/add', name: 'addTournirs')]
    public function addTournirs(EntityManagerInterface $em, Request $request, ValidatorInterface $validator): Response
    {
        $tournaments = new Tournaments();
        $name = $request->request->get('name');
        $tournaments->setName($name);
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($name)->lower();
        $tournaments->setSlug($slug);
        $tournaments->setDate(new \DateTime('now', new \DateTimeZone('Europe/Moscow')));
        $errors = $validator->validate($tournaments);

        if (count($errors) > 0) {
            return $this->render('tournaments/validation.html.twig', [
                'errors' => $errors,
            ]);

        }
        $em->persist($tournaments);
        $em->flush();

        /** @var Teams $teams */
        $teams = $em->getRepository(Teams::class)->findAll();

        $i = 0;

        foreach ($teams as $teamsId) {
            $t = 0;
            unset($teams[$i]);

            foreach ($teams as $teamsId2) {
                $t++;
                $tournamentsTeams = new TournamentsTeams();
                $tournamentsTeams->setTournamentsId($tournaments);
                $tournamentsTeams->addTeamsId($teamsId);
                $tournamentsTeams->setTeamsId2($teamsId2);
                $datetime = new \DateTime("now +{$t} day", new \DateTimeZone('Europe/Moscow'));
                $tournamentsTeams->setDate($datetime);
                $em->persist($tournamentsTeams);
                $em->flush($tournamentsTeams);
            }

            $i++;
        }
        return $this->redirectToRoute('showTournaments');
    }

    #[Route('/tournaments/del', name: 'delTournirs')]
    public function delTournirs(EntityManagerInterface $em, Request $request): Response
    {
        $id = $request->request->get('key');
        $team = $em->find(Tournaments::class, $id);

        if (null != $team) {
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('showTournaments');
    }
}
