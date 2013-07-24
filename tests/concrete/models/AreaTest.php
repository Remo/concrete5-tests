<?php
class AreaTest extends PHPUnit_Extensions_Database_TestCase {

	protected function getConnection() {
		$pdo = new PDO('mysql:host='.$GLOBALS['DB_SERVER'].';dbname='.$GLOBALS['DB_DATABASE'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
		return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DATABASE']);
	}

	public function getDataSet() {

		$dataSets = array();
		foreach (array(
			'Config'
		) as $table) {
			$dataSets[] = $this->createMySQLXMLDataSet($GLOBALS['C5_TEST_BASE_DIR'] . '/fixtures/' . $table . '.xml');
		}
		return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSets);
	}

	public function setUp() {
		$this->getConnection();
		$this->getDataSet();
		// Set error level
		error_reporting(E_ERROR | E_WARNING | E_USER_ERROR);

		define('C5_EXECUTE', true);
		define('DIR_BASE', $GLOBALS['C5_TEST_BASE_DIR'] . '/core/concrete5/web');

		//causes dispatcher to skip the page rendering
		define('C5_ENVIRONMENT_ONLY', true);

		//prevents dispatcher from causing redirection to the base_url
		define('REDIRECT_TO_BASE_URL', false);

		//since we can't define/redefine this for individual tests, we set to a value that's most likely to cause errors (vs '')
		define('DIR_REL', '/blog');

		//this is where the magic happens
		require_once(DIR_BASE . '/concrete/dispatcher.php');

	}

	public function testAutoload() {
		$area = new Area('Main');
		$this->assertThat(
			$area,
			$this->isInstanceOf(
				'Area'
			)
		);
	}

	public function testIsGlobalArea() {
		$this->markTestIncomplete();
	}

	public function testGetAreaID() {
		$area = new Area('Testing');
		$area->arID = 1;
		$this->assertEquals(1, $area->getAreaID());
	}

	public function testGetAreaHandle() {
		$area = new Area('Testing');
		$this->assertEquals('Testing', $area->getAreaHandle());
	}

	public function testGetCustomTemplates() {
		$this->markTestIncomplete();
	}

	public function testSetCustomTemplate() {
		$this->markTestIncomplete();
	}

	public function testGetTotalBlocksInArea() {
		$this->markTestIncomplete();
	}

	public function testOverrideCollectionPermissions() {
		$area = new Area('Testing');
		$area->arOverrideCollectionPermissions = 1;
		$this->assertEquals(1, $area->overrideCollectionPermissions());
	}
}