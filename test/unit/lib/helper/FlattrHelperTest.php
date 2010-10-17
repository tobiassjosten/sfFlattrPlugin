<?php
require_once dirname(__FILE__).'/../../../bootstrap/unit.php';
require_once 'PHPUnit/Framework.php';

// Load the helper we're testing.
require_once dirname(__FILE__).'/../../../../lib/helper/FlattrHelper.php';

class FlattrHelperTest extends PHPUnit_Framework_TestCase
{
  public function testBasicButton()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('href="http://example.com/"', $button);
  }

  public function testButtonTitle()
  {
    $options = array('title' => 'My awesome item');
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('title="My awesome item"', $button);
  }

  public function testButtonTitleDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('title="The title of your item."', $button);
  }

  public function testButtonTitleMin()
  {
    $options = array('title' => '1234');
    $button = flattr_button('http://example.com/', $options);

    $this->assertFalse($button);
  }

  public function testButtonTitleMax()
  {
    $options = array('title' => str_repeat('a', 101));
    $button = flattr_button('http://example.com/', $options);

    $this->assertFalse($button);
  }

  public function testButtonDescription()
  {
    $options = array('description' => 'It is awesome!');
    $button = flattr_button('http://example.com/', $options);

    $this->assertRegExp('~>(\r|\n|\t|\s)*It is awesome!(\r|\n|\t|\s)*</a>~', $button);
  }

  public function testButtonDescriptionDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertRegExp('~>(\r|\n|\t|\s)*A description of your item.(\r|\n|\t|\s)*</a>~', $button);
  }

  public function testButtonDescriptionMin()
  {
    $options = array('description' => '1234');
    $button = flattr_button('http://example.com/', $options);

    $this->assertFalse($button);
  }

  public function testButtonDescriptionMax()
  {
    $options = array('description' => str_repeat('a', 1001));
    $button = flattr_button('http://example.com/', $options);

    $this->assertFalse($button);
  }

  public function testButtonCategory()
  {
    $options = array('category' => 'video');
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('category:video;', $button);
  }

  public function testButtonCategoryHTML5()
  {
    $options = array(
      'category' => 'video',
      'html5' => true,
    );
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('data-flattr-category="video"', $button);
  }

  public function testButtonCategoryDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('category:text;', $button);
  }

  public function testButtonCategoryDefaultHTML5()
  {
    $options = array('html5' => true);
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('data-flattr-category="text"', $button);
  }

  public function testButtonUID()
  {
    $options = array('uid' => 'netsojssaibot');
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('uid:netsojssaibot;', $button);
  }

  public function testButtonUIDHTML5()
  {
    $options = array(
      'uid' => 'netsojssaibot',
      'html5' => true,
    );
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('data-flattr-uid="netsojssaibot"', $button);
  }

  public function testButtonUIDDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('uid:tobiassjosten;', $button);
  }

  public function testButtonUIDDefaultHTML5()
  {
    $options = array('html5' => true);
    $button = flattr_button('http://example.com/', $options);

    $this->assertContains('data-flattr-uid="tobiassjosten"', $button);
  }

  protected function setUp()
  {
    $this->projectConfiguration = new ProjectConfiguration(dirname(__FILE__).'/../../fixtures/project/');

    if(!sfContext::hasInstance('frontend'))
    {
      sfContext::createInstance($this->projectConfiguration->getApplicationConfiguration('frontend', 'test', true));
    }
  }
}
