<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Movie;
use App\Entity\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // Common variables

        $faker = Factory::create('fr_FR');

        // Data

        $fakeBookData = new FakeBookData();
        $fakeMovieData = new FakeMovieData();
        $fakeAdresseData = new FakeAdresseData();
        $fakeUserData = new FakeUserData();  

        // Book
        $fakeBooks = $fakeBookData->getBooks();
        
        foreach ($fakeBooks as $bookData) {
            $book = new Book();

            $book->setPageNb($bookData['pageNb'])
                 ->setContent($bookData['content'])
                 ->setDescription($bookData['description'])
                 ->setTitle($bookData['title'])
                 ->setPrice($bookData['price'])
                 ->setCover($bookData['cover'])
                 ->setAuthor($bookData['author']);

            $manager->persist($book);
            
        }

        // Movie 
        $fakeMovies = $fakeMovieData->getMovies();
        
        foreach ($fakeMovies as $movieData) {
            $movie = new Movie();

            $movie->setDuration($movieData['duration'])
                 ->setLink($movieData['link'])
                 ->setDescription($movieData['description'])
                 ->setTitle($movieData['title'])
                 ->setPrice($movieData['price'])
                 ->setCover($movieData['cover'])
                 ->setDirector($movieData['director'])
                 ->setTrailer($movieData['trailer']);

            $manager->persist($movie);
            
        }

        // Address
        $fakeAddresses = $fakeAdresseData->getAddresses();

        foreach ($fakeAddresses as $fakeAddress) {
            $address = new Address();

            $address->setStreetNb($fakeAddress['streetNb'])
                    ->setAddress($fakeAddress['address'])
                    ->setPostal($fakeAddress['postal'])
                    ->setCity($fakeAddress['city'])
                    ->setType($fakeAddress['type']);

            $manager->persist($address);
        }

        // User
        $fakeUsers = $fakeUserData->getUsers();

        foreach ($fakeUsers as $fakeUser) {
            $user = new User();

            $user->setEmail($fakeUser['email'])
                    ->setPassword($this->passwordEncoder->encodePassword($user, $fakeUser['password']))
                    ->setRoles(isset($fakeUser['role']) != false ? $fakeUser['role'] : array())
                    ->setIsVerified($fakeUser['isVerify'])
                    ->setLastName($fakeUser['lastName'])
                    ->setFirstName($fakeUser['firstName'])
                    ->setIsActive($fakeUser['isActive'])
                    ->setAgreeTerms($fakeUser['agreeTerms']);

            $manager->persist($user);
        }

        // Flush
        $manager->flush();
    }
}
