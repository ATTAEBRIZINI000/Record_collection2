<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620203003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE records CHANGE date date DATETIME NOT NULL, CHANGE category category JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE vinyles_number vinyls_number VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE records CHANGE date date DATE NOT NULL, CHANGE category category LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE vinyls_number vinyles_number VARCHAR(255) NOT NULL');
    }
}
