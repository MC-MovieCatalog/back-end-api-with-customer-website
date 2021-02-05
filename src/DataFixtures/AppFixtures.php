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
        $faker = Factory::create('fr_FR');
        
        $content = '<p>' . join('</p><p>', $faker->paragraphs(20)) . '</p>';

        // $addressTypes = ['Facturation', 'Livraison'];

        for ($b = 1; $b <= 10; $b++) {
            $book = new Book();

            $authorFullName = ucfirst($faker->firstName)." ".strtoupper($faker->lastName);

            $book->setPageNb($faker->randomNumber(2))
                 ->setContent($content)
                 ->setDescription($faker->text)
                 ->setTitle($faker->sentence(4))
                 ->setPrice($faker->randomFloat(2, 3, 1.01))
                 ->setCover($faker->imageUrl(132, 183))
                 ->setAuthor($authorFullName);

            $manager->persist($book);
        }

        for ($m = 1; $m <= 10; $m++) {
            $movie = new Movie();

            $directorFullName = ucfirst($faker->firstName)." ".strtoupper($faker->lastName);

            $movie->setDuration("78")
                 ->setLink("https://www.youtube.com/watch?v=U-ghgkxnmUk")
                 ->setDescription($faker->text)
                 ->setTitle($faker->sentence(4))
                 ->setPrice($faker->randomFloat(2, 3, 1.01))
                 ->setCover($faker->imageUrl(132, 183))
                 ->setDirector($directorFullName)
                 ->setTrailer("https://www.youtube.com/watch?v=HpzzrqJi6ko");

            $manager->persist($movie);
        }

        /*
        for ($a = 1; $a <= 10; $a++) {
            $address = new Address();

            $address->setStreetNb(strval($faker->randomNumber(3)))
                    ->setAddress($faker->streetName)
                    ->setPostal($faker->postcode)
                    ->setCity($faker->city)
                    ->setType($faker->randomElement($addressTypes));

            $manager->persist($address);
        }
        */

        $manager->flush();
    }
}
