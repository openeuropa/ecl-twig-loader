<?php

namespace EcEuropa\Twig\Loader;

/**
 * Class EuropaComponentLibraryLoader.
 *
 * @package EcEuropa\Twig\Loader
 */
class EuropaComponentLibraryLoader extends \Twig_Loader_Filesystem {

  /**
   * List of ECL admissible namespaces, without leading '@'.
   *
   * @var array
   */
  protected $namespaces;

  /**
   * Constructor.
   *
   * @param array $paths
   *    A path or an array of paths where to look for templates.
   * @param null $root
   *    The root path common to all relative paths (null for getcwd()).
   * @param array $namespaces
   *    List of ECL admissible namespaces, without leading '@'.
   */
  public function __construct($paths = [], $root = NULL, $namespaces = []) {
    parent::__construct($paths, $root);
    $this->namespaces = $namespaces;
  }

  /**
   * {@inheritdoc}
   */
  protected function findTemplate($name) {
    list($namespace, $shortname) = $this->parseName($name);
    if (in_array($namespace, $this->namespaces)) {
      $name = $shortname . DIRECTORY_SEPARATOR . str_replace('ecl-', '', $shortname) . '.twig';
    }
    return parent::findTemplate($name);
  }

}
