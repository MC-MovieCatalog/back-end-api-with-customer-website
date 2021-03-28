<?php

namespace App\DataFixtures;

class FakeBookData
{
    const CONTENT = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo harum magni quis voluptatum necessitatibus, ratione quos culpa animi illo cum nulla laboriosam nemo odio. Sapiente ducimus ex distinctio officia delectus.
    Eligendi mollitia quasi possimus qui voluptatum esse nostrum nemo ducimus fugit quo, non blanditiis modi alias iusto? Nihil perferendis voluptates minus. Id rerum delectus reiciendis cum commodi corrupti minus? Doloremque!
    Ipsum quod optio reiciendis voluptatem perspiciatis, corporis necessitatibus eum explicabo architecto tempore pariatur fugiat neque iste incidunt vero quas voluptas, placeat repellat assumenda numquam consectetur. Itaque hic eos sunt aliquid.
    Nesciunt laudantium nostrum ab ex repellendus asperiores ipsum. Eius, explicabo. Doloribus placeat odio nobis? Sit quas consequuntur odio, in doloribus ex inventore numquam consequatur, nemo distinctio alias, rerum beatae esse?
    Quis iure magni doloremque incidunt enim quasi necessitatibus temporibus quae ut, provident voluptates vel quidem atque neque. Ipsum quis obcaecati porro odit quibusdam omnis voluptatibus quia inventore, placeat, tenetur quas.
    Aliquid, quia iusto voluptatum, veniam sit maxime inventore ipsa id doloribus modi doloremque eius! Libero porro illum fuga odit harum placeat voluptas? Aspernatur repellat deleniti porro provident eaque perspiciatis. Laborum!
    Cumque veniam voluptas maiores earum dolorum at dignissimos eos quaerat vel esse in possimus placeat, consectetur quod reiciendis! Corrupti voluptates laborum perspiciatis eius vel est tempore mollitia nobis porro? Recusandae.
    Cupiditate voluptatem blanditiis aut molestiae tenetur eum, tempore modi accusantium, non neque quae provident expedita velit architecto esse unde, consectetur sapiente? Voluptate ratione reiciendis deleniti fuga itaque, obcaecati eius molestiae.
    Adipisci suscipit temporibus, rem soluta repudiandae blanditiis deserunt veniam facere consectetur quo, necessitatibus eum commodi doloribus ipsam deleniti nisi sequi reiciendis consequatur. Adipisci culpa cumque cupiditate laudantium qui minima eligendi.
    Id enim soluta magnam facilis maxime eos dolores quaerat dolorum? Nulla laborum consequatur nesciunt, excepturi porro magnam quas magni asperiores. Autem obcaecati vitae ab nisi aliquam excepturi optio commodi quos.';
 
    // Book data 
    
    private $books = array(
        array(
            'id' => 1,
            'pageNb' => 350,
            'content' => self::CONTENT,
            'description' => 'New York, dans les années 1900. Une jeune fille, que passionnent les livres rares, se joue du destin et gravit tous les échelons. Elle devient la directrice de la fabuleuse bibliothèque du magnat J.P. Morgan...',
            'title' => 'Belle Greene',
            'price' => 14.99,
            'cover' => 'https://covers.feedbooks.net/item/3664070.jpg?size=large&t=1606320285',
            'author' => 'Alexandra LAPIERRE'
        ),
        array(
            'id' => 2,
            'pageNb' => 336,
            'content' => self::CONTENT,
            'description' => 'Le 11 novembre 1942, un télex apprend au monde abasourdi que le Maréchal Pétain a quitté Vichy pour rejoindre Alger où les Américains viennent de débarquer. À Londres, après la consternation c\'est l\'affolement...',
            'title' => 'Ils voyagent vers des pays perdus',
            'price' => 14.99,
            'cover' => 'https://covers.feedbooks.net/item/3704755.jpg?size=large&t=1609380811',
            'author' => 'Jean-Marie ROUART'
        ),
        array(
            'id' => 3,
            'pageNb' => 515,
            'content' => self::CONTENT,
            'description' => 'Zhalie est née du mariage entre une prostituée et un voleur qu\'un rêve a réunis : celui de faire de ce village pauvre et déshérité une grandiose Babylone semblable aux immenses métropoles du monde...',
            'title' => 'Les Chroniques de Zhalie',
            'price' => 3.99,
            'cover' => 'https://covers.feedbooks.net/item/1414517.jpg?size=large&t=1538001276',
            'author' => 'Lianke YAN'
        ),
        array(
            'id' => 4,
            'pageNb' => 250,
            'content' => self::CONTENT,
            'description' => 'Dans un univers mélangeant steampunk et Belle Époque, un groupe d\'amis (Bastien, paléontologue, Agathe, sa gouvernante, Ernest, explorateur, et Angela, Germanienne en exil) se retrouvent parachutés au beau milieu d\'une affaire...',
            'title' => 'La Forêt des araignées tristes',
            'price' => 4.99,
            'cover' => 'https://covers.feedbooks.net/item/3182094.jpg?size=large&t=1567282089',
            'author' => 'Colin Heine'
        ),
        array(
            'id' => 5,
            'pageNb' => 300,
            'content' => self::CONTENT,
            'description' => 'Zéphyrelle se voit confier sa première mission par le dynarque de Slarance : démasquer les trafics d’un duc-marchand qui empoisonne lentement la cité. Une dangereuse enquête qui la conduit du monde haut en couleurs...',
            'title' => 'Le Souper des maléfices',
            'price' => 2.99,
            'cover' => 'https://covers.feedbooks.net/item/3182056.jpg?size=large&t=1594428377',
            'author' => 'Christophe Arleston'
        ),
        array(
            'id' => 6,
            'pageNb' => 192,
            'content' => self::CONTENT,
            'description' => 'Dans une banlieue de Luanda près d’une petite plage, GrandMèreDixNeuf (on l’a amputée d’un orteil) s’occupe de toute une bande de gamins, curieux et débrouillards, amateurs de baignades et de fruits chapardés. Des coopérants...',
            'title' => 'GrandMèreDixNeuf et le secret du Soviétique',
            'price' => 12.99,
            'cover' => 'https://covers.feedbooks.net/item/3669599.jpg?size=large&t=1606924994',
            'author' => 'Ondjaki'
        ),
        array(
            'id' => 7,
            'pageNb' => 304,
            'content' => self::CONTENT,
            'description' => 'Dara McAnulty est un naturaliste nord-irlandais, un amoureux de la faune et de la flore, un adolescent autiste ayant trouvé dans la nature un remède à ses maux, un refuge. En 2018, alors que sa famille s\'apprête à déménager à l\'autre...',
            'title' => 'Journal d\'un jeune naturaliste',
            'price' => 16.99,
            'cover' => 'https://covers.feedbooks.net/item/3683804.jpg?size=large&t=1608321619',
            'author' => 'Dara McAnulty'
        ),
        array(
            'id' => 8,
            'pageNb' => 120,
            'content' => self::CONTENT,
            'description' => 'Le phénomène se propage rapidement aux quatre coins de la planète. On les appelle « kentukis » et tout le monde en parle, tout le monde veut en avoir un. Souris, corbeau, dragon, lapin : ce sont des animaux en peluche apparemment...',
            'title' => 'Kentukis',
            'price' => 14.99,
            'cover' => 'https://covers.feedbooks.net/item/3715559.jpg?size=large&t=1610582787',
            'author' => 'Samanta Schweblin'
        ),
        array(
            'id' => 9,
            'pageNb' => 384,
            'content' => self::CONTENT,
            'description' => 'Quand Dmitry Alexeievitch, traducteur désargenté, insiste auprès de son agence pour obtenir un nouveau contrat, il ne se doute pas que sa vie en sera bouleversée. Le traducteur en charge du premier chapitre ne donnant plus de nouvelles...',
            'title' => 'Sumerki',
            'price' => 2.99,
            'cover' => 'https://covers.feedbooks.net/item/771340.jpg?size=large&t=1602289413',
            'author' => 'Dmitry Glukhovsky'
        ),
        array(
            'id' => 10,
            'pageNb' => 480,
            'content' => self::CONTENT,
            'description' => 'Stella Widstrand est une femme comblée, elle a un mari et un fils qu’elle aime plus que tout au monde. La petite vie tranquille de cette psychothérapeute vole en éclats le jour où elle reçoit une jeune patiente, nommée Isabelle...',
            'title' => 'Rien qu\'à moi',
            'price' => 2.99,
            'cover' => 'https://covers.feedbooks.net/item/3140097.jpg?size=large&t=1607387516',
            'author' => 'Elisabeth Norebäck'
        )
    );
    
    // books data getter
    public function getBooks(): ?array
    {
        return $this->books;
    }
}
