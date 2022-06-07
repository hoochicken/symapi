<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429184847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE demo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE word_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE demo (id INT NOT NULL, name VARCHAR(255) NOT NULL, created VARCHAR(255) NOT NULL, created_user INT NOT NULL, deleted VARCHAR(255) NOT NULL, deleted_user INT NOT NULL, state INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE word (id INT NOT NULL, title VARCHAR(255) NOT NULL, a SMALLINT NOT NULL, b SMALLINT NOT NULL, c SMALLINT NOT NULL, d SMALLINT NOT NULL, e SMALLINT NOT NULL, f SMALLINT NOT NULL, g SMALLINT NOT NULL, h SMALLINT NOT NULL, i SMALLINT NOT NULL, j SMALLINT NOT NULL, k SMALLINT NOT NULL, l SMALLINT NOT NULL, m SMALLINT NOT NULL, n SMALLINT NOT NULL, o SMALLINT NOT NULL, p SMALLINT NOT NULL, q SMALLINT NOT NULL, r SMALLINT NOT NULL, s SMALLINT NOT NULL, t SMALLINT NOT NULL, u SMALLINT NOT NULL, v SMALLINT NOT NULL, w SMALLINT NOT NULL, x SMALLINT NOT NULL, y SMALLINT NOT NULL, z SMALLINT NOT NULL, ae SMALLINT NOT NULL, oe SMALLINT NOT NULL, ue SMALLINT NOT NULL, sch SMALLINT NOT NULL, divided VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE demo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE word_id_seq CASCADE');
        $this->addSql('DROP TABLE demo');
        $this->addSql('DROP TABLE word');
    }
}
