<?php
/**
 * Http local detector
 *
 * @category Popov
 * @package Popov_Translator
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 25.08.2016 12:32
 */
namespace Stagem\ZfcLang\Http;

class LocaleDetector
{
    /**
     * Default locale
     *
     * @var string
     */
    protected $locale = 'en_GB';

    /**
     * List of locales in format 'en_GB'
     *
     * @var array
     */
    protected $locales = [];

    public function __construct(array $locales = [])
    {
        // if not possible call system function "locale"
        #if (false === (function_exists('exec') && exec('locale -a', $this->locales) && $this->locales)) {
            $this->locales = $locales;
        #}
    }

    public function setDefaultLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getDefaultLocale()
    {
        return $this->locale;
    }

    /**
     * Detect locale based on HTTP locale get through Locale::acceptFromHttp()
     *
     * @param $httpLocale
     * @return string
     */
    public function detect($httpLocale)
    {
        if (false === strpos($httpLocale, '_')) {
            return $this->detectByLanguage($httpLocale);
        } else {
            return $httpLocale;
        }
    }

    /**
     * Get locale by language code
     *
     * @link http://stackoverflow.com/a/8573499/1335142
     * @param $langCode
     * @return string
     */
    public function detectByLanguage($langCode)
    {
        $locale = $this->getDefaultLocale();
        foreach ($this->locales as $l) {
            $regex = "/{$langCode}\_[A-Z]{2}$/";
            if (preg_match($regex, $l)/* && file_exists(TRANSROOT . "/{$lang.php}")*/) {
                $locale = $l;
                break;
            }
        }

        return $locale;
    }

    /**
     * Returns a locale from a country code that is provided.
     *
     * @param $countryCode string ISO 3166-2-alpha 2 country code
     * @param $languageCode string ISO 639-1-alpha 2 language code
     * @return string A locale, formatted like en_US, or null if not found
     * @link http://stackoverflow.com/a/10375234/1335142
     */
    public function detectByCountry($countryCode, $languageCode = '')
    {
        // Locale list taken from:
        // http://stackoverflow.com/questions/3191664/
        // list-of-all-locales-and-their-short-codes
        foreach ($this->locales as $locale) {
            $localeRegion = locale_get_region($locale);
            $localeLanguage = locale_get_primary_language($locale);
            $localeArray = ['language' => $localeLanguage, 'region' => $localeRegion];

            if (strtoupper($countryCode) == $localeRegion && $languageCode == '') {
                return locale_compose($localeArray);
            } elseif (strtoupper($countryCode) == $localeRegion && strtolower($languageCode) == $localeLanguage) {
                return locale_compose($localeArray);
            }
        }

        return null;
    }
}