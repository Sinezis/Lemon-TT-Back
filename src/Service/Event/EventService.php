<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class EventService {
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function create(
        FormInterface $form,
        User $user
    ) {
        $event = new Event();
        $event = $form->getData();

        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setCreatedBy($user);

        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new Exception("L'événement n'a pas pu être sauvegardé. Veuillez réessayer.");
        }

        return true;
    }

    public function update(
        FormInterface $form,
        User $user,
        Event $event
    ) {
        $event = $form->getData();

        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new Exception("L'événement n'a pas pu être sauvegardé. Veuillez réessayer.");
        }

        return true;
    }
}