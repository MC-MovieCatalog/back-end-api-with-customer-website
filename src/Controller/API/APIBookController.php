<?php

namespace App\Controller\API;

use App\Entity\Book;
use App\Services\BookValidate;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

/**
 * Undocumented class
 * @Route("/api")
 */
class APIBookController extends APIDefaultController
{
    private $manager;

    private $bookRepo;

    private $serializer;

    private $bookValidate;

    // private $request;

    public function __construct(
        EntityManagerInterface $manager,
        BookRepository $bookRepo,
        SerializerInterface $serializer,
        BookValidate $bookValidate
        /* Request $request*/
    ) {
        $this->manager = $manager;
        $this->bookRepo = $bookRepo;
        $this->serializer = $serializer;
        $this->bookValidate = $bookValidate;
    }

    /**
     * This function returns the books list or not found error.
     * 
     * @Route("/books", methods={"GET"})
     */
    public function apiBookIndex()
    {
        $books = $this->bookRepo->getAllBooks();

        if ($books != 'Aucune livre en stock pour le moment') {
            return $this->respond($books);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    /**
     * This function retrieves the json book sent in the http request, transforms it into a book entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/books/add", methods={"POST"})
     */
    public function apiBookCreate(Request $request)
    {
        // Get the json data in user request
        $jsonDataRequestToCreateBook = json_decode($request->getContent(), true);

        // dd($jsonDataRequestToCreateBook);

        if ($jsonDataRequestToCreateBook === null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'status' => 400,
                'message' => json_last_error_msg()
            ], 400);
        } else {
            // Validate json request data
            if ($this->bookValidate->bookCreateValidateRequest($jsonDataRequestToCreateBook) === null) {
                // Book entity instanciation
                $book = new Book;
                // Book setters the content request
                $book->setPageNb($jsonDataRequestToCreateBook["pageNb"])
                    ->setContent($jsonDataRequestToCreateBook["content"])
                    ->setDescription($jsonDataRequestToCreateBook["description"])
                    ->setTitle($jsonDataRequestToCreateBook["title"])
                    ->setPrice($jsonDataRequestToCreateBook["price"])
                    ->setCover($jsonDataRequestToCreateBook["cover"])
                    ->setAuthor($jsonDataRequestToCreateBook["author"]);

                // Book persist
                $this->manager->persist($book);
                // Book flush in the database
                $this->manager->flush();

                // Returns the created book, with the correct headers and code 201.
                return $this->respondCreated($this->bookRepo->getTheCreatedBook($book));
            } else {
                return $this->bookValidate->bookCreateValidateRequest($jsonDataRequestToCreateBook);
            }
        }
    }

    /**
     * This function returns the book whose identifier is given as a parameter
     * @Route("/books/{id}", methods={"GET"})
     */
    public function apiBookShow(Book $book = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a été trouvé...';

        if (empty($book)) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if ($request->get('id') !== (string)$book->getId()) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if (!empty($book)) {
            $book = $this->bookRepo->getBookById($book->getId());
            // $book = $this->bookRepo->findOneBy(array('id' =>$book->getId()));
            return $this->respond($book);
        } else {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        }
    }

    /**
     * This function retrieves the json book sent in the http request, transforms it into a book entity and then updates it in the database.
     * 
     * @Route("/books/{id}/edit", methods={"PUT","PATCH"})
     */
    public function apiBookEdit(Book $book = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a été trouvé...';

        if (empty($book)) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if ($request->get('id') !== (string)$book->getId()) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if (!empty($book)) {

            // Get the json data in user request
            $jsonDataRequestToEditBook = json_decode($request->getContent(), true);

            $content = $jsonDataRequestToEditBook;

            if ($jsonDataRequestToEditBook === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->bookValidate->bookUpdateValidateRequest($jsonDataRequestToEditBook) === null) {
                    // Book setters the content request
                    if (array_key_exists("pageNb", $jsonDataRequestToEditBook)){
                        $book->setPageNb($jsonDataRequestToEditBook["pageNb"]);
                    }
                    if (array_key_exists("content", $jsonDataRequestToEditBook)){
                        $book->setContent($jsonDataRequestToEditBook["content"]);
                    }
                    if (array_key_exists("description", $jsonDataRequestToEditBook)){
                        $book->setDescription($jsonDataRequestToEditBook["description"]);
                    }
                    if (array_key_exists("title", $jsonDataRequestToEditBook)){
                        $book->setTitle($jsonDataRequestToEditBook["title"]);
                    }
                    if (array_key_exists("price", $jsonDataRequestToEditBook)){
                        $book->setPrice($jsonDataRequestToEditBook["price"]);
                    }
                    if (array_key_exists("cover", $jsonDataRequestToEditBook)){
                        $book->setCover($jsonDataRequestToEditBook["cover"]);
                    }
                    if (array_key_exists("author", $jsonDataRequestToEditBook)){
                        $book->setAuthor($jsonDataRequestToEditBook["author"]);
                    }

                    // Book flush in the database
                    $this->manager->flush();

                    // Returns the created book, with the correct headers and code 201.
                    if (array_key_exists("content", $content)){
                        return $this->respondCreated($this->bookRepo->getTheCreatedBook($book));
                    } else {
                        return $this->respondCreated($this->bookRepo->bookTransform($book));
                    }
                } else {
                    return $this->bookValidate->bookUpdateValidateRequest($jsonDataRequestToEditBook);
                }
            }
        }
    }

    /**
     * This function deletes the book whose identifier is given in parameter
     * @Route("/books/{id}/delete", methods={"DELETE"})
     */
    public function apiBookDelete(Book $book = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à supprimer n\'a été trouvé...';
        $success = ['Success' => 'La ressource a bien été supprimée...'];

        if (empty($book)) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if ($request->get('id') !== (string)$book->getId()) {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        } else if (!empty($book)) {
            $this->manager->remove($book);
            $this->manager->flush();
            return $this->respond($success);
        } else {
            return $this->respondNotFound($error); // throw new NotFoundHttpException($error);
        }
    }
}
