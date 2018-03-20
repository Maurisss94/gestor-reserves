<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 26/02/18
 * Time: 11:55
 */


$idFurgoneta = $_SESSION['info-reserva']['furgoneta'];
$diesIntervals = $_SESSION['info-reserva']['num-dies-reserva'];
$diaInici = $_SESSION['info-reserva']['dia-inici'];
$diaFi = $_SESSION['info-reserva']['dia-fi'];
$temporades = get_field('temporades', 'option') ? get_field('temporades', 'option') : array();


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

$components = get_field('components', $idFurgoneta);
var_dump($components);
?>

<div class="col-md-8" id="">

	<div class="page-title">
		<h2>El teu vehicle</h2>
		<div class="content">
				<div class="available">
					<div class="row">
						<div class="info col-xs-6 col-sm-6 align-center-vertical-flex">
							<img src="<?php echo get_the_post_thumbnail_url($idFurgoneta); ?>" />
						</div>
						<div class="info desc col-xs-6 col-sm-6">
							<div>
								<h2><?php echo get_field('marca', $idFurgoneta); ?></h2>
								<h3><?php echo get_field('model', $idFurgoneta); ?></h3>
								<p class="more-info"><a href="<?php echo get_permalink(); ?>" target="_blank">+ info</a></p>
							</div>
							<div class="info capacity">
								<p>Capacitat per viatjar: <?php echo get_field('ocupants_reserva', $idFurgoneta); ?> persones<br>
									Capacitat per dormir: <?php echo get_field('llits_reserva', $idFurgoneta); ?> persones</p>
							</div>
                            <div class="info">
	                            <?php if($components) : ?>
		                            <?php if(in_array('nevera', $components)) : ?>
                                        <div data-aos="fade-right" data-aos-delay="80" class="block"><img src="<?php echo get_stylesheet_directory_uri() .  '/assets/svg/ico-square-freezer.svg'?>" class="svg"/></div>
		                            <?php endif; ?>
		                            <?php if(in_array('cuina', $components)) : ?>
                                        <div data-aos="zoom-out" data-aos-delay="100" class="block"><img src="<?php echo get_stylesheet_directory_uri() .  '/assets/svg/ico-square-kitchen.svg'?>" class="svg"/></div>
		                            <?php endif; ?>
		                            <?php if(in_array('calefaccio', $components)) : ?>
                                        <div data-aos="fade-left" data-aos-delay="80" class="block"><img src="<?php echo get_stylesheet_directory_uri() .  '/assets/svg/ico-square-heating.svg'?>" class="svg"/></div>
		                            <?php endif; ?>
		                            <?php if(in_array('dutxa', $components)) : ?>
                                        <div data-aos="fade-left" data-aos-delay="160" class="block"><img src="<?php echo get_stylesheet_directory_uri() .  '/assets/svg/ico-square-shower.svg'?>" class="svg"/></div>
		                            <?php endif; ?>
		                            <?php if(in_array('lavabo', $components)) : ?>
                                        <div data-aos="fade-left" data-aos-delay="240" class="block"><img src="<?php echo get_stylesheet_directory_uri() .  '/assets/svg/ico-square-toilet.svg'?>" class="svg"/></div>
		                            <?php endif; ?>
	                            <?php endif; ?>
                            </div>
							<div class="info">
								<div class="success">
									<a href="" class="preu-furgo">
										<span>Reservar per</span><br>
										<span class="preu"><?php echo gestor_calc_price(get_field('preu_dia', $idFurgoneta), $diesIntervals);?></span>
										<span>€</span>
									</a>
								</div>
							</div>
						</div>

					</div>
				</div>
		</div>
	</div>

</div>


