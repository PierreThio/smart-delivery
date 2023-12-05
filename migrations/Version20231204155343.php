<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204155343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step_localisation DROP FOREIGN KEY FK_84BC395D73B21E9C');
        $this->addSql('ALTER TABLE step_localisation DROP FOREIGN KEY FK_84BC395DC68BE09C');
        $this->addSql('DROP TABLE step_localisation');
        $this->addSql('ALTER TABLE localisation ADD step_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F73B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('CREATE INDEX IDX_BFD3CE8F73B21E9C ON localisation (step_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE step_localisation (step_id INT NOT NULL, localisation_id INT NOT NULL, INDEX IDX_84BC395DC68BE09C (localisation_id), INDEX IDX_84BC395D73B21E9C (step_id), PRIMARY KEY(step_id, localisation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE step_localisation ADD CONSTRAINT FK_84BC395D73B21E9C FOREIGN KEY (step_id) REFERENCES step (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step_localisation ADD CONSTRAINT FK_84BC395DC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F73B21E9C');
        $this->addSql('DROP INDEX IDX_BFD3CE8F73B21E9C ON localisation');
        $this->addSql('ALTER TABLE localisation DROP step_id');
    }
}
