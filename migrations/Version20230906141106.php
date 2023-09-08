<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906141106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, complexity_id INT NOT NULL, priority_id INT NOT NULL, organization_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', due_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(255) DEFAULT NULL, INDEX IDX_47CC8C92DAC7F446 (complexity_id), INDEX IDX_47CC8C92497B19F9 (priority_id), INDEX IDX_47CC8C9232C8A3DE (organization_id), INDEX IDX_47CC8C92A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92DAC7F446 FOREIGN KEY (complexity_id) REFERENCES complexity (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9232C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25497B19F9');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25DAC7F446');
        $this->addSql('DROP TABLE task');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, complexity_id INT NOT NULL, priority_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', due_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_527EDB25DAC7F446 (complexity_id), INDEX IDX_527EDB25497B19F9 (priority_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25DAC7F446 FOREIGN KEY (complexity_id) REFERENCES complexity (id)');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92DAC7F446');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92497B19F9');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9232C8A3DE');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92A76ED395');
        $this->addSql('DROP TABLE action');
    }
}
