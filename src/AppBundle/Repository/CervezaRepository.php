<?php

namespace AppBundle\Repository;

/**
 * CervezaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CervezaRepository extends \Doctrine\ORM\EntityRepository
{
	
	public function getDestacadas()
	{
		
		$queryBuilder = $this->createQueryBuilder('c')			
			->where('c.destacada = true');			

		return $queryBuilder->getQuery()->getResult();

	}

	public function getPorOrigen($origen)
	{
		
		$queryBuilder = $this->createQueryBuilder('c')
			->where('c.origen = :origen')
			->setParameters(['origen' => $origen]);

		return $queryBuilder->getQuery()->getResult();

	}

}
