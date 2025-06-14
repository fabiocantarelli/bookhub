<?php

namespace App\Repository;

use App\Dto\BookDto;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(BookDto $bookDto): void
    {
        $em = $this->getEntityManager();

        $book = (new Book())
            ->setTitle($bookDto->getTitle())
            ->setPublisher($bookDto->getPublisher())
            ->setEdition($bookDto->getEdition())
            ->setYearOfPublication($bookDto->getYearOfPublication())
            ->setPrice($bookDto->getPrice());

        foreach ($bookDto->getAuthors() as $autor) {
            $book->addAuthor($autor);
        }

        foreach ($bookDto->getSubjects() as $subject) {
            $book->addSubject($subject);
        }

        $em->persist($book);
        $em->flush();
    }
    public function update(BookDto $bookDto): void
    {
        $em   = $this->getEntityManager();
        $book = $this->find($bookDto->getId());

        $book
            ->setTitle($bookDto->getTitle())
            ->setPublisher($bookDto->getPublisher())
            ->setEdition($bookDto->getEdition())
            ->setYearOfPublication($bookDto->getYearOfPublication())
            ->setPrice($bookDto->getPrice());


        foreach ($book->getAuthors() as $author) {
            $book->removeAuthor($author);
        }

        foreach ($bookDto->getAuthors() as $dtoAuthor) {
            $book->addAuthor($dtoAuthor);
        }

        foreach ($book->getSubjects() as $subject) {
            $book->removeSubject($subject);
        }

        foreach ($bookDto->getSubjects() as $dtoSubject) {
            $book->addSubject($dtoSubject);
        }

        $em->flush();
    }

    public function delete(BookDto $bookDto): void
    {
        $em = $this->getEntityManager();

        $book = $this->find($bookDto->getId());

        $em->remove($book);
        $em->flush();
    }
}
