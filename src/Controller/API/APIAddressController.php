<?php

namespace App\Controller\API;

use App\Controller\API\APIAction\AddressAction;
use App\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Address Controller
 * @Route("/api/addresses")
 */
class APIAddressController
{
    private $addressAction;

    public function __construct(
        AddressAction $addressAction
    ) {
        $this->addressAction = $addressAction;
    }

    /**
     * This function returns the addresses list or not found error.
     * 
     * @Route("/GetAll", methods={"GET"})
     */
    public function apiAddressIndex()
    {
        return $this->addressAction->list();
    }

    /**
     * This function retrieves the json address sent in the http request, transforms it into a address entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/Post", methods={"POST"})
     */
    public function apiAddressCreate(Request $request)
    {
        return $this->addressAction->create($request);
    }

    /**
     * This function returns the address whose identifier is given as a parameter
     * @Route("/Get/{id}", methods={"GET"})
     */
    public function apiAddressShow(Address $address = null, Request $request)
    {
        return $this->addressAction->show($address, $request);
    }

    /**
     * This function retrieves the json address sent in the http request, transforms it into a address entity and then updates it in the database.
     * 
     * @Route("/Update/{id}", methods={"PUT","PATCH"})
     */
    public function apiAddressEdit(Address $address = null, Request $request)
    {
        return $this->addressAction->update($address, $request);
    }

    /**
     * This function deletes the address whose identifier is given in parameter
     * @Route("/Delete/{id}", methods={"DELETE"})
     */
    public function apiAddressDelete(Address $address = null, Request $request)
    {
        return $this->addressAction->delete($address, $request);
    }
}
