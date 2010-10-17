<?php
require_once dirname(__FILE__).'/bootstrap/unit.php';
require_once 'PHPUnit/Framework.php';

class sfFlattrPluginTests
{
  public static function suite()
  {
    global $configuration, $plugin_configuration;
    $suite = new PHPUnit_Framework_TestSuite('sfFlattrPlugin');

    $configuration = ProjectConfiguration::getActive();
    $pluginConfig = $configuration->getPluginConfiguration('sfFlattrPlugin');

    // Fake a unit test task to retrieve all connected tests for this plugin.
    $task = new sfTestUnitTask(
      $configuration->getEventDispatcher(),
      new sfFormatter()
    );
    $event = new sfEvent(
      $task,
      'task.test.filter_test_files',
      array(
        'arguments' => array(
          'name' => array()
        ),
        'options' => array()
      )
    );
    $files = $pluginConfig->filterTestFiles($event, array());
    $suite->addTestFiles($files);

    return $suite;
  }
}
