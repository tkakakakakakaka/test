<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260220172720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__consultation AS SELECT id, age, description, date FROM consultation');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('CREATE TABLE consultation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, age INTEGER NOT NULL, description CLOB NOT NULL, date DATE NOT NULL, patient_id INTEGER NOT NULL, medecin_id INTEGER NOT NULL, CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO consultation (id, age, description, date) SELECT id, age, description, date FROM __temp__consultation');
        $this->addSql('DROP TABLE __temp__consultation');
        $this->addSql('CREATE INDEX IDX_964685A66B899279 ON consultation (patient_id)');
        $this->addSql('CREATE INDEX IDX_964685A64F31A84 ON consultation (medecin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__consultation AS SELECT id, age, description, date FROM consultation');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('CREATE TABLE consultation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, age INTEGER NOT NULL, description CLOB NOT NULL, date DATE NOT NULL)');
        $this->addSql('INSERT INTO consultation (id, age, description, date) SELECT id, age, description, date FROM __temp__consultation');
        $this->addSql('DROP TABLE __temp__consultation');
    }
}
