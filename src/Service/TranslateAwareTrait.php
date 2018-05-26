<?php
/**
 * Enter description here...
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 11.11.2016 10:46
 */
namespace Stagem\ZfcLang\Service\Factory;

/**
 * @todo Це заготовка яку потрібно реалізувати
 * @todo Базується на\Mage_Adminhtml_Controller_Action::__
 */
class TranslateAwareTrait
{
    /**
     * Translate a phrase
     *
     * @return string
     */
    public function __()
    {
        $args = func_get_args();
        $expr = new Mage_Core_Model_Translate_Expr(array_shift($args), $this->getUsedModuleName());
        array_unshift($args, $expr);
        return Mage::app()->getTranslator()->translate($args);
    }
}