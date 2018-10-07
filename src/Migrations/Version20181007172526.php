<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181007172526 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE establishment_days (day_id INT NOT NULL, establishment_id INT NOT NULL, INDEX IDX_449957759C24126 (day_id), INDEX IDX_449957758565851 (establishment_id), PRIMARY KEY(day_id, establishment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE establishment_days ADD CONSTRAINT FK_449957759C24126 FOREIGN KEY (day_id) REFERENCES days (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE establishment_days ADD CONSTRAINT FK_449957758565851 FOREIGN KEY (establishment_id) REFERENCES establishments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC668565851');
        $this->addSql('DROP INDEX IDX_EBE4FC668565851 ON days');
        $this->addSql('ALTER TABLE days DROP establishment_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE establishment_days');
        $this->addSql('ALTER TABLE days ADD establishment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC668565851 FOREIGN KEY (establishment_id) REFERENCES establishments (id)');
        $this->addSql('CREATE INDEX IDX_EBE4FC668565851 ON days (establishment_id)');
    }
}
