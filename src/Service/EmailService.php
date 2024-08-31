<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private UserRepository $userRepository;
    private MailerInterface $mailer;

    public function __construct(UserRepository $userRepository, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function sendEmails(string $subject, string $message, array $categories): void
    {
        $users = $this->userRepository->findByCategories($categories);

        foreach ($users as $user) {
            $email = (new Email())
                ->from('no-reply@test.com')
                ->to($user->getEmail())
                ->subject($subject)
                ->text($message);

            $this->mailer->send($email);
        }
    }
}
