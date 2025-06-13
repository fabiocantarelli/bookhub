<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Author;
use App\Entity\Subject;

class BookDto
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $publisher = null;
    private ?int $edition = null;
    private ?string $yearOfPublication = null;

    /** @var Author[] */
    private array $authors = [];

    /** @var Subject[] */
    private array $subjects = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function getEdition(): ?int
    {
        return $this->edition;
    }

    public function setEdition(int $edition): self
    {
        $this->edition = $edition;
        return $this;
    }

    public function getYearOfPublication(): ?string
    {
        return $this->yearOfPublication;
    }

    public function setYearOfPublication(string $year): self
    {
        $this->yearOfPublication = $year;
        return $this;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param Author[] $authors
     */
    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @return Subject[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @param Subject[] $subjects
     */
    public function setSubjects(array $subjects): self
    {
        $this->subjects = $subjects;
        return $this;
    }
}