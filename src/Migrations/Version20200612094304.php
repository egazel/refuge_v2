<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612094304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE animal ADD fa_id INT DEFAULT NULL, ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FCACAF9B4 FOREIGN KEY (fa_id) REFERENCES fa (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7597D3FE FOREIGN KEY (member_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FCACAF9B4 ON animal (fa_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F7597D3FE ON animal (member_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FCACAF9B4');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7597D3FE');
        $this->addSql('DROP INDEX IDX_6AAB231FCACAF9B4 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231F7597D3FE ON animal');
        $this->addSql('ALTER TABLE animal DROP fa_id, DROP member_id');
    }
}
