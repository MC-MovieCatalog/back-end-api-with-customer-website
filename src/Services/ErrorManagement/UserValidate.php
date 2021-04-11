<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorManagement\CustomValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the user controller
 */
class UserValidate extends CustomValidator
{
    /**
     * This function manages all input errors during creation or update requests concerning user.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateUserMessage($request)
    {

        $errors = [];

        $email = $this->errorDefinedAssert($request, 'email') ? $this->customEmailValidator($request, 'email', 9, 180): null;
        $password = $this->errorDefinedAssert($request, 'password') ? $this->customStringValidator($request, 'password', 6, 255): null;
        $lastName = $this->errorDefinedAssert($request, 'lastName') ? $this->customStringValidator($request, 'lastName', 2, 80): null;
        $firstName = $this->errorDefinedAssert($request, 'firstName') ? $this->customStringValidator($request, 'firstName', 2, 80): null;
        $agreeTerms = $this->errorDefinedAssert($request, 'agreeTerms') ? $this->customBooleanValidator($request, 'agreeTerms'): null;

        // email

        // if empty
        if ($this->errorEmptyAssert($request, 'email')) {
            array_push($errors, $this->errorEmptyAssert($request, 'email', 'L\'email est obligatoire'));
        } else if ($email) {
            foreach ($email as $emailError) {
                array_push($errors, $emailError);
            }
        }

        // password

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'password')) {
            array_push($errors, $this->errorEmptyAssert($request, 'password', 'Le mot de passe est obligatoire'));
        } else if ($password) {
            foreach ($password as $passwordError) {
                array_push($errors, $passwordError);
            }
        }

        // lastName

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'lastName')) {
            array_push($errors, $this->errorEmptyAssert($request, 'lastName', 'Le nom est obligatoire'));
        } else if ($lastName) {
            foreach ($lastName as $lastNameError) {
                array_push($errors, $lastNameError);
            }
        }

        // firstName

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'firstName')) {
            array_push($errors, $this->errorEmptyAssert($request, 'firstName', 'Le prénom est obligatoire'));
        } else if ($firstName) {
            foreach ($firstName as $firstNameError) {
                array_push($errors, $firstNameError);
            }
        }

        // agreeTerms

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'agreeTerms')) {
            array_push($errors, $this->errorEmptyAssert($request, 'agreeTerms', 'L\'acceptation de nos conditions est requise'));
        } else if ($agreeTerms) {
            foreach ($agreeTerms as $agreeTermsError) {
                array_push($errors, $agreeTermsError);
            }
        }
        
        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning user.
     *
     * @param array $request
     * @return void
     */
    public function userCreateValidateRequest($request)
    {
        $errors = $this->errorCreateUserMessage($request);
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
     * This function manages all input errors during creation or update requests concerning user.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateUserMessage($request)
    {

        $errors = [];

        $email = $this->errorDefinedAssert($request, 'email') ? $this->customEmailValidator($request, 'email', 9, 180): null;
        $password = $this->errorDefinedAssert($request, 'password') ? $this->customStringValidator($request, 'password', 6, 255): null;
        $lastName = $this->errorDefinedAssert($request, 'lastName') ? $this->customStringValidator($request, 'lastName', 2, 80): null;
        $firstName = $this->errorDefinedAssert($request, 'firstName') ? $this->customStringValidator($request, 'firstName', 2, 80): null;
        $agreeTerms = $this->errorDefinedAssert($request, 'agreeTerms') ? $this->customBooleanValidator($request, 'agreeTerms'): null;
        $isActive = $this->errorDefinedAssert($request, 'isActive') ? $this->customBooleanValidator($request, 'isActive'): null;
        $isVerified = $this->errorDefinedAssert($request, 'isVerified') ? $this->customBooleanValidator($request, 'isVerified'): null;

        // email

        // if defined
        if ($this->errorDefinedAssert($request, 'email')) {
            foreach ($email as $emailError) {
                array_push($errors, $emailError);
            }
        }

        // password

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'password')) {
            foreach ($password as $passwordError) {
                array_push($errors, $passwordError);
            }
        }

        // lastName

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'lastName')) {
            foreach ($lastName as $lastNameError) {
                array_push($errors, $lastNameError);
            }
        }

        // firstName

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'firstName')) {
            foreach ($firstName as $firstNameError) {
                array_push($errors, $firstNameError);
            }
        }

        // agreeTerms

        // if defined field ?
        if ($this->errorDefinedAssert($request, 'agreeTerms')) {
            foreach ($agreeTerms as $agreeTermsError) {
                array_push($errors, $agreeTermsError);
            }
        }

        // isActive

        // if not empty field ?
        if ($this->errorDefinedAssert($request, 'isActive')) {
            foreach ($isActive as $isActiveError) {
                array_push($errors, $isActiveError);
            }
        }

        // isVerified

        // if not empty field ?
        if ($this->errorDefinedAssert($request, 'isVerified')) {
            foreach ($isVerified as $isVerifiedError) {
                array_push($errors, $isVerifiedError);
            }
        }

        // if field = 0
        if (
            !$this->errorDefinedAssert($request, 'email')
            && !$this->errorDefinedAssert($request, 'password')
            && !$this->errorDefinedAssert($request, 'lastName')
            && !$this->errorDefinedAssert($request, 'firstName')
            && !$this->errorDefinedAssert($request, 'agreeTerms')
            && !$this->errorDefinedAssert($request, 'isActive')
            && !$this->errorDefinedAssert($request, 'isVerified')
        ) {
            array_push($errors, ['Error' => 'Aucune modification détectée, merci de vérifier...']);
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning user.
     *
     * @param array $request
     * @return void
     */
    public function userUpdateValidateRequest($request)
    {
        $errors = $this->errorUpdateUserMessage($request);
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
