<?php

namespace ArturAlves\EuroMillionsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DrawRulesRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DrawRulesRepository extends EntityRepository
{
    /**
     * Returns the active DrawRules.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return DrawRules The DrawRules to apply to a new Draw
     */
    public function getActiveDrawRules()
    {
        $qb = $this->createQueryBuilder('dr')
            ->where('dr.active = 1')
            ->setMaxResults(1);

        $query = $qb->getQuery();

        return $query->getSingleResult();
    }

    /**
     * Returns the DrawRules that are/were active on a given date.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param DateTime $date The date
     *
     * @return DrawRules The DrawRules of the given date
     */
    public function getDrawRules(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('dr')
            ->where('dr.active = 0 AND dr.active_since <= :date AND dr.active_until >= :date')
            ->orWhere('dr.active = 1 AND dr.active_since <= :date')
            ->setParameter(':date', $date->format('Y-m-d'))
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}
