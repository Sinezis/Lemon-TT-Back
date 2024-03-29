<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AttendingService {
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function execute(
        Event $event, 
        User $user,
        bool $attending
    )
    {
        if ($attending)
            $this->addToGuests($event, $user);
        else
            $this->removeFromGuests($event, $user);

        return;
    }

    private function addToGuests()
    {
        //Bidirectionnal relation => i add to both event and user
        $event->addAttendee($user);

        $user->addAttending($event);

        $this->entityManager->persist($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }

    private function removeFromGuests()
    {
        //Bidirectionnal relation => i remove from both event and user
        $event->removeAttendee($user);

        $user->removeAttending($event);

        $this->entityManager->persist($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}