<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820111419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD request_change_id INT DEFAULT NULL, ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256ACD7A53 FOREIGN KEY (request_change_id) REFERENCES project_change_request (id)');
        $this->addSql('CREATE INDEX IDX_527EDB256ACD7A53 ON task (request_change_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256ACD7A53');
        $this->addSql('DROP INDEX IDX_527EDB256ACD7A53 ON task');
        $this->addSql('ALTER TABLE task DROP request_change_id, DROP date');
    }
}
