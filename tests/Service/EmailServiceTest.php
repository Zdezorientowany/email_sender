<?php

namespace App\Tests\Service;

use App\Service\EmailService;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\User;

class EmailServiceTest extends TestCase
{
    public function testSendEmails()
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $mailerMock = $this->createMock(MailerInterface::class);

        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john.doe@example.com');

        $userRepositoryMock->method('findByCategories')
            ->willReturn([$user]);

        $mailerMock->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email) {
                return $email->getTo()[0]->getAddress() === 'john.doe@example.com';
            }));

        $emailService = new EmailService($userRepositoryMock, $mailerMock);
        $emailService->sendEmails('Test Subject', 'Test Message', ['Users']);
    }
}
