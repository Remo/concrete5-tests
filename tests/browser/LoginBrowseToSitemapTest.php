<?php
class LoginBrowseToSitemapTest extends PHPUnit_Extensions_SeleniumTestCase
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
    $this->open("/index.php/login");
    $this->type("id=uName", "admin");
    $this->type("id=uPassword", "password");
    $this->click("id=submit");
    $this->click("id=submit");
    $this->waitForPageToLoad("30000");
    $this->click("xpath=(//a[contains(text(),'Full Sitemap')])[2]");
    $this->waitForPageToLoad("30000");
    $this->assertEquals("Sitemap", $this->getText("css=h3"));
  }
}
?>