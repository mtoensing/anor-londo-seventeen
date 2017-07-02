<?php
/**
 * Template Name: Platform List
 *
 * Description: A custom game ranking template
 *
 */
get_header();
?>

    <div class="wrap">

		<?php if ( have_posts() ) : ?>
            <header class="page-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php twentyseventeen_edit_link( get_the_ID() ); ?>
            </header><!-- .page-header -->
		<?php endif; ?>

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="entry-content">

					<?php

					$terms = get_terms( 'platform', array(
						'hide_empty' => true,
						'include'    => array(
							5225, // GC
							6030, // MD
							5070, // 3DS
							5936, //N64
							10158, // Switch
							1312, //PC
							665, //PS3
							3, //PS4
							4739, //PSV
							185, // 360
							955, // WiiU
							158, // XONE
							4332 // SNES
						)
					) );

					$html = '<ul class="nobullets">';

					foreach ( $terms as $term ) {
						$html .= '<li>';
						$html .= '<a href="' . get_term_link( $term->term_id ) . '">';

						if ( function_exists( 'z_taxonomy_image_url' ) ) {
							$html .= z_taxonomy_image( $term->term_id, 'thumbnail', '', false );
						}
						$html .= '<h2 class="title">' . $term->name . '</h2>';
						$html .= '</a>';
						$html .= '</li>';
					}

					$html .= '</ul>';

					echo $html;
					?>

                </div>
            </main><!-- #main -->
        </div><!-- #primary -->
		<?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
