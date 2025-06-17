<?php

namespace App\Repository;

use App\Vo\AuthorVo;
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

    public function save(AuthorVo $authorVo): void
    {
        $em = $this->getEntityManager();

        $author = new Author();
        $author->setName($authorVo->getName());

        $em->persist($author);
        $em->flush();
    }

    public function update(AuthorVo $authorVo): void
    {
        $em = $this->getEntityManager();

        $author = $this->find($authorVo->getId());
        $author->setName($authorVo->getName());

        $em->persist($author);
        $em->flush();
    }

    public function delete(AuthorVo $authorVo): void
    {
        $em = $this->getEntityManager();

        $author = $this->find($authorVo->getId());

        $em->remove($author);
        $em->flush();
    }
}
