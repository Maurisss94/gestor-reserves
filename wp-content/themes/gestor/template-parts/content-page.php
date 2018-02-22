<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 11:12
 */

$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;

if(!isset( $_POST['nonce_field']) || !wp_verify_nonce( $_POST['nonce_field'], 'post_form_reserva' )) :
	print 'Sorry, your nonce did not verify.';
	exit;
else:
	$diaIni = filter_input(INPUT_POST, 'datepicker-ini');
	$diaFI = filter_input(INPUT_POST, 'datepicker-fi');
	$llocRecollida = filter_input(INPUT_POST, 'opcio-recollida');
	$llocRetorn = filter_input(INPUT_POST, 'opcio-tornada');
	$ocupants = filter_input(INPUT_POST, 'ocupants');
	$animals = filter_input(INPUT_POST, 'animals-check') == 'Yes' ? 1 : 0;

	$data_filter = gestor_check_datas($diaIni, $diaFI);
	$llocRecollida_filter = gestor_check_llocs($llocRecollida, $optionsRecollida);
	$llocRetorn_filter = gestor_check_llocs($llocRetorn, $optionsRecollida);
	//var_dump($llocRecollida_filter['nom']);
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
		),
		'order' => 'ASC',
		'fields' => 'ids'
	);
	$furgosDisponibes = query_posts($args);
	var_dump($furgosDisponibes);

//	$id = wp_insert_post(array(
//	        'post_title'=>'test',
//            'post_type'=>'reserva',
//            'post_content'=>'demo text',
//            'post_status'  => 'publish',
//
//    ));


    ?>
<div>
<h1>RESERVA</h1>
</div>

<?php endif ?>