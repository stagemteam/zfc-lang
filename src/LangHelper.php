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

    /** @var Lang */
    protected $currentLang;

    public function __construct(LangService $langService, CurrentHelper $currentHelper)
    {
        $this->langService = $langService;
        $this->currentHelper = $currentHelper;
    }

    /**
     * @return Lang
     */
    public function getCurrentLang()
    {
        return $this->currentLang;
    }

    /**
     * @param Lang $currentLang
     */
    public function setCurrentLang($currentLang)
    {
        $this->currentLang = $currentLang;
    }
    }