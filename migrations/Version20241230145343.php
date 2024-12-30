<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241230145343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, schedule_id_id INT DEFAULT NULL, circuit_id_id INT DEFAULT NULL, dates VARCHAR(255) NOT NULL, meeting_name VARCHAR(255) NOT NULL, race_laps INT NOT NULL, INDEX IDX_F515E139831D5E0B (schedule_id_id), INDEX IDX_F515E139BC21E890 (circuit_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, season_id_id INT NOT NULL, schedule_name VARCHAR(255) NOT NULL, INDEX IDX_5A3811FB68756988 (season_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, meeting_id_id INT DEFAULT NULL, session_name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, forecast VARCHAR(255) DEFAULT NULL, INDEX IDX_D044D5D41775DC57 (meeting_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139831D5E0B FOREIGN KEY (schedule_id_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E139BC21E890 FOREIGN KEY (circuit_id_id) REFERENCES circuit (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB68756988 FOREIGN KEY (season_id_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D41775DC57 FOREIGN KEY (meeting_id_id) REFERENCES meeting (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139831D5E0B');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E139BC21E890');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB68756988');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D41775DC57');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE session');
    }
}
