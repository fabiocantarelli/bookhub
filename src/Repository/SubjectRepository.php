<?php

declare(strict_types=1);

namespace App\Repository;

use App\Vo\SubjectVo;
use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subject>
 */
class SubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subject::class);
    }

    public function save(SubjectVo $subjectVo): void
    {
        $em = $this->getEntityManager();

        $subject = new Subject();
        $subject->setDescription($subjectVo->getDescription());

        $em->persist($subject);
        $em->flush();
    }

    public function update(SubjectVo $subjectVo): void
    {
        $em = $this->getEntityManager();

        $subject = $this->find($subjectVo->getId());
        $subject->setDescription($subjectVo->getDescription());

        $em->persist($subject);
        $em->flush();
    }

    public function delete(SubjectVo $subjectVo): void
    {
        $em = $this->getEntityManager();

        $subject = $this->find($subjectVo->getId());

        $em->remove($subject);
        $em->flush();
    }
}
