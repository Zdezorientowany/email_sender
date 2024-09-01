<?php

namespace App\Controller;

use App\Request\EmailRequest;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\CategoryRepository;

class EmailController extends AbstractController
{
    public function __construct(
        private EmailService $emailService, 
        private CategoryRepository $categoryRepository
    ){
        //
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('email/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/send-email', name: 'send_email', methods: ['POST'])]
    public function sendEmail(Request $request, ValidatorInterface $validator): Response
    {
        $emailRequest = new EmailRequest();
        $emailRequest->setSubject($request->request->get('subject'));
        $emailRequest->setMessage($request->request->get('message'));
        $emailRequest->setCategories($request->request->all('categories'));

        $errors = $validator->validate($emailRequest);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            $categories = $this->categoryRepository->findAll();

            return $this->render('email/index.html.twig', [
                'categories' => $categories,
                'errors' => $errorMessages,
            ]);
        }

        $this->emailService->sendEmails(
            $emailRequest->getSubject(),
            $emailRequest->getMessage(),
            $emailRequest->getCategories()
        );

        $this->addFlash('success', 'Emails sent successfully!');
        
        return $this->redirectToRoute('index');
    }

}
