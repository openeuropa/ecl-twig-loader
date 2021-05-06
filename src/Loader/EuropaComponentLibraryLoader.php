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
     * ECL template name prefix.
     *
     * @var array
     */
    protected $templatePrefix;

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
     *    Component name prefix, defaults to "ec-component-".
     * @param string       $templatePrefix
     *    ECL template name prefix, defaults to "ecl-".
     * @param string       $extension
     *    Twig extension, defaults to ".html.twig".
     */
    public function __construct($namespaces, $paths = [], $root = null, $prefix = 'twig-component-', $templatePrefix = '', $extension = '.html.twig')
    {
        parent::__construct($paths, $root);
        $this->namespaces = $namespaces;
        $this->prefix = $prefix;
        $this->extension = $extension;
        $this->templatePrefix = $templatePrefix;
    }

    /**
     * {@inheritdoc}
     */
    protected function findTemplate($name)
    {
        list($namespace, $componentName) = $this->parseName($name);

        // If namespace is not one of ours just move along, nothing to see here.
        if (!in_array($namespace, $this->namespaces)) {
            return parent::findTemplate($name);
        }

        // If component uses full name just use it, our job is done.
        if ($this->isFullName($componentName)) {
            return parent::findTemplate($componentName);
        }

        // If component uses the short form then expand it into its full name.
        if (strpos($componentName, '/') === false) {
            // If no sub-component is specified we assume that the Twig template
            // has the same name of the component.
            $prefixedName = $this->normalizeComponentName($componentName);
            $templateName = $componentName;
        } else {
            // If we have a sub-component, then we use it as template name.
            list($componentName, $templateName) = explode('/', $componentName);
            $prefixedName = $this->normalizeComponentName($componentName);
        }
        $name = $prefixedName.DIRECTORY_SEPARATOR.$this->templatePrefix.$templateName;

        // The component name could already include the file extension so check
        // and add if it is not.
        if (substr_compare($name, $this->extension, -strlen($this->extension)) !== 0) {
            $name = $name.$this->extension;
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

    /**
     * Check whereas the component name is expressed in its full form.
     * For example: "ec-component-blockquote/ecl-blockquote.html.twig".
     *
     * @param string $componentName
     *   Component name.
     *
     * @return bool
     *   Whereas the component name is expressed in its full form.
     */
    protected function isFullName($componentName)
    {
        return (bool) preg_match("/^{$this->prefix}(.*)\/{$this->templatePrefix}(.*){$this->extension}$/", $componentName);
    }
}
