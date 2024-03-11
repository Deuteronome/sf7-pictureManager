<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307145649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD file_name VARCHAR(255) NOT NULL, DROP path, DROP min_path');
        $this->addSql('ALTER TABLE registration_codes CHANGE is_available is_available TINYINT(1) DEFAULT TRUE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD min_path VARCHAR(255) NOT NULL, CHANGE file_name path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE registration_codes CHANGE is_available is_available TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
