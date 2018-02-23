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

//Mirem si hi han reserves amb aquestes dates..
$d1 = gestor_createData($diaIni, 'd/m/Y');
$d2 = gestor_createData($diaFI, 'd/m/Y');
$argsReserva = array(
	'post_type' => 'reserva',
	'post_status' => 'publish',
	'meta_query' => array(
		'relation'		    => 'AND',
		array(
			'key'		=> 'data_fi',
			'compare'	=> '>=',
			'value'	=> $d1,
			'type'          => 'DATE',
		),
		 array(
			 'key'		=> 'data_inici',
			 'compare'	=> '<=',
             'value'	=> $d1,
             'type'         => 'DATE',
		 ),

    ),
    'fields' => 'ids'
);
$reserves = query_posts($argsReserva);
var_dump($reserves);

    ?>
<div class="container">

    <div class="progress-container">
        <div class="progress" style="height: 25px; margin-top: 50px">
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="5" style="width: 20%;" >
                Step 1 of 5
            </div>
        </div>

        <div class="navbar steps">
            <div class="navbar-inner">
                <ul class="nav nav-pills">
                    <li class="active"><a href="#step1" data-toggle="tab" data-step="1">Vehicle</a></li>
                    <li><a href="#step2" data-toggle="tab" data-step="2">Accessoris</a></li>
                    <li><a href="#step3" data-toggle="tab" data-step="3">Extres</a></li>
                    <li><a href="#step4" data-toggle="tab" data-step="4">La meva informació</a></li>
                    <li><a href="#step5" data-toggle="tab" data-step="5">Pagament</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8" id="">
            <p>Content dinamic1</p>

        </div>

        <div class="col-md-4 ml-auto" id="info-reserva">
            <div class="card">
                <div class="card-body">
                    <h3>La meva reserva</h3>
                    <h5 class="card-title">Dates</h5>
                    <p class="card-text"><?php echo $diaIni . ' -> ' . $diaFI; ?>
                    </p>

                    <h5 class="card-title">Lloc d'entrega i retorn</h5>
                    <p class="card-text"><?php echo $llocRecollida_filter['nom']; ?>
                        <br>
	                    <?php echo $llocRetorn_filter['nom']; ?>
                    </p>

                    <h5 class="card-title">Número d'ocupants</h5>
                    <p class="card-text"><?php echo $ocupants; ?></p>

                    <h5 class="card-title">Viatges amb animals?</h5>
                    <p class="card-text"><?php echo $animals == 1 ? 'Yes': 'No'; ?></p>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
//Comprovar que els filtres estan correctes, sino redireccionar.
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
	$furgosDisponibes = query_posts($args);
	var_dump($furgosDisponibes);

    ?>
<?php endif ?>