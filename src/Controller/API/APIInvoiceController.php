<?php

namespace App\Controller\API;

use App\Entity\Invoice;
use App\Controller\API\APIAction\InvoiceAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Invoice Controller
 * @Route("/api/invoices")
 */
class APIInvoiceController extends APIDefaultController
{
    private $invoiceAction;

    public function __construct(
        InvoiceAction $invoiceAction
    ) {
        $this->invoiceAction = $invoiceAction;
    }

    /**
     * This function returns the invoices list or not found error.
     * 
     * @Route("/GetAll", methods={"GET"})
     */
    public function apiUserIndex()
    {
        return $this->invoiceAction->list();
    }

    /**
     * This function retrieves the json invoice sent in the http request, transforms it into a invoice entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/Post", methods={"POST"})
     */
    public function apiInvoiceCreate(Request $request)
    {
        return $this->invoiceAction->create($request);
    }

    /**
     * This function returns the invoice whose identifier is given as a parameter
     * @Route("/Get/{id}", methods={"GET"})
     */
    public function apiInvoiceShow(Invoice $invoice = null, Request $request)
    {
        return $this->invoiceAction->show($invoice, $request);
    }

    /**
     * This function retrieves the json invoice sent in the http request, transforms it into a invoice entity and then updates it in the database.
     * 
     * @Route("/Update/{id}", methods={"PUT","PATCH"})
     */
    public function apiInvoiceEdit(Invoice $invoice = null, Request $request)
    {        
        return $this->invoiceAction->update($invoice, $request);
    }
}
