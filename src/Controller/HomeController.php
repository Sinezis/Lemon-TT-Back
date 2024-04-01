<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Service\MyListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route(path: '/', name: 'app_home')]
    public function home(
        Request $request,
        EntityManagerInterface $entityManager,
        EventRepository $eventRepo,
    ): Response
    {
        $user = $this->security->getUser();

        if (isset($_GET['startDate']) && isset($_GET['endDate'])){
            if (($_GET['startDate'] !== "") && ($_GET['endDate'] !== "")) {
                $events = $eventRepo->findUpcoming($_GET['startDate'], $_GET['endDate']);
            } else {
                $events = $eventRepo->findUpcoming();
            }
        } else {
            $events = $eventRepo->findUpcoming();
        }
        
        return $this->render('home/index.html.twig', [
            'events' => $events,
            'user' => $user
        ]);
    }

    #[Route(path: '/mylist', name: 'my_list')]
    public function myList(
        Request $request,
        MyListService $service,
    ): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->security->getUser();
        $eventsCreated = $service->getUserEvents($user);
        $eventsAttending = $user->getAttending();

        return $this->render('mylist/list.html.twig', [
            'eventsAttending' => $eventsAttending,
            'eventsCreated' => $eventsCreated
        ]);
    }
}
