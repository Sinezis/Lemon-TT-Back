<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/home', name: 'app_home')]
    public function home(
        Request $request,
        EntityManagerInterface $entityManager,
        EventRepository $eventRepo,
    ): Response
    {
        $events = $eventRepo->findUpcoming();
        return $this->render('home/index.html.twig', [
            'events'=>$events
        ]);
    }
}
