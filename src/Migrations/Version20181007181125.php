<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181007181125 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE establishment_days_hours (id INT AUTO_INCREMENT NOT NULL, day_id INT DEFAULT NULL, hour_id INT DEFAULT NULL, establishment_id INT DEFAULT NULL, is_open SMALLINT NOT NULL, is_reservable SMALLINT NOT NULL, INDEX IDX_6625558A9C24126 (day_id), INDEX IDX_6625558AB5937BF9 (hour_id), INDEX IDX_6625558A8565851 (establishment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE establishment_days_hours ADD CONSTRAINT FK_6625558A9C24126 FOREIGN KEY (day_id) REFERENCES days (id)');
        $this->addSql('ALTER TABLE establishment_days_hours ADD CONSTRAINT FK_6625558AB5937BF9 FOREIGN KEY (hour_id) REFERENCES hours (id)');
        $this->addSql('ALTER TABLE establishment_days_hours ADD CONSTRAINT FK_6625558A8565851 FOREIGN KEY (establishment_id) REFERENCES establishments (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE establishment_days_hours');
    }
}
