
AlpixelPhoneFormatterBundle
=================

[![Latest Stable Version](https://poser.pugx.org/alpixel/phoneformatterbundle/v/stable)](https://packagist.org/packages/alpixel/phoneformatterbundle)

## Installation


* Install the package

```
composer require 'alpixel/phoneformatterbundle'
```

* Update AppKernel.php


```

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new Alpixel\Bundle\PhoneFormatterBundle\AlpixelPhoneFormatterBundle(),
            );

            // ...
        }

        // ...
    }
```

### Utilisation

#### Helper 

The only helper actually available give you the possibility to reformat and clean a phone number following a pattern.

You can call the helper this way

```
$number = $this->get('alpixel.helper.phone_formatter')->format($currentNumber, PhoneNumberFormat::NATIONAL, 'DE');
```

The example above will try to output a national german number from the input you gave.

The format option can be :
```
AlpixelPhoneNumberFormat::INTERNATIONAL // example "+41 44 668 18 00"
AlpixelPhoneNumberFormat::NATIONAL // example : "044 668 18 00"
AlpixelPhoneNumberFormat::E164 // example : "+41446681800"
AlpixelPhoneNumberFormat::AUTO // Will try to make the best guess from your current locale
```

The third argument is expecting a two letter country code as *FR* or *DE*

#### Twig extension

The helper is callable via a twig extension like this :

```
"03 03 03 03 03"|phone_format("INTERNATIONAL", "FR")
"03 03 03 03 03"|phone_format("NATIONAL")
"03 03 03 03 03"|phone_format("AUTO", "CH")
```

