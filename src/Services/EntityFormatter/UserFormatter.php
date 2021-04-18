<?php

namespace App\Services\EntityFormatter;

use App\Entity\User;
use App\Services\SurveyData;
use App\Services\ConvertDate;

class UserFormatter
{    
    private $convertDate;
    private $surveyData;

    public function __construct(
        ConvertDate $convertDate,
        SurveyData $surveyData
    )
    {
        $this->convertDate = $convertDate;
        $this->surveyData = $surveyData;
    }

    /**
     * Transform user
     *
     * @param User $user
     * @return array
     */
    public function managUser(User $user, $displayFromAddress = false) 
    {
        if (!empty($user->getAddresses()) && $displayFromAddress === false) {
            
            $userAddresses = [];
            
            foreach ($user->getAddresses() as $address) {
                
                array_push($userAddresses, [
                    'id' => (int) $address->getId(),
                    'streetNb' => (string) $address->getStreetNb(),
                    'address' => (string) $address->getAddress(),
                    'postal' => (string) $address->getPostal(),
                    'city' => (string) $address->getCity(),
                    'type' => (string) $address->getType()
                ]);
            }

            return [
                'id' => (int) $user->getId(),
                'email' => (string) $user->getEmail(),
                'lastName' => (string) $user->getLastName(),
                'firstName' => (string) $user->getFirstName(),
                'agreeTerms' => (boolean) $user->getAgreeTerms(),
                'agreeTermsValidateAt' => (string) $this->convertDate->toDateTimeFr($user->getAgreeTermsValidatedAt()->format('Y-m-d H:i:s'), true),
                'inscriptionDate' => (string) $this->convertDate->toDateTimeFr($user->getInscriptionDate()->format('Y-m-d H:i:s'), true),
                'addresses' => $userAddresses
            ];
        } else {
            return [
                'id' => (int) $user->getId(),
                'email' => (string) $user->getEmail(),
                'lastName' => (string) $user->getLastName(),
                'firstName' => (string) $user->getFirstName(),
                'agreeTerms' => (boolean) $user->getAgreeTerms(),
                'agreeTermsValidateAt' => (string) $this->convertDate->toDateTimeFr($user->getAgreeTermsValidatedAt()->format('Y-m-d H:i:s'), true),
                'inscriptionDate' => (string) $this->convertDate->toDateTimeFr($user->getInscriptionDate()->format('Y-m-d H:i:s'), true)
            ];
        }
    }

    /**
     * Default user model for any transformation.
     *
     * @param User $user
     */
    public function transform(User $user)
    {
        return $this->managUser($user);
    }

    /**
     * This function is only used to transform the indicated users into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | users
     */
    public function transformAll($users)
    {
        if ($this->surveyData->isNotNullData($users) === true) {
            $usersArray = [];

            foreach ($users as $user) {
                $usersArray[] = $this->transform($user);
            }

            return $usersArray;
        } else {
            return "Auncun utilisateur inscrit pour le moment";
        }
    }
}
