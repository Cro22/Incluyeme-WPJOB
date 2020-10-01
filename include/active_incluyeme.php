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
			copy($template, $route . '/wpjobboard/job-board/job-applications.php');
		}
	}
}

function incluyeme_rating_function($id){
	global $wpdb;
	$prefix = $wpdb->prefix;
	return $wpdb->get_results("SELECT
  " . $prefix . "wpjb_meta_value.value
FROM " . $prefix . "wpjb_meta_value
WHERE " . $prefix . "wpjb_meta_value.object_id = $id
AND " . $prefix . "wpjb_meta_value.meta_id = (SELECT
    " . $prefix . "wpjb_meta.id
  FROM " . $prefix . "wpjb_meta
  WHERE " . $prefix . "wpjb_meta.name = 'rating')");
}

add_action ('incluyeme_rating_functions', 'incluyeme_rating_function');
