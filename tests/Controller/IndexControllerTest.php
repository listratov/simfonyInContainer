<?php

namespace App\Tests\Controller;

use AllowDynamicProperties;
use App\Controller\IndexController;
use App\Controller\TeamsController;
use App\Controller\TournamentsController;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

#[AllowDynamicProperties] class IndexControllerTest extends TestCase
{
    protected EntityManagerInterface $em;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
    }

    public function testIndexResponse()
    {
        $indexController = $this->createMock(IndexController::class);
        $response = $indexController->AllTournaments($this->em);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testTeamsResponse()
    {
        $teamsController = $this->createMock(TeamsController::class);
        $response = $teamsController->showTeams($this->em);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testTournamentsResponse()
    {
        $tournamentsController = $this->createMock(TournamentsController::class);
        $response = $tournamentsController->showTournaments($this->em);

        $this->assertInstanceOf(Response::class, $response);
    }
}
