<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330184505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `ratings` (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, movie_id INT NOT NULL, rating INT NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_CEB607C9F675F31B (author_id), INDEX IDX_CEB607C98F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `ratings` ADD CONSTRAINT FK_CEB607C9F675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `ratings` ADD CONSTRAINT FK_CEB607C98F93B6FC FOREIGN KEY (movie_id) REFERENCES `movies` (id)');
        $this->addSql('DROP TABLE rating');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, movie_id INT NOT NULL, rating INT NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_D8892622F675F31B (author_id), INDEX IDX_D88926228F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926228F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE `ratings`');
    }
}
