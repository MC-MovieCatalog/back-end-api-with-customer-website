<?php

namespace App\Services\ErrorManagement;

use App\Services\ErrorAssert\ErrorManagement;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This class handles errors for the movie controller
 */
class MovieValidateDeprecated extends ErrorAssert
{
    protected function durationValidated($request)
    {

        $durationErrors = [];

        // if not string value ?
        if ($this->errorStringAssert($request, 'duration')) {
            array_push($durationErrors, $this->errorStringAssert($request, 'duration'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'duration', 2)) {
            array_push($durationErrors, $this->errorStringMinLenghtAssert($request, 'duration', 2));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'duration', 255)) {
            array_push($durationErrors, $this->errorStringMaxLenghtAssert($request, 'duration', 255));
        }

        return $durationErrors;
    }

    protected function linkValidated($request)
    {
        $linkErrors = [];

        // if not string value ?
        if ($this->errorStringAssert($request, 'link')) {
            array_push($linkErrors, $this->errorStringAssert($request, 'link'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'link', 28)) {
            array_push($linkErrors, $this->errorStringMinLenghtAssert($request, 'link', 28));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'link', 255)) {
            array_push($linkErrors, $this->errorStringMaxLenghtAssert($request, 'link', 255));
        }

        return $linkErrors;
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
            array_push($descriptionErrors, $this->errorStringMaxLenghtAssert($request, 'description', 255));
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
            array_push($titleErrors, $this->errorStringMaxLenghtAssert($request, 'title', 80));
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
            array_push($coverErrors, $this->errorStringMaxLenghtAssert($request, 'cover', 255));
        }

        return $coverErrors;
    }

    protected function directorValidated($request)
    {
        $directorErrors = [];
        // if not string value ?
        if ($this->errorStringAssert($request, 'director')) {
            array_push($directorErrors, $this->errorStringAssert($request, 'director'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'director', 5)) {
            array_push($directorErrors, $this->errorStringMinLenghtAssert($request, 'director', 5));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'director', 255)) {
            array_push($directorErrors, $this->errorStringMaxLenghtAssert($request, 'director', 255));
        }

        return $directorErrors;
    }

    protected function trailerValidated($request)
    {
        $trailerErrors = [];
        // if not string value ?
        if ($this->errorStringAssert($request, 'trailer')) {
            array_push($trailerErrors, $this->errorStringAssert($request, 'trailer'));
        }
        // if < min lenght ?
        if ($this->errorStringMinLenghtAssert($request, 'trailer', 5)) {
            array_push($trailerErrors, $this->errorStringMinLenghtAssert($request, 'trailer', 5));
        }
        // if > max lenght ?
        if ($this->errorStringMaxLenghtAssert($request, 'trailer', 255)) {
            array_push($trailerErrors, $this->errorStringMaxLenghtAssert($request, 'trailer', 255));
        }

        return $trailerErrors;
    }


    /**
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorCreateMovieMessage($request)
    {

        $errors = [];


        // duration

        // if empty
        if ($this->errorEmptyAssert($request, 'duration')) {
            array_push($errors, $this->errorEmptyAssert($request, 'duration', 'La durée est obligatoire'));
        } else if ($this->durationValidated($request)) {
            foreach ($this->durationValidated($request) as $durationError) {
                array_push($errors, $durationError);
            }
        }

        // link

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'link')) {
            array_push($errors, $this->errorEmptyAssert($request, 'link', 'Le lien est obligatoire'));
        } else if ($this->linkValidated($request)) {
            foreach ($this->linkValidated($request) as $linkError) {
                array_push($errors, $linkError);
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

        // director

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'director')) {
            array_push($errors, $this->errorEmptyAssert($request, 'director', 'Le directeur ne peut pas être vide'));
        } else if ($this->directorValidated($request)) {
            foreach ($this->directorValidated($request) as $directorError) {
                array_push($errors, $directorError);
            }
        }

        // trailer

        // if empty field ?
        if ($this->errorEmptyAssert($request, 'trailer')) {
            array_push($errors, $this->errorEmptyAssert($request, 'trailer', 'Le trailer ne peut pas être vide'));
        } else if ($this->directorValidated($request)) {
            foreach ($this->directorValidated($request) as $trailerError) {
                array_push($errors, $trailerError);
            }
        }

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
     * This function manages all input errors during creation or update requests concerning movie.
     *
     * @param array $request
     * @return array $errors
     */
    public function errorUpdateMovieMessage($request)
    {

        $errors = [];


        // duration

        // if defined
        if ($this->errorDefinedAssert($request, 'duration')) {
            foreach ($this->durationValidated($request) as $durationError) {
                array_push($errors, $durationError);
            }
        }

        // link

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'link')) {
            foreach ($this->linkValidated($request) as $linkError) {
                array_push($errors, $linkError);
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

        // director

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'director')) {
            foreach ($this->directorValidated($request) as $directorError) {
                array_push($errors, $directorError);
            }
        }

        // trailer

        // if empty field ?
        if ($this->errorDefinedAssert($request, 'trailer')) {
            foreach ($this->directorValidated($request) as $trailerError) {
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
