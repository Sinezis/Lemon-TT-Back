<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\AttendingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/attending', name: 'attending_')]
class AttendingController extends AbstractController
{
    private $attendingManager;
    private $security;

    public function __construct(
        AttendingService $manager,
        Security $security
    ) {
        $this->attendingManager = $manager;
        $this->security = $security;
    }

    #[Route(path: '/{id}/yes', name: 'yes')]
    public function attending(
        Event $event,
    )
    {
        $this->attendingManager->execute($event, $this->security->getUser(), true);

        return $this->redirectToRoute('app_home');
    }

    #[Route(path: '/{id}/no', name: 'no')]
    public function unattending(
        Event $event,
    )
    {
        $this->attendingManager->execute($event, $this->security->getUser(), false);

        return $this->redirectToRoute('app_home');
    }
}