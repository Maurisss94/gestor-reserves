<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 12/02/18
 * Time: 11:21
 */


add_filter('show_admin_bar', '__return_false');

function gestor_enqueue_scripts(){

	//Encua CSS
	wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap/bootstrap.css', array(), '4.0.0');
	wp_register_style('jquery-ui', get_template_directory_uri() . '/assets/css/jquery-ui.css', array(), '1.0.0');

	wp_register_style('gestor-reserves', get_template_directory_uri() . '/assets/css/gestor.css', array('bootstrap', 'jquery-ui'), '1.0');
	wp_enqueue_style('gestor-reserves');

	//Encua JS
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery/jquery-3.3.1.min.js', array(), '3.3.1', true);
	wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap/bootstrap.js', array(), '4.0.0', true);
	wp_register_script('jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array(), '1.0.0', true);

	wp_register_script('gestor-reserves', get_template_directory_uri() . '/assets/js/gestor.js', array('jquery', 'bootstrap', 'jquery-ui'), '1.0', true);
	wp_enqueue_script('gestor-reserves');

}

add_action('wp_enqueue_scripts', 'gestor_enqueue_scripts');

function gestor_menu_class($classes, $item) {
	if(in_array('current-menu-item', $classes)){
		$classes[] ='active nav-item';
	}else{
		$classes[] = 'nav-item';
	}
	return $classes;
}
add_filter('nav_menu_css_class','gestor_menu_class',10,2);

function add_menuclass($ulclass) {
	return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
}
add_filter('wp_nav_menu','add_menuclass');