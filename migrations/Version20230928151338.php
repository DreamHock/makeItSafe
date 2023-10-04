<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928151338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action ADD is_reccurent TINYINT(1) DEFAULT NULL, ADD last_updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD next_updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE complexity CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE country CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE language CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE priority CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE relation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE status CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE technical_role CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP is_reccurent, DROP last_updated_at, DROP next_updated_at');
        $this->addSql('ALTER TABLE complexity CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE country CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE language CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE priority CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE relation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE role CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE status CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE technical_role CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
