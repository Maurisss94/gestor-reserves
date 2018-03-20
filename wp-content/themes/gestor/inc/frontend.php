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


	wp_localize_script('gestor-reserves', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'lang' => ICL_LANGUAGE_CODE));
	wp_localize_script('gestor-reserves', 'object_van', array('ajax_url' => admin_url('admin-ajax.php'), 'lang' => ICL_LANGUAGE_CODE));
	wp_localize_script('gestor-reserves', 'object_booking', array('ajax_url' => admin_url('admin-ajax.php'), 'lang' => ICL_LANGUAGE_CODE));

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

function gestor_check_llocs( $llocRecollida, $optionsRecollida ) {
	$res = array(
		'nom' => '',
		'preu' => -1
	); $i = 1; $trobat = false;
	while ( $i <= sizeof( $optionsRecollida ) and ! $trobat ) {
		if ( $i == $llocRecollida ) {
			$res['nom']= $optionsRecollida[ $i - 1 ]['nom_lloc'];
			$res['preu']= $optionsRecollida[ $i - 1 ]['preu_lloc'];
			$trobat = true;
		}
		$i ++;
	}
	return $res;
}

function gestor_check_datas($diaIni, $diaFI){

	$date = str_replace('/', '-', $diaIni);
	$date2 = str_replace('/', '-', $diaFI);
	$dataI =  new DateTime($date);
	$dataF =  new DateTime($date2);
	$intervalDies = date_diff($dataI, $dataF);
	$intervalDies = intval($intervalDies->format('%R%a'));

	return ($intervalDies >=2 and $dataF > $dataI);
}

function gestor_createData($data, $type){
	$dob_str = $data;
	$date = DateTime::createFromFormat($type, $dob_str);
	return $date->format('Ymd');
}

function gestor_get_available_vans($animals, $ocupants, $arrayFurgosReserva){
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
		'post__not_in'     => $arrayFurgosReserva,
		'order' => 'ASC',
		'fields' => 'ids'
	);
	$furgosDisponibes = query_posts($args);

	return $furgosDisponibes;
}

function gestor_get_unavailable_vans($furgosReservades){
	$args = array(
		'post_type' => 'furgoneta',
		'post_status' => 'publish',
		'post__not_in'     => $furgosReservades,
		'order' => 'ASC',
		'fields' => 'ids'
	);
	$furgosNoDisponibes = query_posts($args);
	return $furgosNoDisponibes;
}

function gestor_calc_price($preuDia, $dies){
	return ($preuDia * $dies);
}

function gestor_get_interval_days($diaIni, $diaFI){
	$date = str_replace('/', '-', $diaIni);
	$date2 = str_replace('/', '-', $diaFI);
	$dataI =  new DateTime($date);
	$dataF =  new DateTime($date2);
	$intervalDies = date_diff($dataI, $dataF);
	return intval($intervalDies->format('%R%a'));
}

function gestor_filter_season($temp) {
	$res = array();
	foreach ($temp as $e){
		array_push($res, $e);
	}

	return $res;
}