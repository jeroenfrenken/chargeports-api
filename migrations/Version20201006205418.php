<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006205418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charger_connection (id INT AUTO_INCREMENT NOT NULL, charger_id INT NOT NULL, connection_type_id INT NOT NULL, status_type_id INT NOT NULL, level_id INT NOT NULL, power_kw NUMERIC(5, 2) NOT NULL, current_type_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_D5D6D4F945422674 (charger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE charger_connection ADD CONSTRAINT FK_D5D6D4F945422674 FOREIGN KEY (charger_id) REFERENCES charger (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE charger_connection');
    }
}
