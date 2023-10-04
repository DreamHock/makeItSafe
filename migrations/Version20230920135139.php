<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920135139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization CHANGE country_id country_id INT NOT NULL, CHANGE relation_id relation_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE language_id language_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization CHANGE country_id country_id INT DEFAULT NULL, CHANGE relation_id relation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE language_id language_id INT DEFAULT NULL');
    }
}
