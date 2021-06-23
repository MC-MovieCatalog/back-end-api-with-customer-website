<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/paramètres", name="user_account")
     */
    public function user_account()
    {
        return $this->render('movie_catalog/account/user_account.html.twig', [
            // 'controller_name' => 'HomePageController',
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/profil", name="user_profile")
     */
    public function user_profile()
    {
        return $this->render('movie_catalog/account/user_profile.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/abonnements", name="user_subscription")
     */
    public function user_subscription()
    {
        return $this->render('movie_catalog/account/user_subscription.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
