<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $manager;

    private $movieRepository;
    
    public function __construct(EntityManagerInterface $manager, MovieRepository $movieRepository)
    {
        $this->manager = $manager;
        $this->movieRepository = $movieRepository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $topTenMovies = $this->movieRepository->getTopTenMovies();

        return $this->render('movie_catalog/home_page.html.twig', [
            'topTenMovies' => $topTenMovies
        ]);
    }
}
