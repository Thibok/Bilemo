<?php

/**
 * Abstract Repository
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * AbstractRepository
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * Paginate using Pagerfanta
     * @access protected
     * @param QueryBuilder $queryBuilder
     * @param integer $limit
     * @param integer $page
     * 
     * @return Pagerfanta
     */
    protected function paginate(QueryBuilder $queryBuilder, $limit = 10, $page = 1)
    {
        $pager = new Pagerfanta(new DoctrineORMAdapter($queryBuilder));

        $pager->setMaxPerPage((int)$limit);
        $pager->setCurrentPage((int)$page);

        return $pager;
    }
}   