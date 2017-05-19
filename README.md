# Europa Component Library Twig loader

[![Build Status](https://travis-ci.org/ec-europa/ecl-twig-loader.svg?branch=master)](https://travis-ci.org/ec-europa/ecl-twig-loader)

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library](https://github.com/ec-europa/europa-component-library),
it allows to load components by accessing them via a configurable namespace.
 
For example, given:

```php
<?php

use \EC\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(['ecl', 'ec-europa'], '/path/to/components', '/root');
$twig = new Twig_Environment($loader);
$output = $twig->loadTemplate('@ecl/logos')->render([]);
```

Then the following calls will load the `ecl-logos` component:

```twig
{% include '@ecl/logos' with {
  'to': 'https://ec.europa.eu',
  'title': 'European Commission',
} %}
```

```twig
{% include '@ec-europa/ecl-logos' with {
  'to': 'https://ec.europa.eu',
  'title': 'European Commission',
} %}
```
