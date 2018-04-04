<?php

namespace Stagem\ZfcLang\View\Helper;

use Popov\ZfcCurrent\CurrentHelper;
use Stagem\ZfcLang\Service\LangService;
use Zend\View\Helper\AbstractHelper;

class LangHelper extends AbstractHelper
{
    /** @var LangService */
    protected $langService;

    /** @var CurrentHelper */
    protected $currentHelper;

    public function __construct(LangService $langService, CurrentHelper $currentHelper)
    {
        $this->langService = $langService;
        $this->currentHelper = $currentHelper;
    }

    /**
     * @return mixed
     */
    public function getAllLangs() {
        $langs = $this->langService->getRepository()->getActiveLangs()->getQuery()->getResult();

        return $langs;
    }
}