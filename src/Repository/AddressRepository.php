<?php

namespace App\Repository;

use App\Entity\Address;
use App\Services\SurveyData;
use Doctrine\Persistence\ManagerRegistry;
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

    public function __construct(
        ManagerRegistry $registry,
        SurveyData $surveyData
    )
    {
        parent::__construct($registry, Address::class);
        $this->surveyData = $surveyData;
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
     * Default address model for any transformation.
     *
     * @param Address $address
     */
    public function transform(Address $address)
    {
        return [
            'id'    => (int) $address->getId(),
            'streetNb' => (string) $address->getStreetNb(),
            'address' => (string) $address->getAddress(),
            'postal' => (string) $address->getPostal(),
            'city' => (string) $address->getCity(),
            'type' => (string) $address->getType()
        ];
    }

    /**
     * This function is only used to transform the indicated addresses into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | addresses
     */
    protected function transformAll($addresses)
    {
        if ($this->surveyData->isNotNullData($addresses) === true) {
            $addressesArray = [];

            foreach ($addresses as $address) {
                $addressesArray[] = $this->transform($address);
            }

            return $addressesArray;
        } else {
            return "Aucun adresse dans notre base pour le moment";
        }
    }

    /**
     * This function returns the list of transformed addresses
     *
     * @return array | addresses
     */
    public function getAllAddresses()
    {

        $address = $this->findAll();
        // $address = null;
        // $address = "";
        // $address = [];

        return $this->transformAll($address);
    }

    /**
     * This function will search the database for the address whose id is indicated as a parameter, 
     * then it will call the transform () function to obtain the correct output format before sending it to the user.
     *
     * @return address | address
     */
    public function getAddressById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $address = $this->find($id);
            return $this->transform($address);
        }
    }
}
