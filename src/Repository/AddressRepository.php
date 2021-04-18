<?php

namespace App\Repository;

use App\Entity\Address;
use App\Services\UtilitiesService\SurveyData;
use Doctrine\Persistence\ManagerRegistry;
use App\Services\EntityFormatter\AddressFormatter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{    
    private $surveyData;
    private $addressFormater;

    public function __construct(
        ManagerRegistry $registry,
        SurveyData $surveyData,
        AddressFormatter $addressFormater
    )
    {
        parent::__construct($registry, Address::class);
        $this->surveyData = $surveyData;
        $this->addressFormater = $addressFormater;
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
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
    public function findOneBySomeField($value): ?Address
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
     * This function returns the list of transformed addresses | only to API
     *
     * @return array | addresses
     */
    public function getAllAddresses()
    {

        $address = $this->findAll();
        // $address = null;
        // $address = "";
        // $address = [];

        return $this->addressFormater->transformAll($address);
    }

    /**
     * This function will search the database for the address whose id is indicated as a parameter, 
     * then it will call the transform () function to obtain the correct output format before sending it to the user |  only to API
     *
     * @return address | address
     */
    public function getAddressById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $address = $this->find($id);
            return $this->addressFormater->transform($address);
        }
    }
}
