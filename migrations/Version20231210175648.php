<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210175648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73A76ED395');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73EF1A9D84');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, reception_mode VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notification_user (notification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_35AF9D73A76ED395 (user_id), INDEX IDX_35AF9D73EF1A9D84 (notification_id), PRIMARY KEY(notification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
