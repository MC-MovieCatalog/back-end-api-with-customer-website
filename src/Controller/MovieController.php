<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/films/details", name="movie_details")
     */
    public function index()
    {
        return $this->render('movie_book/details.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/recherche", name="search")
     */
    public function search()
    {
        return $this->render('movie_book/search.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }
}
