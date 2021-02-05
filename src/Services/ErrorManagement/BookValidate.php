<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorManagement\CustomValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the book controller
 */
class BookValidate extends CustomValidator
{
    /**
     * This function manages all input errors during creation or update requests concerning book.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateBookMessage($request)
    {

        $errors = [];

        $pageNb = $this->customIntegerValidator($request, 'pageNb', 1, 10, 1, 2147483647);
        $content = $this->customStringValidator($request, 'content', 1000, null);
        $description = $this->customStringValidator($request, 'description', 11, 255);
        $title = $this->customStringValidator($request, 'title', 5, 80);
        $price = $this->customFloatValidator($request, 'price');
        $cover = $this->customStringValidator($request, 'cover', 5, 255);
        $author = $this->customStringValidator($request, 'author', 2, 255);

        // pageNb

        // if empty
        if ($this->errorEmptyAssert($request, 'pageNb')) {
            array_push($errors, $this->errorEmptyAssert($request, 'pageNb', 'Le nombre de page ne peut pas être vide'));
        } else if ($pageNb) {
            foreach ($pageNb as $pageNbError) {
                array_push($errors, $pageNbError);
            }
        }

        // content

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'content')) {
            array_push($errors, $this->errorEmptyAssert($request, 'content', 'Le contenu ne peut pas être vide'));
        } else if ($content) {
            foreach ($content as $contentError) {
                array_push($errors, $contentError);
            }
        }

        // description

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'description')) {
            array_push($errors, $this->errorEmptyAssert($request, 'description', 'La description ne peut pas être vide'));
        } else if ($description) {
            foreach ($description as $descriptionError) {
                array_push($errors, $descriptionError);
            }
        }

        // title

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'title')) {
            array_push($errors, $this->errorEmptyAssert($request, 'title', 'Le titre ne peut pas être vide'));
        } else if ($title) {
            foreach ($title as $titleError) {
                array_push($errors, $titleError);
            }
        }

        // price

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'price')) {
            array_push($errors, $this->errorEmptyAssert($request, 'price', 'Le prix ne peut pas être vide'));
        } else if ($price) {
            foreach ($price as $priceError) {
                array_push($errors, $priceError);
            }
        }

        // cover

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'cover')) {
            array_push($errors, $this->errorEmptyAssert($request, 'cover', 'La couverture ne peut pas être vide'));
        } else if ($cover) {
            foreach ($cover as $coverError) {
                array_push($errors, $coverError);
            }
        }

        // author

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'author')) {
            array_push($errors, $this->errorEmptyAssert($request, 'author', 'L\'auteur ne peut pas être vide'));
        } else if ($author) {
            foreach ($author as $authorError) {
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
                if (!in_array($error, $errorsToDisplay)) {
                    array_push($errorsToDisplay, $error);
                }
                // dd($errorsToDisplay);
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

        $pageNb = $this->customIntegerValidator($request, 'pageNb', 1, 10, 1, 2147483647);
        $content = $this->customStringValidator($request, 'content', 1000, null);
        $description = $this->customStringValidator($request, 'description', 11, 255);
        $title = $this->customStringValidator($request, 'title', 5, 80);
        $price = $this->customFloatValidator($request, 'price');
        $cover = $this->customStringValidator($request, 'cover', 5, 255);
        $author = $this->customStringValidator($request, 'author', 2, 255);

        // pageNb

        // if defined
        if ($this->errorDefinedAssert($request, 'pageNb')) {
            foreach ($pageNb as $pageNbError) {
                array_push($errors, $pageNbError);
            }
        }

        // content

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'content')) {
            foreach ($content as $contentError) {
                array_push($errors, $contentError);
            }
        }

        // description

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'description')) {
            foreach ($description as $descriptionError) {
                array_push($errors, $descriptionError);
            }
        }

        // title

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'title')) {
            foreach ($title as $titleError) {
                array_push($errors, $titleError);
            }
        }

        // price

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'price')) {
            foreach ($price as $priceError) {
                array_push($errors, $priceError);
            }
        }

        // cover

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'cover')) {
            foreach ($cover as $coverError) {
                array_push($errors, $coverError);
            }
        }

        // author

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'author')) {
            foreach ($author as $authorError) {
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
