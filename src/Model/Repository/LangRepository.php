<?php

namespace Stagem\ZfcLang\Model\Repository;

class LangRepository extends \Doctrine\ORM\EntityRepository
{
    protected $_alias = 'lang';

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getLangs()
    {
        $qb = $this->createQueryBuilder($this->_alias);
        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveLangs()
    {
        $qb = $this->getLangs();

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq($this->_alias . '.isActive', '?1')
            )
        );

        $qb->setParameters([1 => 1]);
        return $qb;

    }

}