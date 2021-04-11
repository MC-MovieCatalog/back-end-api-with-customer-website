<?php

namespace App\Controller\API\APIAction;

use App\Entity\Address;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\API\APIDefaultController;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ErrorManagement\AddressValidate;


class AddressAction extends APIDefaultController
{
    private $manager;

    private $addressRepo;

    private $addressValidate;

    private $userRepo;

    public function __construct(
        EntityManagerInterface $manager,
        AddressRepository $addressRepo,
        AddressValidate $addressValidate,
        UserRepository $userRepo
    ) {
        $this->manager = $manager;
        $this->addressRepo = $addressRepo;
        $this->addressValidate = $addressValidate;
        $this->userRepo = $userRepo;
    }


    public function list()
    {
        $addresses = $this->addressRepo->getAllAddresses();

        if ($addresses != 'Aucune addresse dans notre base pour l\'instant') {
            return $this->respond($addresses);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    public function create(Request $request)
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

                if (!empty($this->userRepo->findBy(array('id' => $jsonDataRequestToCreateAddress["userId"]),array('email' => 'ASC'),1 ,0)[0])) {
                    $user = $this->userRepo->findBy(array('id' => $jsonDataRequestToCreateAddress["userId"]),array('email' => 'ASC'),1 ,0)[0];
                } else {
                    return $this->respondNotFound('Nous sommes désolé, ce userId n\'existe pas');
                }
                
                // Address entity instanciation
                $address = new Address;
                // Address setters the content request
                $address->setStreetNb($jsonDataRequestToCreateAddress["streetNb"])
                    ->setAddress($jsonDataRequestToCreateAddress["address"])
                    ->setPostal($jsonDataRequestToCreateAddress["postal"])
                    ->setCity($jsonDataRequestToCreateAddress["city"])
                    ->setType($jsonDataRequestToCreateAddress["type"])
                    ->setUser($user);

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

    public function show(Address $address = null, Request $request)
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

    public function update(Address $address = null, Request $request)
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

                    // Address flush in the database
                    $this->manager->flush();

                    // Returns the created address, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->addressRepo->getAddressById($address->getId()));
                } else {
                    return $this->addressValidate->addressUpdateValidateRequest($jsonDataRequestToEditAddress);
                }
            }
        }
    }

    public function delete(Address $address = null, Request $request)
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
