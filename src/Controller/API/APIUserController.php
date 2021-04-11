<?php

namespace App\Controller\API;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API User Controller
 * @Route("/api/users")
 */
class UserAction extends APIDefaultController
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
     * @Route("/getAllUsers", methods={"GET"})
     */
    public function apiUserIndex()
    {
        return $this->userAction->list();
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/createUser", methods={"POST"})
     */
    public function apiUserCreate(Request $request)
    {
        return $this->userAction->create($request);
    }

    /**
     * This function returns the user whose identifier is given as a parameter
     * @Route("/getUserById/{id}", methods={"GET"})
     */
    public function apiUserShow(User $user = null, Request $request)
    {
        return $this->userAction->show($user, $request);
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then updates it in the database.
     * 
     * @Route("/updateUser/{id}", methods={"PUT","PATCH"})
     */
    public function apiUserEdit(User $user = null, Request $request)
    {        
        return $this->userAction->update($user, $request);
    }

    // Fonction désactivation compte utilisateur à implémenter.
}
