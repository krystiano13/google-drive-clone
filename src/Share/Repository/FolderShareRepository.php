<?php

declare(strict_types=1);

namespace Share\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Share\Entity\FolderShare;

/**
 * @extends ServiceEntityRepository<FolderShare>
 */
class FolderShareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FolderShare::class);
    }
}
