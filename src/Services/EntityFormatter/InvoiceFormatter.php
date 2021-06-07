<?php

namespace App\Services\EntityFormatter;

use App\Entity\Invoice;
use App\Services\UtilitiesService\SurveyData;
use App\Services\UtilitiesService\ConvertDate;
use App\Services\EntityFormatter\UserFormatter;
use App\Services\EntityFormatter\AddressFormatter;

class InvoiceFormatter
{    
    private $convertDate;
    private $surveyData;
    private $userFormatter;
    private $addressFormater;

    public function __construct(
        ConvertDate $convertDate,
        SurveyData $surveyData,
        UserFormatter $userFormatter,
        AddressFormatter $addressFormater
    )
    {
        $this->convertDate = $convertDate;
        $this->surveyData = $surveyData;
        $this->userFormatter = $userFormatter;
        $this->addressFormater = $addressFormater;
    }

    /**
     * Transform invoice
     *
     * @param Invoice $invoice
     * @return array
     */
    public function manageInvoice(Invoice $invoice) 
    {
            
        $customer = $invoice->getCustomer();
        $address = $invoice->getAddress();

        $invoiceMovies = [];
        
        foreach ($invoice->getMovies() as $movie) {
            
            array_push($invoiceMovies, [
                'id' => (int) $movie->getId(),
                /*
                'duration' => (string) $movie->getDuration(),
                'link' => (string) $movie->getLink(),
                'description' => (string) $movie->getDescription(),
                */
                'title' => (string) $movie->getTitle(),
                'price' => (float) $movie->getPrice(),
                /*
                'cover' => (string) $movie->getCover(),
                'createdAt' => (string) $this->convertDate->toDateTimeFr($movie->getCreatedAt()->format('Y-m-d H:i:s'), true),
                'director' => (string) $movie->getDirector(),
                'trailor' => (string) $movie->getTrailer()
                */
            ]);
        }

        return [
            'id' => (int) $invoice->getId(),
            // 'customerId' => (int) $invoice->getCustomer()->getId(),
            'customer' => $this->userFormatter->managUser($customer, false),
            // 'addressId' => (int) $invoice->getAddress()->getId(),
            'address' => $this->addressFormater->managAddress($address, false),
            'amount' => (float) $invoice->getAmount(),
            'createdAt' => (string) $this->convertDate->toDateTimeFr($invoice->getCreatedAt()->format('Y-m-d H:i:s'), true),
            'invoiceReference' => (string) $invoice->getInvoiceReference(),
            'movies' => $invoiceMovies
        ];
    }

    /**
     * Default invoice model for any transformation.
     *
     * @param Invoice $invoice
     */
    public function transform(Invoice $invoice)
    {
        return $this->manageInvoice($invoice);
    }

    /**
     * This function is only used to transform the indicated invoices into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | invoices
     */
    public function transformAll($invoices)
    {
        if ($invoices === "undefined") {
            return "undefined";
        } else {
            if ($this->surveyData->isNotNullData($invoices) === true) {
                $invoicesArray = [];
    
                foreach ($invoices as $invoice) {
                    $invoicesArray[] = $this->transform($invoice);
                }
    
                return $invoicesArray;
            } else {
                return "Auncune facture créée pour le moment";
            }
        }
    }
}
