<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 12/02/18
 * Time: 11:20
 */
function gestor_init() {

	require get_template_directory() . '/inc/wp.php';

	if(is_admin()){
		require get_template_directory() . '/inc/backend.php';
	}else if(defined('DOING_AJAX')){
		//
	}else{
		require get_template_directory() . '/inc/frontend.php';
	}
}

add_action('init', 'gestor_init');

function gestor_setup() {
	register_nav_menu('main-menu', 'Menú principal');

	add_theme_support('post-thumbnails', array('post', 'page', 'furgoneta', 'accessori'));

}

add_action('after_setup_theme', 'gestor_setup');
