<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\UtilitiesService\SurveyData;
use Doctrine\Persistence\ManagerRegistry;
use App\Services\EntityFormatter\UserFormatter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $surveyData;

    private $userFormater;

    public function __construct(
        ManagerRegistry $registry,
        SurveyData $surveyData,
        UserFormatter $userFormater
    )
    {
        parent::__construct($registry, User::class);
        $this->surveyData = $surveyData;
        $this->userFormater = $userFormater;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * This function returns the list of transformed users | only to API
     *
     * @return array | users
     */
    public function getAllUsers()
    {

        $users = $this->findAll();
        // $users = null;
        // $users = "";
        // $users = [];
        
        return $this->userFormater->transformAll($users);
    }

    /**
     * This function will search the database for the user whose id is indicated as a parameter, 
     * then it will call the transform () function to obtain the correct output format before sending it to the user | only to API.
     *
     * @return user | user
     */
    public function getUserById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $user = $this->find($id);
            return $this->userFormater->transform($user);
        }
    }
}
