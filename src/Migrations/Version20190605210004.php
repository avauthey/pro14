<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190605210004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE journee (id INT AUTO_INCREMENT NOT NULL, id_equipe_home_id INT NOT NULL, id_equipe_away_id INT NOT NULL, id_arbitre_central_id INT DEFAULT NULL, saison VARCHAR(255) NOT NULL, journee VARCHAR(255) NOT NULL, score_home INT DEFAULT NULL, score_away INT DEFAULT NULL, bphome VARCHAR(255) DEFAULT NULL, bpaway VARCHAR(3) DEFAULT NULL, bdhome VARCHAR(3) DEFAULT NULL, bdaway VARCHAR(3) DEFAULT NULL, jour DATE DEFAULT NULL, heure VARCHAR(5) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, INDEX IDX_DC179AEDCDAB6926 (id_equipe_home_id), INDEX IDX_DC179AED6889A925 (id_equipe_away_id), INDEX IDX_DC179AED5F73FB63 (id_arbitre_central_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE journee ADD CONSTRAINT FK_DC179AEDCDAB6926 FOREIGN KEY (id_equipe_home_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE journee ADD CONSTRAINT FK_DC179AED6889A925 FOREIGN KEY (id_equipe_away_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE journee ADD CONSTRAINT FK_DC179AED5F73FB63 FOREIGN KEY (id_arbitre_central_id) REFERENCES arbitre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE journee');
    }
}
