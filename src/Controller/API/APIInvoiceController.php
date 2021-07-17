<?php

namespace App\Controller\API;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Repository\UserRepository;
use App\Repository\InvoiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\API\APIAction\InvoiceAction;
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

    /* Invoice PDF */

    /**
     * @Route("/viewer/{id}", name="invoices_viewer")
     */
    public function usersData(Invoice $invoice_, InvoiceRepository $invoiceRepo)
    {
        $invoice = $invoiceRepo->findInvoiceById($invoice_->getId());
        // dd($invoice);
        return $this->render('movie_catalog/invoice/invoice.html.twig', [
            'invoice' => $invoice
        ]);
    }


    /**
     * @Route("/invoices/download/{id}", name="invoices_to_mail")
     */
    public function userInvoiceToMail(Invoice $invoice_, InvoiceRepository $invoiceRepo)
    {
        // return $this->invoiceAction->userInvoiceToMail();
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        $invoice = $invoiceRepo->findInvoiceById($invoice_->getId());
        // On génère le html
        $html = $this->renderView('movie_catalog/invoice/invoice.html.twig', [
            'invoice' => $invoice
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'facture-'. $invoice->getInvoiceReference() .'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }

}
