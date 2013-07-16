<?php
/**
 * @author jshannon
 */

// TODO: check include path
//ini_set('include_path', ini_get('include_path'));
$dir = dirname(__FILE__);
chdir($dir.'/core');
if (is_dir($dir.'/core/concrete5')) {
	chdir($dir.'/core/concrete5');
	shell_exec(
		'git pull origin master'
	);
	chdir($dir.'/core');
} else {
	shell_exec(
		'git clone git@github.com:concrete5/concrete5.git'
	);
}
chdir($dir.'/core/concrete5/build');
shell_exec(
	'bash js.sh'
);
shell_exec(
	'bash css.sh'
);
chdir($dir);
// Reinstall C5
if (getenv('C5_REINSTALL') || !file_exists($dir.'/core/db_dump.sql') || !file_exists($dir.'/core/concrete5/web/config/site.php')) {
	$cmd = dirname(__FILE__).'/install-concrete5.php'.
		' --db-server='.getenv('DB_SERVER').
		' --db-username='.getenv('DB_USERNAME').
		' --db-password='.getenv('DB_PASSWORD').
		' --db-database='.getenv('DB_DATABASE').
		' --admin-password=password'.
		' --admin-email=admin@example.com'.
		' --starting-point=standard'.
		' --reinstall'.
		' --site=Test'.
		' --demo-username=test'.
		' --demo-password=test'.
		' --demo-email=test@example.com'.
		' --core='.$dir.'/core/concrete5/web/concrete'.
		' --target='.$dir.'/core/concrete5/web';
	echo(shell_exec($cmd));
	shell_exec(
		'mysqldump -u '.getenv('DB_USERNAME').' -p'.getenv('DB_PASSWORD').' '.getenv('DB_DATABASE').' > '.$dir.'/core/db_dump.sql'
	);
} else {
	shell_exec(
		'mysql -u '.getenv('DB_USERNAME').' -p'.getenv('DB_PASSWORD').' '.getenv('DB_DATABASE').' < '.$dir.'/core/db_dump.sql'
	);
}
// Set error level

error_reporting(E_ERROR | E_WARNING | E_USER_ERROR);

define('C5_EXECUTE', true);
define('DIR_BASE', $dir . '/core/concrete5/web');

//causes dispatcher to skip the page rendering
define('C5_ENVIRONMENT_ONLY', true);

//prevents dispatcher from causing redirection to the base_url
define('REDIRECT_TO_BASE_URL', false);

//since we can't define/redefine this for individual tests, we set to a value that's most likely to cause errors (vs '')
define('DIR_REL', '/blog');

unset($dir);
//this is where the magic happens
require_once(DIR_BASE . '/concrete/dispatcher.php');

// login the admin
User::getByUserID(1, true);
Log::addEntry('bootsrapped','unit tests');
