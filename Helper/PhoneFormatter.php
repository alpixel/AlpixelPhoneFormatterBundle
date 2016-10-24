<?php


namespace Alpixel\Bundle\PhoneFormatterBundle\Helper;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Alpixel\Bundle\PhoneFormatterBundle\Formatter\AlpixelPhoneNumberFormat;

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
    public function format($number, $format = AlpixelPhoneNumberFormat::INTERNATIONAL, $locale = null)
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
                    $format = AlpixelPhoneNumberFormat::NATIONAL;
                } else {
                    $format = AlpixelPhoneNumberFormat::INTERNATIONAL;
                }
            } else {
                $constant = 'AlpixelPhoneNumberFormat::'.$format;
                if (false === defined($constant)) {
                    throw new InvalidArgumentException(
                        'The format must be either a constant value or name in AlpixelPhoneNumberFormat'
                    );
                }
                $format = constant('AlpixelPhoneNumberFormat::'.$format);
            }
        }


        return $phoneUtil->format($parser, $format);
    }
}