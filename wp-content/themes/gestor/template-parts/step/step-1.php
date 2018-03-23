<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 26/02/18
 * Time: 11:55
 */

$idFurgoneta = $_SESSION['info-reserva']['furgoneta'];
$components  = get_field( 'components', $idFurgoneta );
$accessoris  = get_field( 'accessoris', $idFurgoneta );

$page_reserva = get_field( 'page_reserva', 'options' );
?>
    <div class="content">
        <div class="page-title">
            <h2>El teu vehicle</h2>
        </div>
        <div class="available">
            <div class="row">
                <div class="info col-xs-6 col-sm-6 align-center-vertical-flex">
                    <img src="<?php echo get_the_post_thumbnail_url( $idFurgoneta ); ?>"/>
                </div>
                <div class="info desc col-xs-6 col-sm-6">
                    <div>
                        <h2><?php echo get_field( 'marca', $idFurgoneta ); ?></h2>
                        <h3><?php echo get_field( 'model', $idFurgoneta ); ?></h3>
                        <p class="more-info"><a href="<?php echo get_permalink( $idFurgoneta ); ?>" target="_blank">+
                                info</a></p>
                    </div>
                    <div class="info capacity">
                        <p>Capacitat per viatjar: <?php echo get_field( 'ocupants_reserva', $idFurgoneta ); ?>
                            persones<br>
                            Capacitat per dormir: <?php echo get_field( 'llits_reserva', $idFurgoneta ); ?> persones</p>
                    </div>
                    <div class="info">
						<?php if ( $components ) : ?>
							<?php if ( in_array( 'nevera', $components ) ) : ?>
                                <div data-aos="fade-right" data-aos-delay="80" class="block"><img
                                            src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/ico-square-freezer.svg' ?>"
                                            class="svg"/></div>
							<?php endif; ?>
							<?php if ( in_array( 'cuina', $components ) ) : ?>
                                <div data-aos="zoom-out" data-aos-delay="100" class="block"><img
                                            src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/ico-square-kitchen.svg' ?>"
                                            class="svg"/></div>
							<?php endif; ?>
							<?php if ( in_array( 'calefaccio', $components ) ) : ?>
                                <div data-aos="fade-left" data-aos-delay="80" class="block"><img
                                            src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/ico-square-heating.svg' ?>"
                                            class="svg"/></div>
							<?php endif; ?>
							<?php if ( in_array( 'dutxa', $components ) ) : ?>
                                <div data-aos="fade-left" data-aos-delay="160" class="block"><img
                                            src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/ico-square-shower.svg' ?>"
                                            class="svg"/></div>
							<?php endif; ?>
							<?php if ( in_array( 'lavabo', $components ) ) : ?>
                                <div data-aos="fade-left" data-aos-delay="240" class="block"><img
                                            src="<?php echo get_stylesheet_directory_uri() . '/assets/svg/ico-square-toilet.svg' ?>"
                                            class="svg"/></div>
							<?php endif; ?>
						<?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <form class="col-md-12" action="<?php echo get_permalink( $page_reserva ); ?>" method="post">

        <input type="hidden" name="action" value="reserva_form">
        <input type="hidden" name="step" value="2">

		<?php if ( $accessoris ) : ?>
            <div class="content-accessoris">
                <div class="page-title">
                    <h2>Accessoris</h2>
                </div>

                <div class="list-accessoris container">
                    <div class="row">
						<?php
						$i = 1;
						foreach ( $accessoris as $accessori ) :
							$accessori = $accessori['accessori'];
							setup_postdata( $accessori ); ?>
                            <div class="col-md-6 col-xs-3 item-accessori">
                                <img src="<?php echo get_the_post_thumbnail_url( $accessori ); ?>"/>
                                <div class="info">
                                    <div class="align-center-vertical-flex">
                                        <div>
                                            <h4><?php echo get_the_title( $accessori ); ?></h4>
                                            <p><?php echo get_field( 'preu_accessori', $accessori ); ?>€</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="checkbox" value="<?php echo $accessori; ?>" name="accessories[]"
                                       id="accessories-<?php echo $i; ?>">
                                <label for="accessories-<?php echo $i; ?>"></label>
                            </div>

							<?php $i ++; endforeach;
						wp_reset_postdata(); ?>
                    </div>

                </div>
            </div>
		<?php endif; ?>

        <button type="submit" class="btn btn-primary btn-lg button-reserva">SEGÜENT</button>

		<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>
    </form>



