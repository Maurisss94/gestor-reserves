<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 22/03/18
 * Time: 10:07
 */

$hores        = get_field( 'hores_retorn_recollida', 'options' );
$asseguranca  = get_field( 'asseguranca', 'options' );
$page_reserva = get_field( 'page_reserva', 'options' );

global $_form_step;
?>

<div class="content">
	<?php if ( $hores ) : ?>
    <div class="page-title">
        <h2>Recollida / Entrega</h2>
    </div>
    <form action="<?php echo get_permalink( $page_reserva ); ?>" method="post">
        <input type="hidden" name="action" value="reserva_form">
        <input type="hidden" name="step" value="3">

        <div class="row">
            <div class="col-md-6">
                <label for="select-hora-inici">Hora recollida</label>
                <select class="form-control " name="opcio-hora_inici" id="select-hora-inici">
					<?php foreach ( $hores['hora_inici'] as $hora ) : ?>
                        <option value="<?php echo $hora['hora']; ?>"><?php echo $hora['hora']; ?> H.</option>
					<?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="select-hora-fi">Hora retorn</label>
                <select class="form-control" name="opcio-hora_fi" id="select-hora-fi">
					<?php ?>
					<?php foreach ( $hores['hora_fi'] as $hora ) : ?>
                        <option value="<?php echo $hora['hora']; ?>"><?php echo $hora['hora']; ?> H.</option>
					<?php endforeach; ?>
					<?php ?>
                </select>
            </div>

            <div class="asseguranca col-md-12" style="margin-top: 25px;">
				<?php if ( $asseguranca ): ?>
                    <div class="page-title">
                        <h2>Assegurança</h2>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="check-asseguranca"
                               name="check-asseguranca">
                        <label class="form-check-label" for="check-asseguranca">
							<?php echo $asseguranca['text_asseguranca']; ?><br>
                            <a href="<?php echo $asseguranca['document']; ?>" target="_blank">Document de
                                assegurança</a>
                        </label>
                    </div>

                <?php if(!$_POST['check-asseguranca'] && $_POST['step'] == '3'): ?>
                    <p>MARCA LA CASELLA</p>
                <?php endif; ?>
				<?php endif; ?>
            </div>

        </div>

        <button type="submit" class="btn btn-primary btn-lg button-reserva">SEGÜENT</button>
		<?php wp_nonce_field( 'post_form_reserva', 'nonce_field' ); ?>

    </form>
</div>
<?php endif; ?>


