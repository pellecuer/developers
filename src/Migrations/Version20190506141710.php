<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506141710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE badge_label (id INT AUTO_INCREMENT NOT NULL, badge_level_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6A68F6C49D603009 (badge_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge_level (id INT AUTO_INCREMENT NOT NULL, level_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_badge_label (developer_id INT NOT NULL, badge_label_id INT NOT NULL, INDEX IDX_18A52F1964DD9267 (developer_id), INDEX IDX_18A52F19F1685497 (badge_label_id), PRIMARY KEY(developer_id, badge_label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE badge_label ADD CONSTRAINT FK_6A68F6C49D603009 FOREIGN KEY (badge_level_id) REFERENCES badge_level (id)');
        $this->addSql('ALTER TABLE developer_badge_label ADD CONSTRAINT FK_18A52F1964DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_badge_label ADD CONSTRAINT FK_18A52F19F1685497 FOREIGN KEY (badge_label_id) REFERENCES badge_label (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE developer_badge_label DROP FOREIGN KEY FK_18A52F19F1685497');
        $this->addSql('ALTER TABLE badge_label DROP FOREIGN KEY FK_6A68F6C49D603009');
        $this->addSql('ALTER TABLE developer_badge_label DROP FOREIGN KEY FK_18A52F1964DD9267');
        $this->addSql('DROP TABLE badge_label');
        $this->addSql('DROP TABLE badge_level');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_badge_label');
    }
}
