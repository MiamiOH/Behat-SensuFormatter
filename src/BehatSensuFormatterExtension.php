<?php

namespace miamioh\BehatSensuFormatter;


use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;


/**
 * Class BehatSensuFormatter
 * @package Features\Formatter
 */
class BehatSensuFormatterExtension implements Extension
{
  /**
   * You can modify the container here before it is dumped to PHP code.
   *
   * @param ContainerBuilder $container
   */
  public function process(ContainerBuilder $container)
  {
      // TODO: Implement process() method.
  }

  /**
   * Returns the extension config key.
   *
   * @return string
   */
  public function getConfigKey()
  {
      // TODO: Implement getConfigKey() method.
      return "miamiohsbehatensu";
  }

  /**
   * Initializes other extensions.
   *
   * This method is called immediately after all extensions are activated but
   * before any extension `configure()` method is called. This allows extensions
   * to hook into the configuration of other extensions providing such an
   * extension point.
   *
   * @param ExtensionManager $extensionManager
   */
  public function initialize(ExtensionManager $extensionManager)
  {
      // TODO: Implement initialize() method.
  }

  /**
   * Setups configuration for the extension.
   *
   * @param ArrayNodeDefinition $builder
   */
  public function configure(ArrayNodeDefinition $builder)
  {
    $builder->children()->integerNode('warning')->defaultValue('20');
    $builder->children()->integerNode('critical')->defaultValue('50');

  }

  /**
   * Loads extension services into temporary container.
   *
   * @param ContainerBuilder $container
   * @param array $config
   */
  public function load(ContainerBuilder $container, array $config)
  {
    $definition = new Definition("miamioh\\BehatSensuFormatter\\Formatter\\SensuFormatter");
    $definition->addArgument($config['warning']);
    $definition->addArgument($config['critical']);
    $container->setDefinition("sensuformatter",$definition)->addTag("output.formatter");

  }

}
