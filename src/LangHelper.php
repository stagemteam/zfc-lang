<?php

namespace Stagem\ZfcLang;

use Popov\ZfcCurrent\CurrentHelper;
use Stagem\ZfcLang\Model\Lang;
use Stagem\ZfcLang\Service\LangService;

class LangHelper
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

    public function current()
    {
        return $this->langService->getCurrent();
    }
}