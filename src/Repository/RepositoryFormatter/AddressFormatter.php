<?php

namespace App\Repository\RepositoryFormatter;

use App\Entity\Address;
use App\Repository\RepositoryFormatter\UserFormatter;

class AddressFormatter
{
    private $userFormatter;

    public function __construct(
        UserFormatter $userFormatter
    )
    {
        $this->userFormatter = $userFormatter;
    }

    /**
     * Transform address
     *
     * @return array
     */
    public function managAddress(Address $address, $displayFromUser = false)
    {
        $user = $address->getUser();

        if ($displayFromUser === false) {
            return [
                'id' => (int) $address->getId(),
                'streetNb' => (string) $address->getStreetNb(),
                'address' => (string) $address->getAddress(),
                'postal' => (string) $address->getPostal(),
                'city' => (string) $address->getCity(),
                'type' => (string) $address->getType(),
                'user' => $this->userFormatter->managUser($user, true)
            ];
        } else {
            return [
                'id' => (int) $address->getId(),
                'streetNb' => (string) $address->getStreetNb(),
                'address' => (string) $address->getAddress(),
                'postal' => (string) $address->getPostal(),
                'city' => (string) $address->getCity(),
                'type' => (string) $address->getType()
            ];
        }
    }
}
