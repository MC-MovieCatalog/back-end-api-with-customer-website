<?php

namespace App\Controller\API;

use App\Entity\Movie;
use App\Services\ErrorManagement\MovieValidate;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Movie Controller
 * @Route("/api")
 */
class APIMovieController extends APIDefaultController
{
    private $manager;

    private $movieRepo;

    private $movieValidate;

    // private $request;

    public function __construct(
        EntityManagerInterface $manager,
        MovieRepository $movieRepo,
        MovieValidate $movieValidate
        /* Request $request*/
    ) {
        $this->manager = $manager;
        $this->movieRepo = $movieRepo;
        $this->movieValidate = $movieValidate;
    }

    /**
     * This function returns the movies list or not found error.
     * 
     * @Route("/movies", methods={"GET"})
     */
    public function apiMovieIndex()
    {
        $movies = $this->movieRepo->getAllMovies();

        if ($movies != 'Aucune vidéo en stock pour le moment') {
            return $this->respond($movies);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    /**
     * This function retrieves the json movie sent in the http request, transforms it into a movie entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/movies/add", methods={"POST"})
     */
    public function apiMovieCreate(Request $request)
    {
        // Get the json data in user request
        $jsonDataRequestToCreateMovie = json_decode($request->getContent(), true);

        // dd($jsonDataRequestToCreateMovie);

        if ($jsonDataRequestToCreateMovie === null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'status' => 400,
                'message' => json_last_error_msg()
            ], 400);
        } else {
            // Validate json request data
            if ($this->movieValidate->movieCreateValidateRequest($jsonDataRequestToCreateMovie) === null) {
                // Movie entity instanciation
                $movie = new Movie;
                // Movie setters the content request
                $movie->setDuration($jsonDataRequestToCreateMovie["duration"])
                    ->setLink($jsonDataRequestToCreateMovie["link"])
                    ->setDescription($jsonDataRequestToCreateMovie["description"])
                    ->setTitle($jsonDataRequestToCreateMovie["title"])
                    ->setPrice($jsonDataRequestToCreateMovie["price"])
                    ->setCover($jsonDataRequestToCreateMovie["cover"])
                    ->setDirector($jsonDataRequestToCreateMovie["director"])
                    ->setTrailer($jsonDataRequestToCreateMovie["trailer"]);

                // Movie persist
                $this->manager->persist($movie);
                // Movie flush in the database
                $this->manager->flush();

                // Returns the created movie, with the correct headers and code 201.
                return $this->respondCreated($this->movieRepo->getMovieById($movie->getId()));
            } else {
                return $this->movieValidate->movieCreateValidateRequest($jsonDataRequestToCreateMovie);
            }
        }
    }

    /**
     * This function returns the movie whose identifier is given as a parameter
     * @Route("/movies/{id}", methods={"GET"})
     */
    public function apiMovieShow(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a été trouvé...';

        if (empty($movie)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$movie->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($movie)) {
            $movie = $this->movieRepo->getMovieById($movie->getId());
            return $this->respond($movie);
        } else {
            return $this->respondNotFound($movie);
        }
    }

    /**
     * This function retrieves the json movie sent in the http request, transforms it into a movie entity and then updates it in the database.
     * 
     * @Route("/movies/{id}/edit", methods={"PUT","PATCH"})
     */
    public function apiMovieEdit(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a été trouvé...';

        if (empty($movie)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$movie->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($movie)) {

            // Get the json data in user request
            $jsonDataRequestToEditMovie = json_decode($request->getContent(), true);

            $content = $jsonDataRequestToEditMovie;

            if ($jsonDataRequestToEditMovie === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->movieValidate->MovieUpdateValidateRequest($jsonDataRequestToEditMovie) === null) {
                    if (array_key_exists("duration", $jsonDataRequestToEditMovie)){
                        $movie->setDuration($jsonDataRequestToEditMovie["duration"]);
                    }
                    if (array_key_exists("link", $jsonDataRequestToEditMovie)){
                        $movie->setLink($jsonDataRequestToEditMovie["link"]);
                    }
                    if (array_key_exists("description", $jsonDataRequestToEditMovie)){
                        $movie->setDescription($jsonDataRequestToEditMovie["description"]);
                    }
                    if (array_key_exists("title", $jsonDataRequestToEditMovie)){
                        $movie->setTitle($jsonDataRequestToEditMovie["title"]);
                    }
                    if (array_key_exists("price", $jsonDataRequestToEditMovie)){
                        $movie->setPrice($jsonDataRequestToEditMovie["price"]);
                    }
                    if (array_key_exists("cover", $jsonDataRequestToEditMovie)){
                        $movie->setCover($jsonDataRequestToEditMovie["cover"]);
                    }
                    if (array_key_exists("director", $jsonDataRequestToEditMovie)){
                        $movie->setDirector($jsonDataRequestToEditMovie["director"]);
                    }
                    if (array_key_exists("trailer", $jsonDataRequestToEditMovie)){
                        $movie->setTrailer($jsonDataRequestToEditMovie["trailer"]);
                    }

                    // Book flush in the database
                    $this->manager->flush();

                    // Returns the created movie, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->movieRepo->movieTransform($movie));
                } else {
                    return $this->movieValidate->movieUpdateValidateRequest($jsonDataRequestToEditMovie);
                }
            }
        }
    }

    /**
     * This function deletes the movie whose identifier is given in parameter
     * @Route("/movies/{id}/delete", methods={"DELETE"})
     */
    public function apiMovieDelete(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à supprimer n\'a été trouvé...';
        $success = ['Success' => 'La ressource a bien été supprimée...'];

        if (empty($movie)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$movie->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($movie)) {
            $this->manager->remove($movie);
            $this->manager->flush();
            return $this->respond($success);
        } else {
            return $this->respondNotFound($error);
        }
    }
}
