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
    $button = flattr_button('http://example.com/', 'My awesome item');

    $this->assertContains('title="My awesome item"', $button);
  }

  public function testButtonTitleDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('title="The title of your item."', $button);
  }

  public function testButtonTitleMin()
  {
    $button = flattr_button('http://example.com/', '1234');

    $this->assertFalse($button);
  }

  public function testButtonTitleMax()
  {
    $button = flattr_button('http://example.com/', str_repeat('a', 101));

    $this->assertFalse($button);
  }

  public function testButtonDescription()
  {
    $button = flattr_button('http://example.com/', null, 'It is awesome!');

    $this->assertRegExp('~>(\r|\n|\t|\s)*It is awesome!(\r|\n|\t|\s)*</a>~', $button);
  }

  public function testButtonDescriptionDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertRegExp('~>(\r|\n|\t|\s)*A description of your item.(\r|\n|\t|\s)*</a>~', $button);
  }

  public function testButtonDescriptionMin()
  {
    $button = flattr_button('http://example.com/', null, '1234');

    $this->assertFalse($button);
  }

  public function testButtonDescriptionMax()
  {
    $button = flattr_button('http://example.com/', null, str_repeat('a', 1001));

    $this->assertFalse($button);
  }

  public function testButtonCategory()
  {
    $button = flattr_button('http://example.com/', null, null, 'video');

    $this->assertContains('category:video;', $button);
  }

  public function testButtonCategoryHTML5()
  {
    $button = flattr_button('http://example.com/', null, null, 'video', null, true);

    $this->assertContains('data-flattr-category="video"', $button);
  }

  public function testButtonCategoryDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('category:text;', $button);
  }

  public function testButtonCategoryDefaultHTML5()
  {
    $button = flattr_button('http://example.com/', null, null, null, null, true);

    $this->assertContains('data-flattr-category="text"', $button);
  }

  public function testButtonUID()
  {
    $button = flattr_button('http://example.com/', null, null, null, 'netsojssaibot');

    $this->assertContains('uid:netsojssaibot;', $button);
  }

  public function testButtonUIDHTML5()
  {
    $button = flattr_button('http://example.com/', null, null, null, 'netsojssaibot', true);

    $this->assertContains('data-flattr-uid="netsojssaibot"', $button);
  }

  public function testButtonUIDDefault()
  {
    $button = flattr_button('http://example.com/');

    $this->assertContains('uid:tobiassjosten;', $button);
  }

  public function testButtonUIDDefaultHTML5()
  {
    $button = flattr_button('http://example.com/', null, null, null, null, true);

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
