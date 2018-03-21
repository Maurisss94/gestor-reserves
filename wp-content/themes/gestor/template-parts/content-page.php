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
	$furgoneta = filter_input(INPUT_POST, 'furgo');
	$diaIni = filter_input(INPUT_POST, 'datepicker-ini');
	$diaFI = filter_input(INPUT_POST, 'datepicker-fi');
	$llocRecollida = filter_input(INPUT_POST, 'opcio-recollida');
	$llocRetorn = filter_input(INPUT_POST, 'opcio-tornada');
	$ocupants = filter_input(INPUT_POST, 'ocupants');
	$animals = filter_input(INPUT_POST, 'animals-check') == 'Yes' ? 1 : 0;

	$data_filter = gestor_check_datas($diaIni, $diaFI);
	$llocRecollida_filter = gestor_check_llocs($llocRecollida, $optionsRecollida);
	$llocRetorn_filter = gestor_check_llocs($llocRetorn, $optionsRecollida);

	$_SESSION['info-reserva'] = array(
	    'furgoneta' => $furgoneta,
	    'dia-inici' => $diaIni,
        'dia-fi' => $diaFI,
        'lloc-recollida' => $llocRecollida_filter,
        'lloc-retorn' => $llocRetorn_filter,
        'ocupants' => $ocupants,
        'animals' => $animals
    );

    //TODO: Comprovar que els filtres estan correctes, sino redireccionar.

    var_dump($_SESSION);
?>


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
        <?php get_template_part('template-parts/step/search-results'); ?>
        <?php get_template_part('template-parts/resume-form'); ?>
    </div>

</div>


<?php


    ?>
<?php endif ?>