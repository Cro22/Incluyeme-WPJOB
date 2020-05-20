<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */
require_once plugin_dir_path(__FILE__) . 'admins/incluyeme_filters_adminPage.php';
add_action('admin_menu', 'incluyeme_filters_menus');
add_action('admin_enqueue_scripts', 'incluyeme_styles');
function incluyeme_filters_menus()
{
	add_menu_page(
		'Incluyeme - Filtros',
		'Incluyeme - Filtros',
		'manage_options',
		'incluyemefilters',
		'incluyeme_filters_adminPage'
	);
}
