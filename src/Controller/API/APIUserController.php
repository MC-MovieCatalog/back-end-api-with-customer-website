<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Controller\API\APIAction\UserAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API User Controller
 * @Route("/api/users")
 */
class APIUserController extends APIDefaultController
{
    private $userAction;

    public function __construct(
        UserAction $userAction
    ) {
        $this->userAction = $userAction;
    }

    /**
     * This function returns the users list or not found error.
     * 
     * @Route("/GetAll", methods={"GET"})
     */
    public function apiUserIndex()
    {
        return $this->userAction->list();
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/Post", methods={"POST"})
     */
    public function apiUserCreate(Request $request)
    {
        return $this->userAction->create($request);
    }

    /**
     * This function returns the user whose identifier is given as a parameter
     * @Route("/Get/{id}", methods={"GET"})
     */
    public function apiUserShow(User $user = null, Request $request)
    {
        return $this->userAction->show($user, $request);
    }

    /**
     * This function returns the user whose email is given as a parameter
     * @Route("/GetUserByEmail/{email}", methods={"GET"})
     */
    public function apiGetUserByEmail(User $user = null, Request $request)
    {
        return $this->userAction->getUserByEmail($user, $request);
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then updates it in the database.
     * 
     * @Route("/Update/{id}", methods={"PUT","PATCH"})
     */
    public function apiUserEdit(User $user = null, Request $request)
    {        
        return $this->userAction->update($user, $request);
    }

    // Fonction désactivation compte utilisateur à implémenter.

    /**
     * This function deletes the user whose identifier is given in parameter
     * @Route("/Delete/{id}", methods={"DELETE"})
     */
    public function apiUserDelete(User $user = null, Request $request)
    {
        return $this->userAction->delete($user, $request);
    }
}
