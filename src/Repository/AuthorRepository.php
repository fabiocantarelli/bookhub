<?php

namespace App\Repository;

use App\Dto\AuthorDto;
use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function save(AuthorDto $authorDto): void
    {
        $em = $this->getEntityManager();

        $author = new Author();
        $author->setName($authorDto->getName());

        $em->persist($author);
        $em->flush();
    }

    public function update(AuthorDto $authorDto): void
    {
        $em = $this->getEntityManager();

        $author = $this->find($authorDto->getId());
        $author->setName($authorDto->getName());

        $em->persist($author);
        $em->flush();
    }

    public function delete(AuthorDto $authorDto): void
    {
        $em = $this->getEntityManager();

        $author = $this->find($authorDto->getId());

        $em->remove($author);
        $em->flush();
    }
}
