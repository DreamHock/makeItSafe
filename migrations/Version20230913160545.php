<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913160545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_technical_role (user_id INT NOT NULL, technical_role_id INT NOT NULL, INDEX IDX_10E91B70A76ED395 (user_id), INDEX IDX_10E91B70BA4F871D (technical_role_id), PRIMARY KEY(user_id, technical_role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_technical_role ADD CONSTRAINT FK_10E91B70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technical_role ADD CONSTRAINT FK_10E91B70BA4F871D FOREIGN KEY (technical_role_id) REFERENCES technical_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action CHANGE complexity_id complexity_id INT NOT NULL, CHANGE priority_id priority_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user_technical_role DROP FOREIGN KEY FK_10E91B70A76ED395');
        $this->addSql('ALTER TABLE user_technical_role DROP FOREIGN KEY FK_10E91B70BA4F871D');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE technical_role');
        $this->addSql('DROP TABLE user_technical_role');
        $this->addSql('ALTER TABLE action CHANGE complexity_id complexity_id INT DEFAULT NULL, CHANGE priority_id priority_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user DROP role_id');
    }
}
