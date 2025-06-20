<?php

declare(strict_types=1);

namespace App\Services;

use App\Validator\BookRequestValidator;
use App\Vo\BookVo;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BookService extends AbstractService
{
    public function __construct(
        EntityManagerInterface $em,
        protected readonly BookRequestValidator $bookRequestValidator
    ) {
        parent::__construct($em);
    }

    /**
     * @return array{
     *   title: string,
     *   books: Book[],
     *   authors: Author[],
     *   subjects: Subject[],
     *   currentYear: string
     * }
     */
    public function list(): array
    {
        $books = $this->getBookRepository()->findAll();
        $authors = $this->getAuthorRepository()->findAll();
        $subjects = $this->getSubjectRepository()->findAll();

        $currentDate = (new \DateTime());
        $currentYearFormated = $currentDate->format('Y');

        return [
            'title' => 'Livros',
            'books' => $books,
            'authors' => $authors,
            'subjects' => $subjects,
            'currentYear' => $currentYearFormated

        ];
    }

    public function new(Request $request): void
    {
        $this->bookRequestValidator->validateNewRequest($request);
        $bookVo = BookVo::buildDataFromRequest($request);
        $this->getBookRepository()->save($bookVo);
    }

    public function edit(Request $request): void
    {
        $this->bookRequestValidator->validateEditRequest($request);
        $bookVo = BookVo::buildDataFromRequest($request);
        $this->getBookRepository()->update($bookVo);
    }

    public function delete(Request $request): void
    {
        $this->bookRequestValidator->validateDeleteRequest($request);
        $bookVo = BookVo::buildDataFromRequest($request);
        $this->getBookRepository()->delete($bookVo);
    }
}
