<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506153840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE badge_label DROP FOREIGN KEY FK_6A68F6C49D603009');
        $this->addSql('DROP TABLE badge_level');
        $this->addSql('DROP INDEX IDX_6A68F6C49D603009 ON badge_label');
        $this->addSql('ALTER TABLE badge_label CHANGE badge_level_id level INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE badge_level (id INT AUTO_INCREMENT NOT NULL, level_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE badge_label CHANGE level badge_level_id INT NOT NULL');
        $this->addSql('ALTER TABLE badge_label ADD CONSTRAINT FK_6A68F6C49D603009 FOREIGN KEY (badge_level_id) REFERENCES badge_level (id)');
        $this->addSql('CREATE INDEX IDX_6A68F6C49D603009 ON badge_label (badge_level_id)');
    }
}
