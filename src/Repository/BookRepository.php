<?php

namespace App\Repository;

use App\Vo\BookVo;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        readonly private AuthorRepository $authorRepository,
        readonly private SubjectRepository $subjectRepository,
    ) {
        parent::__construct($registry, Book::class);
    }

    public function save(BookVo $bookVo): void
    {
        $em = $this->getEntityManager();

        $book = (new Book())
            ->setTitle($bookVo->getTitle())
            ->setPublisher($bookVo->getPublisher())
            ->setEdition($bookVo->getEdition())
            ->setYearOfPublication($bookVo->getYearOfPublication())
            ->setPrice($bookVo->getPrice());

        $authors = $this->getAuthorsFromIds($bookVo->getAuthorsId());

        foreach ($authors as $autor) {
            $book->addAuthor($autor);
        }

        $subjects = $this->getSubjectsFromIds($bookVo->getSubjectsId());

        foreach ($subjects as $subject) {
            $book->addSubject($subject);
        }

        $em->persist($book);
        $em->flush();
    }
    public function update(BookVo $bookVo): void
    {
        $em   = $this->getEntityManager();
        $book = $this->find($bookVo->getId());

        $book
            ->setTitle($bookVo->getTitle())
            ->setPublisher($bookVo->getPublisher())
            ->setEdition($bookVo->getEdition())
            ->setYearOfPublication($bookVo->getYearOfPublication())
            ->setPrice($bookVo->getPrice());


        foreach ($book->getAuthors() as $author) {
            $book->removeAuthor($author);
        }

        $authors = $this->getAuthorsFromIds($bookVo->getAuthorsId());

        foreach ($authors as $autor) {
            $book->addAuthor($autor);
        }

        foreach ($book->getSubjects() as $subject) {
            $book->removeSubject($subject);
        }

        $subjects = $this->getSubjectsFromIds($bookVo->getSubjectsId());

        foreach ($subjects as $subject) {
            $book->addSubject($subject);
        }

        $em->flush();
    }

    public function delete(BookVo $bookVo): void
    {
        $em = $this->getEntityManager();

        $book = $this->find($bookVo->getId());

        $em->remove($book);
        $em->flush();
    }


    /**
     * @param int[] $authorIds
     *
     * @return Author[]
     */
    private function getAuthorsFromIds(array $authorIds): array
    {
        $authors = [];
        foreach ($authorIds as $authorId) {
            $authors[] = $this->authorRepository->find($authorId);
        }
        return $authors;
    }

    /**
     * @param int[] $subjectIds
     *
     * @return Subject[]
     */
    private function getSubjectsFromIds(array $subjectIds): array
    {
        $subjects = [];
        foreach ($subjectIds as $subjectId) {
            $subjects[] = $this->subjectRepository->find($subjectId);
        }
        return $subjects;
    }
}
