<?php

namespace App\Controller;

use App\Request\EmailRequest;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmailController extends AbstractController
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/send-email', name: 'send_email', methods: ['POST'])]
    public function sendEmail(Request $request, ValidatorInterface $validator): Response
    {
        $emailRequest = new EmailRequest();
        $emailRequest->setSubject($request->request->get('subject'));
        $emailRequest->setMessage($request->request->get('message'));
        $emailRequest->setCategories($request->request->all('categories'));

        // Walidacja danych
        $errors = $validator->validate($emailRequest);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new Response(implode("\n", $errorMessages), Response::HTTP_BAD_REQUEST);
        }

        // Wysłanie e-maili
        $this->emailService->sendEmails(
            $emailRequest->getSubject(),
            $emailRequest->getMessage(),
            $emailRequest->getCategories()
        );

        return new Response('Emails sent successfully!');
    }
}
