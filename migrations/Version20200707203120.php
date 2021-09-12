<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707203120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C61C54BBB8');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C693C8D8F');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6E808103');
        $this->addSql('DROP INDEX IDX_38BBA6C693C8D8F ON exam');
        $this->addSql('DROP INDEX IDX_38BBA6C61C54BBB8 ON exam');
        $this->addSql('DROP INDEX IDX_38BBA6C6E808103 ON exam');
        $this->addSql('ALTER TABLE exam ADD groupe_id INT DEFAULT NULL, ADD salle_id INT DEFAULT NULL, ADD module_id INT DEFAULT NULL, DROP groupe_e_id, DROP salle_e_id, DROP module_e_id, CHANGE date_e fait_le DATETIME DEFAULT NULL, CHANGE state_e state VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C67A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C67A45358C ON exam (groupe_id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C6DC304035 ON exam (salle_id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C6AFC2B591 ON exam (module_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C67A45358C');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6DC304035');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6AFC2B591');
        $this->addSql('DROP INDEX IDX_38BBA6C67A45358C ON exam');
        $this->addSql('DROP INDEX IDX_38BBA6C6DC304035 ON exam');
        $this->addSql('DROP INDEX IDX_38BBA6C6AFC2B591 ON exam');
        $this->addSql('ALTER TABLE exam ADD groupe_e_id INT DEFAULT NULL, ADD salle_e_id INT DEFAULT NULL, ADD module_e_id INT DEFAULT NULL, DROP groupe_id, DROP salle_id, DROP module_id, CHANGE fait_le date_e DATETIME DEFAULT NULL, CHANGE state state_e VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C61C54BBB8 FOREIGN KEY (groupe_e_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C693C8D8F FOREIGN KEY (salle_e_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6E808103 FOREIGN KEY (module_e_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C693C8D8F ON exam (salle_e_id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C61C54BBB8 ON exam (groupe_e_id)');
        $this->addSql('CREATE INDEX IDX_38BBA6C6E808103 ON exam (module_e_id)');
    }
}
