# Europa Component Library Twig loader
[![Build Status](https://drone.fpfis.eu/api/badges/openeuropa/ecl-twig-loader/status.svg)](https://drone.fpfis.eu/openeuropa/ecl-twig-loader/)
[![Packagist](https://img.shields.io/packagist/v/openeuropa/ecl-twig-loader.svg)](https://packagist.org/packages/openeuropa/ecl-twig-loader)

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library](https://github.com/ec-europa/europa-component-library),
it allows to load components by accessing them via a configurable namespace.
 
For example, given:

```php
<?php

use \OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(
    ['ecl', 'openeuropa'], 
    '/path/to/components', 
    '/root');
$twig = new Twig_Environment($loader);
```

The following calls will load the `ecl-logos` component:

```twig
{% include '@ecl/ecl-logos' with {
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

You can specify a custom ECL prefix too. The prefix will be applied to the parent directory when loading the template:

```php
<?php

use \OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(
    ['ecl'], 
    '/path/to/components', 
    '/root', 'ec-component', 
    '.html.twig');
$twig = new Twig_Environment($loader);
```

```twig
{% include '@ecl/foo' %}
```

This will load:

```
/path/to/components/ec-component-foo/foo.html.twig
```

You can also specify sub-components in the following way:

```twig
{% include '@ecl/foo/bar' %}
```

This will load:

```
/path/to/components/ec-component-foo/bar.html.twig
```

## Installation using Docker Compose

The setup procedure can be simplified by using Docker Compose.

Requirements:

- [Docker](https://www.docker.com/get-docker)
- [Docker-compose](https://docs.docker.com/compose/)

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
