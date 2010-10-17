<?php

if (!isset($_SERVER['SYMFONY']))
{
  throw new RuntimeException('Could not find symfony core libraries.');
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

$projectPath = dirname(__FILE__).'/../fixtures/project';
require_once($projectPath.'/config/ProjectConfiguration.class.php');
$configuration = new ProjectConfiguration($projectPath);

function sfFlattrPlugin_autoload_again($class)
{
  $autoload = sfSimpleAutoload::getInstance();
  $autoload->reload();
  return $autoload->autoload($class);
}
spl_autoload_register('sfFlattrPlugin_autoload_again');

if (file_exists($config = dirname(__FILE__).'/../../config/sfFlattrPluginConfiguration.class.php'))
{
  require_once $config;
  $plugin_configuration = new sfFlattrPluginConfiguration($configuration, dirname(__FILE__).'/../..', 'sfFlattrPlugin');
}
else
{
  $plugin_configuration = new sfPluginConfigurationGeneric($configuration, dirname(__FILE__).'/../..', 'sfFlattrPlugin');
}
