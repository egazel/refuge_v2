<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620080412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE house_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fa ADD house_type_id INT DEFAULT NULL, DROP house_type');
        $this->addSql('ALTER TABLE fa ADD CONSTRAINT FK_48CB8F10519B0A8E FOREIGN KEY (house_type_id) REFERENCES house_type (id)');
        $this->addSql('CREATE INDEX IDX_48CB8F10519B0A8E ON fa (house_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fa DROP FOREIGN KEY FK_48CB8F10519B0A8E');
        $this->addSql('DROP TABLE house_type');
        $this->addSql('DROP INDEX IDX_48CB8F10519B0A8E ON fa');
        $this->addSql('ALTER TABLE fa ADD house_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP house_type_id');
    }
}
