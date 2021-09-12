<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707173909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, groupe_e_id INT DEFAULT NULL, salle_e_id INT DEFAULT NULL, module_e_id INT DEFAULT NULL, name_e VARCHAR(255) NOT NULL, type_e VARCHAR(255) NOT NULL, date_e DATETIME DEFAULT NULL, state_e VARCHAR(255) DEFAULT NULL, INDEX IDX_38BBA6C61C54BBB8 (groupe_e_id), INDEX IDX_38BBA6C693C8D8F (salle_e_id), INDEX IDX_38BBA6C6E808103 (module_e_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exam_professeur (exam_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_5AD28CC578D5E91 (exam_id), INDEX IDX_5AD28CCBAB22EE9 (professeur_id), PRIMARY KEY(exam_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C61C54BBB8 FOREIGN KEY (groupe_e_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C693C8D8F FOREIGN KEY (salle_e_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6E808103 FOREIGN KEY (module_e_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE exam_professeur ADD CONSTRAINT FK_5AD28CC578D5E91 FOREIGN KEY (exam_id) REFERENCES exam (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exam_professeur ADD CONSTRAINT FK_5AD28CCBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exam_professeur DROP FOREIGN KEY FK_5AD28CC578D5E91');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE exam_professeur');
    }
}
