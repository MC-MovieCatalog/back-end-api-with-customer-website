<?php

namespace App\DataFixtures;

use DateTime;

class FakeUserData
{
 
    // User data 
    
    private $users = array(
        array(
            'id' => 1,
            'email' => 'j.dubois@movie-catalog.fr',
            'password' => 'password',
            'isVerify' => true,
            'lastName' => 'Jean',
            'firstName' => 'Dubois',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 2,
            'email' => 'l.edouard@movie-catalog.fr',
            'password' => 'password',
            'isVerify' => true,
            'lastName' => 'Louis',
            'firstName' => 'Edouard',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 3,
            'email' => 'g.sylvie@movie-catalog.fr',
            'password' => 'password',
            'isVerify' => true,
            'lastName' => 'GILBERT',
            'firstName' => 'Sylvie',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 4,
            'email' => 'e.estefania@movie-catalog.fr',
            'password' => 'password',
            'isVerify' => true,
            'lastName' => 'Emiliano',
            'firstName' => 'Estefania',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 5,
            'email' => 'r.borgo@movie-catalog.fr',
            'password' => 'password',
            'isVerify' => true,
            'lastName' => 'Raphael',
            'firstName' => 'Borgo',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 6,
            'email' => 'admin.admin@movie-catalog.fr',
            'password' => 'adminPassword',
            'roles' => array('ROLE_ADMIN'),
            'isVerify' => true,
            'lastName' => 'Admin',
            'firstName' => 'Admin',
            'isActive' => true,
            'agreeTerms' => true
        ),
        array(
            'id' => 7,
            'email' => 'administrateur@movie-catalog.fr',
            'password' => 'adminPassword',
            'roles' => array('ROLE_ADMIN'),
            'isVerify' => true,
            'lastName' => 'Administrateur',
            'firstName' => 'Administrateur',
            'isActive' => true,
            'agreeTerms' => true
        )
    );
    
    // users data getter
    public function getUsers(): ?array
    {
        return $this->users;
    }
}
