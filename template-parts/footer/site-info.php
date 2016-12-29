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
	<a href="<?php echo esc_url( __( get_bloginfo( 'url' ), 'twentyseventeen' ) ); ?>"><?php printf( __( 'A project by %s', 'twentyseventeen' ), get_bloginfo( 'name ') ); ?></a>
</div><!-- .site-info -->
