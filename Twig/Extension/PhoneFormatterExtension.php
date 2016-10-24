<?php


namespace Alpixel\Bundle\PhoneFormatterBundle\Twig\Extension;

use Alpixel\Bundle\PhoneFormatterBundle\Helper\PhoneFormatter;


/**
 * @author Benjamin HUBERT <benjamin@alpixel.fr>
 */
class PhoneFormatterExtension extends \Twig_Extension
{
    /**
     * @var \Alpixel\Bundle\PhoneFormatterBundle\Helper\PhoneFormatter
     */
    private $formatter;

    /**
     * PhoneFormatterExtension constructor.
     * @param \Alpixel\Bundle\PhoneFormatterBundle\Helper\PhoneFormatter $formatter
     */
    public function __construct(PhoneFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('phone_number', [$this->formatter, 'format']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'phone_number';
    }
}