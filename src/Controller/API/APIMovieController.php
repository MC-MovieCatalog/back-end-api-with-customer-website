<?php

namespace App\Controller\API;

use App\Controller\API\APIAction\MovieAction;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Movie Controller
 * @Route("/api/movies")
 */
class APIMovieController
{
    private $movieAction;

    public function __construct(
        MovieAction $movieAction
    ) {
        $this->movieAction = $movieAction;
    }

    /**
     * This function returns the movies list or not found error.
     * 
     * @Route("/GetAll", methods={"GET"})
     */
    public function apiMovieIndex()
    {
        return $this->movieAction->list();
    }

    /**
     * This function retrieves the json movie sent in the http request, transforms it into a movie entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/Post", methods={"POST"})
     */
    public function apiMovieCreate(Request $request)
    {
        return $this->movieAction->create($request);
    }

    /**
     * This function returns the movie whose identifier is given as a parameter
     * @Route("/Get/{id}", methods={"GET"})
     */
    public function apiMovieShow(Movie $movie = null, Request $request)
    {
        return $this->movieAction->show($movie, $request);
    }

    /**
     * This function retrieves the json movie sent in the http request, transforms it into a movie entity and then updates it in the database.
     * 
     * @Route("/Update/{id}", methods={"PUT","PATCH"})
     */
    public function apiMovieEdit(Movie $movie = null, Request $request)
    {
        return $this->movieAction->update($movie, $request);
    }

    /**
     * This function deletes the movie whose identifier is given in parameter
     * @Route("/Delete/{id}", methods={"DELETE"})
     */
    public function apiMovieDelete(Movie $movie = null, Request $request)
    {
        return $this->movieAction->delete($movie, $request);
    }
}
