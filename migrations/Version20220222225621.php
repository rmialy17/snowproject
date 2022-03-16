<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222225621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY figure_ibfk_1');
        $this->addSql('DROP INDEX videos_id ON figure');
        $this->addSql('ALTER TABLE figure DROP videos_id');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE figure RENAME INDEX user_id TO IDX_2F57B37AA76ED395');
        $this->addSql('ALTER TABLE image CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY utilisateur_ibfk_1');
        $this->addSql('DROP INDEX figure_id ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP figure_id');
        $this->addSql('ALTER TABLE video CHANGE URL url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video RENAME INDEX figures_id TO IDX_7CC7DA2C5C7F3A37');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP photo');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AA76ED395');
        $this->addSql('ALTER TABLE figure ADD videos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT figure_ibfk_1 FOREIGN KEY (videos_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX videos_id ON figure (videos_id)');
        $this->addSql('ALTER TABLE figure RENAME INDEX idx_2f57b37aa76ed395 TO user_id');
        $this->addSql('ALTER TABLE image CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD figure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT utilisateur_ibfk_1 FOREIGN KEY (figure_id) REFERENCES figure (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX figure_id ON utilisateur (figure_id)');
        $this->addSql('ALTER TABLE video CHANGE url URL VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE video RENAME INDEX idx_7cc7da2c5c7f3a37 TO figures_id');
    }
}
