<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorModel\CustomValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the movie controller
 */
class MovieValidate extends CustomValidator
{
    /**
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateMovieMessage($request)
    {

        $errors = [];

        $duration = $this->errorDefinedAssert($request, 'duration') ? $this->customStringValidator($request, 'duration', 2, 255): null;
        // $link = $this->errorDefinedAssert($request, 'link') ? $this->customUrlValidator($request, 'link', 28, 255): null;
        $link = $this->errorDefinedAssert($request, 'link') ? $this->customStringValidator($request, 'link', 5, 80): null;
        $description = $this->errorDefinedAssert($request, 'description') ? $this->customStringValidator($request, 'description', 11, 255): null;
        // $description = $this->errorDefinedAssert($request, 'description') ? $this->customStringValidator($request, 'description', 11, 255): null;
        $title = $this->errorDefinedAssert($request, 'title') ? $this->customStringValidator($request, 'title', 5, 80): null;
        $price = $this->errorDefinedAssert($request, 'price') ? $this->customFloatOrIntegerValidator($request, 'price'): null;
        $cover = $this->errorDefinedAssert($request, 'cover') ? $this->customStringValidator($request, 'cover', 5, 255): null;
        $director = $this->errorDefinedAssert($request, 'director') ? $this->customStringValidator($request, 'director', 5, 255): null;
        $trailer = $this->errorDefinedAssert($request, 'trailer') ? $this->customStringValidator($request, 'trailer', 5, 255): null;

        // duration

        // if empty
        if ($this->errorEmptyAssert($request, 'duration')) {
            array_push($errors, $this->errorEmptyAssert($request, 'duration', 'La durée ne peut pas être vide'));
        } else if ($duration) {
            foreach ($duration as $durationError) {
                array_push($errors, $durationError);
            }
        }

        // link

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'link')) {
            array_push($errors, $this->errorEmptyAssert($request, 'link', 'Le lien est obligatoire'));
        } else if ($link) {
            foreach ($link as $linkError) {
                array_push($errors, $linkError);
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

        // director

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'director')) {
            array_push($errors, $this->errorEmptyAssert($request, 'director', 'Le directeur est obligatoire'));
        } else if ($director) {
            foreach ($director as $directorError) {
                array_push($errors, $directorError);
            }
        }

        // trailer

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'trailer')) {
            array_push($errors, $this->errorEmptyAssert($request, 'trailer', 'Le trailer est obligatoire'));
        } else if ($trailer) {
            foreach ($trailer as $trailerError) {
                array_push($errors, $trailerError);
            }
        }

        //dd($errors);
        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return void
     */
    public function movieCreateValidateRequest($request)
    {
        $errors = $this->errorCreateMovieMessage($request);
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
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateMovieMessage($request)
    {

        $errors = [];

        $duration = $this->errorDefinedAssert($request, 'duration') ? $this->customStringValidator($request, 'duration', 2, 255): null;
        $link = $this->errorDefinedAssert($request, 'link') ? $this->customStringValidator($request, 'link', 5, 80): null;
        // $link = $this->errorDefinedAssert($request, 'link') ? $this->customUrlValidator($request, 'link', 28, 255): null;
        $description = $this->errorDefinedAssert($request, 'description') ? $this->customStringValidator($request, 'description', 11, 255): null;
        $title = $this->errorDefinedAssert($request, 'title') ? $this->customStringValidator($request, 'title', 5, 80): null;
        $price = $this->errorDefinedAssert($request, 'price') ? $this->customFloatOrIntegerValidator($request, 'price'): null;
        $cover = $this->errorDefinedAssert($request, 'cover') ? $this->customStringValidator($request, 'cover', 5, 255): null;
        $director = $this->errorDefinedAssert($request, 'director') ? $this->customStringValidator($request, 'director', 5, 255): null;
        $trailer = $this->errorDefinedAssert($request, 'trailer') ? $this->customStringValidator($request, 'trailer', 5, 255): null;

        // duration

        // if defined
        if ($this->errorDefinedAssert($request, 'duration')) {
            foreach ($duration as $durationError) {
                array_push($errors, $durationError);
            }
        }

        // link

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'link')) {
            foreach ($link as $linkError) {
                array_push($errors, $linkError);
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

        // director

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'director')) {
            foreach ($director as $directorError) {
                array_push($errors, $directorError);
            }
        }

        // trailer

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'trailer')) {
            foreach ($trailer as $trailerError) {
                array_push($errors, $trailerError);
            }
        }

        // if field = 0
        if (
            !$this->errorDefinedAssert($request, 'duration')
            && !$this->errorDefinedAssert($request, 'link')
            && !$this->errorDefinedAssert($request, 'description')
            && !$this->errorDefinedAssert($request, 'title')
            && !$this->errorDefinedAssert($request, 'price')
            && !$this->errorDefinedAssert($request, 'cover')
            && !$this->errorDefinedAssert($request, 'director')
            && !$this->errorDefinedAssert($request, 'trailer')

        ) {
            array_push($errors, ['Error' => 'Aucune modification détectée, merci de vérifier...']);
        }

        return $errors;
    }

    /**
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return void
     */
    public function movieUpdateValidateRequest($request)
    {
        $errors = $this->errorUpdateMovieMessage($request);
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
