<?php

namespace App\Controller\Controller;

use App\Entity\Email;
use App\Enum\FlashEnum;
use App\Form\Form\MailListFormType;
use App\Repository\EmailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailListController extends AbstractController
{
    public function __construct(
        private readonly EmailRepository $emailRepository
    )
    {
    }

    #[Route('/create/mailing', name: 'mailing_list_form')]
    public function create(Request $request): Response
    {
        $email = new Email();
        $emailForm = $this->createForm(MailListFormType::class, $email);

        $emailForm->handleRequest($request);
        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $email = $this->emailRepository->findOneBy([
                'address' => $email->getAddress(),
            ]);
            $isEmailAlreadyOnList = $this->emailRepository->findOneBy([
                'address' => $emailForm->get('address')->getData(),
            ]);

            if ($isEmailAlreadyOnList instanceof Email) {
                return $this->render('partial/_message.html.twig', [
                    'type' => FlashEnum::ERROR->value,
                    'message' => 'Hmmm, something went wrong',
                ]);
            } else {
                $this->emailRepository->save(entity: $email, flush: true);
                return $this->render('partial/_message.html.twig', [
                    'type' => FlashEnum::MESSAGE->value,
                    'message' => 'successfully added to the mailing list',
                ]);
            }

        }

        return $this->render('email/create.html.twig', [
            'emailForm' => $emailForm,
        ]);

    }
}