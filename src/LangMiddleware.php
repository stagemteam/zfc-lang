<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Vlad Kozak
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Kozak
 * @package Kozak <package>
 * @author Vlad Kozak <vlad.gem.typ@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcLang;

use Locale;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stagem\ZfcLang\Model\Lang;
use Stagem\ZfcLang\Service\LangService;
use Stagem\ZfcLang\Http\LocaleDetector;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\I18n\Translator\Translator;

class LangMiddleware implements MiddlewareInterface
{
    const LANG_ATTRIBUTE = 'lang';

    const LOCALIZATION_ATTRIBUTE = 'locale';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var LangHelper
     */
    protected $langHelper;

    /**
     * @var LocaleDetector
     */
    protected $localeDetector;

    /**
     * @var LangService
     */
    protected $langService;

    /**
     * @var array
     */
    protected $config;

    public function __construct(TranslatorInterface $translator, LocaleDetector $localeDetector, LangHelper $langHelper, LangService $langService, array $config = null)
    {
        $this->translator = $translator;
        $this->localeDetector = $localeDetector;
        $this->langService = $langService;
        $this->langHelper = $langHelper;
        $this->config = $config;
        //$i18nTranslator = Translator::factory($config['translator']);
        //if ($container->has('Zend\I18n\Translator\TranslatorInterface')) {
        //    return new MvcTranslator($container->get('Zend\I18n\Translator\TranslatorInterface'));
        //}
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Get locale from route, fallback to the user's browser preference
        #$locale = $request->getAttribute('locale') ?: Locale::acceptFromHttp(
        #    $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? $this->config['translator']['locale']
        #);

        $locale = $request->getAttribute('lang') ?: $this->config['translator']['locale'];
        $locale = $this->localeDetector->detect($locale);
        $lang = explode('_', $locale)[0];

        $langObject = $this->langService->getRepository()->findOneBy(['mnemo' => $lang]);
        $this->langHelper->setCurrentLang($langObject);

        // Set up translator
        $this->translator->setLocale($locale)
            ->setFallbackLocale($this->localeDetector->getDefaultLocale());

        // Store the locale as a request attribute
        return $handler->handle(
            $request
                ->withAttribute(self::LANG_ATTRIBUTE, $lang)
                ->withAttribute(self::LOCALIZATION_ATTRIBUTE, $locale)
                //->withAttribute('langObject', $langObject)
        );
    }
}