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
if (getenv('C5_REINSTALL') || !file_exists($dir.'/db_dump.sql') || !file_exists($dir.'/core/concrete5/web/config/site.php')) {
	$cmd = $dir.'/install-concrete5.php'.
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
		'mysqldump --xml -t -u '.getenv('DB_USERNAME').' -p'.getenv('DB_PASSWORD').' '.getenv('DB_DATABASE').' > '.$dir.'/db_fixture.xml'
	);
	shell_exec(
		'mysqldump -u '.getenv('DB_USERNAME').' -p'.getenv('DB_PASSWORD').' '.getenv('DB_DATABASE').' > '.$dir.'/db_dump.sql'
	);
	shell_exec(
		$dir.'/split_fixture.php'
	);
}
/*
} else {
	shell_exec(
		'mysql -u '.getenv('DB_USERNAME').' -p'.getenv('DB_PASSWORD').' '.getenv('DB_DATABASE').' < '.$dir.'/db_dump.sql'
	);
}
*/
$GLOBALS['DB_DATABASE'] = getenv('DB_DATABASE');
$GLOBALS['DB_SERVER'] = getenv('DB_SERVER');
$GLOBALS['DB_PASSWORD'] = getenv('DB_PASSWORD');
$GLOBALS['DB_USERNAME'] = getenv('DB_USERNAME');
$GLOBALS['C5_TEST_BASE_DIR'] = $dir;
