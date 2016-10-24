<?php


namespace Alpixel\Bundle\PhoneFormatterBundle\Helper;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;


/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */
class PhoneFormatter
{

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * PhoneFormatter constructor.
     * @param $defaultLocale
     */
    public function __construct($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param mixed $number
     * @param mixed $format
     * @param string $locale
     * @return string
     */
    public function format($number, $format = PhoneNumberFormat::INTERNATIONAL, $locale = null)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        if ($locale === null) {
            $locale = $this->defaultLocale;
        } else {
            $locale = $locale;
        }

        if (empty($locale)) {
            throw new InvalidArgumentException("Invalid locale");
        }

        try {
            $parser = $phoneUtil->parse($number, strtoupper(substr($locale, 0, 2)));
        } catch (NumberParseException $e) {
            return $number;
        }

        if (true === is_string($format)) {
            if ($format === "AUTO") {
                if (strtoupper($this->defaultLocale) == strtoupper($locale)) {
                    $format = PhoneNumberFormat::NATIONAL;
                } else {
                    $format = PhoneNumberFormat::INTERNATIONAL;
                }
            } else {
                $constant = '\libphonenumber\PhoneNumberFormat::'.$format;
                if (false === defined($constant)) {
                    throw new InvalidArgumentException(
                        'The format must be either a constant value or name in libphonenumber\PhoneNumberFormat'
                    );
                }
                $format = constant('\libphonenumber\PhoneNumberFormat::'.$format);
            }
        }


        return $phoneUtil->format($parser, $format);
    }
}