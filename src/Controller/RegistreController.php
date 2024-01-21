<?php

namespace App\Controller;
use App\Form\RegistreType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistreController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
    }


    #[Route('/inscription', name: 'app_registre')]
    public function index(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(RegistreType::class, $user);

        $form -> handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->render('registre/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
