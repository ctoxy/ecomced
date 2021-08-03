<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;




class AccountPasswordController extends AbstractController
{
    //instanciation du contructeur doctrine entitymanager
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }
    
    /**
     * @Route("/account/password", name="account_password")
     */
    public function index(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        //notification
        $notification = null;
        /*instanciation DE L UTLISATEUR COURrant*/
        $user = $this->getUser();
        /*instanciation du formulaire */
        $form = $this->createForm(ChangePasswordType::class,$user);

        /*injection de dependance request pour mettre le code front dans le form */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            //recupération du mdp saisi par l utlisateur dans le form modifier mdp
            $old_password = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_password)) {
                // mise en place en var new pwd du mdp saisi par le user
                $new_pwd = $form->get('new_password')->getData();
                //mise a jour du mdp dans l'objet user et hasher
                $password = $encoder->hashPassword($user, $new_pwd);
                $user->setPassword($password);
                
                //met en db pas de persist car update de l objet
                $this->entityManager->flush();
                // mise a jour notif
                $notification ='Votre mdp a été mis a jour';
            } else {
                $notification = "votre mdp actuel n'est pas le bon";
            }
        } 

        
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
