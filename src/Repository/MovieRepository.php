<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Services\SurveyData;
use App\Services\ConvertDate;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    private $convertDate;
    
    private $surveyData;

    public function __construct(
        ManagerRegistry $registry,
        ConvertDate $convertDate,
        SurveyData $surveyData
    )
    {
        parent::__construct($registry, Movie::class);
        $this->convertDate = $convertDate;
        $this->surveyData = $surveyData;
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Default movie model for any transformation.
     *
     * @param Movie $movie
     */
    public function transform(Movie $movie)
    {
        return [
            'id'    => (int) $movie->getId(),
            'duration' => (string) $movie->getDuration(),
            'link' => (string) $movie->getLink(),
            'description' => (string) $movie->getDescription(),
            'title' => (string) $movie->getTitle(),
            'price' => (float) $movie->getPrice(),
            'cover' => (string) $movie->getCover(),
            'createdAt' => (string) $this->convertDate->toDateTimeFr($movie->getCreatedAt()->format('Y-m-d H:i:s'), true),
            // 'dateTest' => $this->convertDate->toStrDateTimeFr($book->getCreatedAt()->format('Y-m-d H:i:s'), false),
            'director' => (string) $movie->getDirector(),
            'trailor' => (string) $movie->getTrailer()
        ];
    }

    /**
     * This function is only used to transform the indicated movies into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | movies
     */
    protected function transformAll($movies)
    {
        if ($this->surveyData->isNotNullData($movies) === true) {
            $moviesArray = [];

            foreach ($movies as $movie) {
                $moviesArray[] = $this->transform($movie);
            }

            return $moviesArray;
        } else {
            return "Aucun film dans notre base pour le moment";
        }
    }

    /**
     * This function returns the list of transformed movies
     *
     * @return array | movies
     */
    public function getAllMovies()
    {

        $movies = $this->findAll();
        // $movies = null;
        // $movies = "";
        // $movies = [];

        return $this->transformAll($movies);
    }

    /**
     * This function will search the database for the movie whose id is indicated as a parameter, 
     * then it will call the transform () function to obtain the correct output format before sending it to the user.
     *
     * @return movie | movie
     */
    public function getMovieById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $movie = $this->find($id);
            return $this->transform($movie);
        }
    }

    // Start Backend API to front twig
    public function getTopTenMovies(){
        $queryBuilder = $this->createQueryBuilder('m')
            // TO CHECK orderBy rate / view
            ->orderBy('m.createdAt', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(10);
        
        return $queryBuilder->getQuery()->getResult();
    }
    // End Backend API to front twig
}
