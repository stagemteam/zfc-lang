<?php

namespace Stagem\ZfcLang\View\Helper;

use Popov\ZfcCurrent\CurrentHelper;
use Stagem\ZfcLang\Service\LangService;
use Zend\Form\Element\Collection;
use Zend\View\Helper\AbstractHelper;

class LangHelper extends AbstractHelper
{
    /** @var LangService */
    protected $langService;

    /** @var CurrentHelper */
    protected $currentHelper;

    /** @var array */
    protected $languages;

    public function __construct(LangService $langService, CurrentHelper $currentHelper)
    {
        $this->langService = $langService;
        $this->currentHelper = $currentHelper;
    }

    /**
     * @return mixed
     */
    public function getLangs()
    {
        if (!$this->languages) {
            $this->languages = $this->langService->getRepository()->getActiveLangs()->getQuery()->getResult();
        }
        return $this->languages;
    }

    /**
     * Normalization of languages fieldset collection
     *
     * Add empty fieldsets if numbers of languages is different to numbers of fieldsets
     *
     * @param Collection $fieldsetCollection
     * @return Collection
     */
    public function normalizeCollection(Collection $fieldsetCollection)
    {
        $fieldsets = $fieldsetCollection->getFieldsets();
        foreach ($this->getLangs() as $key => $lang) {
            $fieldset = clone $fieldsetCollection->getTargetElement();
            isset($fieldsets[$key]) ?: $fieldsetCollection->add($fieldset, ['name' => $key]);
        }

        return $fieldsetCollection;
    }


}