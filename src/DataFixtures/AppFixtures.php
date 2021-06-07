<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Movie;
use App\Entity\Address;
use App\Entity\Rating;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Invoice;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        // Data

        $fakeMovieData = new FakeMovieData();
        $fakeAdresseData = new FakeAdresseData();
        $fakeUserData = new FakeUserData();
        $fakeInvoiceData = new FakeInvoiceData();

        // Movie
        $movies = [];

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
            $movies[] = $movie;
            
        }

        // User
        $users = [];

        $fakeUsers = $fakeUserData->getUsers();

        foreach ($fakeUsers as $fakeUser) {
            $user = new User();

            $user->setEmail($fakeUser['email'])
                    ->setPassword($this->passwordEncoder->encodePassword($user, $fakeUser['password']))
                    ->setRoles(isset($fakeUser['roles']) != false ? $fakeUser['roles'] : array())
                    ->setIsVerified($fakeUser['isVerify'])
                    ->setLastName($fakeUser['lastName'])
                    ->setFirstName($fakeUser['firstName'])
                    ->setIsActive($fakeUser['isActive'])
                    ->setAgreeTerms($fakeUser['agreeTerms']);

            $manager->persist($user);
            $users[] = $user;
        }

        // Address
        $addresses = [];
        
        $fakeAddresses = $fakeAdresseData->getAddresses();

        foreach ($fakeAddresses as $fakeAddress) {

            $user_address = $users[mt_rand(0, count($users) - 1)];

            $address = new Address();

            $address->setStreetNb($fakeAddress['streetNb'])
                    ->setAddress($fakeAddress['address'])
                    ->setPostal($fakeAddress['postal'])
                    ->setCity($fakeAddress['city'])
                    ->setType($fakeAddress['type'])
                    ->setUser($user_address);

            $manager->persist($address);

            $addresses[] = $address;
        }
        
        // Invoice
        $fakeInvoices = $fakeInvoiceData->getInvoices();
        
        foreach ($fakeInvoices as $fakeInvoice) {

            $invoice_movies = array_rand($movies, 3);

            $invoice_address = $addresses[mt_rand(0, count($addresses) -1)];
            
            $invoice = new Invoice();
            $fakeInvoice = $invoice;
            $amount = 0;
            
            for ($i=0; $i < count($invoice_movies); $i++) { 
                $fakeInvoice->addMovie($movies[$invoice_movies[$i]]);
                $amount = $amount + $movies[$invoice_movies[$i]]->getPrice();
            }

            $fakeInvoice->setAmount($amount)
                    ->setCustomer($invoice_address->getUser())
                    ->setAddress($invoice_address);

            $manager->persist($fakeInvoice);        
        }
        

        // Rating
        for ($r = 0; $r < 20; $r++) {

            $author = $users[mt_rand(0, count($users) - 1)];
            $movie = $movies[mt_rand(0, count($movies) - 1)];

            $rating = new Rating();

            $rating->setRating(mt_rand(1, 5))
                ->setAuthor($author)
                ->setMovie($movie);

            $manager->persist($rating);
        }

        // Flush
        $manager->flush();
    }
}
