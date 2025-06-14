<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\SubjectDto;
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

    public function save(SubjectDto $subjectDto): void
    {
        $em = $this->getEntityManager();

        $subject = new Subject();
        $subject->setDescription($subjectDto->getDescription());

        $em->persist($subject);
        $em->flush();
    }

    public function update(SubjectDto $subjectDto): void
    {
        $em = $this->getEntityManager();

        $subject = $this->find($subjectDto->getId());
        $subject->setDescription($subjectDto->getDescription());

        $em->persist($subject);
        $em->flush();
    }

    public function delete(SubjectDto $subjectDto): void
    {
        $em = $this->getEntityManager();

        $subject = $this->find($subjectDto->getId());

        $em->remove($subject);
        $em->flush();
    }
}
