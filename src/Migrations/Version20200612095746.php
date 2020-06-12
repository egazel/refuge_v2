<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612095746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membre_event (membre_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_8D8805266A99F74A (membre_id), INDEX IDX_8D88052671F7E88B (event_id), PRIMARY KEY(membre_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_event ADD CONSTRAINT FK_8D8805266A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_event ADD CONSTRAINT FK_8D88052671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation ADD member_donating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0D4945564 FOREIGN KEY (member_donating_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_31E581A0D4945564 ON donation (member_donating_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE membre_event');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0D4945564');
        $this->addSql('DROP INDEX IDX_31E581A0D4945564 ON donation');
        $this->addSql('ALTER TABLE donation DROP member_donating_id');
    }
}
