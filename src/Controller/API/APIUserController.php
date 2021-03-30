<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ErrorManagement\UserValidate;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

/**
 * API User Controller
 * @Route("/api/users")
 */
class APIUserController extends APIDefaultController
{
    private $manager;

    private $userRepo;

    private $userValidate;

    private $passwordEncoder;

    private $emailVerifier;

    public function __construct(
        EntityManagerInterface $manager,
        UserRepository $userRepo,
        UserValidate $userValidate,
        UserPasswordEncoderInterface $passwordEncoder,
        EmailVerifier $emailVerifier
    ) {
        $this->manager = $manager;
        $this->userRepo = $userRepo;
        $this->userValidate = $userValidate;
        $this->passwordEncoder = $passwordEncoder;
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * This function returns the users list or not found error.
     * 
     * @Route("/getAllUsers", methods={"GET"})
     */
    public function apiUserIndex()
    {
        $users = $this->userRepo->getAllUsers();

        if ($users != 'Auncun utilisateur inscrit pour le moment') {
            return $this->respond($users);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then saves it in the database. 
     * In all other cases, it appears an error.
     * 
     * @Route("/createUser", methods={"POST"})
     */
    public function apiUserCreate(Request $request)
    {
        // Get the json data in user request
        $jsonDataRequestToCreateUser = json_decode($request->getContent(), true);

        if ($jsonDataRequestToCreateUser === null && json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'status' => 400,
                'message' => json_last_error_msg()
            ], 400);
        } else {
            // Validate json request data
            if ($this->userValidate->userCreateValidateRequest($jsonDataRequestToCreateUser) === null) {
                // User entity instanciation
                $user = new User;
                // User setters the content request
                $user->setEmail($jsonDataRequestToCreateUser["email"])
                    ->setPassword($this->passwordEncoder->encodePassword($user, $jsonDataRequestToCreateUser['password']))
                    ->setLastName($jsonDataRequestToCreateUser["lastName"])
                    ->setFirstName($jsonDataRequestToCreateUser["firstName"])
                    ->setRoles(isset($jsonDataRequestToCreateUser['roles']) != false ? $jsonDataRequestToCreateUser['roles'] : array())
                    ->setAgreeTerms($jsonDataRequestToCreateUser["agreeTerms"]);

                // User persist
                $this->manager->persist($user);
                // User flush in the database
                $this->manager->flush();


                // generate a signed url and email it to the user
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('moviecatalog.nsn@gmail.com', 'Movie Catalog'))
                        ->to($user->getEmail())
                        ->subject('Merci de confirmer votre adresse email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
                // do anything else you need here, like send an email
                
                // Returns the created user, with the correct headers and code 201.
                return $this->respondCreated($this->userRepo->getUserById($user->getId()));
            } else {
                return $this->userValidate->userCreateValidateRequest($jsonDataRequestToCreateUser);
            }
        }
    }

    /**
     * This function returns the user whose identifier is given as a parameter
     * @Route("/getUserById/{id}", methods={"GET"})
     */
    public function apiUserShow(User $user = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a pas été trouvé...';

        if (empty($user)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$user->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($user)) {
            $user = $this->userRepo->getUserById($user->getId());
            return $this->respond($user);
        } else {
            return $this->respondNotFound($user);
        }
    }

    /**
     * This function retrieves the json user sent in the http request, transforms it into a user entity and then updates it in the database.
     * 
     * @Route("/updateUser/{id}", methods={"PUT","PATCH"})
     */
    public function apiUserEdit(User $user = null, Request $request)
    {
        $error = 'La ressource que vous cherchez à modifier n\'a pas été trouvé...';

        if (empty($user)) {
            return $this->respondNotFound($error);
        } else if ($request->get('id') !== (string)$user->getId()) {
            return $this->respondNotFound($error);
        } else if (!empty($user)) {

            // Get the json data in user request
            $jsonDataRequestToEditUser = json_decode($request->getContent(), true);

            if ($jsonDataRequestToEditUser === null && json_last_error() !== JSON_ERROR_NONE) {
                return $this->json([
                    'status' => 400,
                    'message' => json_last_error_msg()
                ], 400);
            } else {
                // Validate json request data
                if ($this->userValidate->userUpdateValidateRequest($jsonDataRequestToEditUser) === null) {
                    if (array_key_exists("email", $jsonDataRequestToEditUser)){
                        $user->setEmail($jsonDataRequestToEditUser["email"]);
                    }
                    /*
                    if (array_key_exists("password", $jsonDataRequestToEditUser)){
                        $user->setPassword($jsonDataRequestToEditUser["password"]);
                    }
                    */
                    if (array_key_exists("lastName", $jsonDataRequestToEditUser)){
                        $user->setLastName($jsonDataRequestToEditUser["lastName"]);
                    }
                    if (array_key_exists("firstName", $jsonDataRequestToEditUser)){
                        $user->setFirstName($jsonDataRequestToEditUser["firstName"]);
                    }
                    if (array_key_exists("agreeTerms", $jsonDataRequestToEditUser)){
                        $user->setAgreeTerms($jsonDataRequestToEditUser["agreeTerms"]);
                    }

                    // Book flush in the database
                    $this->manager->flush();

                    // Returns the created user, with the correct headers and code 201.
                    
                    return $this->respondCreated($this->userRepo->getUserById($user->getId()));
                } else {
                    return $this->userValidate->userUpdateValidateRequest($jsonDataRequestToEditUser);
                }
            }
        }
    }

    // Fonction désactivation compte utilisateur à implémenter.
}
