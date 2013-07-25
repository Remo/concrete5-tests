<?php
class Example extends PHPUnit_Extensions_SeleniumTestCase
{
	public static function setUpBeforeClass() {
		if (!defined('ENABLE_NEWSFLOW_OVERLAY')) {
			define('ENABLE_NEWSFLOW_OVERLAY', false);
		}
	}

  protected function setUp()
  {
    $this->setBrowser('googlechrome');
    $this->setBrowserUrl("http://testing/");
  }

  public function testMyTestCase()
  {
    $this->open("/index.php/dashboard/sitemap/full/");
    $this->click("css=#tree-label129 > span");
    $this->click("id=menuPermissions129");
    $this->click("document.ccmPermissionsForm.elements['readGID[]'][1]");
    $this->click("name=readGID[]");
    $this->click("link=Save");
    $this->click("id=ctaskCopy");
    $this->click("link=Go");
    $this->click("css=#tree-label135 > span");
    $this->click("id=menuPermissions135");
    $this->click("document.ccmPermissionsForm.elements['readGID[]'][1]");
    $this->click("name=readGID[]");
    $this->click("link=Save");
    $this->click("css=#tree-label129 > span");
    $this->click("id=menuPermissions129");
    $this->assertTrue($this->isChecked("//form[@id='ccmPermissionsForm']/div/ul/li[2]/label"));
  }
}
?>