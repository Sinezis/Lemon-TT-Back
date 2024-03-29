<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Service\EventCreationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/event', name: 'event_')]
class EventController extends AbstractController
{
    private $eventCreator;
    private $security;

    public function __construct(
        EventCreationService $creator,
        Security $security
    ) {
        $this->eventCreator = $creator;
        $this->security = $security;
    }

    #[Route(path: '/new', name: 'new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_login');
        }

        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventCreator->create($form, $this->security->getUser());

            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }
}