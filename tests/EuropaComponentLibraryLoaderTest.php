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
            ['@namespace1/component1', 'component1', ''],
            // Test without prefix and with inclusions.
            ['@namespace2/component2', 'component2 component1', ''],
            ['@namespace2/component3', 'component3 component2 component1', ''],
            // Test without prefix and sub component.
            ['@namespace2/component4/sub-component1', 'component4 sub-component1', ''],
            // Test with prefix.
            ['@namespace1/component5', 'component5', 'ecl-'],
            ['@namespace1/component5/sub-component1', 'component5 sub-component1', 'ecl-'],
            // Test with prefix and with relative loading.
            ['@namespace1/component6', 'component6 component5', 'ecl-'],
            // Test when using full name.
            ['@namespace1/ec-component-full-name/ecl-full-name.html.twig', 'full-name', 'ec-component-'],
        ];
    }
}
