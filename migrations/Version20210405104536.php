<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210405104536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `invoices` (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, address_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, invoice_reference VARCHAR(255) DEFAULT NULL, INDEX IDX_6A2F2F959395C3F3 (customer_id), INDEX IDX_6A2F2F95F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_movie (invoice_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_2084A2DA2989F1FD (invoice_id), INDEX IDX_2084A2DA8F93B6FC (movie_id), PRIMARY KEY(invoice_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `invoices` ADD CONSTRAINT FK_6A2F2F959395C3F3 FOREIGN KEY (customer_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE `invoices` ADD CONSTRAINT FK_6A2F2F95F5B7AF75 FOREIGN KEY (address_id) REFERENCES `addresses` (id)');
        $this->addSql('ALTER TABLE invoice_movie ADD CONSTRAINT FK_2084A2DA2989F1FD FOREIGN KEY (invoice_id) REFERENCES `invoices` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice_movie ADD CONSTRAINT FK_2084A2DA8F93B6FC FOREIGN KEY (movie_id) REFERENCES `movies` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addresses ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516A76ED395 FOREIGN KEY (user_id) REFERENCES `users` (id)');
        $this->addSql('CREATE INDEX IDX_6FCA7516A76ED395 ON addresses (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_movie DROP FOREIGN KEY FK_2084A2DA2989F1FD');
        $this->addSql('DROP TABLE `invoices`');
        $this->addSql('DROP TABLE invoice_movie');
        $this->addSql('ALTER TABLE `addresses` DROP FOREIGN KEY FK_6FCA7516A76ED395');
        $this->addSql('DROP INDEX IDX_6FCA7516A76ED395 ON `addresses`');
        $this->addSql('ALTER TABLE `addresses` DROP user_id');
    }
}
