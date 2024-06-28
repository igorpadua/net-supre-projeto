<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628182240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pessoa_telefone DROP CONSTRAINT fk_99e9c45edf6fa0a5');
        $this->addSql('ALTER TABLE pessoa_telefone DROP CONSTRAINT fk_99e9c45e92d095a9');
        $this->addSql('DROP TABLE pessoa_telefone');
        $this->addSql('ALTER TABLE telefone ADD pessoa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE telefone ADD CONSTRAINT FK_2132E361DF6FA0A5 FOREIGN KEY (pessoa_id) REFERENCES pessoa (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2132E361DF6FA0A5 ON telefone (pessoa_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE pessoa_telefone (pessoa_id INT NOT NULL, telefone_id INT NOT NULL, PRIMARY KEY(pessoa_id, telefone_id))');
        $this->addSql('CREATE INDEX idx_99e9c45e92d095a9 ON pessoa_telefone (telefone_id)');
        $this->addSql('CREATE INDEX idx_99e9c45edf6fa0a5 ON pessoa_telefone (pessoa_id)');
        $this->addSql('ALTER TABLE pessoa_telefone ADD CONSTRAINT fk_99e9c45edf6fa0a5 FOREIGN KEY (pessoa_id) REFERENCES pessoa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pessoa_telefone ADD CONSTRAINT fk_99e9c45e92d095a9 FOREIGN KEY (telefone_id) REFERENCES telefone (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE telefone DROP CONSTRAINT FK_2132E361DF6FA0A5');
        $this->addSql('DROP INDEX IDX_2132E361DF6FA0A5');
        $this->addSql('ALTER TABLE telefone DROP pessoa_id');
    }
}
