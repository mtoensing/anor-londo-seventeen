<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if (is_sticky() && is_home()) :
		echo twentyseventeen_get_svg(array( 'icon' => 'thumb-tack' ));
	endif;
	?>

	<?php if ('' !== get_the_post_thumbnail() && ! is_single()) : ?>
		<?php $thumb = get_the_post_thumbnail_url(get_the_ID(),'thumbnail'); ?>
		<?php echo '<div class="post-thumbnail" style="background-image:url(' . $thumb . ');">'; ?>
        <a href="<?php the_permalink(); ?>">
			<?php $score = get_post_meta(get_the_ID(),'score_value',true); ?>
			<?php  if($score != ''){
				echo '<div class="shortscore shortscore-' . $score . '" id="rangeslider_output">' . $score . '</div>';
			} else {
				echo '<div class="shortscore shortscore-0" id="rangeslider_output">?</div>';
			}
			?>

        </a>
        </div><!-- .post-thumbnail -->
	<?php endif; ?>

    <header class="entry-header">
		<?php
		if ('post' === get_post_type()) :
			echo '<div class="entry-meta">';
			if (is_single()) :
				twentyseventeen_posted_on();
			else :
				echo twentyseventeen_time_link();
				twentyseventeen_edit_link();
			endif;
			echo '</div><!-- .entry-meta -->';
		endif;

		if (is_single()) {
			the_title('<h1 class="entry-title">', '</h1>');
		} else {
			the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
		}
		?>
    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		if (get_post_format() == "aside" || !is_home() && !is_archive()) {
			the_content(sprintf(
				__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'),
				get_the_title()
			));
		}

		wp_link_pages(array(
			'before'      => '<div class="page-links">' . __('Pages:', 'twentyseventeen'),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		));
		?>
    </div><!-- .entry-content -->

	<?php if (is_single()) : ?>
		<?php twentyseventeen_entry_footer(); ?>
	<?php endif; ?>

</article><!-- #post-## -->
