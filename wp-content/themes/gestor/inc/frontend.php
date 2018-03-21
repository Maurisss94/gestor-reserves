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

function gestor_calc_price($mapPreus){
	$nDies = 0;
	$prices = 0;
	foreach ($mapPreus as $preus) {
		$nDies += $preus['num-dies'];
		$prices +=  $preus['preu'];
	}
	return ($nDies * $prices);
}

function gestor_get_interval_days($diaIni, $diaFI){
	$intervalDies = date_diff($diaIni, $diaFI);
	return intval($intervalDies->format('%R%a'))+ 1;
}

function gestor_filter_season($temp) {
	$res = array();
	foreach ($temp as $e){
		array_push($res, $e);
	}

	return $res;
}
function gestor_get_datetime($d, $type){
	return date_create_from_format($type, $d);
}
function checkSeason($dIni, $dFi, $t, $furgoneta) {
	$preuT1 = get_field('preu_dia_t1', $furgoneta);
	$preuT2 = get_field('preu_dia_t2', $furgoneta);
	$preuT3 = get_field('preu_dia_t3', $furgoneta);
	$preuT4 = get_field('preu_dia_t4', $furgoneta);
	$res = array(
		't1' => array(),
		't2' => array(),
		't3' => array(),
		't4' => array()
	);
	$dateTime1 = gestor_get_datetime($dIni, 'd/m/Y');
	$dateTime2 = gestor_get_datetime($dFi, 'd/m/Y');
	$diesTotals = gestor_get_interval_days($dateTime1, $dateTime2);

	$tempActual = 1; $numDies = 0;
	foreach ($t as $temp){
		foreach ($temp as $item) {
			$dateToCompareIni = gestor_get_datetime($item['data_inici'], 'm/d/Y');
			$dateToCompareFi = gestor_get_datetime($item['data_fi'], 'm/d/Y');
			$dataActual = clone $dateTime1;

			for($i = 0;$i < $diesTotals;$i++) {

				if($dataActual >= $dateToCompareIni and $dataActual <= $dateToCompareFi){
					$numDies++;
					switch ($tempActual) {
						case 1:
							$res['t1'] = array(
								'preu' => $preuT1,
								'num-dies' => $numDies
							);
							break;
						case 2:
							$res['t2'] = array(
								'preu' => $preuT2,
								'num-dies' => $numDies
							);
							break;
						case 3:
							$res['t3'] = array(
								'preu' => $preuT3,
								'num-dies' => $numDies
							);
							break;
						case 4:
							$res['t4'] = array(
								'preu' => $preuT4,
								'num-dies' => $numDies
							);
							break;
					}
				}
				date_add($dataActual, date_interval_create_from_date_string('1 day'));

			}
			$numDies = 0;

		}
		$tempActual++;
	}
	return $res;
}