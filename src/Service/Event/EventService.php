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

        // Throw error if start date is before now
        if ($event->getStartDate() < $now) {
            $return['status'] = 'ko';
            $return['message'] = "La date de départ ne peut pas être antérieure à la date actuelle.";
            return $return;
        }
        // Throw error if end date is before start date
        if ($event->getEndDate() < $event->getStartDate()) {
            $return['status'] = 'ko';
            $return['message'] = "La date de fin ne peut pas être antérieure à la date de départ.";
            return $return;
        }

        // Set the creator and the creation time 
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setCreatedBy($user);
        $event->addAttendee($user);

        $user->addAttending($event);

        // Throw error if the event isn't saved in the DB
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

        // Throw exception if start date is before now
        if ($event->getStartDate() < $now) {
            throw new \Exception("La date de départ ne peut pas être antérieure à la date actuelle");
        }

        // Throw exception if end date is before start date
        if ($event->getEndDate() > $event->getStartDate()) {
            throw new \Exception("La date de fin ne peut pas être antérieure à la date de départ");
        }

        // Throw exception if the event isn't saved in the DB
        try {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("L'événement n'a pas pu être sauvegardé. Veuillez réessayer.");
        }

        return true;
    }

    public function delete(
        Event $event
    ) {
        try {
            $this->entityManager->remove($event);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("L'événement n'a pas pu être supprimé. Veuillez réessayer.");
        }

        return true;
    }
}