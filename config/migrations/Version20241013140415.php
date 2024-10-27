<?php

declare(strict_types=1);

namespace config\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241013140415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE EntityObject CHANGE `range` `range` LONGTEXT DEFAULT NULL, CHANGE population population LONGTEXT DEFAULT NULL, CHANGE habitats habitats LONGTEXT DEFAULT NULL, CHANGE threats threats LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE EntityObject CHANGE `range` `range` VARCHAR(255) DEFAULT NULL, CHANGE population population VARCHAR(255) DEFAULT NULL, CHANGE habitats habitats VARCHAR(255) DEFAULT NULL, CHANGE threats threats VARCHAR(255) DEFAULT NULL');
    }
}
