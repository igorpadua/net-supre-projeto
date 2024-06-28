<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628180637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CDFAB823E3E11F0 ON pessoa (cpf)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CDFAB828F06FD70 ON pessoa (rg)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2132E3612132E361 ON telefone (telefone)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_2132E3612132E361');
        $this->addSql('DROP INDEX UNIQ_1CDFAB823E3E11F0');
        $this->addSql('DROP INDEX UNIQ_1CDFAB828F06FD70');
    }
}
