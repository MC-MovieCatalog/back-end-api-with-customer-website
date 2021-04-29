<?php

namespace App\Controller\API\APIAction;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ErrorManagement\UserValidate;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Controller\API\APIDefaultController;


class UserAction extends APIDefaultController
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

    public function list()
    {
        $users = $this->userRepo->getAllUsers();

        if ($users != 'Auncun utilisateur inscrit pour le moment') {
            return $this->respond($users);
        } else {
            return $this->respondNotFound(); // This function can take a custom string message, but contains the default message: Not found
        }
    }

    public function create(Request $request)
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
                if (($this->userRepo->findBy(array('email' => $jsonDataRequestToCreateUser["email"])) !== null) 
                    && ($this->userRepo->findBy(array('email' => $jsonDataRequestToCreateUser["email"])) !== [])
                ) {
                    $emailVerify = $this->userRepo->findBy(array('email' => $jsonDataRequestToCreateUser["email"]));
                } else {
                    $emailVerify = null;
                }
                
                
                if ($emailVerify !== null) {
                    return $this->respondUnauthorized('Un compte existe déjà pour cette adresse email.');
                } else {
                    $user->setEmail($jsonDataRequestToCreateUser["email"]);
                }
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

    public function show(User $user = null, Request $request)
    {
        $error = 'La ressource que vous recherchez n\'a pas été trouvée...';

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

    public function update(User $user = null, Request $request)
    {        
        $error = 'La ressource que vous cherchez à modifier n\'a pas été trouvée...';

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
                        
                        $emailVerify = $this->userRepo->findBy(array('email' => $jsonDataRequestToEditUser["email"]),array('email' => 'ASC'),1 ,0)[0];
                        if (!empty($emailVerify)) {
                            if ((string)$emailVerify->getId() !== $request->get('id')) {
                                if ((string)$emailVerify->getEmail() === $jsonDataRequestToEditUser["email"]) {
                                    return $this->respondUnauthorized('Un compte existe déjà pour cette adresse email.');
                                }
                            }
                        } else {
                            $user->setEmail($jsonDataRequestToEditUser["email"]);
                        }
                    }
                    if (array_key_exists("roles", $jsonDataRequestToEditUser)){
                        $user->setRoles($jsonDataRequestToEditUser["roles"]);
                    }
                    if (array_key_exists("lastName", $jsonDataRequestToEditUser)){
                        $user->setLastName($jsonDataRequestToEditUser["lastName"]);
                    }
                    if (array_key_exists("firstName", $jsonDataRequestToEditUser)){
                        $user->setFirstName($jsonDataRequestToEditUser["firstName"]);
                    }
                    if (array_key_exists("isActive", $jsonDataRequestToEditUser)){
                        $user->setIsActive($jsonDataRequestToEditUser["isActive"]);
                    }
                    if (array_key_exists("isVerified", $jsonDataRequestToEditUser)){
                        $user->setIsVerified($jsonDataRequestToEditUser["isVerified"]);
                    }

                    // User flush in the database
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
