<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250615035458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria a view vw_book_by_author com LEFT JOIN para listar autores mesmo sem livros';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE OR REPLACE VIEW vw_book_by_author AS
            SELECT
                ROW_NUMBER() OVER (ORDER BY a.CodAu, l.CodL) AS CodVw,
                a.CodAu AS Autor_CodAu,
                a.Nome AS Autor_Nome,
                l.CodL AS Livro_CodL,
                l.Titulo AS Livro_Titulo,
                l.Editora AS Livro_Editora,
                l.Edicao AS Livro_Edicao,
                l.AnoPublicacao AS Livro_Ano,
                l.Valor AS Livro_Valor,
                GROUP_CONCAT(DISTINCT s.Descricao ORDER BY s.Descricao SEPARATOR ', ') AS Assunto_Descricao
            FROM Autor a
            LEFT JOIN Livro_Autor la ON la.Autor_CodAu = a.CodAu
            LEFT JOIN Livro l ON l.CodL = la.Livro_CodL
            LEFT JOIN Livro_Assunto ls ON ls.Livro_CodL = l.CodL
            LEFT JOIN Assunto s ON s.CodAs = ls.Assunto_CodAs
            GROUP BY a.CodAu, a.Nome, l.CodL, l.Titulo, l.Editora, l.Edicao, l.AnoPublicacao, l.Valor 
            ORDER BY a.Nome ASC
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW IF EXISTS vw_book_by_author');
    }
}
