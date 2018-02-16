<?php
/**
 * Created by PhpStorm.
 * User: mauro
 * Date: 16/02/18
 * Time: 10:49
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title><?php bloginfo('name'); ?></title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php get_template_part('template-parts/navbar'); ?>
