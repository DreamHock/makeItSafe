<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826140356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE relation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization ADD relation_id INT NOT NULL');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C3256915B FOREIGN KEY (relation_id) REFERENCES relation (id)');
        $this->addSql('CREATE INDEX IDX_C1EE637C3256915B ON organization (relation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C3256915B');
        $this->addSql('DROP TABLE relation');
        $this->addSql('DROP INDEX IDX_C1EE637C3256915B ON organization');
        $this->addSql('ALTER TABLE organization DROP relation_id');
    }
}
