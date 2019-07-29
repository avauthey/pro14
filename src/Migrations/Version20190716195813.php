<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190716195813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE asso_joueur_journee (id INT AUTO_INCREMENT NOT NULL, journee_id INT DEFAULT NULL, joueur_id INT DEFAULT NULL, equipe_id INT DEFAULT NULL, poste_id INT DEFAULT NULL, numero INT NOT NULL, points INT DEFAULT NULL, essais INT DEFAULT NULL, transformation INT DEFAULT NULL, penalite INT DEFAULT NULL, drops INT DEFAULT NULL, placages_reussis INT DEFAULT NULL, placages_manques INT DEFAULT NULL, assist INT DEFAULT NULL, offload INT DEFAULT NULL, passe INT DEFAULT NULL, course INT DEFAULT NULL, metre_gagne INT DEFAULT NULL, perce INT DEFAULT NULL, defenseur_battu INT DEFAULT NULL, penalite_concedee INT DEFAULT NULL, cj INT DEFAULT NULL, cr INT DEFAULT NULL, INDEX IDX_F65755F5CF066148 (journee_id), INDEX IDX_F65755F5A9E2D76C (joueur_id), INDEX IDX_F65755F56D861B89 (equipe_id), INDEX IDX_F65755F5A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_joueur_journee ADD CONSTRAINT FK_F65755F5CF066148 FOREIGN KEY (journee_id) REFERENCES journee (id)');
        $this->addSql('ALTER TABLE asso_joueur_journee ADD CONSTRAINT FK_F65755F5A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE asso_joueur_journee ADD CONSTRAINT FK_F65755F56D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE asso_joueur_journee ADD CONSTRAINT FK_F65755F5A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE asso_joueur_journee');
    }
}
