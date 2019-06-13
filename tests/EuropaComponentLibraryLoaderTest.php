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
    public function testLoader($name, $expected, $prefix)
    {
        $namespaces = ['namespace1', 'namespace2'];
        $paths = ['tests/fixtures/components'];
        $loader = new EuropaComponentLibraryLoader($namespaces, $paths, null, $prefix);
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
            // Test without prefix.
            ['@namespace1/ecl-component1', 'ecl-component1/ecl-component1.twig ecl-component2/ecl-component2.twig ecl-component3/ecl-component3.twig', ''],
            ['@namespace2/ecl-component2', 'ecl-component2/ecl-component2.twig ecl-component3/ecl-component3.twig', ''],
            ['@namespace2/ecl-component3', 'ecl-component3/ecl-component3.twig', ''],
            ['@namespace2/ecl-component4/sub-component1', 'ecl-component4/sub-component1.twig', ''],
            // Test with prefix.
            ['@namespace1/component5', 'ecl-component5/component5.twig', 'ecl-'],
            ['@namespace1/component5/sub-component1', 'ecl-component5/sub-component1.twig', 'ecl-'],
            // Test with relative loading.
            ['@namespace1/component6', 'ecl-component6/component6.twig ecl-component5/component5.twig', 'ecl-'],
        ];
    }
}
