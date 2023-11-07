<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106140110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, longitude INT NOT NULL, latitude INT NOT NULL, timestamp DATETIME NOT NULL, UNIQUE INDEX UNIQ_BFD3CE8FF44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locker (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, relay_center_id INT DEFAULT NULL, locker_number INT NOT NULL, address VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, volume INT NOT NULL, INDEX IDX_1E067DC067B3B43D (users_id), INDEX IDX_1E067DC024829C36 (relay_center_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, reception_mode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_user (notification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_35AF9D73EF1A9D84 (notification_id), INDEX IDX_35AF9D73A76ED395 (user_id), PRIMARY KEY(notification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE package (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, locker_id INT DEFAULT NULL, weight INT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, volume INT NOT NULL, INDEX IDX_DE686795A76ED395 (user_id), INDEX IDX_DE686795841CF1E0 (locker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relay_center (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step_localisation (step_id INT NOT NULL, localisation_id INT NOT NULL, INDEX IDX_84BC395D73B21E9C (step_id), INDEX IDX_84BC395DC68BE09C (localisation_id), PRIMARY KEY(step_id, localisation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FF44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('ALTER TABLE locker ADD CONSTRAINT FK_1E067DC067B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE locker ADD CONSTRAINT FK_1E067DC024829C36 FOREIGN KEY (relay_center_id) REFERENCES relay_center (id)');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795841CF1E0 FOREIGN KEY (locker_id) REFERENCES locker (id)');
        $this->addSql('ALTER TABLE step_localisation ADD CONSTRAINT FK_84BC395D73B21E9C FOREIGN KEY (step_id) REFERENCES step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step_localisation ADD CONSTRAINT FK_84BC395DC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD relay_center_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64924829C36 FOREIGN KEY (relay_center_id) REFERENCES relay_center (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64924829C36 ON user (relay_center_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64924829C36');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FF44CABFF');
        $this->addSql('ALTER TABLE locker DROP FOREIGN KEY FK_1E067DC067B3B43D');
        $this->addSql('ALTER TABLE locker DROP FOREIGN KEY FK_1E067DC024829C36');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73EF1A9D84');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73A76ED395');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795A76ED395');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795841CF1E0');
        $this->addSql('ALTER TABLE step_localisation DROP FOREIGN KEY FK_84BC395D73B21E9C');
        $this->addSql('ALTER TABLE step_localisation DROP FOREIGN KEY FK_84BC395DC68BE09C');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE locker');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_user');
        $this->addSql('DROP TABLE package');
        $this->addSql('DROP TABLE relay_center');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE step_localisation');
        $this->addSql('DROP INDEX IDX_8D93D64924829C36 ON user');
        $this->addSql('ALTER TABLE user DROP relay_center_id');
    }
}
