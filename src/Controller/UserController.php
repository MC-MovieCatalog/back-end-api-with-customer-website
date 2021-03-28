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
        return $this->render('movie_catalog/account/user_account.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/mettre-a-jour-mon-profil", name="user_profile")
     */
    public function user_profile()
    {
        return $this->render('movie_catalog/account/user_profile.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }
}
