<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    //instanciation du contructeur doctrine entitymanager
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }
    
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request,UserPasswordHasherInterface $encoder): Response
    {
        /*instanciation class user */
        $user = new User();
        /*instanciation du formulaire */
        $form = $this->createForm(RegisterType::class,$user);

        /*injection de dependance request pour mettre le code front dans le form */
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            //passage du form dans la var user
            $user = $form->getData();
            //encodage du password
            $password = $encoder->hashPassword($user,$user->getPassword());
            //reinjection du mdp hasher dans l'objet user
            $user->setPassword($password);
            //appel de doctrine
            
            // persist l'objet via doctrine
            $this->entityManager->persist($user);
            //met en db
            $this->entityManager->flush();
            //log de user
            //dd($user);
            
        } 

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
