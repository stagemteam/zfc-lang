<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem Team
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_ZfcTranslator
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcLang;

use Zend\I18n\Translator\TranslatorAwareTrait as ZendTranslatorAwareTrait;

trait TranslatorAwareTrait
{
    use ZendTranslatorAwareTrait;

    public function translate($message)
    {
        return $this->getTranslator()->translate($message, $this->getTranslatorTextDomain());
    }

    public function translatePlural($singular, $plural, $number)
    {
        return $this->getTranslator()->translatePlural($singular, $plural, $number, $this->getTranslatorTextDomain());
    }
}