# ECL Twig loader

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library](https://github.com/ec-europa/europa-component-library),
it allows to load components by accessing them via a configurable namespace.
 
For example, given:

```php
<?php

use \EcEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$leader = new EuropaComponentLibraryLoader('/path/to/components', '/root', ['ecl', 'ec-europa']);
$twig = new Twig_Environment($loader);
```

Then the following calls will load the `ecl-logos` component:

```twig
{% include '@ecl/logos' with {
  'to': 'https://ec.europa.eu',
  'title': 'European Commission',
} %}
```

```twig
{% include '@ec-europa/logos' with {
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
