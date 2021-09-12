<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200621223100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP INDEX UNIQ_FDCA8C9CAFC2B591, ADD INDEX IDX_FDCA8C9CAFC2B591 (module_id)');
        $this->addSql('ALTER TABLE cours DROP INDEX UNIQ_FDCA8C9CBAB22EE9, ADD INDEX IDX_FDCA8C9CBAB22EE9 (professeur_id)');
        $this->addSql('ALTER TABLE cours RENAME INDEX uniq_fdca8c9cdc304035 TO IDX_FDCA8C9CDC304035');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP INDEX IDX_FDCA8C9CBAB22EE9, ADD UNIQUE INDEX UNIQ_FDCA8C9CBAB22EE9 (professeur_id)');
        $this->addSql('ALTER TABLE cours DROP INDEX IDX_FDCA8C9CAFC2B591, ADD UNIQUE INDEX UNIQ_FDCA8C9CAFC2B591 (module_id)');
        $this->addSql('ALTER TABLE cours RENAME INDEX idx_fdca8c9cdc304035 TO UNIQ_FDCA8C9CDC304035');
    }
}
