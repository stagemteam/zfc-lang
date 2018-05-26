<?php
/**
 * @category Popov
 * @package Popov_Translator
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 25.08.2016 12:44
 */
namespace Stagem\ZfcLang\Http;

class LocaleDetectorFactory
{
    public function __invoke($sm)
    {
        $config = $sm->get('config');
        $detector = new LocaleDetector($config['translator']['locales']);
        $detector->setDefaultLocale($config['translator']['locale']);

        return $detector;
    }
}