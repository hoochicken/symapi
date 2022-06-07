<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DevtoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {

    }
}
