<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BookByAuthorView;
use App\Entity\ReportView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookByAuthorView>
 */
class BookByAuthorViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookByAuthorView::class);
    }
}
