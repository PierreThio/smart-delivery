<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204160732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation DROP INDEX UNIQ_BFD3CE8FF44CABFF, ADD INDEX IDX_BFD3CE8FF44CABFF (package_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localisation DROP INDEX IDX_BFD3CE8FF44CABFF, ADD UNIQUE INDEX UNIQ_BFD3CE8FF44CABFF (package_id)');
    }
}
