<?php

namespace App\Repository;

use App\Entity\Invoice;
use App\Services\EntityFormatter\InvoiceFormatter;
use App\Services\UtilitiesService\SurveyData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    private $surveyData;

    private $invoiceFormater;

    public function __construct(
        ManagerRegistry $registry,
        SurveyData $surveyData,
        InvoiceFormatter $invoiceFormater
    )
    {
        parent::__construct($registry, Invoice::class);
        $this->surveyData = $surveyData;
        $this->invoiceFormater = $invoiceFormater;
    }

    // /**
    //  * @return Invoice[] Returns an array of Invoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invoice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * This function returns the list of transformed invoices | only to API
     *
     * @return array | invoices
     */
    public function getAllInvoices()
    {

        $invoices = $this->findAll();
        // $invoices = null;
        // $invoices = "";
        // $invoices = [];
        if (!isset($invoices)) {
            $invoices = "undefined";
        }
        
        return $this->invoiceFormater->transformAll($invoices);
    }

    /**
     * This function will search the database for the invoice whose id is indicated as a parameter, 
     * then it will call the transform () function to obtain the correct output format before sending it to the invoice | only to API.
     *
     * @return invoice | invoice
     */
    public function getInvoiceById($id)
    {
        if ($this->surveyData->isNumExist($id) === true) {
            $invoice = $this->find($id);
            return $this->invoiceFormater->transform($invoice);
        }
    }

    public function findInvoiceById($id){
        $qb = $this->createQueryBuilder('i');

        $qb->select('i as invoice')
            ->innerJoin('i.customer', 'c')
            ->innerJoin('i.address', 'a')
            ->innerJoin('i.movies', 'm')

            ->addSelect('c')
            ->addSelect('a')
            ->addSelect('m')
            ->where('i.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getResult()[0]["invoice"];
    }
}
