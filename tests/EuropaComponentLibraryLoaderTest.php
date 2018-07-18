<?php

namespace OpenEuropa\Twig\Loader\Tests;

use OpenEuropa\Twig\Loader\EuropaComponentLibraryLoader;
use PHPUnit\Framework\TestCase;
use Twig\Environment as Twig_Environment;

/**
 * Class EuropaComponentLibraryLoaderTest
 */
class EuropaComponentLibraryLoaderTest extends TestCase
{

    /**
     * Test loader.
     *
     * @param string $name
     * @param string $expected
     *
     * @dataProvider dataProvider
     */
    public function testLoader($name, $expected)
    {
        $namespaces = [
            'namespace1',
            'namespace2',
        ];
        $loader = new EuropaComponentLibraryLoader($namespaces, 'tests/fixtures/components');
        $twig = new Twig_Environment($loader);
        $actual = $twig->loadTemplate($name)->render([]);
        $actual = str_replace("\n", ' ', trim($actual));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Data provider.
     *
     * @return array
     *    Test data.
     */
    public function dataProvider()
    {
        return [
            ['@namespace1/ecl-component1', 'ecl-component1.twig ecl-component2.twig ecl-component3.twig'],
            ['@namespace2/ecl-component2', 'ecl-component2.twig ecl-component3.twig'],
            ['@namespace2/ecl-component3', 'ecl-component3.twig'],
        ];
    }
}
