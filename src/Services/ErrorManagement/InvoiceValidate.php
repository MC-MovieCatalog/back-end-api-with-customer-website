<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorModel\CustomValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the invoice controller
 */
class InvoiceValidate extends CustomValidator
{
    /**
     * This function manages all input errors during creation or update requests concerning invoice.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateInvoiceMessage($request)
    {

        $errors = [];

        $customerId = $this->errorDefinedAssert($request, 'customerId') ? $this->customIntegerValidator($request, 'customerId', 1, 10, 1, 2147483647): null;
        $addressId = $this->errorDefinedAssert($request, 'addressId') ? $this->customIntegerValidator($request, 'addressId', 1, 10, 1, 2147483647): null;
        $amount = $this->errorDefinedAssert($request, 'amount') ? $this->customFloatValidator($request, 'amount'): null;
        $movies = $this->errorDefinedAssert($request, 'amount') ? false : null;


        // customer / user

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'customerId')) {
            array_push($errors, $this->errorEmptyAssert($request, 'customerId', 'La facture doit être associée à un client'));
        } else if ($customerId) {
            foreach ($customerId as $customerIdError) {
                array_push($errors, $customerIdError);
            }
        }

        // address

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'addressId')) {
            array_push($errors, $this->errorEmptyAssert($request, 'addressId', 'La facture doit être associée à une adresse'));
        } else if ($addressId) {
            foreach ($addressId as $addressIdError) {
                array_push($errors, $addressIdError);
            }
        }

        // amount

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'amount')) {
            array_push($errors, $this->errorEmptyAssert($request, 'amount', 'Le montant ne peut pas être vide'));
        } else if ($amount) {
            foreach ($amount as $amountError) {
                array_push($errors, $amountError);
            }
        }

        // movies

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'movies')) {
            array_push($errors, $this->errorEmptyAssert($request, 'movies', 'Vous devez ajouter au moins un films sur votre facture'));
        } else if ($movies) {
            foreach ($movies as $moviesError) {
                array_push($errors, $moviesError);
            }
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning invoice.
     *
     * @param array $request
     * @return void
     */
    public function invoiceCreateValidateRequest($request)
    {
        $errors = $this->errorCreateInvoiceMessage($request);
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
     * This function manages all input errors during creation or update requests concerning invoice.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateInvoiceMessage($request)
    {

        $errors = [];

        $customerId = $this->errorDefinedAssert($request, 'customerId') ? $this->customIntegerValidator($request, 'customerId', 1, 10, 1, 2147483647): null;
        $addressId = $this->errorDefinedAssert($request, 'addressId') ? $this->customIntegerValidator($request, 'addressId', 1, 10, 1, 2147483647): null;
        $amount = $this->errorDefinedAssert($request, 'amount') ? $this->customFloatValidator($request, 'amount'): null;
        $movies = $this->errorDefinedAssert($request, 'amount') ? 'Vous devez ajouter au moins un films sur votre facture': null;

        // customerId

        // if defined
        if ($this->errorDefinedAssert($request, 'customerId')) {
            foreach ($customerId as $customerIdError) {
                array_push($errors, $customerIdError);
            }
        }

        // address

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'addressId')) {
            foreach ($addressId as $addressIdError) {
                array_push($errors, $addressIdError);
            }
        }

        // amount

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'amount')) {
            foreach ($amount as $amountError) {
                array_push($errors, $amountError);
            }
        }

        // movies

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'movies')) {
            array_push($errors, $movies);
        }

        // if field = 0
        if (
            !$this->errorDefinedAssert($request, 'customerId')
            && !$this->errorDefinedAssert($request, 'addressId')
            && !$this->errorDefinedAssert($request, 'customerId')
        ) {
            array_push($errors, ['Error' => 'Aucune modification détectée, merci de vérifier...']);
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning invoice.
     *
     * @param array $request
     * @return void
     */
    public function invoiceUpdateValidateRequest($request)
    {
        $errors = $this->errorUpdateInvoiceMessage($request);
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
