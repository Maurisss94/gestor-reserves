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

register_post_type('accessori', array(
	'labels' => array(
		'name' => __('Accessoris', 'bravavans'),
		'singular_name' => __('Accessori', 'bravavans'),
		'menu_name' => __('Accessoris', 'bravavans')
	),
	'description' => '',
	'public' => true,
	'show_ui' => true,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => false,
	'hierarchical' => false,
	'rewrite' => array('slug' => untrailingslashit(_x('accessori', 'post type slug', 'bravavans')), 'with_front' => false, 'feeds' => true),
	'query_var' => true,
	'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes'),
	'has_archive' => 'accessoris',
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


if(is_admin()){
	add_action( 'wp_ajax_vans_available', 'gestor_vans_available' );
	add_action( 'wp_ajax_nopriv_vans_available', 'gestor_vans_available' );

	add_action( 'wp_ajax_vans_prices', 'gestor_vans_prices' );
	add_action( 'wp_ajax_nopriv_vans_prices', 'gestor_vans_prices' );

	add_action( 'wp_ajax_gestor_get_reserved_vans', 'gestor_get_reserved_vans' );
	add_action( 'wp_ajax_nopriv_gestor_get_reserved_vans', 'gestor_get_reserved_vans' );
}

function gestor_vans_available(){
	global $wpdb;
	$ocupants = filter_input(INPUT_GET, 'ocupants', FILTER_SANITIZE_SPECIAL_CHARS);
	$animals = filter_input(INPUT_GET, 'animals', FILTER_SANITIZE_SPECIAL_CHARS);

	if($animals == 0){
		$argsAnimals =array();
	}else{
		$argsAnimals = array(
			'key'		=> 'accepta_animals',
			'compare'	=> '=',
			'value'		=> $animals,
		);
	}

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
			$argsAnimals,
			array(
				'key' => 'total_furgonetes',
				'compare' => '>=',
				'value' => 1
			),
		),
		'order' => 'ASC',
		'fields' => 'ids'
	);
	$furgosIDs = query_posts($args);
	$res = array();
	foreach ($furgosIDs as $f) {
		$tmp = array(
			'id' => $f,
			'title' => get_the_title($f),
			'thumbnail' => get_the_post_thumbnail_url($f)
		);
		array_push($res, $tmp);
	}

	echo json_encode($res);
	wp_die();
}

function gestor_get_reserved_vans() {
	global $wpdb;
	$id = filter_input(INPUT_GET, 'id_furgo', FILTER_SANITIZE_SPECIAL_CHARS);
	//$d1 = filter_input(INPUT_GET, 'data_inici', FILTER_SANITIZE_SPECIAL_CHARS);

	$argsReserva = array(
		'post_type' => 'reserva',
		'post_status' => 'publish',
		'meta_query' => 'id_furgoneta',
		'meta_value' => $id,
		'fields' => 'ids'
	);
	$reserves = query_posts($argsReserva);

	$res = array();
	if($reserves) {
		foreach ($reserves as $idReserva) {
			$dataInici = get_field('data_inici', $idReserva);
			$dataFi = get_field('data_fi', $idReserva);
			$tmp = array(
				'dIni' => $dataInici,
				'dFi' => $dataFi
			);
			array_push($res, $tmp);
		}
	}

	echo json_encode($res);
	wp_die();
}

function gestor_vans_prices(){
	global $wpdb;
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
	$res = array(
		'preu_t1' => get_field('preu_dia_t1', $id),
		'preu_t2' => get_field('preu_dia_t2', $id),
		'preu_t3' => get_field('preu_dia_t3', $id),
		'preu_t4' => get_field('preu_dia_t4', $id),
	);
	echo json_encode($res);
	wp_die();
}