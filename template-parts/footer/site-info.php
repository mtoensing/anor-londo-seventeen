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
    $GDPR_page = '';

	if($GDPR_page_id = get_page_by_title( 'Datenschutzerklärung') ) {
		$GDPR_page = '| <a href="' . get_page_link($GDPR_page_id) . '">Datenschutz</a>';
	} elseif ( $GDPR_page_id = get_page_by_title( 'Data Protection Policy') ) {
		$GDPR_page = ' | <a href="' . get_page_link($GDPR_page_id) . '">Data Protection Policy</a>';
	}

	?>
    <a href="<?php echo get_home_url(); ?>">Start</a> | <a href="/impressum/">Impressum</a> <?php echo $GDPR_page; ?>

</div><!-- .site-info -->
