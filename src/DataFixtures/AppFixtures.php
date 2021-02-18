<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Faker\Factory;
use App\Entity\Book;
use App\Entity\Movie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        // Commons variables

        $faker = Factory::create('fr_FR');

        $fakeData = new FakeData();


        // Book
        $fakeBooks = $fakeData->getBooks();
        
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
        $fakeMovies = $fakeData->getMovies();
        
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
        $fakeAddresses = $fakeData->getAddresses();

        foreach ($fakeAddresses as $fakeAddress) {
            $address = new Address();

            $address->setStreetNb($fakeAddress['streetNb'])
                    ->setAddress($fakeAddress['address'])
                    ->setPostal($fakeAddress['postal'])
                    ->setCity($fakeAddress['city'])
                    ->setType($fakeAddress['type']);

            $manager->persist($address);
        }

        // Flush
        $manager->flush();
    }
}
