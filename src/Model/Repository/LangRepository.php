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

}