<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817223915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD updated_at DATETIME NOT NULL, CHANGE ref_media ref_media VARCHAR(50) DEFAULT NULL, CHANGE media_name media_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD budget DOUBLE PRECISION NOT NULL, CHANGE cost cost DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) DEFAULT NULL, ADD firstname VARCHAR(255) DEFAULT NULL, ADD skills VARCHAR(255) DEFAULT NULL, ADD departement VARCHAR(255) DEFAULT NULL, ADD level INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP updated_at, CHANGE ref_media ref_media VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE media_name media_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project DROP budget, CHANGE cost cost INT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP name, DROP firstname, DROP skills, DROP departement, DROP level');
    }
}
