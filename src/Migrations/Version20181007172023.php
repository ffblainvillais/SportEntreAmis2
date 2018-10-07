<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181007172023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE days_hours (day_id INT NOT NULL, hour_id INT NOT NULL, INDEX IDX_AFE1E9249C24126 (day_id), INDEX IDX_AFE1E924B5937BF9 (hour_id), PRIMARY KEY(day_id, hour_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hours (id INT AUTO_INCREMENT NOT NULL, begin_hour VARCHAR(255) NOT NULL, end_hour VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE days_hours ADD CONSTRAINT FK_AFE1E9249C24126 FOREIGN KEY (day_id) REFERENCES days (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE days_hours ADD CONSTRAINT FK_AFE1E924B5937BF9 FOREIGN KEY (hour_id) REFERENCES hours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE days ADD establishment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE days ADD CONSTRAINT FK_EBE4FC668565851 FOREIGN KEY (establishment_id) REFERENCES establishments (id)');
        $this->addSql('CREATE INDEX IDX_EBE4FC668565851 ON days (establishment_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE days_hours DROP FOREIGN KEY FK_AFE1E924B5937BF9');
        $this->addSql('DROP TABLE days_hours');
        $this->addSql('DROP TABLE hours');
        $this->addSql('ALTER TABLE days DROP FOREIGN KEY FK_EBE4FC668565851');
        $this->addSql('DROP INDEX IDX_EBE4FC668565851 ON days');
        $this->addSql('ALTER TABLE days DROP establishment_id');
    }
}
