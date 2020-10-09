<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/mon-compte", name="user_account")
     */
    public function user_account()
    {
        return $this->render('movie_book/account/user_account.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/mettre-a-jour-mon-profil", name="user_profile")
     */
    public function user_profile()
    {
        return $this->render('movie_book/account/user_profile.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/inscription", name="sign_up")
     */
    public function sign_up()
    {
        return $this->render('movie_book/security/sign-up.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function login()
    {
        return $this->render('movie_book/security/login.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/mot-de-passe-oublie", name="forgot_password")
     */
    public function reset_password()
    {
        return $this->render('movie_book/security/forgot_password.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }
}
