<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826135741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649642B8210');
        $this->addSql('DROP INDEX IDX_8D93D649642B8210 ON user');
        $this->addSql('ALTER TABLE user ADD organization_id INT NOT NULL, DROP admin_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64932C8A3DE ON user (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64932C8A3DE');
        $this->addSql('DROP INDEX IDX_8D93D64932C8A3DE ON user');
        $this->addSql('ALTER TABLE user ADD admin_id INT DEFAULT NULL, DROP organization_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649642B8210 ON user (admin_id)');
    }
}
