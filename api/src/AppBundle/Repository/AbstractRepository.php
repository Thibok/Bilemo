<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $queryBuilder, $limit = 10, $page = 1)
    {
        $pager = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));

        $pager->setMaxPerPage((int)$limit);
        $pager->setCurrentPage((int)$page);

        return $pager;
    }
}   