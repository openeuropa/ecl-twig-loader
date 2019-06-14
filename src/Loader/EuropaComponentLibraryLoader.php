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
    public function __construct($namespaces, $paths = [], $root = null, $prefix = '', $extension = '.twig')
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
            if (strpos($componentName, '/') === false) {
                // If no sub-component is specified we assume that the Twig template
                // has the same name of the component.
                $prefixedName = $this->normalizeComponentName($componentName);
                $name = $prefixedName.DIRECTORY_SEPARATOR.$componentName.$this->extension;
            } else {
                // If we have a sub-component, then we use it as template name.
                list($componentName, $templateName) = explode('/', $componentName);
                $prefixedName = $this->normalizeComponentName($componentName);
                $name = $prefixedName.DIRECTORY_SEPARATOR.$templateName.$this->extension;
            }
        }

        // ECL 2.0 Twig templates use relative include method.
        // The following snippet allows to load templates that are references
        // within other templates, given that they use the same prefix.
        if (strstr($name, '..'.DIRECTORY_SEPARATOR.$this->prefix)) {
            $name = str_replace('..'.DIRECTORY_SEPARATOR, '', $name);
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
