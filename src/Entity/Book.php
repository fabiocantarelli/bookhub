<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'Livro')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(name: 'Titulo', type: Types::STRING, length: 40, nullable: false)]
    private ?string $title = null;

    #[ORM\Column(name: 'Editora', type: Types::STRING, length: 40, nullable: false)]
    private ?string $publisher = null;

    #[ORM\Column(name: 'Edicao', type: Types::INTEGER, nullable: false)]
    private ?int $edition = null;

    #[ORM\Column(name: 'AnoPublicacao', type: Types::STRING, length: 4, nullable: false)]
    private ?string $yearOfPublication = null;

    #[ORM\Column(name: 'Valor', type: Types::FLOAT, precision: 10, scale: 2, nullable: false)]
    private ?float $price = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinTable(name: 'Livro_Autor')]
    #[ORM\JoinColumn(name: 'Livro_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'Autor_id', referencedColumnName: 'id')]
    private Collection $authors;

    /**
     * @var Collection<int, Subject>
     */
    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'books')]
    #[ORM\JoinTable(name: 'Livro_Assunto')]
    #[ORM\JoinColumn(name: 'Livro_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'Assunto_id', referencedColumnName: 'id')]
    private Collection $subjects;

    public function __construct()
    {
        $this->authors  = new ArrayCollection();
        $this->subjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setYearOfPublication(string $yearOfPublication): self
    {
        $this->yearOfPublication = $yearOfPublication;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (! $this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (! $this->subjects->contains($subject)) {
            $this->subjects->add($subject);
            $subject->addBook($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->removeElement($subject)) {
            $subject->removeBook($this);
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
