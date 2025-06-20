<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\SubjectRepository;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{
    public function __construct(
        protected readonly EntityManagerInterface $em
    ) {
    }

    protected function getAuthorRepository(): AuthorRepository
    {
        /** @var AuthorRepository */
        return $this->em->getRepository(Author::class);
    }

    protected function getBookRepository(): BookRepository
    {
        /** @var BookRepository */
        return $this->em->getRepository(Book::class);
    }

    protected function getSubjectRepository(): SubjectRepository
    {
        /** @var SubjectRepository */
        return $this->em->getRepository(Subject::class);
    }
}
