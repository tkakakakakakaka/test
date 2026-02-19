<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219141258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__traitement AS SELECT id, medicament, quantite, contenant, duree, dose, frequence FROM traitement');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('CREATE TABLE traitement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, medicament VARCHAR(255) NOT NULL, quantite INTEGER NOT NULL, contenant VARCHAR(255) NOT NULL, duree INTEGER NOT NULL, dose VARCHAR(255) NOT NULL, frequence INTEGER NOT NULL, consultation_id INTEGER DEFAULT NULL, CONSTRAINT FK_2A356D2762FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO traitement (id, medicament, quantite, contenant, duree, dose, frequence) SELECT id, medicament, quantite, contenant, duree, dose, frequence FROM __temp__traitement');
        $this->addSql('DROP TABLE __temp__traitement');
        $this->addSql('CREATE INDEX IDX_2A356D2762FF6CDF ON traitement (consultation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__traitement AS SELECT id, medicament, quantite, contenant, duree, dose, frequence FROM traitement');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('CREATE TABLE traitement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, medicament VARCHAR(255) NOT NULL, quantite INTEGER NOT NULL, contenant VARCHAR(255) NOT NULL, duree INTEGER NOT NULL, dose VARCHAR(255) NOT NULL, frequence INTEGER NOT NULL)');
        $this->addSql('INSERT INTO traitement (id, medicament, quantite, contenant, duree, dose, frequence) SELECT id, medicament, quantite, contenant, duree, dose, frequence FROM __temp__traitement');
        $this->addSql('DROP TABLE __temp__traitement');
    }
}
