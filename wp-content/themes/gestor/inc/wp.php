<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 12/02/18
 * Time: 11:20
 */

//Page options
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' => 'Gestió reserves',
		'menu_title' => 'Gestió reserves',
		'menu_slug' => 'gestio-reserves',
		'capability' => 'edit_posts',
		'redirect' => false,
		'position' => 54
	));
	acf_add_options_page(array(
		'page_title' => 'Options',
		'menu_title' => 'Options',
		'menu_slug' => 'opcions-theme',
		'capability' => 'edit_posts',
		'redirect' => false
	));
}


/* CUSTOM POST TYPES */
register_post_type('furgoneta', array(
	'labels' => array(
		'name' => __('Furgonetes', 'bravavans'),
		'singular_name' => __('Furgoneta', 'bravavans'),
		'menu_name' => __('Furgonetes', 'bravavans')
	),
	'description' => '',
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => false,
	'hierarchical' => false,
	'rewrite' => array('slug' => untrailingslashit(_x('furgoneta', 'post type slug')), 'with_front' => false, 'feeds' => true),
	'query_var' => true,
	'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
	'has_archive' => 'furgonetes',
	'show_in_nav_menus' => true
));
register_post_type('reserva', array(
	'labels' => array(
		'name' => __('Reserves', 'bravavans'),
		'singular_name' => __('Reserva', 'bravavans'),
		'menu_name' => __('Reserves', 'bravavans')
	),
	'description' => '',
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'capabilities' => array(
		'create_posts' => 'do_not_allow',
	),
	'map_meta_cap' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => false,
	'hierarchical' => false,
	'rewrite' => array('slug' => untrailingslashit(_x('reserva', 'post type slug')), 'with_front' => false, 'feeds' => true),
	'query_var' => true,
	'supports' => array('title', 'custom-fields', 'page-attributes'),
	'has_archive' => 'reserva',
	'show_in_nav_menus' => true
));
