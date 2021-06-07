<?php

namespace App\Services\EntityFormatter;

use App\Entity\Address;
use App\Services\UtilitiesService\SurveyData;
use App\Services\EntityFormatter\UserFormatter;

class AddressFormatter
{
    private $userFormatter;
    private $surveyData;

    public function __construct(
        UserFormatter $userFormatter,
        SurveyData $surveyData
    )
    {
        $this->userFormatter = $userFormatter;
        $this->surveyData = $surveyData;
    }

    /**
     * Transform address
     *
     * @return array
     */
    public function managAddress(Address $address, $displayUser = true)
    {
        $user = $address->getUser();

        if ($displayUser === true) {
            return [
                'id' => (int) $address->getId(),
                'streetNb' => (string) $address->getStreetNb(),
                'address' => (string) $address->getAddress(),
                'postal' => (string) $address->getPostal(),
                'city' => (string) $address->getCity(),
                'type' => (string) $address->getType(),
                'user' => $this->userFormatter->managUser($user, false)
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

    /**
     * Default address model for any transformation.
     *
     * @param Address $address
     */
    public function transform(Address $address)
    {
        return $this->managAddress($address);
    }

    /**
     * This function is only used to transform the indicated addresses into the correct format. 
     * [{element: element}, {element: element}]
     *
     * @return array | addresses
     */
    public function transformAll($addresses)
    {
        if ($addresses === "undefined") {
            return "undefined";
        } else {
            if ($this->surveyData->isNotNullData($addresses) === true) {
                $addressesArray = [];
    
                foreach ($addresses as $address) {
                    $addressesArray[] = $this->transform($address);
                }
    
                return $addressesArray;
            } else {
                return "Aucune adresse dans notre base pour le moment";
            }
        }
    }

}
