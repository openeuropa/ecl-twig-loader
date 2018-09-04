# Europa Component Library Twig loader
[![Build Status](https://drone.fpfis.eu/api/badges/openeuropa/ecl-twig-loader/status.svg)](https://drone.fpfis.eu/openeuropa/ecl-twig-loader/)
[![Packagist](https://img.shields.io/packagist/v/openeuropa/ecl-twig-loader.svg)](https://packagist.org/packages/openeuropa/ecl-twig-loader)

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library](https://github.com/ec-europa/europa-component-library),
it allows to load components by accessing them via a configurable namespace.
 
For example, given:

```php
<?php

use \OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(['ecl', 'openeuropa'], '/path/to/components', '/root');
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
{% include '@openeuropa/ecl-logos' with {
  'to': 'https://ec.europa.eu',
  'title': 'European Commission',
} %}
```
## Using Docker Compose

The setup procedure can be simplified by using Docker Compose.

Copy docker-compose.yml.dist into docker-compose.yml.

You can make any alterations you need for your local Docker setup. However, the defaults should be enough to set the project up.

Run:

```
$ docker-compose up -d
```

Then:

```
$ docker-compose exec web composer install
```
