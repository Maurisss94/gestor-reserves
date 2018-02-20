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
	'rewrite' => array('slug' => untrailingslashit(_x('furgoneta', 'post type slug', 'bravavans')), 'with_front' => false, 'feeds' => true),
	'query_var' => true,
	'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
	'has_archive' => 'furgonetes',
	'show_in_nav_menus' => true
));

add_action( 'admin_post_nopriv_reserva_form', 'gestor_reserva_info' );
add_action( 'admin_post_reserva_form', 'gestor_reserva_info' );
function gestor_reserva_info(){
	global $wpdb;
	$diaIni = filter_input(INPUT_POST, 'datepicker-ini');
	$diaFI = filter_input(INPUT_POST, 'datepicker-fi');
	$llocRecollida = filter_input(INPUT_POST, 'opcio-recollida');
	$llocRetorn = filter_input(INPUT_POST, 'opcio-tornada');
	$ocupants = filter_input(INPUT_POST, 'ocupants');
	$animals = filter_input(INPUT_POST, 'animals-check');
	if($animals == 'Yes')
		$animals = 1;
	else
		$animals = 0;

	var_dump($llocRecollida);

	$args = array(
		'post_type' => 'furgoneta',
		'post_status' => 'publish',
		'meta_query' => array(
			'relation'		=> 'AND',
			array(
				'key'		=> 'ocupants_reserva',
				'compare'	=> '>=',
				'value'		=> $ocupants,
			),
			array(
				'key'		=> 'accepta_animals',
				'compare'	=> '=',
				'value'		=> $animals,
			)
		),
		'order' => 'ASC',
		'fields' => 'ids'
	);
	$furgosDisponibes = query_posts($args);
	var_dump($furgosDisponibes);
}
