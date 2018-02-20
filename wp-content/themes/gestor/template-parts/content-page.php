<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 11:12
 */

$optionsRecollida = get_field('lloc_recollida_tornada', 'option') ? get_field('lloc_recollida_tornada', 'option') : array();
$numOcupants = get_field('num_ocupants_maxim', 'options') ? get_field('num_ocupants_maxim', 'options') : 6;
?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2><?php the_title(); ?></h2>
        <p class="lead">Reserva la teva furgoneta</p>
    </div>

    <div class="row">
        <form class="col-md-12" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">

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

            <?php for($i = 0;$i<2;$i++) : ?>
            <div class="form-group row">
                <label for="lloc-tornada" class="col-sm-2 col-form-label">
                    <?php   if($i == 0): echo 'Lloc de recollida';
                            else: echo 'Lloc de tornada';
                            endif;
                    ?>
                </label>
                <div class="col-sm-10">
                    <select class="form-control" name="opcio-<?php if($i == 0): echo 'recollida';
                    else: echo 'tornada'; endif; ?>">
	                    <?php
	                    if ( $optionsRecollida ) :
		                    foreach ( $optionsRecollida as $opcio ): ?>
                                <option value="<?php echo $opcio['nom_lloc']; ?>"><?php echo $opcio['nom_lloc'] . ' ('.$opcio['preu_lloc'].'€)'; ?></option>
		                    <?php endforeach;
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
        </form>

    </div>

</div>