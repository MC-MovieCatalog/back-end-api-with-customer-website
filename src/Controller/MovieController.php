<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Form\RatingFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        return $this->render('movie_catalog/movie/movies.html.twig', [
            'movies' => $movies,
            'topTenMovies' => $topTenMovies
        ]);
    }

    /**
     * @Route("/films/{slug}/regarder", name="details")
     */
    public function movieDetails(Movie $movie, Request $request)
    {
        $user = $this->getUser();

        $rating = new Rating();

        $form = $this->createForm(RatingFormType::class, $rating);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $rating->setMovie($movie)
                    ->setAuthor($user);

            $this->manager->persist($rating);
            $this->manager->flush();

            $this->addFlash(
                'success',
                "Merci, nous avons bien pris en compte votre note !"
            );

            return $this->redirectToRoute('details', [
                'slug' => $movie->getSlug(),
            ]);
        }

        return $this->render('movie_catalog/movie/details.html.twig', [
            'movie' => $movie,
            'ratingForm' => $form->createView(),
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
