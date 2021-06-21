<?php

namespace App\Controller\API\APIAction;

use App\Entity\Invoice;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\API\APIDefaultController;
use App\Repository\InvoiceRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ErrorManagement\InvoiceValidate;

class InvoiceAction extends APIDefaultController
{
    private $manager;

    private $invoiceRepo;

    private $invoiceValidate;

    private $userRepo;

    private $addressRepo;

    private $movieRepo;

    public function __construct(
        EntityManagerInterface $manager,
        InvoiceRepository $invoiceRepo,
        InvoiceValidate $invoiceValidate,
        UserRepository $userRepo,
        AddressRepository $addressRepo,
        MovieRepository $movieRepo
    ) {
        $this->manager = $manager;
        $this->invoiceRepo = $invoiceRepo;
        $this->invoiceValidate = $invoiceValidate;
        $this->userRepo = $userRepo;
        $this->addressRepo = $addressRepo;
        $this->movieRepo = $movieRepo;
    }


    public function list()
    {
        $invoices = $this->invoiceRepo->getAllInvoices();

        if ($invoices === "undefined") {
            return $this->respondInternalError('Erreur serveur inconnue');
        } else {
            if ($invoices != 'Auncune facture créée pour le moment') {
                return $this->respond($invoices);
            } else {
                return $this->respondNotFound('Auncune facture créée pour le moment'); // This function can take a custom string message, but contains the default message: Not found
            }
        }
    }

    public function create(Request $request)
    {
        // Get the json data in customer request
        $jsonDataRequestToCreateInvoice = json_decode($request->getContent(), true);

        if ($jsonDataRequestToCreateInvoice === null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'status' => 400,
                'message' => json_last_error_msg()
            ], 400);
        } else {
            // Validate json request data
            if ($this->invoiceValidate->invoiceCreateValidateRequest($jsonDataRequestToCreateInvoice) === null) {

                // customer / user
                if (!empty($this->userRepo->findBy(array('id' => $jsonDataRequestToCreateInvoice["customerId"]),array('email' => 'ASC'),1 ,0)[0])) {
                    $customer = $this->userRepo->findBy(array('id' => $jsonDataRequestToCreateInvoice["customerId"]),array('email' => 'ASC'),1 ,0)[0];
                } else {
                    return $this->respondNotFound('Nous sommes désolé, ce client est inconnu');
                }

                // address
                if (!empty($this->addressRepo->findBy(array('id' => $jsonDataRequestToCreateInvoice["addressId"]),array('streetNb' => 'ASC'),1 ,0)[0])) {
                    $address = $this->addressRepo->findBy(array('id' => $jsonDataRequestToCreateInvoice["addressId"]),array('streetNb' => 'ASC'),1 ,0)[0];
                } else {
                    return $this->respondNotFound('Nous sommes désolé, cette adresse n\'existe pas');
                }
                
                // Invoice entity instanciation
                $invoice = new Invoice;
                $amount = 0;

                // movies
                if (!empty($jsonDataRequestToCreateInvoice["movies"])) {

                    $movies = $jsonDataRequestToCreateInvoice["movies"];
            
                    dd('movies', $movies);
                    for ($i=0; $i < count($movies); $i++) { 
                        if (!empty($this->movieRepo->findBy(array('id' => $movies[$i]->getId()),array('id' => 'ASC'),1 ,0)[0])) {
                            $address = $this->movieRepo->findBy(array('id' => $movies[$i]->getId()),array('id' => 'ASC'),1 ,0)[0];
                            $invoice->addMovie($address);

                            if (empty($jsonDataRequestToCreateInvoice["amount"])) {
                                $amount = $amount + $movies[$i]->getPrice();
                            }
                            
                        } else {
                            dd('Introuvable(s)...');
                            // return $this->respondNotFound('Nous sommes désolé, vidéo(s) introuvable(s)');
                        }
                    }
                }
                
                // Invoice setters the content request
                $invoice->setCustomer($customer)
                    ->setAddress($address);
                
                // amount
                if (empty($jsonDataRequestToCreateInvoice["amount"])) {
                    $invoice->setAmount($amount);
                } else {
                    $invoice->setAmount($jsonDataRequestToCreateInvoice["amount"]);
                }
                    

                // Invoice persist
                $this->manager->persist($invoice);
                // Invoice flush in the database
                $this->manager->flush();

                // Returns the created invoice, with the correct headers and code 201.
                return $this->respondCreated($this->invoiceRepo->getInvoiceById($invoice->getId()));
            } else {
                return $this->invoiceValidate->invoiceCreateValidateRequest($jsonDataRequestToCreateInvoice);
            }
        }
    }

    public function show(Invoice $invoice = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a pas été trouvé...';

        if (empty($invoice)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$invoice->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($invoice)) {
            $invoice = $this->invoiceRepo->getInvoiceById($invoice->getId());
            return $this->respond($invoice);
        } else {
            return $this->respondNotFound($invoice);
        }
    }

    public function update(Invoice $invoice = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a pas été trouvée...';

        if (empty($invoice)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$invoice->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($invoice)) {

            // Get the json data in user request
            $jsonDataRequestToEditInvoice = json_decode($request->getContent(), true);

            if ($jsonDataRequestToEditInvoice === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->invoiceValidate->invoiceUpdateValidateRequest($jsonDataRequestToEditInvoice) === null) {
                    if (array_key_exists("customerId", $jsonDataRequestToEditInvoice)){
                        // customer / user
                        if (!empty($this->userRepo->findBy(array('id' => $jsonDataRequestToEditInvoice["customerId"]),array('email' => 'ASC'),1 ,0)[0])) {
                            $customer = $this->userRepo->findBy(array('id' => $jsonDataRequestToEditInvoice["customerId"]),array('email' => 'ASC'),1 ,0)[0];

                            $invoice->setCustomer($customer);

                        } else {
                            return $this->respondNotFound('Nous sommes désolé, ce client est inconnu');
                        }
                    }
                    if (array_key_exists("addressId", $jsonDataRequestToEditInvoice)){

                        // address
                        if (!empty($this->addressRepo->findBy(array('id' => $jsonDataRequestToEditInvoice["addressId"]),array('streetNb' => 'ASC'),1 ,0)[0])) {
                            $address = $this->addressRepo->findBy(array('id' => $jsonDataRequestToEditInvoice["addressId"]),array('streetNb' => 'ASC'),1 ,0)[0];

                            $invoice->setAddress($address);

                        } else {
                            return $this->respondNotFound('Nous sommes désolé, cette adresse n\'existe pas');
                        }
                    }
                    
                    if (array_key_exists("movies", $jsonDataRequestToEditInvoice)){

                        $amount = 0;
                        $isAmount = false;

                        // movies
                        if (!empty($jsonDataRequestToEditInvoice["movies"])) {

                            $movies = $jsonDataRequestToEditInvoice["movies"];
                    
                            dd('movies', $movies);
                            for ($i=0; $i < count($movies); $i++) { 
                                if (!empty($this->movieRepo->findBy(array('id' => $movies[$i]->getId()),array('id' => 'ASC'),1 ,0)[0])) {
                                    $address = $this->movieRepo->findBy(array('id' => $movies[$i]->getId()),array('id' => 'ASC'),1 ,0)[0];
                                    $invoice->addMovie($address);

                                    if (empty($jsonDataRequestToEditInvoice["amount"])) {
                                        $amount = $amount + $movies[$i]->getPrice();
                                        $this->$isAmount = true;
                                    }
                                    
                                } else {
                                    dd('Introuvable(s)...');
                                    // return $this->respondNotFound('Nous sommes désolé, vidéo(s) introuvable(s)');
                                }
                            }
                        }
                    }
                    
                    if (array_key_exists("amount", $jsonDataRequestToEditInvoice)){
                        if (empty($jsonDataRequestToEditInvoice["amount"]) && $this->$isAmount !== false) {
                            $invoice->setAmount($amount);
                        } else {
                            $invoice->setAmount($jsonDataRequestToEditInvoice["amount"]);
                        }
                    }

                    // Invoice flush in the database
                    $this->manager->flush();

                    // Returns the created invoice, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->invoiceRepo->getInvoiceById($invoice->getId()));
                } else {
                    return $this->invoiceValidate->invoiceUpdateValidateRequest($jsonDataRequestToEditInvoice);
                }
            }
        }
    }

    public function delete(Invoice $invoice = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à supprimer n\'a pas été trouvée...';
        $success = ['Success' => 'La ressource a bien été supprimée...'];

        if (empty($invoice)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$invoice->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($invoice)) {
            $this->manager->remove($invoice);
            $this->manager->flush();
            return $this->respond($success);
        } else {
            return $this->respondNotFound($error);
        }
    }
}
