<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/event', name: 'event_')]
class EventController extends AbstractController
{
    private $eventManager;
    private $security;

    public function __construct(
        EventService $manager,
        Security $security
    ) {
        $this->eventManager = $manager;
        $this->security = $security;
    }

    #[Route(path: '/new', name: 'new')]
    public function new(
        Request $request,
    ): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_login');
        }

        $error = null;
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $check = $this->eventManager->create($form, $this->security->getUser());

            if ($check['status'] != 'ok') {
                $error = $check['message'];
            } else {
                return $this->redirectToRoute('app_home');
            }
        }
        
        return $this->render('event/create.html.twig', [
            'form' => $form,
            'error' => $error
        ]);
    }

    #[Route(path: '/update/{id}', name: 'update')]
    public function update(
        Request $request,
        Event $event,
    ): Response
    {
        if ($event->getCreatedBy() != $this->security->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = null;
        $form = $this->createForm(EventFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $check = $this->eventManager->update($form, $this->security->getUser(), $event);

            if ($check['status'] != 'ok') {
                $error = $check['message'];
            } else {
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('event/update.html.twig', [
            'form' => $form,
            'error' => $error
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'delete')]
    public function delete(
        Request $request,
        Event $event,
    ): Response
    {
        if ($event->getCreatedBy() != $this->security->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        
        $this->eventManager->delete($event);

        return $this->redirectToRoute('app_home');
    }
}