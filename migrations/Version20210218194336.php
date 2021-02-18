<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218194336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `bills` (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, created_at DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_22775DD0F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bill_movie (bill_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_2BAEA7F11A8C12F5 (bill_id), INDEX IDX_2BAEA7F18F93B6FC (movie_id), PRIMARY KEY(bill_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `ongoings` (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, ongoing VARCHAR(255) NOT NULL, INDEX IDX_5E2406FD8F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `bills` ADD CONSTRAINT FK_22775DD0F5B7AF75 FOREIGN KEY (address_id) REFERENCES `addresses` (id)');
        $this->addSql('ALTER TABLE bill_movie ADD CONSTRAINT FK_2BAEA7F11A8C12F5 FOREIGN KEY (bill_id) REFERENCES `bills` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill_movie ADD CONSTRAINT FK_2BAEA7F18F93B6FC FOREIGN KEY (movie_id) REFERENCES `movies` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `ongoings` ADD CONSTRAINT FK_5E2406FD8F93B6FC FOREIGN KEY (movie_id) REFERENCES `movies` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill_movie DROP FOREIGN KEY FK_2BAEA7F11A8C12F5');
        $this->addSql('DROP TABLE `bills`');
        $this->addSql('DROP TABLE bill_movie');
        $this->addSql('DROP TABLE `ongoings`');
    }
}
