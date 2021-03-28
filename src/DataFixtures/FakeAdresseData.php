<?php

namespace App\DataFixtures;

class FakeAdresseData
{
    // Address data 
    
    private $addresses = array(
        array(
            'id' => 1,
            'streetNb' => '25',
            'address' => 'Rue la fontaine',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Personnelle'
        ),
        array(
            'id' => 2,
            'streetNb' => '80',
            'address' => 'Boulevard Volataire',
            'postal' => '92600',
            'city' => 'Asnières-sur-seine',
            'type' => 'Facturation'
        ),
        array(
            'id' => 3,
            'streetNb' => '14',
            'address' => 'Parc de l\'effort mutuelle',
            'postal' => '91120',
            'city' => 'Palaiseau',
            'type' => 'Personnelle'
        ),
        array(
            'id' => 4,
            'streetNb' => '5',
            'address' => 'Rue des graviers',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Facturation'
        ),
        array(
            'id' => 5,
            'streetNb' => '120',
            'address' => 'Rue Henri Pourrat',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Personnelle'
        ),
        array(
            'id' => 6,
            'streetNb' => '18',
            'address' => 'Parc de la tourelle',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Facturation'
        ),
        array(
            'id' => 7,
            'streetNb' => '86',
            'address' => 'Rue ferme de la tour',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Personnelle'
        ),
        array(
            'id' => 8,
            'streetNb' => '34',
            'address' => 'Rue sabliere des mèches',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Facturation'
        ),
        array(
            'id' => 9,
            'streetNb' => '75',
            'address' => 'Rue Mesly',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Personnelle'
        ),
        array(
            'id' => 10,
            'streetNb' => '30',
            'address' => 'Avenue Maréchal Foch',
            'postal' => '94460',
            'city' => 'Valenton',
            'type' => 'Facturation'
        ),
    );
    
    // addresses data getter
    public function getAddresses(): ?array
    {
        return $this->addresses;
    }
}
