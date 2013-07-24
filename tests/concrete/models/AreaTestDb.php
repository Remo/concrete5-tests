<?php
class AreaTest extends PHPUnit_Extensions_Database_TestCase {

	protected function getConnection() {
		$pdo = new PDO('mysql:host='.$GLOBALS['DB_SERVER'].';dbname='.$GLOBALS['DB_DATABASE'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
		return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DATABASE']);
	}

	public function getDataSet() {
		$dataSets = array();
		foreach (array(
			'Config',
			'Pages',
			'Collections',
			'CollectionVersions',
			'Areas'
		) as $table) {
			$dataSets[] = $this->createMySQLXMLDataSet($GLOBALS['C5_TEST_BASE_DIR'] . '/fixtures/' . $table . '.xml');
		}
		return new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($dataSets);
	}

	public function setUp() {
		parent::setUp();
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

	public function testGetPermissionObjectIdentifier() {
		$area = Area::getOrCreate(Page::getByID(HOME_CID), 'Testing');
		$this->assertEquals($area->getPermissionObjectIdentifier(), '1:Testing');
	}

	public function testGetCollectionID() {
		$area = Area::getOrCreate(Page::getByID(HOME_CID), 'Testing');
		$this->assertEquals($area->getCollectionID(), HOME_CID);
	}

	public function testGetAreaCollectionObject() {
		$area = Area::getOrCreate(Page::getByID(HOME_CID), 'Testing');
		$page = $area->getAreaCollectionObject();
		$this->assertInstanceOf('Page', $page);
		$this->assertEquals(1, $page->getCollectionID());
	}

	public function testGetAreaHandleFromID() {
		$this->assertEquals('Header', Area::getAreaHandleFromID(1));
	}

	public function testGet() {
		$area = Area::get(Page::getByID(105), 'Header');
		$this->assertInstanceOf('Area', $area);
		$this->assertEquals(1, $area->getAreaID());
		$this->assertEquals(105, $area->getCollectionID());
		$this->assertEquals('Header', $area->getAreaHandle());
		$this->assertEquals(0, $area->overrideCollectionPermissions());
		$this->assertEquals(0, $area->getAreaCollectionInheritID());
		$this->assertEquals(0, $area->isGlobalArea());
	}
}
