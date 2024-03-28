<?php declare(strict_types=1);
use App\Entity\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testCreation() {
        $firstName = "TestFirstName";
        $lastName = "TestLastName";
        $email = "test@mail.com";

        $user = new User;

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);

        $this->assertSame($firstName, $user->getFirstname());
        $this->assertSame($lastName, $user->getLastName());
        $this->assertSame($email, $user->getEmail());
    }
}

?>