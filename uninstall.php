<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}
$template = plugin_dir_path(__FILE__) . '/templates/incluyeme-board/job-applications.php';
$route = get_template_directory();

$route = $route . '/wpjobboard';
deleteDirectory($route);
function deleteDirectory($dir) {
	if (!file_exists($dir)) {
		return true;
	}
	
	if (!is_dir($dir)) {
		return unlink($dir);
	}
	
	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') {
			continue;
		}
		
		if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
			return false;
		}
		
	}
	
	return rmdir($dir);
}