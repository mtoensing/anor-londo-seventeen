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
	<header class="entry-header">
		<?php
            if ('post' === get_post_type()) :
                echo '<div class="entry-meta">';
                    if (is_single() OR is_home() OR is_archive() ) :
                        twentyseventeen_posted_on();
	                    anorlondo_comments_popup_link(false,false,false,false,'');
	                    twentyseventeen_edit_link();
                    else :
                        echo twentyseventeen_time_link();
	                    anorlondo_comments_popup_link(false,false,false,false,'');
	                    twentyseventeen_edit_link();
                    endif;
                echo '</div><!-- .entry-meta -->';
            endif;

            if (is_single()) {
                the_title('<h1 class="entry-title"><span>', '</span></h1>');
            } else {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            }
        ?>
	</header><!-- .entry-header -->

	<?php if ('' !== get_the_post_thumbnail() && ! is_single()) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('twentyseventeen-featured-image'); ?>
			</a>

		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<div class="entry-content">
		<?php

            /* show the exerpt only on hp and archive pages if the post has one. */
            if ( !is_single() AND has_excerpt() ) {
                echo '<a href="'. get_permalink($post->ID) . '">';
                the_excerpt();
                echo '</a>';

                /* translators: %s: Name of current post */
                echo '<a href="'. get_permalink($post->ID) . '">' . sprintf(
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                        get_the_title() ) . '</a>';
            } else if( is_single() ) {
		            the_content();
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
