<?php
class SearchPageTest extends PHPUnit_Extensions_SeleniumTestCase
{

	public static function setUpBeforeClass() {
		if (!defined('ENABLE_NEWSFLOW_OVERLAY')) {
			define('ENABLE_NEWSFLOW_OVERLAY', false);
		}
	}

  protected function setUp()
  {
    $this->setBrowser("googlechrome");
    $this->setBrowserUrl("http://testing/");
  }

  public function testMyTestCase()
  {
    $this->open("/");
    $this->click("link=Search");
    $this->waitForPageToLoad("30000");
    $this->type("name=query", "Hello");
    $this->click("name=submit");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("Hello World", $this->getText("css=div.searchResult > h3"));
  }
}
?>