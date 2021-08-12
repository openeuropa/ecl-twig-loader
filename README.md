# Europa Component Library Twig loader
[![Build Status](https://drone.fpfis.eu/api/badges/openeuropa/ecl-twig-loader/status.svg)](https://drone.fpfis.eu/openeuropa/ecl-twig-loader/)
[![Packagist](https://img.shields.io/packagist/v/openeuropa/ecl-twig-loader.svg)](https://packagist.org/packages/openeuropa/ecl-twig-loader)

[Twig](http://twig.sensiolabs.org) loader for [Europa Component Library Version 3](https://github.com/ec-europa/europa-component-library),
it allows to load components by accessing them via a configurable namespace.

For example, given you have the following ECL components:

```
/path/to/components/
├── twig-component-link
│   └── ecl-link.html.twig
└── twig-component-language-list
    ├── ecl-language-list.html.twig
    ├── ecl-language-list-grid.html.twig
    └── ecl-language-list-item.html.twig
```

If you set up the loader as follows:

```php
<?php

use \OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;

$loader = new EuropaComponentLibraryLoader(['ecl'], '/components', '/path/to');
$twig = new Twig_Environment($loader);
```

Then you can load the link component in the following way:

```twig
{% include '@ecl/link/link.html.twig' with {
  link: {
    type: 'standalone',
    label: 'Standalone link'
  }
} %}
```

You can also use a shorter form, based on implicit naming conventions:

```twig
{% include '@ecl/link' with {
  link: {
    type: 'standalone',
    label: 'Standalone link'
  }
} %}
```

To load sub-components append them after the component name:

```twig
{% include '@ecl/language-list/language-list-item' %}
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

#### Step debugging

To enable step debugging from the command line, pass the `XDEBUG_SESSION` environment variable with any value to
the container:

```bash
docker-compose exec -e XDEBUG_SESSION=1 web <your command>
```

Please note that, starting from XDebug 3, a connection error message will be outputted in the console if the variable is
set but your client is not listening for debugging connections. The error message will cause false negatives for PHPUnit
tests.

To initiate step debugging from the browser, set the correct cookie using a browser extension or a bookmarklet
like the ones generated at https://www.jetbrains.com/phpstorm/marklets/.
