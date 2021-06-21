<?php

namespace App\DataFixtures;

class FakeMovieData
{
    private $movies = array(
        array(
            'id' => 1,
            'duration' => '1h17',
            /* 'link' => 'https://www.youtube.com/watch?v=9Yl3aAEcR7A',*/
            'link' => '9Yl3aAEcR7A',
            'description' => 'Alors qu\'une équipe de scientifiques tente de repousser les limites de l\'esprit humain en mettant au point un sérum révolutionnaire permettant d\'ouvrir un pont entre le monde des esprits et celui des hommes, l\'expérience tourne mal et ouvre un...',
            'title' => 'Décharnés',
            'price' => 13.00,
            'cover' => 'https://i.ytimg.com/vi_webp/9Yl3aAEcR7A/maxresdefault.webp?v=600d727b',
            'director' => 'Mario Sorrenti',
            /* 'trailer' => 'https://www.youtube.com/watch?v=SLxUcxYk3Qo',*/
            'trailer' => 'SLxUcxYk3Qo',
            'genre' => 'Horreur, Thriller, Film Adolescent, Suspense, Paranormal, Fantastique'
        ),
        array(
            'id' => 2,
            'duration' => '1h18',
            /* 'link' => 'https://www.youtube.com/watch?v=qbc8HirM-j4',*/
            'link' => 'qbc8HirM-j4',
            'description' => 'Un couple en deuil décide de s\'installer à la campagne. Ils découvrent bientôt que leur nouvelle maison est hantée.',
            'title' => 'We Are Still Here',
            'price' => 17.00,
            'cover' => 'https://i.ytimg.com/vi_webp/qbc8HirM-j4/maxresdefault.webp',
            'director' => 'Ted Geoghegan',
            /* 'trailer' => 'https://www.youtube.com/watch?v=z9M5cJCQ9BI',*/
            'trailer' => 'z9M5cJCQ9BI',
            'genre' => 'Horreur, Thriller'
        ),
        array(
            'id' => 3,
            'duration' => '1h26',
            /* 'link' => 'https://www.youtube.com/watch?v=DoyLZJvWKJQ',*/
            'link' => 'DoyLZJvWKJQ',
            'description' => 'Une dame très cynique et une jeune femme commencent une relation de 5 ans après s\'être rencontrées lors d\'une pluie de météores.',
            'title' => 'Comet',
            'price' => 17.00,
            'cover' => 'https://i.ytimg.com/vi_webp/DoyLZJvWKJQ/maxresdefault.webp',
            'director' => 'Sam Esmail',
            /* 'trailer' => 'https://www.youtube.com/watch?v=mlUhYYZpFAo',*/
            'trailer' => 'mlUhYYZpFAo',
            'genre' => 'Romance, Comédie Romantique, Adolescent'
        ),
        array(
            'id' => 4,
            'duration' => '1h40',
            /* 'link' => 'https://www.youtube.com/watch?v=HEkdQCcRztE',*/
            'link' => 'HEkdQCcRztE',
            'description' => 'Depuis la mort de sa femme, Monte Wildhorn, un écrivain spécialisé dans les westerns, noie son chagrin dans l\'alcool et la solitude. Son neveu s\'inquiète de son état, et le pousse à partir en vacances d\'été dans une petite ville paisible...',
            'title' => 'Un Été Magique',
            'price' => 9.82,
            'cover' => 'https://i.ytimg.com/vi_webp/HEkdQCcRztE/maxresdefault.webp',
            'director' => 'Rob Reiner',
            /* 'trailer' => 'https://www.youtube.com/watch?v=Pmyrdr3WWZE',*/
            'trailer' => 'Pmyrdr3WWZE',
            'genre' => 'Adolescent, Comédie'
        ),
        array(
            'id' => 5,
            'duration' => '1h27',
            /* 'link' => 'https://www.youtube.com/watch?v=MPJ9iKHIp1o',*/
            'link' => 'MPJ9iKHIp1o',
            'description' => 'La quiétude matinale dun Fast food vole en éclats lorsque des coups de feux retentissent.',
            'title' => 'Fragments',
            'price' => 3.90,
            'cover' => 'https://i.ytimg.com/vi_webp/MPJ9iKHIp1o/maxresdefault.webp',
            'director' => 'Roy Freirich',
            /* 'trailer' => 'https://www.youtube.com/watch?v=s3qaqXwwGhs',*/
            'trailer' => 's3qaqXwwGhs',
            'genre' => 'Drame, Thriller'
        ),
        array(
            'id' => 6,
            'duration' => '1h23',
            /*'link' => 'https://www.youtube.com/watch?v=yPff5FTKKvI',*/
            'link' => 'yPff5FTKKvI',
            'description' => 'Quand un paquebot est coulé par un gigantesque requin mutant à deux têtes, son équipage tente de trouver refuge sur un atoll qui semble désert.',
            'title' => 'Double Shark',
            'price' => 3.55,
            'cover' => 'https://i.ytimg.com/vi_webp/yPff5FTKKvI/maxresdefault.webp',
            'director' => 'Christopher Ray',
            /* 'trailer' => 'https://www.youtube.com/watch?v=IwT4ihubcSs',*/
            'trailer' => 'IwT4ihubcSs',
            'genre' => 'Adolescent, Comédie'
        ),
        array(
            'id' => 7,
            'duration' => '1h45',
            /* 'link' => 'https://www.youtube.com/watch?v=yBDkPoUhzGc',*/
            'link' => 'uVM1TZvq_zk',
            'description' => 'Surfant sur le succès de son premier film, Herbert Biberman, un jeune cinéaste, profite de sa gloire naissante pour faire des projets d\'avenir. Cependant l\'heure n\'est pas aux réjouissances : la guerre froide bat son plein et le Sénat crée...',
            'title' => 'One of the Hollywood Ten',
            'price' => 16.00,
            'cover' => 'https://i.ytimg.com/vi_webp/yBDkPoUhzGc/maxresdefault.webp',
            'director' => 'Karl Francis',
            /* 'trailer' => 'https://www.youtube.com/watch?v=EaS4H2jpHIs',*/
            'trailer' => 'U0w8Rpaf8CI',
            'genre' => 'Adolescent, Comédie'
        ),
        array(
            'id' => 8,
            'duration' => '1h34',
            /*'link' => 'https://www.youtube.com/watch?v=FKrgDRmLBXo',*/
            'link' => 'FKrgDRmLBXo',
            'description' => 'Matthew Taylor, un expert en relations amoureuses en tournée promotionnelle pour son dernier best-seller, croise la route de Kristin Peralta, une psychologue qui l\'accuse d\'être un charlatan. Leur relation professionnelle orageuse prend...',
            'title' => 'The bounce back',
            'price' => 17.41,
            'cover' => 'https://i.ytimg.com/vi_webp/FKrgDRmLBXo/maxresdefault.webp',
            'director' => 'Youssef Delara',
            /*'trailer' => 'https://www.youtube.com/watch?v=H1oF7bLKBEc',*/
            'trailer' => 'H1oF7bLKBEc',
            'genre' => 'Adolescent, Comédie, Romance'
        ),
        array(
            'id' => 9,
            'duration' => '1h29',
            /*'link' => 'https://www.youtube.com/watch?v=Z2e-fsUhPZQ',*/
            'link' => 'Z2e-fsUhPZQ',
            'description' => 'Une jeune femme et ses amies deviennent le cible d\'un groupe de kidnappeurs sans pitié et doivent lutter pour survivre.',
            'title' => 'Submerged',
            'price' => 12.90,
            'cover' => 'https://i.ytimg.com/vi_webp/Z2e-fsUhPZQ/maxresdefault.webp',
            'director' => 'Ryan Dodson',
            /*'trailer' => 'https://www.youtube.com/watch?v=zMR6kanIfM0',*/
            'trailer' => 'zMR6kanIfM0',
            'genre' => 'Adolescent, Thriller'
        ),
        array(
            'id' => 10,
            'duration' => '1h26',
            /*'link' => 'https://www.youtube.com/watch?v=vt-_oy14OXk',*/
            'link' => 'vt-_oy14OXk',
            'description' => 'Un tremblement de terre sous-marin provoque un tsunami qui vient frapper les côtes, occasionnant d\'importants dégâts.',
            'title' => 'Malibu Shark Attack',
            'price' => 7.51,
            'cover' => 'https://i.ytimg.com/vi_webp/vt-_oy14OXk/maxresdefault.webp',
            'director' => 'Rob Reiner',
            /*'trailer' => 'https://www.youtube.com/watch?v=WOepmvBKfYw',*/
            'trailer' => 'WOepmvBKfYw',
            'genre' => 'Horreur'
        )
    );

    // movies data getter
    public function getMovies(): ?array
    { 
        return $this->movies;
    }

}
