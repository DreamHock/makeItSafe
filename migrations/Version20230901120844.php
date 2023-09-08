<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901120844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complexity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, complexity_id INT NOT NULL, priority_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', due_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(255) DEFAULT NULL, INDEX IDX_527EDB25DAC7F446 (complexity_id), INDEX IDX_527EDB25497B19F9 (priority_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25DAC7F446 FOREIGN KEY (complexity_id) REFERENCES complexity (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25DAC7F446');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25497B19F9');
        $this->addSql('DROP TABLE complexity');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE task');
    }
}
