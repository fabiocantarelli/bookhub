<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250615035350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE Assunto (CodAs INT AUTO_INCREMENT NOT NULL, Descricao VARCHAR(20) NOT NULL, PRIMARY KEY(CodAs)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Autor (CodAu INT AUTO_INCREMENT NOT NULL, Nome VARCHAR(40) NOT NULL, PRIMARY KEY(CodAu)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro (CodL INT AUTO_INCREMENT NOT NULL, Titulo VARCHAR(40) NOT NULL, Editora VARCHAR(40) NOT NULL, Edicao INT NOT NULL, AnoPublicacao VARCHAR(4) NOT NULL, Valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(CodL)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro_Autor (Livro_CodL INT NOT NULL, Autor_CodAu INT NOT NULL, INDEX IDX_412939417134DCF1 (Livro_CodL), INDEX IDX_41293941B44F3F36 (Autor_CodAu), PRIMARY KEY(Livro_CodL, Autor_CodAu)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro_Assunto (Livro_CodL INT NOT NULL, Assunto_CodAs INT NOT NULL, INDEX IDX_2F01B7437134DCF1 (Livro_CodL), INDEX IDX_2F01B74364209C06 (Assunto_CodAs), PRIMARY KEY(Livro_CodL, Assunto_CodAs)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor ADD CONSTRAINT FK_412939417134DCF1 FOREIGN KEY (Livro_CodL) REFERENCES Livro (CodL)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor ADD CONSTRAINT FK_41293941B44F3F36 FOREIGN KEY (Autor_CodAu) REFERENCES Autor (CodAu)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto ADD CONSTRAINT FK_2F01B7437134DCF1 FOREIGN KEY (Livro_CodL) REFERENCES Livro (CodL)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto ADD CONSTRAINT FK_2F01B74364209C06 FOREIGN KEY (Assunto_CodAs) REFERENCES Assunto (CodAs)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor DROP FOREIGN KEY FK_412939417134DCF1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor DROP FOREIGN KEY FK_41293941B44F3F36
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto DROP FOREIGN KEY FK_2F01B7437134DCF1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto DROP FOREIGN KEY FK_2F01B74364209C06
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Assunto
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Autor
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Livro
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Livro_Autor
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE Livro_Assunto
        SQL);
    }
}
