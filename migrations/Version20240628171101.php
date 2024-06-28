<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628171101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pessoa_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE telefone_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pessoa (id INT NOT NULL, nome VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, rg VARCHAR(7) NOT NULL, cep VARCHAR(8) NOT NULL, logradouro VARCHAR(255) NOT NULL, complemento VARCHAR(255) NOT NULL, setor VARCHAR(255) NOT NULL, cidade VARCHAR(255) NOT NULL, uf VARCHAR(2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pessoa_telefone (pessoa_id INT NOT NULL, telefone_id INT NOT NULL, PRIMARY KEY(pessoa_id, telefone_id))');
        $this->addSql('CREATE INDEX IDX_99E9C45EDF6FA0A5 ON pessoa_telefone (pessoa_id)');
        $this->addSql('CREATE INDEX IDX_99E9C45E92D095A9 ON pessoa_telefone (telefone_id)');
        $this->addSql('CREATE TABLE telefone (id INT NOT NULL, telefone VARCHAR(11) NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE pessoa_telefone ADD CONSTRAINT FK_99E9C45EDF6FA0A5 FOREIGN KEY (pessoa_id) REFERENCES pessoa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pessoa_telefone ADD CONSTRAINT FK_99E9C45E92D095A9 FOREIGN KEY (telefone_id) REFERENCES telefone (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pessoa_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE telefone_id_seq CASCADE');
        $this->addSql('ALTER TABLE pessoa_telefone DROP CONSTRAINT FK_99E9C45EDF6FA0A5');
        $this->addSql('ALTER TABLE pessoa_telefone DROP CONSTRAINT FK_99E9C45E92D095A9');
        $this->addSql('DROP TABLE pessoa');
        $this->addSql('DROP TABLE pessoa_telefone');
        $this->addSql('DROP TABLE telefone');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
