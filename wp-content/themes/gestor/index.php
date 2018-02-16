<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 12/02/18
 * Time: 11:22
 */

get_header(); ?>

<div class="container p-t-lg-1">
	<div class="row">
		<?php if(have_posts()):
			while(have_posts()):
				the_post();
				get_template_part('template-parts/content', get_post_type());
			endwhile;
		else:
			get_template_part('template-parts/content', 'none');
		endif;  ?>
	</div>
	<?php get_template_part('template-parts/pagination');  ?>
</div>


<?php get_footer(); ?>
