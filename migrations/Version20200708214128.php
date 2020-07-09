<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200708214128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(1024) NOT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, `task_priority_name` VARCHAR(32) DEFAULT NULL, `task_status_name` VARCHAR(32) DEFAULT NULL, INDEX IDX_527EDB256FBACE13 (`task_priority_name`), INDEX IDX_527EDB25798BE3 (`task_status_name`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_priority (`name` VARCHAR(32) NOT NULL, label VARCHAR(255) NOT NULL, `order` INT NOT NULL, PRIMARY KEY(`name`)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_property (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, type VARCHAR(255) NOT NULL, content VARCHAR(2056) NOT NULL, INDEX IDX_CB32F6928DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_status (`name` VARCHAR(32) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(`name`)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256FBACE13 FOREIGN KEY (`task_priority_name`) REFERENCES task_priority (`name`) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25798BE3 FOREIGN KEY (`task_status_name`) REFERENCES task_status (`name`) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE task_property ADD CONSTRAINT FK_CB32F6928DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_property DROP FOREIGN KEY FK_CB32F6928DB60186');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256FBACE13');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25798BE3');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_priority');
        $this->addSql('DROP TABLE task_property');
        $this->addSql('DROP TABLE task_status');
    }
}
