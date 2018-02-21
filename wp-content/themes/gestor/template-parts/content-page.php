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

	var_dump($_POST);

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

	$id = wp_insert_post(array(
	        'post_title'=>'test',
            'post_type'=>'reserva',
            'post_content'=>'demo text',

    ));


    ?>
<div>

</div>

<?php endif ?>