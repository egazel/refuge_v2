<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200612093630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fa ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE fa ADD CONSTRAINT FK_48CB8F10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_48CB8F10A76ED395 ON fa (user_id)');
        $this->addSql('ALTER TABLE gerant ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE gerant ADD CONSTRAINT FK_D1D45C70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D1D45C70A76ED395 ON gerant (user_id)');
        $this->addSql('ALTER TABLE membre ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB29A76ED395 ON membre (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fa DROP FOREIGN KEY FK_48CB8F10A76ED395');
        $this->addSql('DROP INDEX UNIQ_48CB8F10A76ED395 ON fa');
        $this->addSql('ALTER TABLE fa DROP user_id');
        $this->addSql('ALTER TABLE gerant DROP FOREIGN KEY FK_D1D45C70A76ED395');
        $this->addSql('DROP INDEX UNIQ_D1D45C70A76ED395 ON gerant');
        $this->addSql('ALTER TABLE gerant DROP user_id');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29A76ED395');
        $this->addSql('DROP INDEX UNIQ_F6B4FB29A76ED395 ON membre');
        $this->addSql('ALTER TABLE membre DROP user_id');
    }
}
