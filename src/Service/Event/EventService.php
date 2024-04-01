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
        $return = [
            'status' => 'ok',
            'message' => ''
        ];

        $event = new Event();
        $event = $form->getData();

        $now = new \DateTime();

        if ($event->getStartDate() < $event) {
            $return['status'] = 'ko';
            $return['message'] = "La date de départ ne peut pas être antérieure à la date actuelle.";
            return $return;
        }
        if ($event->getEndDate() > $event->getStartDate()) {
            $return['status'] = 'ko';
            $return['message'] = "La date de fin ne peut pas être antérieure à la date de départ.";
            return $return;
        }

        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setCreatedBy($user);
        $event->addAttendee($user);

        $user->addAttending($event);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (Exception $e) {
            $return['status'] = 'ko';
            $return['message'] = "L'événement n'a pas pu être sauvegardé. Veuillez réessayer.";
            return $return;
        }

        return $return;
    }

    public function update(
        FormInterface $form,
        User $user,
        Event $event
    ) {
        $event = $form->getData();

        $now = new \DateTime();

        if ($event->getStartDate() < $event) {
            throw new \Exception("La date de départ ne peut pas être antérieure à la date actuelle");
        }
        if ($event->getEndDate() > $event->getStartDate()) {
            throw new \Exception("La date de fin ne peut pas être antérieure à la date de départ");
        }

        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new Exception("L'événement n'a pas pu être sauvegardé. Veuillez réessayer.");
        }

        return true;
    }

    public function delete(
        Event $event
    ) {
        try {
            $this->entityManager->remove($event);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new Exception("L'événement n'a pas pu être supprimé. Veuillez réessayer.");
        }

        return true;
    }
}