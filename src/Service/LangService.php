<?php

namespace Stagem\ZfcLang\Service;

use Popov\ZfcCore\Service\DomainServiceAbstract;
use Stagem\ZfcLang\Model\Repository\LangRepository;
use Stagem\ZfcLang\Model\Lang;

/**
 * Class LangService
 * @method LangRepository getRepository()
 */
class LangService extends DomainServiceAbstract
{
    protected $entity = Lang::class;

    /**
     * @var Lang
     */
    protected $current;

    public function save(Lang $lang)
    {
        $om = $this->getObjectManager();
        if (!$om->contains($lang)) {
            $om->persist($lang);
        }
        $om->flush();
    }

    /**
     * @return Lang
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param Lang $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }
}