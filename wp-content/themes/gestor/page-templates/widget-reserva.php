<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 21/02/18
 * Time: 9:23
 */
/* Template Name: widget-reserva */
get_header();

$_SESSION['user_id'] = get_current_user_id();

$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;
$page_reserva = get_field('page_reserva', 'options');
$furgos = get_posts(array(
        'post_type' => 'furgoneta',
        'post_status' => 'publish'
));


$id = wp_insert_post(array(
    'ID' => '860',
	'post_title'=>'test',
	'post_type'=>'reserva',
	'post_status'  => 'publish'
));
$dateI = gestor_createData('1/03/2018', 'd/m/Y');
$dateF = gestor_createData('8/03/2018', 'd/m/Y');

$postID = update_field('id_furgoneta', '800', $id);
$postID = update_field('data_inici', $dateI, $id);
$postID = update_field('data_fi', $dateF, $id);

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

                <div class="form-group row">
                    <label for="lloc-tornada" class="col-sm-2 col-form-label">Numero d'ocupants</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="ocupants" id="ocupants">
                            <option value="" selected disabled hidden>Escull una opció</option>
							<?php for($i =1;$i<=$numOcupants;$i++) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
                        </select>
                    </div>
                </div>
                    <div class="form-check row animals hide">

                        <label class="form-check-label" for="animals-check">
                            Viatges amb animals?
                        </label>
                        <div class="radio">
                            <label><input type="radio" name="opcio-animals" value="Yes">Si</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="opcio-animals" value="No">No</label>
                        </div>

                    </div>

                    <br>

                    <div class="form-group row hide">
                        <label for="furgoneta" class="col-sm-2 col-form-label">Tria la teva furgo</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="furgo">
                                <?php
                                global $post;
                                foreach($furgos as $post) : setup_postdata($post);  ?>
                                    <option value="<?php the_title(); ?>"><?php the_title(); ?></option>
                                <?php
                                wp_reset_postdata();
                                endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row hide">
                        <label for="data-ini" class="col-sm-2 col-form-label">Data inici</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="datepicker-ini" name="datepicker-ini" >
                        </div>
                    </div>

                    <div class="form-group row hide">
                        <label for="data-fi" class="col-sm-2 col-form-label">Data Fi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="datepicker-fi" name="datepicker-fi" >
                        </div>
                    </div>

                    <?php $llocText = ""; $llocName = "";
                    for($i = 0;$i<2;$i++) :
                        if($i == 0):  $llocText ='recollida'; $llocName = 'Lloc de recollida';
                        else: $llocText = 'tornada'; $llocName = 'Lloc de tornada'; endif;
                        ?>
                        <div class="form-group row hide">
                            <label for="lloc-<?php echo $llocText; ?>" class="col-sm-2 col-form-label">
                                <?php echo $llocName; ?>
                            </label>
                            <div class="col-sm-10">
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

                    <button type="submit" class="btn btn-primary btn-lg hide">CERCAR</button>

				<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>
			</form>

		</div>

	</div>






<?php get_footer(); ?>