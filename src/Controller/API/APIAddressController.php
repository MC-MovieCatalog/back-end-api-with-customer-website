<?php

namespace App\Controller\API;

use App\Entity\Address;
use App\Services\ErrorManagement\AddressValidate;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API Address Controller
 * @Route("/api/addresses")
 */
class APIAddressController extends APIDefaultController
{
    private $manager;

    private $addressRepo;

    private $addressValidate;

    // private $request;

    public function __construct(
        EntityManagerInterface $manager,
        AddressRepository $addressRepo,
        AddressValidate $addressValidate
        /* Request $request*/
    ) {
        $this->manager = $manager;
        $this->addressRepo = $addressRepo;
        $this->addressValidate = $addressValidate;
    }

    /**
     * This function returns the addresses list or not found error.
     * 
     * @Route("/getAllAddresses", methods={"GET"})
     */
    public function apiAddressIndex()
    {
        $addresses = $this->addressRepo->getAllAddresses();

        if ($addresses != 'Aucune addresse dans notre base pour l\'instant') {
            return $this->respond($addresses);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    /**
     * This function retrieves the json address sent in the http request, transforms it into a address entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/createAddress", methods={"POST"})
     */
    public function apiAddressCreate(Request $request)
    {
        // Get the json data in user request
        $jsonDataRequestToCreateAddress = json_decode($request->getContent(), true);

        if ($jsonDataRequestToCreateAddress === null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'status' => 400,
                'message' => json_last_error_msg()
            ], 400);
        } else {
            // Validate json request data
            if ($this->addressValidate->addressCreateValidateRequest($jsonDataRequestToCreateAddress) === null) {
                // Address entity instanciation
                $address = new Address;
                // Address setters the content request
                $address->setStreetNb($jsonDataRequestToCreateAddress["streetNb"])
                    ->setAddress($jsonDataRequestToCreateAddress["address"])
                    ->setPostal($jsonDataRequestToCreateAddress["postal"])
                    ->setCity($jsonDataRequestToCreateAddress["city"])
                    ->setType($jsonDataRequestToCreateAddress["type"]);

                // Address persist
                $this->manager->persist($address);
                // Address flush in the database
                $this->manager->flush();

                // Returns the created address, with the correct headers and code 201.
                return $this->respondCreated($this->addressRepo->getAddressById($address->getId()));
            } else {
                return $this->addressValidate->addressCreateValidateRequest($jsonDataRequestToCreateAddress);
            }
        }
    }

    /**
     * This function returns the address whose identifier is given as a parameter
     * @Route("/getAddresseById/{id}", methods={"GET"})
     */
    public function apiAddressShow(Address $address = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a pas été trouvé...';

        if (empty($address)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$address->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($address)) {
            $address = $this->addressRepo->getAddressById($address->getId());
            return $this->respond($address);
        } else {
            return $this->respondNotFound($address);
        }
    }

    /**
     * This function retrieves the json address sent in the http request, transforms it into a address entity and then updates it in the database.
     * 
     * @Route("/updateAddress/{id}", methods={"PUT","PATCH"})
     */
    public function apiAddressEdit(Address $address = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a pas été trouvé...';

        if (empty($address)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$address->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($address)) {

            // Get the json data in user request
            $jsonDataRequestToEditAddress = json_decode($request->getContent(), true);

            if ($jsonDataRequestToEditAddress === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->addressValidate->addressUpdateValidateRequest($jsonDataRequestToEditAddress) === null) {
                    if (array_key_exists("streetNb", $jsonDataRequestToEditAddress)){
                        $address->setStreetNb($jsonDataRequestToEditAddress["streetNb"]);
                    }
                    if (array_key_exists("address", $jsonDataRequestToEditAddress)){
                        $address->setAddress($jsonDataRequestToEditAddress["address"]);
                    }
                    if (array_key_exists("postal", $jsonDataRequestToEditAddress)){
                        $address->setPostal($jsonDataRequestToEditAddress["postal"]);
                    }
                    if (array_key_exists("city", $jsonDataRequestToEditAddress)){
                        $address->setCity($jsonDataRequestToEditAddress["city"]);
                    }
                    if (array_key_exists("type", $jsonDataRequestToEditAddress)){
                        $address->setType($jsonDataRequestToEditAddress["type"]);
                    }

                    // Book flush in the database
                    $this->manager->flush();

                    // Returns the created address, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->addressRepo->getAddressById($address->getId()));
                } else {
                    return $this->addressValidate->addressUpdateValidateRequest($jsonDataRequestToEditAddress);
                }
            }
        }
    }

    /**
     * This function deletes the address whose identifier is given in parameter
     * @Route("/deleteAdresse/{id}", methods={"DELETE"})
     */
    public function apiAddressDelete(Address $address = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à supprimer n\'a pas été trouvé...';
        $success = ['Success' => 'La ressource a bien été supprimée...'];

        if (empty($address)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$address->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($address)) {
            $this->manager->remove($address);
            $this->manager->flush();
            return $this->respond($success);
        } else {
            return $this->respondNotFound($error);
        }
    }
}
