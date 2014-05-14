<?php

class BugRepository extends \Doctrine\ORM\EntityRepository
{

	public function getClosed()
	{
		return $this->findBy(['status' => 'CLOSE']);
	}
}
