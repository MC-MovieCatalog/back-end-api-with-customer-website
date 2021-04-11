<?php

namespace App\Repository\RepositoryFormatter;

use App\Entity\Address;
use App\Entity\User;
// use App\Repository\RepositoryFormatter\AddressFormatter\AddressFormatter;
use App\Services\ConvertDate;

class UserFormatter
{    
    private $convertDate;
    
    // private $addressFormatter;

    public function __construct(
        ConvertDate $convertDate
        // AddressFormatter $addressFormatter
    )
    {
        $this->convertDate = $convertDate;
        // $this->addressFormatter = $addressFormatter;
    }

    /**
     * Transform address
     *
     * @param Address $address
     * @return array
     */
    public function managAddress(Address $address)
    {
        $user = $address->getUser();

        return [
            'id' => (int) $address->getId(),
            'streetNb' => (string) $address->getStreetNb(),
            'address' => (string) $address->getAddress(),
            'postal' => (string) $address->getPostal(),
            'city' => (string) $address->getCity(),
            'type' => (string) $address->getType(),
            'user' => $this->managUser($user)
        ];
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
}
