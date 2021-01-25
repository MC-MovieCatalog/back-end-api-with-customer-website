<?php

namespace App\Repository;

use App\Entity\Book;
use App\Services\ConvertDate;
use App\Services\SurveyData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    private $convertDate;

    private $surveyData;

    public function __construct(
        ManagerRegistry $registry,
        ConvertDate $convertDate,
        SurveyData $surveyData
    ) {
        parent::__construct($registry, Book::class);
        $this->convertDate = $convertDate;
        $this->surveyData = $surveyData;
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Default book model for any transformation.
     *
     * @param Book $book
     */
    protected function transform(Book $book)
    {
        return [
            'id'    => (int) $book->getId(),
            'pageNb' => (string) $book->getPageNb(),
            'content' => null,
            'description' => (string) $book->getDescription(),
            'title' => (string) $book->getTitle(),
            'price' => (float) $book->getPrice(),
            'cover' => (string) $book->getCover(),
            'createdAt' => $this->convertDate->toDateTimeFr($book->getCreatedAt()->format('Y-m-d H:i:s'), true),
            /*
                // Other possible formats to be completed as needed
                'createdAt' => $this->convertDate->toStrDateTimeFr($book->getCreatedAt()->format('Y-m-d H:i:s'), false),
             */
            'author' => (string) $book->getAuthor()
        ];
    }

    /**
     * This function is only used to transform the indicated books into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | books
     */
    protected function transformAll($books)
    {
        if ($this->surveyData->isNotNullData($books) === true) {
            $booksArray = [];

            foreach ($books as $book) {
                $booksArray[] = $this->transform($book);
            }

            return $booksArray;
        } else {
            return "Aucune livre en stock pour le moment";
        }
    }

    
    /**
     * This function will retrieve all the books in the database, 
     * then will call the transformAll() function to return them in the correct format to the user
     *
     * @return array | books
     */
    public function getAllBooks()
    {

        $books = $this->findAll();
        // $books = null;
        // $books = "";
        // $books = [];

        return $this->transformAll($books);
    }

    /**
     * In book creation mode, this function retrieves the created book by transforming the way the book.content is retrieved to display it to the user.
     *
     * @param Book $book
     * @return book | transformed after its creation
     */
    public function getTheCreatedBook(Book $book){

        $bookDefaultModel = $this->transform($book);

        // $bookTransformed = ($book === null) ? null : array_replace($bookDefaultModel, ['content' => (string) base64_decode($book->getContent())]);
        $bookTransformed = (!array_key_exists('content', (array)$book) === null) ? null : array_replace($bookDefaultModel, ['content' => (string) base64_decode($book->getContent())]);  

        return $bookTransformed; 
    }


    /**
     * 
     * This function transforms the book whose id is passed as a parameter by modifying the way the book.content is retrieved in read-only mode.
     * @param Book $book
     * @return book | book transformed read only
     */
    public function bookTransform(Book $book){

        $bookDefaultModel = $this->transform($book);

        // $bookTransformed = ($book === null) ? null : array_replace($bookDefaultModel, ['content' => (string) base64_decode($book->getContentReadOnly())]); 
        $bookTransformed = (!array_key_exists('content', (array)$book) === null) ? null : array_replace($bookDefaultModel, ['content' => (string) base64_decode($book->getContentReadOnly())]);  

        return $bookTransformed; 
    }
    

    /**
     * This function will search the database for the book whose id is indicated as a parameter, 
     * then it will call the booksTransform () function to obtain the correct output format before sending it to the user.
     *
     * @return book | book
     */
    public function getBookById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $book = $this->find($id);
            return $this->bookTransform($book);
        }
    }
}
