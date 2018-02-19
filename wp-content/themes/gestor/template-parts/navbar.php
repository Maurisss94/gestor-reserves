<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 10:58
 */
 ?>

<nav class="navbar navbar-dark bg-dark">

	<a class="navbar-brand" href="<?php home_url(); ?>"><?php bloginfo('name'); ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<?php
		wp_nav_menu(array(
			'menu' => 'main-menu',
			'menu_class' => 'navbar-nav mr-auto',
			'container' => '',
		));
		?>
	</div>

</nav>
