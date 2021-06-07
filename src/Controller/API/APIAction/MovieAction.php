<?php

namespace App\Controller\API\APIAction;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\API\APIDefaultController;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ErrorManagement\MovieValidate;


class MovieAction extends APIDefaultController
{
    private $manager;

    private $movieRepo;

    private $movieValidate;

    public function __construct(
        EntityManagerInterface $manager,
        MovieRepository $movieRepo,
        MovieValidate $movieValidate
    ) {
        $this->manager = $manager;
        $this->movieRepo = $movieRepo;
        $this->movieValidate = $movieValidate;
    }

    public function list()
    {
        $movies = $this->movieRepo->getAllMovies();

        if ($movies === "undefined") {
            return $this->respondInternalError('Erreur serveur inconnue');
        } else {
            if ($movies != 'Aucun film dans notre base pour le moment') {
                return $this->respond($movies);
            } else {
                return $this->respondNotFound('Aucun film dans notre base pour le moment'); // This function can take a custom string message, but contains the default message: Not found
            }
        }
    }

    public function create(Request $request)
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

    public function show(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a pas été trouvée...';

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

    public function update(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a pas été trouvée...';

        if (empty($movie)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$movie->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($movie)) {

            // Get the json data in user request
            $jsonDataRequestToEditMovie = json_decode($request->getContent(), true);

            if ($jsonDataRequestToEditMovie === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->movieValidate->movieUpdateValidateRequest($jsonDataRequestToEditMovie) === null) {
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

                    // Movie flush in the database
                    $this->manager->flush();

                    // Returns the created movie, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->movieRepo->getMovieById($movie->getId()));
                } else {
                    return $this->movieValidate->movieUpdateValidateRequest($jsonDataRequestToEditMovie);
                }
            }
        }
    }

    public function delete(Movie $movie = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à supprimer n\'a pas été trouvée...';
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
