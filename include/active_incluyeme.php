<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
include_once plugin_dir_path(__FILE__) . 'lib/WP_Incluyeme.php';
function incluyeme_load()
{
	incluyeme_files();
}


function incluyeme_files()
{
	$template = plugin_dir_path(__FILE__) . '/templates/incluyeme-board/job-applications.php';
	$route = get_template_directory();
	if (!file_exists($route . '/wpjobboard/job-board/job-applications.php')) {
		mkdir($route . '/wpjobboard');
		mkdir($route . '/wpjobboard/job-board');
		copy($template, $route . '/wpjobboard/job-board/job-applications.php');
	} else {
		$templateSize = filesize(plugin_dir_path(__FILE__) . '/templates/incluyeme-board/job-applications.php');
		$templateExist = filesize($route . '/wpjobboard/job-board/job-applications.php');
		if ($templateExist !== $templateSize) {
			rmdir($route . '/wpjobboard/job-board/job-applications.php');
			copy($template, $route . '/wpjobboard/job-board/job-applications.php');
		}
	}
}