<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210320201819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD last_name VARCHAR(80) NOT NULL, ADD first_name VARCHAR(80) NOT NULL, ADD is_active TINYINT(1) DEFAULT NULL, ADD inscription_date DATETIME DEFAULT NULL, ADD expiration_date DATETIME DEFAULT NULL, ADD agree_terms TINYINT(1) NOT NULL, ADD agree_terms_validate_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `users` DROP last_name, DROP first_name, DROP is_active, DROP inscription_date, DROP expiration_date, DROP agree_terms, DROP agree_terms_validate_at');
    }
}
