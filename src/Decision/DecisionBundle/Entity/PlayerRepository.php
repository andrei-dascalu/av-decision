<?php

namespace Decision\DecisionBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends EntityRepository
{

    public function fetchFreePlayers()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM DecisionBundle:Player p WHERE p.playerTeamId > 0')
            ->getResult();
    }
}
