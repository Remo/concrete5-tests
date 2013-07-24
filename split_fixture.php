#!/usr/bin/env php
<?php
$dir = dirname(__FILE__);
$fixturesDir = $dir . '/fixtures';
$xml = new SimpleXMLElement(file_get_contents($dir . '/db_fixture.xml'));
foreach ($xml->database->table_data as $table) {
	$contents = '<?xml version="1.0"?>'."\n";
	$contents .= '<mysqldump xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">'."\n";
	$contents .= '<database name="Testing">'."\n";
	$contents .= $table->asXML()."\n";
	$contents .= '</database>'."\n";
	$contents .= '</mysqldump>'."\n";
	file_put_contents($fixturesDir . '/' . $table['name'] . '.xml', $contents);
}
