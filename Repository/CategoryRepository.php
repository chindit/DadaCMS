<?php

namespace Dada\CMSBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
  public function getNbCat(){
		$query = $this->createQueryBuilder('a')
			->select('COUNT(a.id)');
		return $query->getQuery()->getSingleScalarResult();
	}
}
