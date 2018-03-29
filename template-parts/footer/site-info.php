<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<div class="site-info">
	<?php
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		echo '<a href="/impressum/">Impressum</a>';
	} else {
		echo '<a href="' . get_home_url(). '">Start</a> | <a href="/impressum/">Impressum</a>';
	}
	?>
</div><!-- .site-info -->
