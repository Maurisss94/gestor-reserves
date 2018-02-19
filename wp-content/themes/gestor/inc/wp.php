<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 12/02/18
 * Time: 11:20
 */
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
	'rewrite' => array('slug' => untrailingslashit(_x('furgoneta', 'post type slug', 'bravavans')), 'with_front' => false, 'feeds' => true),
	'query_var' => true,
	'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
	'has_archive' => 'furgonetes',
	'show_in_nav_menus' => true
));