<?php

namespace Stagem\ZfcLang\Service;

use Popov\ZfcCore\Service\DomainServiceAbstract;
use Stagem\ZfcLang\Model\Repository\LangRepository;
use Stagem\ZfcLang\Model\Lang;

/**
 * Class LangService
 *
 * @method LangRepository getRepository()
 */
class LangService extends DomainServiceAbstract
{
    protected $entity = Lang::class;

    public function save(Lang $lang)
    {
        $om = $this->getObjectManager();
        if (!$om->contains($lang)) {
            $om->persist($lang);
        }
        $om->flush();
    }

}