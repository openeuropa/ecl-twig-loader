# Europa Component Library Twig loader
[![Build Status](https://drone.fpfis.eu/api/badges/openeuropa/ecl-twig-loader/status.svg)](https://drone.fpfis.eu/openeuropa/ecl-twig-loader/)
[![Packagist](https://img.shields.io/packagist/v/openeuropa/ecl-twig-loader.svg)](https://packagist.org/packages/openeuropa/ecl-twig-loader)

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library Twig implementation (ECL Twig)](https://github.com/ec-europa/ecl-twig),
it allows to load components by accessing them via a configurable namespace.
 
For example, given you have the following ECL twig components:

```
/path/to/components/
├── ec-component-link
│   └── ecl-link.html.twig
└── ec-component-language-list
    ├── ecl-language-list.html.twig
    ├── ecl-language-list-item.html.twig
    ├── ecl-language-list-overlay.html.twig
    └── ecl-language-list-splash.html.twig
```

If you setup the loader as follows:

```php
<?php

use \OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(['ecl'], '/components', '/path/to');
$twig = new Twig_Environment($loader);
```

Then you can load the link component in the following way:

```twig
{% include '@ecl/link' with {
  link: { 
    type: 'standalone',
    label: 'Standalone link',
    path: 'http://google.com',
    icon_position: 'after'
  }
} %}
```

You can also load sub-components by specifying appending them after the component name.

```twig
{% include '@ecl/language-list/language-list-splash' %}
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
