<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200708232216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, secteur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe ADD filiere_id INT DEFAULT NULL, ADD annee_debut INT DEFAULT NULL, ADD annee_fin INT NOT NULL, ADD level VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21180AA129 ON groupe (filiere_id)');
        $this->addSql('ALTER TABLE module ADD filiere_id INT DEFAULT NULL, ADD niveau VARCHAR(255) NOT NULL, ADD level VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_C242628180AA129 ON module (filiere_id)');
        $this->addSql('ALTER TABLE note ADD exam_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14578D5E91 FOREIGN KEY (exam_id) REFERENCES exam (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14578D5E91 ON note (exam_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21180AA129');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628180AA129');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP INDEX IDX_4B98C21180AA129 ON groupe');
        $this->addSql('ALTER TABLE groupe DROP filiere_id, DROP annee_debut, DROP annee_fin, DROP level');
        $this->addSql('DROP INDEX IDX_C242628180AA129 ON module');
        $this->addSql('ALTER TABLE module DROP filiere_id, DROP niveau, DROP level');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14578D5E91');
        $this->addSql('DROP INDEX IDX_CFBDFA14578D5E91 ON note');
        $this->addSql('ALTER TABLE note DROP exam_id');
    }
}
