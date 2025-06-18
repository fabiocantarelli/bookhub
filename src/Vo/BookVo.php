<?php

declare(strict_types=1);

namespace App\Vo;

use Symfony\Component\HttpFoundation\Request;

final class BookVo implements RequestVoInterface
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $publisher = null;
    private ?int $edition = null;
    private ?string $yearOfPublication = null;
    private ?float $price = null;

    /** @var int[] */
    private array $authors = [];

    /** @var int[] */
    private array $subjects = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function getEdition(): ?int
    {
        return $this->edition;
    }

    public function setEdition(?int $edition): self
    {
        $this->edition = $edition;
        return $this;
    }

    public function getYearOfPublication(): ?string
    {
        return $this->yearOfPublication;
    }

    public function setYearOfPublication(?string $year): self
    {
        $this->yearOfPublication = $year;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAuthorsId(): array
    {
        return $this->authors;
    }

    /**
     * @param int[] $authors
     */
    public function setAuthorsId(array $authors): self
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getSubjectsId(): array
    {
        return $this->subjects;
    }

    /**
     * @param int[] $subjects
     */
    public function setSubjectsId(array $subjects): self
    {
        $this->subjects = $subjects;
        return $this;
    }

    public static function buildDataFromRequest(Request $request): static
    {
        return (new static())
            ->setId((int) $request->get('id'))
            ->setTitle($request->get('title'))
            ->setPublisher($request->get('publisher'))
            ->setEdition((int) $request->get('edition'))
            ->setYearOfPublication($request->get('yearOfPublication'))
            ->setPrice((float) $request->get('price'))
            ->setAuthorsId($request->get('authors') ?? [])
            ->setSubjectsId($request->get('subjects') ?? []);
    }
}
