<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190614174800 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE asso_joueur_equipe (id INT AUTO_INCREMENT NOT NULL, id_joueur_id INT NOT NULL, id_equipe_id INT NOT NULL, saison VARCHAR(10) NOT NULL, INDEX IDX_BAD36EE29D76B4B (id_joueur_id), INDEX IDX_BAD36EEEDB3A7AE (id_equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asso_joueur_equipe ADD CONSTRAINT FK_BAD36EE29D76B4B FOREIGN KEY (id_joueur_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE asso_joueur_equipe ADD CONSTRAINT FK_BAD36EEEDB3A7AE FOREIGN KEY (id_equipe_id) REFERENCES equipe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE asso_joueur_equipe');
    }
}
