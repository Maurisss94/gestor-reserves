<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 26/03/18
 * Time: 8:31
 */

global $_form_step;

if(!$_POST['check-asseguranca'] && $_POST['step'] == '3'):
	$_form_step = 2;
endif;
?>

<div class="progress-container display-hidden-xs">
	<ul class="progressbar">
		<li class="<?php echo $_form_step >= 1 ? 'active' : ''; ?>">Accessoris</li>
		<li class="<?php echo $_form_step >= 2 ? 'active' : ''; ?>">Extres</li>
		<li class="<?php echo $_form_step >= 3 ? 'active' : ''; ?>">Dades reserva</li>
		<li class="<?php echo $_form_step >= 4 ? 'active' : ''; ?>">Pagar</li>
	</ul>
</div>
