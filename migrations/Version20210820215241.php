<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820215241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_change_request ADD approuved_by_id INT DEFAULT NULL, ADD requested_by_id INT DEFAULT NULL, DROP approved_by, DROP request_by');
        $this->addSql('ALTER TABLE project_change_request ADD CONSTRAINT FK_2227199492E67029 FOREIGN KEY (approuved_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project_change_request ADD CONSTRAINT FK_222719944DA1E751 FOREIGN KEY (requested_by_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_2227199492E67029 ON project_change_request (approuved_by_id)');
        $this->addSql('CREATE INDEX IDX_222719944DA1E751 ON project_change_request (requested_by_id)');
        $this->addSql('ALTER TABLE task ADD color VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_change_request DROP FOREIGN KEY FK_2227199492E67029');
        $this->addSql('ALTER TABLE project_change_request DROP FOREIGN KEY FK_222719944DA1E751');
        $this->addSql('DROP INDEX IDX_2227199492E67029 ON project_change_request');
        $this->addSql('DROP INDEX IDX_222719944DA1E751 ON project_change_request');
        $this->addSql('ALTER TABLE project_change_request ADD approved_by VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD request_by VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP approuved_by_id, DROP requested_by_id');
        $this->addSql('ALTER TABLE task DROP color');
    }
}
