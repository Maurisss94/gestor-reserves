<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 21/02/18
 * Time: 9:23
 */
/* Template Name: widget-reserva */
get_header();

$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;
$page_reserva = get_field('page_reserva', 'options');
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
					<label for="data-ini" class="col-sm-2 col-form-label">Data inici</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="datepicker-ini" name="datepicker-ini" value="">
					</div>
				</div>
				<div class="form-group row">
					<label for="data-fi" class="col-sm-2 col-form-label">Data Fi</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="datepicker-fi" name="datepicker-fi" value="">
					</div>
				</div>

				<?php $llocText = ""; $llocName = "";
				for($i = 0;$i<2;$i++) :
					if($i == 0):  $llocText ='recollida'; $llocName = 'Lloc de recollida';
					else: $llocText = 'tornada'; $llocName = 'Lloc de tornada'; endif;
					?>
					<div class="form-group row">
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

				<div class="form-group row">
					<label for="lloc-tornada" class="col-sm-2 col-form-label">Numero d'ocupants</label>
					<div class="col-sm-10">
						<select class="form-control" name="ocupants">
							<?php for($i =1;$i<=$numOcupants;$i++) : ?>
								<option  value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
						</select>
					</div>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" name="animals-check" value="Yes" id="animals-check">
					<label class="form-check-label" for="animals-check">
						Viatges amb animals?
					</label>
				</div>
				<br>
				<br>

				<button type="submit" class="btn btn-primary btn-lg">CERCAR</button>

				<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>
			</form>

		</div>

	</div>






<?php get_footer(); ?>