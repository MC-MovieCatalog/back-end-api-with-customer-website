<?php

namespace App\Services;

use App\Services\ErrorAssert;
use App\Controller\API\APIDefaultController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the book controller
 */
class BookValidate extends ErrorAssert
{
    protected function pageNbValidated($request)
    {

        $pageNbErrors = [];

        // if not integer value ?
        if ($this->errorIntegerAssert($request, 'pageNb')) {
            array_push($pageNbErrors, $this->errorIntegerAssert($request, 'pageNb'));
        }
        // if < min lenght ?
        if ($this->errorIntegerMinLenghtAssert($request, 'pageNb', 1)) {
            array_push($pageNbErrors, $this->errorIntegerMinLenghtAssert($request, 'pageNb', 1));
        }
        // if > max lenght ?
        if ($this->errorIntegerMaxLenghtAssert($request, 'pageNb', 10)) {
            array_push($pageNbErrors, $this->errorIntegerMaxLenghtAssert($request, 'pageNb', 10));
        }
        // if < min value ?
        if ($this->errorIntegerMinValeuAssert($request, 'pageNb', 1)) {
            array_push($pageNbErrors, $this->errorIntegerMinValeuAssert($request, 'pageNb', 1));
        }
        // if > max value ?
        if ($this->errorIntegerMaxValueAssert($request, 'pageNb', 2147483647)) {
            array_push($pageNbErrors, $this->errorIntegerMaxValueAssert($request, 'pageNb', 2147483647));
        }

        return $pageNbErrors;
    }

    protected function contentValidated($request)
    {
        $contentErrors = [];

        // if not string value ?
        if ($this->errorStringAssert($request, 'content')) {
            array_push($contentErrors, $this->errorStringAssert($request, 'content'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'content', 1000)) {
            array_push($contentErrors, $this->errorStringMinLenghtAssert($request, 'content', 1000));
        }

        return $contentErrors;
    }

    protected function descriptionValidated($request)
    {
        $descriptionErrors = [];

        // if not string value ?
        if ($this->errorStringAssert($request, 'description')) {
            array_push($descriptionErrors, $this->errorStringAssert($request, 'description'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'description', 11)) {
            array_push($descriptionErrors, $this->errorStringMinLenghtAssert($request, 'description', 11));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'description', 255)) {
            array_push($descriptionErrors, $this->errorStringAssert($request, 'description', 255));
        }

        return $descriptionErrors;
    }

    protected function titleValidated($request)
    {
        $titleErrors = [];
        // if not string value ?
        if ($this->errorStringAssert($request, 'title')) {
            array_push($titleErrors, $this->errorStringAssert($request, 'title'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'title', 5)) {
            array_push($titleErrors, $this->errorStringMinLenghtAssert($request, 'title', 5));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'title', 80)) {
            array_push($titleErrors, $this->errorStringAssert($request, 'title', 80));
        }

        return $titleErrors;
    }

    protected function priceValidated($request)
    {
        $priceErrors = [];
        // if not float/double value ?
        if ($this->errorFloatAssert($request, 'price')) {
            array_push($priceErrors, $this->errorFloatAssert($request, 'price'));
        }

        return $priceErrors;
    }

    protected function coverValidated($request)
    {
        $coverErrors = [];

        // if not string value ?
        if ($this->errorStringAssert($request, 'cover')) {
            array_push($coverErrors, $this->errorStringAssert($request, 'cover'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'cover', 5)) {
            array_push($coverErrors, $this->errorStringMinLenghtAssert($request, 'cover', 5));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'cover', 255)) {
            array_push($coverErrors, $this->errorStringAssert($request, 'cover', 255));
        }

        return $coverErrors;
    }

    protected function authorValidated($request)
    {
        $authorErrors = [];
        // if not string value ?
        if ($this->errorStringAssert($request, 'author')) {
            array_push($authorErrors, $this->errorStringAssert($request, 'author'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'author', 2)) {
            array_push($authorErrors, $this->errorStringMinLenghtAssert($request, 'author', 2));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'author', 255)) {
            array_push($authorErrors, $this->errorStringAssert($request, 'author', 255));
        }

        return $authorErrors;
    }


    /**
     * This function manages all input errors during creation or update requests concerning book.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateBookMessage($request)
    {

        $errors = [];


        // pageNb

        // if empty
        if ($this->errorEmptyAssert($request, 'pageNb')) {
            array_push($errors, $this->errorEmptyAssert($request, 'pageNb', 'Le nombre de page ne peut pas être vide'));
        } else if ($this->pageNbValidated($request)) {
            foreach ($this->pageNbValidated($request) as $pageNBError) {
                array_push($errors, $pageNBError);
            }
        }

        // content

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'content')) {
            array_push($errors, $this->errorEmptyAssert($request, 'content', 'Le contenu ne peut pas être vide'));
        } else if ($this->contentValidated($request)) {
            foreach ($this->contentValidated($request) as $contentError) {
                array_push($errors, $contentError);
            }
        }

        // description

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'description')) {
            array_push($errors, $this->errorEmptyAssert($request, 'description', 'La description ne peut pas être vide'));
        } else if ($this->descriptionValidated($request)) {
            foreach ($this->descriptionValidated($request) as $descriptionError) {
                array_push($errors, $descriptionError);
            }
        }

        // title

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'title')) {
            array_push($errors, $this->errorEmptyAssert($request, 'title', 'Le titre ne peut pas être vide'));
        } else if ($this->titleValidated($request)) {
            foreach ($this->titleValidated($request) as $titleError) {
                array_push($errors, $titleError);
            }
        }

        // price

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'price')) {
            array_push($errors, $this->errorEmptyAssert($request, 'price', 'Le prix ne peut pas être vide'));
        } else if ($this->priceValidated($request)) {
            foreach ($this->priceValidated($request) as $priceError) {
                array_push($errors, $priceError);
            }
        }

        // cover

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'cover')) {
            array_push($errors, $this->errorEmptyAssert($request, 'cover', 'La couverture ne peut pas être vide'));
        } else if ($this->coverValidated($request)) {
            foreach ($this->coverValidated($request) as $coverError) {
                array_push($errors, $coverError);
            }
        }

        // author

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'author')) {
            array_push($errors, $this->errorEmptyAssert($request, 'author', 'L\'auteur ne peut pas être vide'));
        } else if ($this->authorValidated($request)) {
            foreach ($this->authorValidated($request) as $authorError) {
                array_push($errors, $authorError);
            }
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning book.
     *
     * @param array $request
     * @return void
     */
    public function bookCreateValidateRequest($request)
    {
        $errors = $this->errorCreateBookMessage($request);
        $errorsToDisplay = [];

        foreach ($errors as $error) {
            if ($error !== null) {
                array_push($errorsToDisplay, $error);
            }
        }

        if (count($errorsToDisplay) > 0) {
            return new JsonResponse($errorsToDisplay, 422, []);
        } else {
            return null;
        }
    }

    /**
     * This function manages all input errors during creation or update requests concerning book.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateBookMessage($request)
    {

        $errors = [];


        // pageNb

        // if defined
        if ($this->errorDefinedAssert($request, 'pageNb')) {
            foreach ($this->pageNbValidated($request) as $pageNBError) {
                array_push($errors, $pageNBError);
            }
        }

        // content

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'content')) {
            foreach ($this->contentValidated($request) as $contentError) {
                array_push($errors, $contentError);
            }
        }

        // description

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'description')) {
            foreach ($this->descriptionValidated($request) as $descriptionError) {
                array_push($errors, $descriptionError);
            }
        }

        // title

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'title')) {
            foreach ($this->titleValidated($request) as $titleError) {
                array_push($errors, $titleError);
            }
        }

        // price

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'price')) {
            foreach ($this->priceValidated($request) as $priceError) {
                array_push($errors, $priceError);
            }
        }

        // cover

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'cover')) {
            foreach ($this->coverValidated($request) as $coverError) {
                array_push($errors, $coverError);
            }
        }

        // author

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'author')) {
            foreach ($this->authorValidated($request) as $authorError) {
                array_push($errors, $authorError);
            }
        }

        // if field = 0
        if (
            !$this->errorDefinedAssert($request, 'pageNb')
            && !$this->errorDefinedAssert($request, 'content')
            && !$this->errorDefinedAssert($request, 'description')
            && !$this->errorDefinedAssert($request, 'title')
            && !$this->errorDefinedAssert($request, 'price')
            && !$this->errorDefinedAssert($request, 'cover')
            && !$this->errorDefinedAssert($request, 'author')

        ) {
            array_push($errors, ['Error' => 'Aucune modification détectée, merci de vérifier...']);
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning book.
     *
     * @param array $request
     * @return void
     */
    public function bookUpdateValidateRequest($request)
    {
        $errors = $this->errorUpdateBookMessage($request);
        $errorsToDisplay = [];

        foreach ($errors as $error) {
            if ($error !== null) {
                array_push($errorsToDisplay, $error);
            }
        }

        if (count($errorsToDisplay) > 0) {
            return new JsonResponse($errorsToDisplay, 422, []);
        } else {
            return null;
        }
    }
}
