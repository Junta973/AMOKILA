<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813132921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE component (id INT AUTO_INCREMENT NOT NULL, component_ref VARCHAR(50) NOT NULL, component_name VARCHAR(50) NOT NULL, component_cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component_task (component_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_EE5E6C13E2ABAFFF (component_id), INDEX IDX_EE5E6C138DB60186 (task_id), PRIMARY KEY(component_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE component_supplier (component_id INT NOT NULL, supplier_id INT NOT NULL, INDEX IDX_D928F893E2ABAFFF (component_id), INDEX IDX_D928F8932ADD6D8C (supplier_id), PRIMARY KEY(component_id, supplier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, ref_material VARCHAR(50) NOT NULL, name_material VARCHAR(255) NOT NULL, date_validation_in DATE NOT NULL, date_validation_out DATE NOT NULL, material_cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, ref_media VARCHAR(50) NOT NULL, media_name VARCHAR(255) NOT NULL, indice VARCHAR(50) DEFAULT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, phase_name VARCHAR(255) NOT NULL, phase_description VARCHAR(255) NOT NULL, project_phase_date_start DATE NOT NULL, project_phase_date_end DATE NOT NULL, INDEX IDX_B1BDD6CB166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, user_id INT DEFAULT NULL, process_path_id INT DEFAULT NULL, document1_path_id INT DEFAULT NULL, document2_path_id INT DEFAULT NULL, document3_path_id INT DEFAULT NULL, document4_path_id INT DEFAULT NULL, ref_process VARCHAR(255) NOT NULL, process_name VARCHAR(255) NOT NULL, process_indice VARCHAR(255) NOT NULL, INDEX IDX_861D18968DB60186 (task_id), INDEX IDX_861D1896A76ED395 (user_id), INDEX IDX_861D189691148CBE (process_path_id), INDEX IDX_861D1896B6441C79 (document1_path_id), INDEX IDX_861D18968FC920BC (document2_path_id), INDEX IDX_861D189698B234FF (document3_path_id), INDEX IDX_861D1896FCD35936 (document4_path_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, maitre_id INT DEFAULT NULL, ref_project VARCHAR(255) NOT NULL, project_name VARCHAR(255) NOT NULL, project_description LONGTEXT NOT NULL, date_init_projet DATE NOT NULL, date_fin_projet DATE NOT NULL, cost INT NOT NULL, INDEX IDX_2FB3D0EECF133C25 (maitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_change_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, project_id INT DEFAULT NULL, date_de_creation DATE NOT NULL, pcr_description LONGTEXT NOT NULL, pcr_change_reason LONGTEXT NOT NULL, impact_of_change LONGTEXT NOT NULL, pcr_proposed_action LONGTEXT NOT NULL, approval_date DATE DEFAULT NULL, pcr_status VARCHAR(255) NOT NULL, pcr_name VARCHAR(255) NOT NULL, pcr_ref VARCHAR(255) NOT NULL, approved_by VARCHAR(255) NOT NULL, materials VARCHAR(255) NOT NULL, components VARCHAR(255) NOT NULL, request_by VARCHAR(255) NOT NULL, priority VARCHAR(255) NOT NULL, estimated_cost INT NOT NULL, INDEX IDX_22271994A76ED395 (user_id), INDEX IDX_22271994166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, supplier_ref VARCHAR(255) NOT NULL, supplier_name VARCHAR(255) NOT NULL, supplier_email VARCHAR(255) NOT NULL, supplier_adress VARCHAR(255) NOT NULL, supplier_phone VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, projet_id INT DEFAULT NULL, task_ref VARCHAR(255) NOT NULL, task_name VARCHAR(255) NOT NULL, task_description LONGTEXT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, progress DOUBLE PRECISION NOT NULL, task_cost INT NOT NULL, INDEX IDX_527EDB25A76ED395 (user_id), INDEX IDX_527EDB25C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_material (task_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_3C7E9FD98DB60186 (task_id), INDEX IDX_3C7E9FD9E308AC6F (material_id), PRIMARY KEY(task_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, age INT DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, contrat VARCHAR(255) DEFAULT NULL, hourly_fee INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE component_task ADD CONSTRAINT FK_EE5E6C13E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE component_task ADD CONSTRAINT FK_EE5E6C138DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE component_supplier ADD CONSTRAINT FK_D928F893E2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE component_supplier ADD CONSTRAINT FK_D928F8932ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CB166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18968DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189691148CBE FOREIGN KEY (process_path_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896B6441C79 FOREIGN KEY (document1_path_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18968FC920BC FOREIGN KEY (document2_path_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189698B234FF FOREIGN KEY (document3_path_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896FCD35936 FOREIGN KEY (document4_path_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EECF133C25 FOREIGN KEY (maitre_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project_change_request ADD CONSTRAINT FK_22271994A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project_change_request ADD CONSTRAINT FK_22271994166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C18272 FOREIGN KEY (projet_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task_material ADD CONSTRAINT FK_3C7E9FD98DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_material ADD CONSTRAINT FK_3C7E9FD9E308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE component_task DROP FOREIGN KEY FK_EE5E6C13E2ABAFFF');
        $this->addSql('ALTER TABLE component_supplier DROP FOREIGN KEY FK_D928F893E2ABAFFF');
        $this->addSql('ALTER TABLE task_material DROP FOREIGN KEY FK_3C7E9FD9E308AC6F');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189691148CBE');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896B6441C79');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18968FC920BC');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189698B234FF');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896FCD35936');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CB166D1F9C');
        $this->addSql('ALTER TABLE project_change_request DROP FOREIGN KEY FK_22271994166D1F9C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25C18272');
        $this->addSql('ALTER TABLE component_supplier DROP FOREIGN KEY FK_D928F8932ADD6D8C');
        $this->addSql('ALTER TABLE component_task DROP FOREIGN KEY FK_EE5E6C138DB60186');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18968DB60186');
        $this->addSql('ALTER TABLE task_material DROP FOREIGN KEY FK_3C7E9FD98DB60186');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896A76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EECF133C25');
        $this->addSql('ALTER TABLE project_change_request DROP FOREIGN KEY FK_22271994A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('DROP TABLE component');
        $this->addSql('DROP TABLE component_task');
        $this->addSql('DROP TABLE component_supplier');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_change_request');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_material');
        $this->addSql('DROP TABLE `user`');
    }
}
