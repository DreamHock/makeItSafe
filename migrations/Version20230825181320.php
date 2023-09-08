<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825181320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB ');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, parent_id INT NOT NULL, name VARCHAR(255) NOT NULL, siret INT DEFAULT NULL, postal_address VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, activity_area VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, INDEX IDX_C1EE637CF92F3E70 (country_id), INDEX IDX_C1EE637C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, admin_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, function VARCHAR(255) DEFAULT NULL, end_validation_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_demo_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', has_notifications TINYINT(1) DEFAULT NULL, has_invitation TINYINT(1) NOT NULL, contact_email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64982F1BAF4 (language_id), INDEX IDX_8D93D649642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C727ACA70 FOREIGN KEY (parent_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637CF92F3E70');
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C727ACA70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64982F1BAF4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649642B8210');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE user');
    }
}
