<?php

namespace App\Entity;

use App\Repository\BookByAuthorViewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(readOnly: true, repositoryClass: BookByAuthorViewRepository::class)]
#[ORM\Table(name: 'vw_book_by_author')]
class BookByAuthorView
{
    #[ORM\Id]
    #[ORM\Column(name: 'CodVw')]
    /** @phpstan-ignore-next-line */
    private ?int $id;

    #[ORM\Column(name: 'Livro_CodL')]
    /** @phpstan-ignore-next-line */
    private ?int $bookId;

    #[ORM\Column(name: 'Autor_CodAu')]
    /** @phpstan-ignore-next-line */
    private int $authorId;

    #[ORM\Column(name: 'Autor_Nome')]
    /** @phpstan-ignore-next-line */
    private string $authorName;

    #[ORM\Column(name: 'Livro_Titulo')]
    /** @phpstan-ignore-next-line */
    private string $bookTitle;

    #[ORM\Column(name: 'Livro_Editora')]
    /** @phpstan-ignore-next-line */
    private string $bookPublisher;

    #[ORM\Column(name: 'Livro_Edicao')]
    /** @phpstan-ignore-next-line */
    private int $bookEdition;

    #[ORM\Column(name: 'Livro_Ano')]
    /** @phpstan-ignore-next-line */
    private string $bookYearOfPublication;

    #[ORM\Column(name: 'Livro_Valor')]
    /** @phpstan-ignore-next-line */
    private float $bookPrice;

    #[ORM\Column(name: 'Assunto_Descricao')]
    /** @phpstan-ignore-next-line */
    private ?string $subjectDescription;

    public function getId(): int
    {
        return $this->id;
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getBookTitle(): string
    {
        return $this->bookTitle;
    }

    public function getBookPublisher(): string
    {
        return $this->bookPublisher;
    }

    public function getBookEdition(): int
    {
        return $this->bookEdition;
    }

    public function getBookYearOfPublication(): string
    {
        return $this->bookYearOfPublication;
    }

    public function getBookPrice(): float
    {
        return $this->bookPrice;
    }

    public function getSubjectDescription(): ?string
    {
        return $this->subjectDescription;
    }
}
