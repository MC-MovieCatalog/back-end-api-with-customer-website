<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124101910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `addresses` (id INT AUTO_INCREMENT NOT NULL, street_nb VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, type VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `movies` (id INT AUTO_INCREMENT NOT NULL, duration VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(80) NOT NULL, price DOUBLE PRECISION NOT NULL, cover VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, director VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `addresses`');
        $this->addSql('DROP TABLE `movies`');
    }
}
