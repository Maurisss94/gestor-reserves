<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 11:12
 */

global $accessories, $_form_step, $horaInici, $horaFi;

$_form_step = filter_input(INPUT_POST, 'step', FILTER_SANITIZE_NUMBER_INT);
$_form_step = $_form_step === null ? -1 : intval($_form_step);


$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;

if(!isset( $_POST['nonce_field']) || !wp_verify_nonce( $_POST['nonce_field'], 'post_form_reserva' )) :
	print 'Sorry, your nonce did not verify.';
	exit;
else:
	if($_form_step === 1) {
		$furgoneta     = filter_input( INPUT_POST, 'furgo' );
		$diaIni        = filter_input( INPUT_POST, 'datepicker-ini' );
		$diaFI         = filter_input( INPUT_POST, 'datepicker-fi' );
		$llocRecollida = filter_input( INPUT_POST, 'opcio-recollida' );
		$llocRetorn    = filter_input( INPUT_POST, 'opcio-tornada' );
		$ocupants      = filter_input( INPUT_POST, 'ocupants' );
		$animals       = filter_input( INPUT_POST, 'animals-check' ) == 'Yes' ? 1 : 0;

		$llocRecollida_filter = gestor_check_llocs( $llocRecollida, $optionsRecollida );
		$llocRetorn_filter    = gestor_check_llocs( $llocRetorn, $optionsRecollida );

		$_SESSION['info-reserva'] = array(
			'furgoneta'      => $furgoneta,
			'dia-inici'      => $diaIni,
			'dia-fi'         => $diaFI,
			'lloc-recollida' => $llocRecollida_filter,
			'lloc-retorn'    => $llocRetorn_filter,
			'ocupants'       => $ocupants,
			'animals'        => $animals
		);

	}else if($_form_step > 1) {
		$sessio                 = $_SESSION['info-reserva'];
		$furgoneta              = $sessio['furgoneta'];
		$diaIni                 = $sessio['dia-inici'];
		$diaFI                  = $sessio['dia-fi'];
		$llocRecollida          = $sessio['lloc-recollida'];
		$llocRetorn             = $sessio['lloc-retorn'];
		$ocupants               = $sessio['ocupants'];
		$animals                = $sessio['animals'] == 'Yes' ? 1 : 0;
		if(!empty($_POST['accessories'])){
			$accessorisSeleccionats = $_POST['accessories'];
			$accessories = gestor_get_accessories_of_van($accessorisSeleccionats);
        }
		if(!empty($_POST['opcio-hora_inici']) and !empty($_POST['opcio-hora_fi']) and $_POST['check-asseguranca']) {
		    $horaInici = $_POST['opcio-hora_inici'];
		    $horaFi = $_POST['opcio-hora_fi'];
        }

	}
	$data_filter = gestor_check_datas($diaIni, $diaFI);

	if ($_form_step === -1) {
	    $_form_step = 1;
    }

    //TODO: Comprovar que els filtres estan correctes, sino redireccionar.
	//var_dump($_SESSION);
?>


<div class="container reserva">

    <div class="progress-container">
        <ul id="progressbar">
            <li class="active">Personal Details</li>
            <li>Social Profiles</li>
            <li>Account Setup</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?php
            if(!$_POST['check-asseguranca'] && $_form_step == '3'){
                $_form_step = '2';
            }
            get_template_part('template-parts/step/step-'.intval($_form_step));

            ?>
        </div>
        <div class="col-md-4">
            <?php get_template_part('template-parts/resume-form'); ?>
        </div>
    </div>

</div>


<?php endif ?>