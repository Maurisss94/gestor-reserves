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
	$diesIntervals = gestor_get_interval_days($diaIni, $diaFI);
	$llocRecollida_filter = gestor_check_llocs($llocRecollida, $optionsRecollida);
	$llocRetorn_filter = gestor_check_llocs($llocRetorn, $optionsRecollida);

	$_SESSION['info-reserva'] = array(
	    'dia-inici' => $diaIni,
        'dia-fi' => $diaFI,
        'lloc-recollida' => $llocRecollida_filter,
        'lloc-retorn' => $llocRetorn_filter,
        'num-dies-reserva' => $diesIntervals,
    );
	//var_dump($llocRecollida_filter['nom']);

    //Comprovar que els filtres estan correctes, sino redireccionar.

//Mirem si hi han reserves amb aquestes dates i les obtenim..
$furgosReservades = gestor_get_reserved_vans($diaIni, $diaFI);
//var_dump("Furgonetes Reservades", $furgosReservades);

$furgosDisponibes = gestor_get_available_vans($animals, $ocupants, $furgosReservades);
//var_dump("Furgonetes Disponibles", $furgosDisponibes);

$furgosNoDisponibles = gestor_get_unavailable_vans($furgosDisponibes);
//var_dump("Furgonetes NO Disponibles", $furgosNoDisponibles);

var_dump($_SESSION);
?>

<!--<form>-->
<!--    --><?php
//    foreach ($_POST AS $k => $v) {
//        echo '<input type="hidden" name="'.esc_attr($k).'" value="'.esc_attr($v).'">';
//    }
//    ?>
<!--</form>-->

<div class="container reserva">

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

            <div class="page-title">
                <h2>Tria el teu vehicle</h2>
                <p>Consulta la disponibilitat de les furgonetes camper pels dies que t'interessen</p>
                <div class="content">
                    <div class="row header hidden-xs">
                        <div class="col-xs-6 col-sm-3">Camper</div>
                        <div class="col-xs-6 col-sm-3">Descripció</div>
                        <div class="col-xs-6 col-sm-3">Capacitat</div>
                        <div class="col-xs-6 col-sm-3">Preu</div>
                    </div>
                    <?php foreach ($furgosDisponibes as $furgo): ?>
                    <div class="available">
                        <div class="row">
                            <div class="info col-xs-6 col-sm-3 align-center-vertical-flex">
                                <img src="<?php echo get_the_post_thumbnail_url($furgo); ?>" />
                            </div>
                            <div class="info desc col-xs-6 col-sm-3">
                                <div>
                                    <h4><?php echo get_field('marca', $furgo); ?></h4>
                                    <p><?php echo get_field('descripcio_reserva', $furgo); ?></p>
                                    <p class="more-info"><a href="<?php echo get_permalink($furgo); ?>" target="_blank">+ info</a></p>
                                </div>
                            </div>
                            <div class="info capacity col-xs-6 col-sm-3 hidden-xs">
                                <p>Capacitat per viatjar: <?php echo get_field('ocupants_reserva', $furgo); ?> persones<br>
                                    Capacitat per dormir: <?php echo get_field('llits_reserva', $furgo); ?> persones</p>
                            </div>
                            <div class="info col-xs-12 col-sm-3">
                                <div class="success">
                                    <a href="" class="preu-furgo">
                                        <span>Reservar per</span><br>
                                        <span class="preu"><?php echo gestor_calc_price(get_field('preu_dia', $furgo), $diesIntervals);?></span>
                                        <span>€</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="page-title">
                <h2>Vehicles no disponibles</h2>
                <p>Els següents vehicles no estan disponibles per a les dates que has seleccionat</p>
            </div>
            <div class="content">
                <div class="row header hidden-xs">
                    <div class="col-xs-6 col-sm-3">Camper</div>
                    <div class="col-xs-6 col-sm-3">Descripció</div>
                    <div class="col-xs-6 col-sm-3">Capacitat</div>
                    <div class="col-xs-6 col-sm-3">Preu</div>
                </div>
		        <?php foreach ($furgosNoDisponibles as $furgo): ?>
                    <div class="unavailable">
                        <div class="row">
                            <div class="info col-xs-6 col-sm-3 align-center-vertical-flex">
                                <img src="<?php echo get_the_post_thumbnail_url($furgo); ?>" />
                            </div>
                            <div class="info desc col-xs-6 col-sm-3">
                                <div>
                                    <h4><?php echo get_field('marca', $furgo); ?></h4>
                                    <p><?php echo get_field('descripcio_reserva', $furgo); ?></p>
                                    <p class="more-info"><a href="<?php echo get_permalink($furgo); ?>" target="_blank">+ info</a></p>
                                </div>
                            </div>
                            <div class="info capacity col-xs-6 col-sm-3 hidden-xs">
                                <p>Capacitat per viatjar: <?php echo get_field('ocupants_reserva', $furgo); ?> persones<br>
                                    Capacitat per dormir: <?php echo get_field('llits_reserva', $furgo); ?> persones</p>
                            </div>
                            <div class="info col-xs-12 col-sm-3">
                                <div class="success">

                                        <div>
                                            No disponible
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>

		        <?php endforeach; ?>
            </div>


        </div>

        <div class="col-md-4 ml-auto" id="info-reserva">
            <div class="card">
                <div class="card-body">
                    <h3>La meva reserva</h3>
                    <h5 class="card-title">Dates</h5>
                    <p class="card-text">
                        <?php echo $diaIni . ' -> ' . $diaFI; ?>
                    </p>

                    <h5 class="card-title">Lloc d'entrega i retorn</h5>
                    <p class="card-text"><?php echo $llocRecollida_filter['nom'] . ' ('.$llocRetorn_filter['preu'] . '€)'; ?>
                        <br>
	                    <?php echo $llocRetorn_filter['nom'] . ' ('.$llocRetorn_filter['preu'] . '€)'; ?>
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


    ?>
<?php endif ?>