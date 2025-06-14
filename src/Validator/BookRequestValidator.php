<?php

declare(strict_types=1);

namespace App\Validator;

use App\Dto\BookDto;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\SubjectRepository;
use Symfony\Component\HttpFoundation\Request;

final class BookRequestValidator
{
    public const MAX_EDITION = 99999;
    private const TITLE_MAX_LENGTH = 40;
    private const PUBLISHER_MAX_LENGTH = 40;
    private const YEAR_OF_PUBLICATION_MAX_LENGTH = 4;
    private const MAX_PRICE = 99999.99;

    public function __construct(
        readonly private BookRepository $bookRepository,
        readonly private AuthorRepository $authorRepository,
        readonly private SubjectRepository $subjectRepository
    ) {}

    public function validateNewRequest(Request $request): BookDto
    {
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $price = (float) $request->get('price');
        $authorIds = $request->get('authors');
        $subjectIds = $request->get('subjects');

        $this->validateBookData(
            $title, 
            $publisher, 
            $edition, 
            $yearOfPublication, 
            $price, 
            $authorIds, 
            $subjectIds
        );

        $authors = $this->getAuthorsFromIds($authorIds);
        $subjects = $this->getSubjectsFromIds($subjectIds);

        return (new BookDto)
            ->setTitle($title)
            ->setPublisher($publisher)
            ->setEdition($edition)
            ->setYearOfPublication($yearOfPublication)
            ->setPrice($price)
            ->setAuthors($authors)
            ->setSubjects($subjects);
    }

    public function validateEditRequest(Request $request): BookDto
    {
        $id = (int) $request->get('id');
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $price = (float) $request->get('price');
        $authorIds = $request->get('authors');
        $subjectIds = $request->get('subjects');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $this->validateBookData($title, $publisher, $edition, $yearOfPublication, $price, $authorIds, $subjectIds, $id);

        $authors = $this->getAuthorsFromIds($authorIds);
        $subjects = $this->getSubjectsFromIds($subjectIds);

        return (new BookDto)
            ->setId($id)
            ->setTitle($title)
            ->setPublisher($publisher)
            ->setEdition($edition)
            ->setYearOfPublication($yearOfPublication)
            ->setPrice($price)
            ->setAuthors($authors)
            ->setSubjects($subjects);
    }

    public function validateDeleteRequest(Request $request): BookDto
    {
        $id = (int) $request->get('id');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        return (new BookDto)
            ->setId($id);
    }

    private function validateBookData(
        string $title,
        string $publisher,
        int $edition,
        string $yearOfPublication,
        float $price,
        array $authorIds,
        array $subjectIds,
        ?int $id = null
    ): void {
        match (true) {
            empty($title) => throw new \Exception('Você não pode inserir um título vazio!'),
            empty($publisher) => throw new \Exception('Você não pode inserir uma editora vazia!'),
            empty($edition) => throw new \Exception('Você não pode inserir uma edição vazia!'),
            empty($yearOfPublication) => throw new \Exception('Você não pode inserir um ano de publicação vazio!'),
            empty($authorIds) => throw new \Exception('Você não pode inserir um autor vazio!'),
            empty($subjectIds) => throw new \Exception('Você não pode inserir um assunto vazio!'),
            empty($price) => throw new \Exception('Você não pode inserir um preço vazio!'),
            default => ''
        };

        if (mb_strlen($title, 'UTF-8') > self::TITLE_MAX_LENGTH) {
            throw new \Exception('O título não pode ter mais de ' . self::TITLE_MAX_LENGTH . ' caracteres.');
        }

        if (mb_strlen($publisher, 'UTF-8') > self::PUBLISHER_MAX_LENGTH) {
            throw new \Exception('A editora não pode ter mais de ' . self::PUBLISHER_MAX_LENGTH . ' caracteres.');
        }

        if (mb_strlen($yearOfPublication, 'UTF-8') > self::YEAR_OF_PUBLICATION_MAX_LENGTH) {
            throw new \Exception('O ano de publicação não pode ter mais de ' . self::YEAR_OF_PUBLICATION_MAX_LENGTH . ' caracteres.');
        }

        if ($edition > self::MAX_EDITION) {
            throw new \Exception('A edição não pode ser maior que ' . self::MAX_EDITION);
        }

        if ($price > self::MAX_PRICE) {
            throw new \Exception('O preço não pode ser maior que ' . self::MAX_PRICE);
        }

        $findBook = $this->bookRepository->findOneBy(['title' => $title]);

        if ($findBook && $findBook->getId() !== $id) {
            throw new \Exception('Título já existe!');
        }
    }

    private function getAuthorsFromIds(array $authorIds): array
    {
        $authors = [];
        foreach ($authorIds as $authorId) {
            $authors[] = $this->authorRepository->find($authorId);
        }
        return $authors;
    }

    private function getSubjectsFromIds(array $subjectIds): array
    {
        $subjects = [];
        foreach ($subjectIds as $subjectId) {
            $subjects[] = $this->subjectRepository->find($subjectId);
        }
        return $subjects;
    }
}
