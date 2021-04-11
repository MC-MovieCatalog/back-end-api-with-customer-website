<?php

namespace App\Services\ErrorManagement;

/**
 * This class handles errors for the API responses
 */
class ErrorAssert
{
    // Empty data

    /**
     * This function checks whether the content of the specified field is defined.
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorEmptyAssert(array $data, string $field, string $message = 'Ce champ est obligatoire')
    {
        if (array_key_exists($field, $data) === false) {
            return ['field' => $field, 'message' => $message];
        }
        
        // return array_key_exists($field, $data) ? true : ['field' => $field, 'message' => $message];
    }

    /**
     * This function checks whether the content of the specified value is null.
     *
     * @param array $data
     * @param string $field
     * @param string $message
     */
    protected function errorDefinedAssert(array $data, string $field)
    {
        if (array_key_exists($field, $data)) {
            return true;
        }
    }

    // Integer 

    /**
     * This function checks if the indicated value is of type integer
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorIntegerAssert(array $data, string $field, string $message = 'Cette valeur doit être un nombre entier')
    {
        if (is_int($data[$field]) !== true) {
            return ['field' => $field, 'message' => $message];
        }
    }


    /**
     * This function checks if the indicated value is of type numeric
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorNumericAssert(array $data, string $field, string $message = 'Cette valeur n\'est pas conforme')
    {
        if (is_numeric($data[$field]) !== true) {
            return ['field' => $field, 'message' => $message];
        }
    }

    /**
     * This function checks the minimum size of the entered numeric value
     *
     * @param array $data
     * @param string $field
     * @param integer $minLenght
     * @param string $message
     * @return array
     */
    protected function errorNumericMinLenghtAssert(
        array $data,
        string $field,
        int $minLenght,
        string $message = 'Le nombre saisit ne peut peut contenir moins de '
    ) {
        $error = ($message !== 'Le nombre saisit ne peut peut contenir moins de ') ? $message : $message . strval($minLenght) . ' chiffres(s)';

        if (is_numeric($data[$field]) === true && strlen((string)$data[$field]) < $minLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks the maximum size of the entered numeric value
     *
     * @param array $data
     * @param string $field
     * @param integer $maxLenght
     * @param string $message
     * @return array
     */
    protected function errorNumericMaxLenghtAssert(
        array $data,
        string $field,
        int $maxLenght,
        string $message = 'Le nombre saisit ne peut peut contenir plus de '
    ) {
        $error = ($message !== 'Le nombre saisit ne peut peut contenir plus de ') ? $message : $message . strval($maxLenght) . ' chiffre(s)';

        if (is_numeric($data[$field]) === true && strlen((string)$data[$field]) > $maxLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }
    
    /**
     * This function checks the minimum size of the entered int value
     *
     * @param array $data
     * @param string $field
     * @param integer $minLenght
     * @param string $message
     * @return array
     */
    protected function errorIntegerMinLenghtAssert(
        array $data,
        string $field,
        int $minLenght,
        string $message = 'Le nombre saisit ne peut peut contenir moins de '
    ) {
        $error = ($message !== 'Le nombre saisit ne peut peut contenir moins de ') ? $message : $message . strval($minLenght) . ' chiffres(s)';

        if (is_int($data[$field]) === true && strlen((string)$data[$field]) < $minLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks the maximum size of the entered int value
     *
     * @param array $data
     * @param string $field
     * @param integer $maxLenght
     * @param string $message
     * @return array
     */
    protected function errorIntegerMaxLenghtAssert(
        array $data,
        string $field,
        int $maxLenght,
        string $message = 'Le nombre saisit ne peut peut contenir plus de '
    ) {
        $error = ($message !== 'Le nombre saisit ne peut peut contenir plus de ') ? $message : $message . strval($maxLenght) . ' chiffre(s)';

        if (is_int($data[$field]) === true && strlen((string)$data[$field]) > $maxLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks the minimum int value entered
     *
     * @param array $data
     * @param string $field
     * @param integer $minValue
     * @param string $message
     * @return array
     */
    protected function errorIntegerMinValeuAssert(
        array $data,
        string $field,
        int $minValue,
        string $message = 'Le nombre saisit ne peut pas être plus petit que '
    ) {
        $error = ($message !== 'Le nombre saisit ne peut pas être plus petit que ') ? $message : $message . strval($minValue);

        if (is_int($data[$field]) === true && $data[$field] < $minValue) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks the maximum int value entered | max value 2147483647
     *
     * @param array $data
     * @param string $field
     * @param integer $maxValue
     * @param string $message
     * @return array
     */
    protected function errorIntegerMaxValueAssert(
        array $data,
        string $field,
        int $maxValue,
        string $message = 'La nombre saisit ne peut pas être plus grand que '
    ) {
        $error = ($message !== 'La nombre saisit ne peut pas être plus grand que ') ? $message : $message . strval($maxValue);

        if (is_int($data[$field]) === true && $data[$field] > $maxValue) {
            return ['field' => $field, 'error' => $error];
        }
    }

    // String

    /**
     * This function checks if the indicated value is of type string
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorStringAssert(array $data, string $field, string $message = 'Cette valeur doit être du texte')
    {
        if (is_string($data[$field]) === false) {
            return ['field' => $field, 'message' => $message];
        }
    }


    /**
     * This function checks the minimum size of the entered string value
     *
     * @param array $data
     * @param string $field
     * @param integer $minLenght
     * @param string $message
     * @return array
     */
    protected function errorStringMinLenghtAssert(
        array $data,
        string $field,
        int $minLenght,
        string $message = 'Vous ne pouvez pas saisir moins de '
    ) {
        $error = ($message !== 'Vous ne pouvez pas saisir moins de ') ? $message : $message . strval($minLenght) . ' caractères';

        if (is_string($data[$field]) === true && strlen((string)$data[$field]) < $minLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks the minimum size of the entered string value
     *
     * @param array $data
     * @param string $field
     * @param integer $maxLenght
     * @param string $message
     * @return array
     */
    protected function errorStringMaxLenghtAssert(
        array $data,
        string $field,
        int $maxLenght,
        string $message = 'Vous ne pouvez pas saisir plus de '
    ) {
        $error = ($message !== 'Vous ne pouvez pas saisir plus de ') ? $message : $message . strval($maxLenght) . ' caractères';

        if (is_string($data[$field]) === true && strlen((string)$data[$field]) > $maxLenght) {
            return ['field' => $field, 'error' => $error];
        }
    }

    /**
     * This function checks whether the content of the specified value is not empty.
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorFloatAssert(array $data, string $field, string $message = 'Cette valeur doit être un nombre décimal')
    {
        if (is_float($data[$field]) === false) {
            return ['field' => $field, 'message' => $message];
        }
    }
    // public function errorAsset($data, $field, $lenght = null, $message = null)
    
    protected function errorUrlAssert(array $data, string $field, string $message = 'Cette url n\'est pas valide') {
        if (!filter_var($data[$field], FILTER_VALIDATE_URL)) {
            return ['field' => $field, 'message' => $message];
        }
    }

    // Boolean

    /**
     * This function checks if the indicated value is of type bool
     *
     * @param array $data
     * @param boolean $field
     * @param string $message
     * @return array
     */
    protected function errorBooleanAssert(array $data, $field, string $message = 'Cette valeur doit être soit vrai soit faux')
    {
        if (is_bool($data[$field]) !== true) {
            return ['field' => $field, 'message' => $message];
        }
    }

    // Email
    
    /**
     * Undocumented function
     *
     * @param array $data
     * @param string $field
     * @param string $message
     * @return array
     */
    protected function errorEmailAssert(array $data, string $field, string $message = 'Cette email n\'est pas valide') {
        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            return ['field' => $field, 'message' => $message];
        }
    }
}
