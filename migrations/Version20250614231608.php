<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614231608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE Assunto (id INT AUTO_INCREMENT NOT NULL, Descricao VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Autor (id INT AUTO_INCREMENT NOT NULL, Nome VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro (id INT AUTO_INCREMENT NOT NULL, Titulo VARCHAR(40) NOT NULL, Editora VARCHAR(40) NOT NULL, Edicao INT NOT NULL, AnoPublicacao VARCHAR(4) NOT NULL, Valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro_Autor (Livro_id INT NOT NULL, Autor_id INT NOT NULL, INDEX IDX_41293941A112A7F9 (Livro_id), INDEX IDX_41293941EDA239E8 (Autor_id), PRIMARY KEY(Livro_id, Autor_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE Livro_Assunto (Livro_id INT NOT NULL, Assunto_id INT NOT NULL, INDEX IDX_2F01B743A112A7F9 (Livro_id), INDEX IDX_2F01B7433BA4155 (Assunto_id), PRIMARY KEY(Livro_id, Assunto_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor ADD CONSTRAINT FK_41293941A112A7F9 FOREIGN KEY (Livro_id) REFERENCES Livro (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor ADD CONSTRAINT FK_41293941EDA239E8 FOREIGN KEY (Autor_id) REFERENCES Autor (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto ADD CONSTRAINT FK_2F01B743A112A7F9 FOREIGN KEY (Livro_id) REFERENCES Livro (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto ADD CONSTRAINT FK_2F01B7433BA4155 FOREIGN KEY (Assunto_id) REFERENCES Assunto (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor DROP FOREIGN KEY FK_41293941A112A7F9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Autor DROP FOREIGN KEY FK_41293941EDA239E8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto DROP FOREIGN KEY FK_2F01B743A112A7F9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE Livro_Assunto DROP FOREIGN KEY FK_2F01B7433BA4155
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
