<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617173502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, fa_id INT DEFAULT NULL, member_id INT DEFAULT NULL, gerant_id INT DEFAULT NULL, race_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, age INT NOT NULL, sex VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, ok_dogs TINYINT(1) DEFAULT NULL, ok_cats TINYINT(1) DEFAULT NULL, ok_kids TINYINT(1) DEFAULT NULL, adoption_price DOUBLE PRECISION NOT NULL, date_add DATE NOT NULL, need_care TINYINT(1) NOT NULL, is_hosted TINYINT(1) NOT NULL, image_links JSON NOT NULL, INDEX IDX_6AAB231FCACAF9B4 (fa_id), INDEX IDX_6AAB231F7597D3FE (member_id), INDEX IDX_6AAB231FA500A924 (gerant_id), INDEX IDX_6AAB231F6E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, member_donating_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX IDX_31E581A0D4945564 (member_donating_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, gerant_id INT DEFAULT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7A500A924 (gerant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fa (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, house_type VARCHAR(255) DEFAULT NULL, has_dog TINYINT(1) DEFAULT NULL, has_cat TINYINT(1) DEFAULT NULL, has_kid TINYINT(1) DEFAULT NULL, can_quarantine TINYINT(1) DEFAULT NULL, house_size INT DEFAULT NULL, UNIQUE INDEX UNIQ_48CB8F10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gerant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_D1D45C70A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE login_attempt (id INT AUTO_INCREMENT NOT NULL, ip_address VARCHAR(50) DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', username LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_F6B4FB29A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_event (membre_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_8D8805266A99F74A (membre_id), INDEX IDX_8D88052671F7E88B (event_id), PRIMARY KEY(membre_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, googleAuthenticatorSecret VARCHAR(255) DEFAULT NULL, usual_browser VARCHAR(50) DEFAULT NULL, register_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FCACAF9B4 FOREIGN KEY (fa_id) REFERENCES fa (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7597D3FE FOREIGN KEY (member_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA500A924 FOREIGN KEY (gerant_id) REFERENCES gerant (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0D4945564 FOREIGN KEY (member_donating_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A500A924 FOREIGN KEY (gerant_id) REFERENCES gerant (id)');
        $this->addSql('ALTER TABLE fa ADD CONSTRAINT FK_48CB8F10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gerant ADD CONSTRAINT FK_D1D45C70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE membre_event ADD CONSTRAINT FK_8D8805266A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_event ADD CONSTRAINT FK_8D88052671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membre_event DROP FOREIGN KEY FK_8D88052671F7E88B');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FCACAF9B4');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FA500A924');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A500A924');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7597D3FE');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0D4945564');
        $this->addSql('ALTER TABLE membre_event DROP FOREIGN KEY FK_8D8805266A99F74A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE fa DROP FOREIGN KEY FK_48CB8F10A76ED395');
        $this->addSql('ALTER TABLE gerant DROP FOREIGN KEY FK_D1D45C70A76ED395');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29A76ED395');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE fa');
        $this->addSql('DROP TABLE gerant');
        $this->addSql('DROP TABLE login_attempt');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE membre_event');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE user');
    }
}
