<?php declare(strict_types=1);
use App\Entity\Event;
use PHPUnit\Framework\TestCase;

final class EventTest extends TestCase
{
    public function testCreation() {
        $now = new \DateTimeImmutable();
        $start = new \DateTime();
        $start->setDate(2024, 01, 01)->setTime(0, 0);
        $end = new \DateTime();
        $end->setDate(2024, 12, 31)->setTime(23, 59);
        
        $title = "TestTitle";
        $description = "TestDescription";
        $location = "TestLocation";

        $event = new Event;

        $event->setTitle($title);
        $event->setDescription($description);
        $event->setLocation($location);
        $event->setStartDate($start);
        $event->setEndDate($end);
        $event->setCreatedAt($now);

        $this->assertSame($title, $event->getTitle());
        $this->assertSame($description, $event->getDescription());
        $this->assertSame($location, $event->getLocation());
        $this->assertSame($start, $event->getStartDate());
        $this->assertSame($end, $event->getEndDate());
        $this->assertSame($now, $event->getCreatedAt());
    }
}

?>