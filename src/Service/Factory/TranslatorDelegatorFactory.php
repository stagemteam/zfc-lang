<?php
/**
 * @category Popov
 * @package Popov_Translator
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 16.10.2016 16:44
 */
namespace Stagem\ZfcLang\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\Stdlib\Exception;
use Popov\ZfcEntity\Helper\ModuleHelper;
use Popov\ZfcCurrent\CurrentHelper;

class TranslatorDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        return $this->createDelegatorWithName($container, $name, $name, $callback);
    }

    public function createDelegatorWithName(ServiceLocatorInterface $sm, $name, $requestedName, $callback)
    {
        $service = $callback();
        if ($service instanceof TranslatorAwareInterface) {
            if ($sm->has(ModuleHelper::class)) {
                /** @var ModuleHelper $modulePlugin */
                $modulePlugin = $sm->get(ModuleHelper::class);
                $textDomain = $modulePlugin->setRealContext($service)->getModule()->getName();
            } elseif ($sm->has(CurrentHelper::class)) {
                /** @var CurrentHelper $currentPlugin */
                $currentPlugin = $sm->get(CurrentHelper::class);
                $textDomain = $currentPlugin->currentModule();
            } else {
                throw new Exception\LogicException(
                    'Cannot get module text domain. "agerecompany/zfc-module or "popovsergiy/zfc-current" is required. '
                    . 'Add one of this dependency to composer.json'
                );
            }

            /** @var Translator $translator */
            $translator = $sm->get(TranslatorInterface::class);
            $service->setTranslator($translator);
            $service->setTranslatorTextDomain($textDomain);
        }

        return $service;
    }
}