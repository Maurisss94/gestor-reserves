<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 21/02/18
 * Time: 9:23
 */
/* Template Name: widget-reserva */
get_header();

$_form_step = filter_input(INPUT_POST, 'step', FILTER_SANITIZE_NUMBER_INT);
$_form_step = $_form_step === null ? -1 : $_form_step;

$_SESSION['user_id'] = get_current_user_id();

$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;
$temporades = get_field('temporades', 'option') ? get_field('temporades', 'option') : array();
$page_reserva = get_field('page_reserva', 'options');
$temps = array();

//TODO: REcollir temporades, es podria fer millor
$t1 = $temporades["temporada_1"]["rangs_temporada_t1"];
$t2 = $temporades["temporada_2"]["rangs_temporada_t2"];
$t3 = $temporades["temporada_3"]["rangs_temporada_t3"];
$t4 = $temporades["temporada_4"]["rangs_temporada_t4"];

$t1Filtrada = gestor_filter_season($t1);
$t2Filtrada = gestor_filter_season($t2);
$t3Filtrada = gestor_filter_season($t3);
$t4Filtrada = gestor_filter_season($t4);
array_push($temps, $t1Filtrada, $t2Filtrada, $t3Filtrada, $t4Filtrada);
$tempFiltrada = json_encode($temps);




//Test per insertar dos reserves
$id = wp_insert_post(array(
    'ID' => '860',
	'post_title'=>'test',
	'post_type'=>'reserva',
	'post_status'  => 'publish'
));
$dateI = gestor_createData('18/03/2018', 'd/m/Y');
$dateF = gestor_createData('24/03/2018', 'd/m/Y');

$postID = update_field('id_furgoneta', '135', $id);
$postID = update_field('data_inici', $dateI, $id);
$postID = update_field('data_fi', $dateF, $id);

$id = wp_insert_post(array(
	'ID' => '861',
	'post_title'=>'test1',
	'post_type'=>'reserva',
	'post_status'  => 'publish'
));
$dateI = gestor_createData('25/03/2018', 'd/m/Y');
$dateF = gestor_createData('28/03/2018', 'd/m/Y');

$postID = update_field('id_furgoneta', '135', $id);
$postID = update_field('data_inici', $dateI, $id);
$postID = update_field('data_fi', $dateF, $id);

if ($_form_step === -1) {
	$_form_step = 1;
}

?>

	<div class="container">
		<div class="py-5 text-center">
			<img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
			<h2><?php the_title(); ?></h2>
			<p class="lead">Reserva la teva furgoneta</p>
		</div>

		<div class="row">
			<form class="col-md-12" action="<?php echo get_permalink($page_reserva); ?>" method="post">

				<input type="hidden" name="action" value="reserva_form">
				<input type="hidden" name="step" value="1">

                <div class="form-group row">
                    <label for="lloc-tornada" class="col-sm-3 col-form-label">Numero d'ocupants</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="ocupants" id="ocupants">
                            <option value="" selected disabled hidden>Escull una opció</option>
							<?php for($i =1;$i<=$numOcupants;$i++) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
                        </select>
                    </div>
                </div>
                    <div class="form-group row animals hide">

                        <label class="col-sm-3 col-form-label" for="animals-check">
                            Viatges amb animals?
                        </label>
                        <div class="col-sm-4">
                            <label><input type="radio" name="opcio-animals" value="Yes">Si</label>
                        </div>
                        <div class="col-sm-4">
                            <label><input type="radio" name="opcio-animals" value="No">No</label>
                        </div>

                    </div>

                    <br>

                    <div class="form-group row furgos hide">
                        <label for="furgoneta" class="col-sm-3 col-form-label">Furgonetes disponibles</label>
                        <div class="col-sm-9">
                            <select class="form-control select-furgos selectpicker" name="furgo">
                            </select>
                        </div>
                    </div>

                    <div class="form-group row calendar-ini hide">
                        <label for="data-ini" class="col-sm-3 col-form-label">Data inici</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="datepicker-ini" name="datepicker-ini" >
                        </div>
                    </div>

                    <div class="form-group row calendar-fi hide">
                        <label for="data-fi" class="col-sm-3 col-form-label">Data Fi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="datepicker-fi" name="datepicker-fi" >
                        </div>
                    </div>

                    <?php $llocText = ""; $llocName = "";
                    for($i = 0;$i<2;$i++) :
                        if($i == 0):  $llocText ='recollida'; $llocName = 'Lloc de recollida';
                        else: $llocText = 'tornada'; $llocName = 'Lloc de tornada'; endif;
                        ?>
                        <div class="form-group row llocs-recollida-retorn  hide">
                            <label for="lloc-<?php echo $llocText; ?>" class="col-sm-3 col-form-label">
                                <?php echo $llocName; ?>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control" name="opcio-<?php echo $llocText; ?>">
                                    <?php
                                    if ( $optionsRecollida ) :  $j=1;
                                        foreach ( $optionsRecollida as $opcio ): ?>
                                            <option value="<?php echo $j; ?>"><?php echo $opcio['nom_lloc'] . ' ('.$opcio['preu_lloc'].'€)'; ?></option>
                                        <?php  $j++; endforeach;
                                    else :?>
                                        <option>No disposem de llocs de recollida</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <button type="submit" class="btn btn-primary btn-lg hide button-reserva">RESERVA</button>

				<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>
			</form>

		</div>

	</div>
<script>
    var temporades  = <?php echo $tempFiltrada; ?>;
</script>




<?php get_footer(); ?>