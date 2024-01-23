<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ComptePasswordController extends AbstractController
{

    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
    }


    #[Route('/compte/modifier-mypassword', name: 'app_change_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->CreateForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $old_mdp = $form->get('old_mdp')->getData();

            if($encoder->isPasswordValid($user, $old_mdp)){
                $new_mdp = $form->get('new_mdp')->getData();
                $password = $encoder->hashPassword($user, $new_mdp);
                $user->setPassword($password);
                

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre mot de passe à bien été mise a jour";
            }else{
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('compte/changePassword.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
