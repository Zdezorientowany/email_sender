<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class EmailService
{
    public function __construct(
        private UserRepository $userRepository, 
        private MailerInterface $mailer,
    ){
        //
    }

 public function sendEmails(string $subject, string $message, array $categories): void
    {
        $users = $this->userRepository->findByCategories($categories);

        foreach ($users as $user) {
            $fullName = $user->getFullName();
            
            $email = (new TemplatedEmail())
                ->from('no-reply@test.com')
                ->to($user->getEmail())
                ->subject($subject)
                ->htmlTemplate('email/email_template.html.twig')
                ->context([
                    'subject' => $subject,
                    'message' => $message,
                    'fullName' => $fullName,
                ]);

            $this->mailer->send($email);
        }
    }
}
