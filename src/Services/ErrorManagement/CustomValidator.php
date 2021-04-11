<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorManagement\ErrorAssert;
use App\Controller\API\APIDefaultController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the entities controllers
 */
class CustomValidator extends ErrorAssert
{
    protected function stringFieldValidator($request, $field, ?int $minLength, ?int $maxLength)
    {

        $fieldErrors = [];

        // is not string value ?
        if ($this->errorStringAssert($request, $field)) {
            array_push($fieldErrors, $this->errorStringAssert($request, $field));
        }
        // if < min lenght ?
        if ($minLength !== null) {
            if ($this->errorStringMinLenghtAssert($request, $field, $minLength)) {
                array_push($fieldErrors, $this->errorStringMinLenghtAssert($request, $field, $minLength));
            }
        }
        // if > max lenght ?
        if ($maxLength !== null) {
            if ($this->errorStringMaxLenghtAssert($request, $field, $maxLength)) {
                array_push($fieldErrors, $this->errorStringMaxLenghtAssert($request, $field, $maxLength));
            }
        }

        return $fieldErrors;
    }

    protected function numericFieldValidator($request, $field, ?int $minLength, ?int $maxLength)
    {

        $fieldErrors = [];

        // is not string value ?
        if ($this->errorNumericAssert($request, $field)) {
            array_push($fieldErrors, $this->errorNumericAssert($request, $field));
        }
        // if < min lenght ?
        if ($minLength !== null) {
            if ($this->errorNumericMinLenghtAssert($request, $field, $minLength)) {
                array_push($fieldErrors, $this->errorNumericMinLenghtAssert($request, $field, $minLength));
            }
        }
        // if > max lenght ?
        if ($maxLength !== null) {
            if ($this->errorNumericMaxLenghtAssert($request, $field, $maxLength)) {
                array_push($fieldErrors, $this->errorNumericMaxLenghtAssert($request, $field, $maxLength));
            }
        }

        return $fieldErrors;
    }

    protected function integerFieldValidator($request, $field, ?int $minLength, ?int $maxLength, ?int $minValue, ?int $maxValue)
    {

        $fieldErrors = [];

        // if not integer value ?
        if ($this->errorIntegerAssert($request, $field)) {
            array_push($fieldErrors, $this->errorIntegerAssert($request, $field));
        }
        // if < min lenght ?
        if ($minLength !== null) {
            if ($this->errorIntegerMinLenghtAssert($request, $field, $minLength)) {
                array_push($fieldErrors, $this->errorIntegerMinLenghtAssert($request, $field, $minLength));
            }
        }
        // if > max lenght ?
        if ($maxLength !== null) {
            if ($this->errorIntegerMaxLenghtAssert($request, $field, $maxLength)) {
                array_push($fieldErrors, $this->errorIntegerMaxLenghtAssert($request, $field, $maxLength));
            }
        }
        // if < min value ?
        if ($minValue !== null) {
            if ($this->errorIntegerMinValeuAssert($request, $field, $minValue)) {
                array_push($fieldErrors, $this->errorIntegerMinValeuAssert($request, $field, $minValue));
            }
        }
        // if > max value ?
        if ($maxValue !== null) {
            if ($this->errorIntegerMaxValueAssert($request, $field, $maxValue)) {
                array_push($fieldErrors, $this->errorIntegerMaxValueAssert($request, $field, $maxValue));
            }
        }

        return $fieldErrors;
    }

    protected function customStringValidator($request, $field, ?int $minLength, ?int $maxLength)
    {
        $stringErrors = $this->stringFieldValidator($request, $field, $minLength, $maxLength);

        // if not integer value ?
        if ($this->errorStringAssert($request, $field)) {
            array_push($stringErrors, $this->errorStringAssert($request, $field));
        }

        return $stringErrors;
    }

    protected function customUrlValidator($request, $field, ?int $minLength, ?int $maxLength)
    {
        $stringErrors = $this->customStringValidator($request, $field, $minLength, $maxLength);

        // if not integer value ?
        if ($this->errorUrlAssert($request, $field)) {
            array_push($stringErrors, $this->errorUrlAssert($request, $field));
        }

        return $stringErrors;
    }

    protected function customIntegerValidator($request, $field, ?int $minLength, ?int $maxLength, ?int $minValue, ?int $maxValue)
    {
        $integerErrors = $this->integerFieldValidator($request, $field, $minLength, $maxLength, $minValue, $maxValue);

        // if not integer value ?
        if ($this->errorIntegerAssert($request, $field)) {
            array_push($integerErrors, $this->errorIntegerAssert($request, $field));
        }

        return $integerErrors;
    }

    protected function customNumricValidator($request, $field, ?int $minLength, ?int $maxLength)
    {
        $stringErrors = $this->numericFieldValidator($request, $field, $minLength, $maxLength);

        // if not numeric value ?
        if ($this->errorNumericAssert($request, $field)) {
            array_push($stringErrors, $this->errorNumericAssert($request, $field));
        }

        return $stringErrors;
    }

    protected function customFloatValidator($request, $field)
    {
        $floatErrors = [];
        // if not float/double value ?
        if ($this->errorFloatAssert($request, $field)) {
            array_push($floatErrors, $this->errorFloatAssert($request, $field));
        }

        return $floatErrors;
    }


    protected function customBooleanValidator($request, $field)
    {
        $booleanErrors = [];

        // if not boolean value ?
        if ($this->errorBooleanAssert($request, $field)) {
            array_push($booleanErrors, $this->errorBooleanAssert($request, $field));
        }

        return $booleanErrors;
    }

    protected function customEmailValidator($request, $field, ?int $minLength, ?int $maxLength)
    {
        $emailErrors = $this->customStringValidator($request, $field, $minLength, $maxLength);

        // if not integer value ?
        if ($this->errorEmailAssert($request, $field)) {
            array_push($emailErrors, $this->errorEmailAssert($request, $field));
        }

        return $emailErrors;
    }

}
