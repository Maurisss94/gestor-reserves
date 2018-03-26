<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 21/03/18
 * Time: 8:39
 */

$temporades = get_field( 'temporades', 'option' ) ? get_field( 'temporades', 'option' ) : array();
$temps      = array();
global $accessories, $_form_step, $horaInici, $horaFi;
//TODO: REcollir temporades, es podria fer millor
$t1 = $temporades["temporada_1"]["rangs_temporada_t1"];
$t2 = $temporades["temporada_2"]["rangs_temporada_t2"];
$t3 = $temporades["temporada_3"]["rangs_temporada_t3"];
$t4 = $temporades["temporada_4"]["rangs_temporada_t4"];

$t1Filtrada = gestor_filter_season( $t1 );
$t2Filtrada = gestor_filter_season( $t2 );
$t3Filtrada = gestor_filter_season( $t3 );
$t4Filtrada = gestor_filter_season( $t4 );
array_push( $temps, $t1Filtrada, $t2Filtrada, $t3Filtrada, $t4Filtrada );

$diaIni        = $_SESSION['info-reserva']['dia-inici'];
$diaFi         = $_SESSION['info-reserva']['dia-fi'];
$llocRecollida = $_SESSION['info-reserva']['lloc-recollida'];
$llocRetorn    = $_SESSION['info-reserva']['lloc-retorn'];
$ocupants      = $_SESSION['info-reserva']['ocupants'];
$animals       = $_SESSION['info-reserva']['animals'];
$furgoneta     = $_SESSION['info-reserva']['furgoneta'];

$mapPreus = gestor_checkSeason( $diaIni, $diaFi, $temps, $furgoneta );
?>
<div class="card">
    <div class="card-body">
        <h3>La meva reserva</h3>

		<?php if ( $_form_step >= 2 ) : ?>
            <img src="<?php echo get_the_post_thumbnail_url( $furgoneta ); ?>"
                 style="width: 100%; margin-bottom: 10px;"/>
            <h5 class="card-title">Furgoneta</h5>
            <p class="card-text"><?php echo get_field( 'marca', $furgoneta ); ?>
                 <?php echo get_field( 'model', $furgoneta ); ?></p>
		<?php endif; ?>


        <h5 class="card-title">Dates</h5>
        <p class="card-text">
			<?php echo $diaIni . ' &rarr; ' . $diaFi; ?>
        </p>

        <h5 class="card-title">Lloc d'entrega i retorn</h5>
        <p class="card-text"><?php echo $llocRecollida['nom'] . ' (' . $llocRecollida['preu'] . '€)'; ?>
            <?php if($horaInici):
                echo ' &rarr; ' . $horaInici . 'H.';
            endif; ?>
            <br>
			<?php echo $llocRetorn['nom'] . ' (' . $llocRetorn['preu'] . '€)'; ?>
	        <?php if($horaFi):
		        echo ' &larr; ' . $horaFi . 'H.';
	        endif; ?>
        </p>

        <h5 class="card-title">Número d'ocupants</h5>
        <p class="card-text"><?php echo $ocupants; ?></p>

        <h5 class="card-title">Viatges amb animals?</h5>
        <p class="card-text"><?php echo $animals == 1 ? 'Yes' : 'No'; ?></p>

		<?php if ( $accessories ) : ?>
            <h5 class="card-title">Accessoris</h5>
            <ul style="list-style: none;margin: 0;padding:0">
				<?php foreach ( $accessories as $accesori ): ?>
                    <li><?php echo $accesori['title'] . ' ' .  $accesori['price']. '€' ?></li>
				<?php endforeach; ?>
            </ul>
		<?php endif; ?>
    </div>
    <div class="card-footer">
        <div class="price">Preu total:
            <span><?php echo gestor_calc_price( $mapPreus, $llocRecollida, $llocRetorn, $accessories ); ?>€</span>
        </div>
    </div>
</div>
