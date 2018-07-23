<?php

namespace OpenEuropa\Twig\Loader;

/**
 * Class EuropaComponentLibraryLoader.
 *
 * @package OpenEuropa\Twig\Loader
 */
class EuropaComponentLibraryLoader extends \Twig_Loader_Filesystem
{

    /**
     * List of ECL admissible namespaces, without leading '@'.
     *
     * @var array
     */
    protected $namespaces;

    /**
     * Component name prefix.
     *
     * @var array
     */
    protected $prefix;

    /**
     * Twig extension.
     *
     * @var array
     */
    protected $extension;

    /**
     * EuropaComponentLibraryLoader constructor.
     *
     * @param array        $namespaces
     *    List of ECL admissible namespaces, without leading '@'.
     * @param array|string $paths
     *    A path or an array of paths where to look for templates.
     * @param null|string  $root
     *    The root path common to all relative paths (null for getcwd())
     * @param string       $prefix
     *    Component name prefix.
     * @param string       $extension
     *    Twig extension.
     */
    public function __construct($namespaces, $paths = [], $root = null, $prefix = 'ecl-', $extension = '.twig')
    {
        parent::__construct($paths, $root);
        $this->namespaces = $namespaces;
        $this->prefix = $prefix;
        $this->extension = $extension;
    }

    /**
     * {@inheritdoc}
     */
    protected function findTemplate($name)
    {
        list($namespace, $componentName) = $this->parseName($name);
        if (in_array($namespace, $this->namespaces)) {
            $normalizedName = $this->normalizeComponentName($componentName);
            $name = $normalizedName.DIRECTORY_SEPARATOR.$normalizedName.$this->extension;
        }

        return parent::findTemplate($name);
    }

    /**
     * Normalize component name taking into account current prefix.
     *
     * @param string $name
     *    Component name.
     *
     * @return string
     *    Normalized component name.
     */
    protected function normalizeComponentName($name)
    {
        if ($this->prefix) {
            $name = strpos($name, $this->prefix) === false ? $this->prefix.$name : $name;
        }

        return $name;
    }
}
