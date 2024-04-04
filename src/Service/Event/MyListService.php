<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\User;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class MyListService {
    private $eventRepo;

    public function __construct(
        EventRepository $eventRepo
    ) {
        $this->eventRepo = $eventRepo;
    }

    public function getUserEvents(
        User $user
    ) {
        $events = $this->eventRepo->findByCreatedBy($user);

        return $events;
    }

    public function update(
        FormInterface $form,
        User $user,
        Event $event
    ) {
        $return = [
            'status' => 'ok',
            'message' => ''
        ];

        $event = $form->getData();

        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $return['status'] = 'ko';
            $return['message'] = "L'événement n'a pas pu être sauvegardé, veuillez réessayer.";
            return $return;
        }

        return true;
    }
}