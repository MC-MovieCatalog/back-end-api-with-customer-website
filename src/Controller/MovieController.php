<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{

    private $manager;

    private $movieRepository;
    
    public function __construct(EntityManagerInterface $manager, MovieRepository $movieRepository)
    {
        $this->manager = $manager;
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/films", name="movies")
     */
    public function movieCatalog()
    {
        $movies = $this->movieRepository->findAll();
        $topTenMovies = $this->movieRepository->getTopTenMovies();

        // dd($topTenMovie);
        // dd($movies);

        return $this->render('movie_catalog/movies.html.twig', [
            'movies' => $movies,
            'topTenMovies' => $topTenMovies
        ]);
    }

    /**
     * @Route("/films/details", name="details")
     */
    public function movieDetails()
    {
        return $this->render('movie_catalog/details.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }

    /**
     * @Route("/recherche", name="search")
     */
    public function search()
    {
        return $this->render('movie_catalog/search.html.twig', [
            // 'controller_name' => 'HomePageController',
        ]);
    }
}
