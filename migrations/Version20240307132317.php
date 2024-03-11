<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307132317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(100) NOT NULL, path VARCHAR(100) NOT NULL, min_path VARCHAR(110) NOT NULL, INDEX IDX_E01FBE6A7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE registration_codes CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_available is_available TINYINT(1) DEFAULT TRUE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A0761A577153098 ON registration_codes (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A7E3C61F9');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP INDEX UNIQ_6A0761A577153098 ON registration_codes');
        $this->addSql('ALTER TABLE registration_codes CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE is_available is_available TINYINT(1) NOT NULL');
    }
}
