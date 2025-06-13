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

    public function __construct(
        readonly private BookRepository $bookRepository,
        readonly private AuthorRepository $authorRepository,
        readonly private SubjectRepository $subjectRepository
    ) {}

    public function validateNewRequest(Request $request): BookDto
    {
        $this->basicRequestValidate($request);

        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $authors = $request->get('authors');
        $subjects = $request->get('subjects');

        $findBook = $this->bookRepository->findOneBy([
            'title' => $title
        ]);

        if (!empty($findBook)) {
            throw new \Exception('Título já existe!');
        }

        $authorsEntity = [];
        $subjectsEntity = [];

        foreach ($authors as $author) {
            $authorsEntity[] = $this->authorRepository->find($author);
        }

        foreach ($subjects as $subject) {
            $subjectsEntity[] = $this->subjectRepository->find($subject);
        }

        return (new BookDto)
            ->setTitle($title)
            ->setPublisher($publisher)
            ->setEdition($edition)
            ->setYearOfPublication($yearOfPublication)
            ->setAuthors($authorsEntity)
            ->setSubjects($subjectsEntity);
    }

    public function validateEditRequest(Request $request): BookDto
    {
        $this->basicRequestValidate($request);

        $id = (int) $request->get('id');
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $authors = $request->get('authors');
        $subjects = $request->get('subjects');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $authorsEntity = [];
        $subjectsEntity = [];

        foreach ($authors as $author) {
            $authorsEntity[] = $this->authorRepository->find($author);
        }

        foreach ($subjects as $subject) {
            $subjectsEntity[] = $this->subjectRepository->find($subject);
        }

        $book = $this->bookRepository->find($id);

        if (empty($book)) {
            throw new \Exception('Livro não encontrado!');
        }

        return (new BookDto)
            ->setId($id)
            ->setTitle($title)
            ->setPublisher($publisher)
            ->setEdition($edition)
            ->setYearOfPublication($yearOfPublication)
            ->setAuthors($authorsEntity)
            ->setSubjects($subjectsEntity);
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

    private function basicRequestValidate(Request $request)
    {
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = (string) $request->get('yearOfPublication');
        $authors = $request->get('authors');
        $subjects = $request->get('subjects');

        match (true) {
            empty($title) => throw new \Exception('Você não pode inserir um título vazio!'),
            empty($publisher) => throw new \Exception('Você não pode inserir uma editora vazia!'),
            empty($edition) => throw new \Exception('Você não pode inserir uma edição vazia!'),
            empty($yearOfPublication) => throw new \Exception('Você não pode inserir um ano de publicação vazio!'),
            empty($authors) => throw new \Exception('Você não pode inserir um autor vazio!'),
            empty($subjects) => throw new \Exception('Você não pode inserir um assunto vazio!'),
            default => ''
        };

        if (mb_strlen($title, 'UTF-8') > self::TITLE_MAX_LENGTH) {
            throw new \Exception(
                'Você não pode inserir um titulo maior que '
                    . self::TITLE_MAX_LENGTH
                    . ' caracteres'
            );
        }

        if (mb_strlen($publisher, 'UTF-8') > self::PUBLISHER_MAX_LENGTH) {
            throw new \Exception(
                'Você não pode inserir um editora maior que '
                    . self::PUBLISHER_MAX_LENGTH
                    . ' caracteres'
            );
        }

        if (mb_strlen($yearOfPublication, 'UTF-8') > self::YEAR_OF_PUBLICATION_MAX_LENGTH) {
            throw new \Exception(
                'Você não pode inserir um ano de publicação maior que '
                    . self::YEAR_OF_PUBLICATION_MAX_LENGTH
                    . ' caracteres'
            );
        }

        if ($edition > self::MAX_EDITION) {
            throw new \Exception('Você não pode inserir uma edição maior que ' . self::MAX_EDITION);
        }
    }
}
