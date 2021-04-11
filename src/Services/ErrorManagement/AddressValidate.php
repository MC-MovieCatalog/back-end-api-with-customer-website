<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorManagement\CustomValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the address controller
 */
class AddressValidate extends CustomValidator
{
    /**
     * This function manages all input errors during creation or update requests concerning address.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateAddressMessage($request)
    {

        $errors = [];

        $streetNb = $this->errorDefinedAssert($request, 'streetNb') ? $this->customNumricValidator($request, 'streetNb', 1, 255): null;
        $address = $this->errorDefinedAssert($request, 'address') ? $this->customStringValidator($request, 'address', 7, 255): null;
        $postal = $this->errorDefinedAssert($request, 'postal') ? $this->customStringValidator($request, 'postal', 5, 5): null;
        $city = $this->errorDefinedAssert($request, 'city') ? $this->customStringValidator($request, 'city', 3, 255): null;
        $type = $this->errorDefinedAssert($request, 'type') ? $this->customStringValidator($request, 'type', 8, 255): null;
        $userId = $this->errorDefinedAssert($request, 'userId') ? $this->customIntegerValidator($request, 'userId', 1, 10, 1, 2147483647): null;

        // streetNb

        // if empty
        if ($this->errorEmptyAssert($request, 'streetNb')) {
            array_push($errors, $this->errorEmptyAssert($request, 'streetNb', 'La numéro de rue ne peut pas être vide'));
        } else if ($streetNb) {
            foreach ($streetNb as $streetNbError) {
                array_push($errors, $streetNbError);
            }
        }

        // address

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'address')) {
            array_push($errors, $this->errorEmptyAssert($request, 'address', 'L\'address ne peut pas être vide'));
        } else if ($address) {
            foreach ($address as $addressError) {
                array_push($errors, $addressError);
            }
        }

        // postal

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'postal')) {
            array_push($errors, $this->errorEmptyAssert($request, 'postal', 'Le code postal ne peut pas être vide'));
        } else if ($postal) {
            foreach ($postal as $postalError) {
                array_push($errors, $postalError);
            }
        }

        // city

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'city')) {
            array_push($errors, $this->errorEmptyAssert($request, 'city', 'La ville ne peut pas être vide'));
        } else if ($city) {
            foreach ($city as $cityError) {
                array_push($errors, $cityError);
            }
        }

        // type

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'type')) {
            array_push($errors, $this->errorEmptyAssert($request, 'type', 'Le type d\'adresse est obligatoire'));
        } else if ($type) {
            foreach ($type as $typeError) {
                array_push($errors, $typeError);
            }
        }

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'userId')) {
            array_push($errors, $this->errorEmptyAssert($request, 'userId', 'L\'adresse doit être associée à un utilisateur'));
        } else if ($userId) {
            foreach ($userId as $userIdError) {
                array_push($errors, $userIdError);
            }
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning address.
     *
     * @param array $request
     * @return void
     */
    public function addressCreateValidateRequest($request)
    {
        $errors = $this->errorCreateAddressMessage($request);
        $errorsToDisplay = [];

        foreach ($errors as $error) {
            if ($error !== null) {
                if (!in_array($error, $errorsToDisplay)) {
                    array_push($errorsToDisplay, $error);
                }
            }
        }

        if (count($errorsToDisplay) > 0) {
            return new JsonResponse($errorsToDisplay, 422, []);
        } else {
            return null;
        }
    }

    /**
     * This function manages all input errors during creation or update requests concerning address.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateAddressMessage($request)
    {

        $errors = [];

        $streetNb = $this->errorDefinedAssert($request, 'streetNb') ? $this->customNumricValidator($request, 'streetNb', 2, 255): null;
        $address = $this->errorDefinedAssert($request, 'address') ? $this->customStringValidator($request, 'address', 11, 255): null;
        $postal = $this->errorDefinedAssert($request, 'postal') ? $this->customStringValidator($request, 'postal', 5, 80): null;
        $city = $this->errorDefinedAssert($request, 'city') ? $this->customStringValidator($request, 'city', 5, 255): null;
        $type = $this->errorDefinedAssert($request, 'type') ? $this->customStringValidator($request, 'type', 5, 255): null;
        $userId = $this->errorDefinedAssert($request, 'userId') ? $this->customIntegerValidator($request, 'userId', 1, 10, 1, 2147483647): null;

        // streetNb

        // if defined
        if ($this->errorDefinedAssert($request, 'streetNb')) {
            foreach ($streetNb as $streetNbError) {
                array_push($errors, $streetNbError);
            }
        }

        // address

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'address')) {
            foreach ($address as $addressError) {
                array_push($errors, $addressError);
            }
        }

        // postal

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'postal')) {
            foreach ($postal as $postalError) {
                array_push($errors, $postalError);
            }
        }

        // city

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'city')) {
            foreach ($city as $cityError) {
                array_push($errors, $cityError);
            }
        }

        // type

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'type')) {
            foreach ($type as $typeError) {
                array_push($errors, $typeError);
            }
        }

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'userId')) {
            foreach ($userId as $userIdError) {
                array_push($errors, $userIdError);
            }
        }

        // if field = 0
        if (
            !$this->errorDefinedAssert($request, 'streetNb')
            && !$this->errorDefinedAssert($request, 'address')
            && !$this->errorDefinedAssert($request, 'postal')
            && !$this->errorDefinedAssert($request, 'city')
            && !$this->errorDefinedAssert($request, 'type')
            && !$this->errorDefinedAssert($request, 'userId')

        ) {
            array_push($errors, ['Error' => 'Aucune modification détectée, merci de vérifier...']);
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning address.
     *
     * @param array $request
     * @return void
     */
    public function addressUpdateValidateRequest($request)
    {
        $errors = $this->errorUpdateAddressMessage($request);
        $errorsToDisplay = [];

        foreach ($errors as $error) {
            if ($error !== null) {
                if (!in_array($error, $errorsToDisplay)) {
                    array_push($errorsToDisplay, $error);
                }
            }
        }

        if (count($errorsToDisplay) > 0) {
            return new JsonResponse($errorsToDisplay, 422, []);
        } else {
            return null;
        }
    }
}
