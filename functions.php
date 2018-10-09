<?php

add_filter( 'auto_update_theme', '__return_true' );

add_action( 'after_setup_theme', 'anorlondo_theme_setup' );

function anorlondo_theme_setup() {
	add_image_size( 'article-retina', 1480 ); // 1480 pixels wide (and unlimited height)
	add_image_size( 'featured-game', 240, 240, false ); // game
	add_image_size( 'featured-game-retina', 480, 480, false ); // game retina
	add_image_size( 'yarpp', 231, 100, true ); // yarpp image
	add_image_size( 'yarpp-retina', 462, 200, true ); // yarpp image
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'dashicons' );
}

/* Add has-sidebar class to body tag on single pages */
function wpse15850_body_class( $wp_classes, $extra_classes ) {
	if ( is_single() ) {
		$blacklist = array( 'has-sidebar' );

		$wp_classes = array_diff( $wp_classes, $blacklist );

		// Add the extra classes back untouched
		return array_merge( $wp_classes, (array) $extra_classes );
	} else {
		return array_merge( $wp_classes, (array) $extra_classes );
	}
}

function get_PiwikPixel() {
	$piwiksiteID = get_option( 'wp-piwik-site_id', false );
	$piwiURL     = get_option( 'wp-piwik_global-piwik_url', false );
	$html        = false;
	$data        = array(
		'idsite'      => $piwiksiteID,
		'rec'         => 1,
		'action_name' => 'TITLE',
		'url'         => 'CANONICAL_URL',
		'urlref'      => 'DOCUMENT_REFERRER',
		'e_c'         => 'amp',
		'e_a'         => 'TITLE',
		'e_n'         => 'CANONICAL_URL',
		'rand'        => 'RANDOM'
	);

	$params = http_build_query( $data, '', '&amp;' );

	if ( $piwiksiteID && $piwiURL ) {
		$html = '<amp-pixel src="' . $piwiURL . 'piwik.php?' . $params . '"></amp-pixel>';
	}

	return $html;
}


function get_Shortscore() {

	$id = get_the_ID();

	$score_count = get_post_meta( $id, 'score_count', true );

	$markup = '';

	if ( $score_count > 0 ) {

		$shortscore = get_post_meta( $id, 'score_value', true );

		$score_int = floor( $shortscore );

		$markup .= '<div class="average shortscore shortscore-' . $score_int . '">' . $shortscore . '</div>';

	} else {
		$markup .= '<div class="shortscore shortscore-0">?</div>';

	}

	return $markup;

}


add_filter( 'body_class', 'wpse15850_body_class', 100, 2 );

/* set content width to 740 (image width) */
function anorlondo_content_width() {
	$content_width = 740;

	if ( twentyseventeen_is_frontpage() ) {
		$content_width = 1120;
	}

	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );

}

add_action( 'after_setup_theme', 'anorlondo_content_width', 100 );

/* new widget area */
function anorlondo_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Header', 'twentyseventeen' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Add widgets here to appear in your header.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}

add_action( 'widgets_init', 'anorlondo_widgets_init' );

function anorlondo_get_shortscore_list() {

	$args = array(
		'post_type'      => 'post',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
		'meta_key'       => '_shortscore_user_rating',
		'posts_per_page' => '300',
		'order'          => 'DESC'
	);

	$the_query = new WP_Query( $args );
	$html      = '';
	$score     = '';

	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$result = anorlondo_object_to_array( get_post_meta( get_the_ID(), "_shortscore_result", true ) );
		if ( isset( $result["game"] ) AND isset( $result["game"]["title"] ) ) {
			$title = $result["game"]["title"];
		}
		$shortscore = get_post_meta( get_the_ID(), "_shortscore_user_rating", true );

		if ( $score != $shortscore AND $shortscore > 0 ) {
			if ( $score != '' ) {
				$html .= "</ul> \n";
			}
			$html .= '<h2>SHORTSCORE ' . $shortscore . '/10</h2>';
			$html .= '<ul>';
		}

		if ( $title != '' AND $shortscore != '' ) {
			$html .= '<li>';
			$html .= '[' . $shortscore . '/10] - <a href="' . get_permalink() . '">' . $title . '</a>';
			$html .= "</li> \n";
		}

		$score = $shortscore;
	endwhile;

	return $html;
}


function anorlondo_object_to_array( $d ) {
	if ( is_object( $d ) ) {
		$d = get_object_vars( $d );
	}

	return is_array( $d ) ? array_map( __FUNCTION__, $d ) : $d;
}

function anorlondo_get_shortscore_table() {

	$args = array(
		'post_type'      => 'game',
		'orderby'        => 'meta_value_num',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
		'meta_key'       => 'score_value',
		'posts_per_page' => '300',
		'order'          => 'DESC'
	);

	$the_query = new WP_Query( $args );
	$html      = '<table class="GeneratedTable">
  <thead>
    <tr>
      <th>Score</th>
      <th>Votes</th>
      <th>Game</th>
      <!-- <th>Developer</th> -->
      <th>Release Date</th>
    </tr>
  </thead>
  <tbody>';
	$score     = '';

	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$gid         = get_the_ID();
		$shortscore  = get_post_meta( $gid, "score_value", true );
		$title       = get_the_title( $gid );
		$score_count = get_post_meta( $gid, "score_count", true );
		//$developer_list = get_the_term_list( $gid, 'developer', '', ', ' );
		$releasedate = get_the_date( 'd. m. Y', $gid );

		$html .= '<tr>';
		$html .= '<td>';
		$html .= $shortscore . '/10';
		$html .= "</td> \n";
		$html .= '<td>';
		$html .= $score_count;
		$html .= "</td> \n";
		$html .= '<td>';
		$html .= '<a href="' . get_permalink() . '">' . $title . '</a>';
		$html .= "</td> \n";
		//$html .= '<td>';
		//$html .= $developer_list;
		//$html .= "</td> \n";
		$html .= '<td>';
		$html .= $releasedate;
		$html .= "</td> \n";

		$html .= '</tr>';
	endwhile;
	$html .= '  </tbody>
</table>';

	return $html;
}

/**
 * Displays the link to the comments for the current post ID.
 *
 * @since 0.71
 *
 * @param string $zero Optional. String to display when no comments. Default false.
 * @param string $one Optional. String to display when only one comment is available.
 *                          Default false.
 * @param string $more Optional. String to display when there are more than one comment.
 *                          Default false.
 * @param string $css_class Optional. CSS class to use for comments. Default empty.
 * @param string $none Optional. String to display when comments have been turned off.
 *                          Default false.
 */
function anorlondo_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	$id     = get_the_ID();
	$title  = get_the_title();
	$number = get_comments_number( $id );

	if ( false === $zero ) {
		/* translators: %s: post title */
		$zero = sprintf( __( 'No Comments<span class="screen-reader-text"> on %s</span>' ), $title );
	}

	if ( false === $one ) {
		/* translators: %s: post title */
		$one = sprintf( __( '1 Comment<span class="screen-reader-text"> on %s</span>' ), $title );
	}

	if ( false === $more ) {
		/* translators: 1: Number of comments 2: post title */
		$more = _n( '%1$s Comment<span class="screen-reader-text"> on %2$s</span>', '%1$s Comments<span class="screen-reader-text"> on %2$s</span>', $number );
		$more = sprintf( $more, number_format_i18n( $number ), $title );
	}

	if ( false === $none ) {
		/* translators: %s: post title */
		$none = '';
	}

	if ( 0 == $number && ! comments_open() && ! pings_open() ) {
		echo '<span' . ( ( ! empty( $css_class ) ) ? ' class="' . esc_attr( $css_class ) . '"' : '' ) . '>' . $none . '</span>';

		return;
	}

	if ( post_password_required() ) {
		_e( 'Enter your password to view comments.' );

		return;
	}

	echo ' – <a href="';
	if ( 0 == $number ) {
		$respond_link = get_permalink() . '#respond';
		/**
		 * Filters the respond link when a post has no comments.
		 *
		 * @since 4.4.0
		 *
		 * @param string $respond_link The default response link.
		 * @param integer $id The post ID.
		 */
		echo apply_filters( 'respond_link', $respond_link, $id );
	} else {
		comments_link();
	}
	echo '"';

	if ( ! empty( $css_class ) ) {
		echo ' class="' . $css_class . '" ';
	}

	$attributes = '';
	/**
	 * Filters the comments link attributes for display.
	 *
	 * @since 2.5.0
	 *
	 * @param string $attributes The comments link attributes. Default empty.
	 */
	echo apply_filters( 'comments_popup_link_attributes', $attributes );

	echo '>';
	comments_number( $zero, $one, $more );
	echo '</a>';
}

if ( ! function_exists( 'twentyseventeen_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function twentyseventeen_entry_footer() {

		/* translators: used between list items, there is a space after the comma */
		$separate_meta = __( ', ', 'twentyseventeen' );

		// Get Categories for posts.
		$categories_list = get_the_category_list( $separate_meta );

		// Get Tags for posts.
		$tags_list = get_the_tag_list( '', $separate_meta );

		// We don't want to output .entry-footer if it will be empty, so make sure its not.
		if ( ( ( twentyseventeen_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

			echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && twentyseventeen_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';


					// YOAST Breadcrumbs
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<span class="cat-links breadcrumb-links">' . twentyseventeen_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Breadcrumbs', 'twentyseventeen' ) . '</span>', '</span>' );
					} else if ( $categories_list && twentyseventeen_categorized_blog() ) {
						// Not needed because if breadcrumbs are active
						// Make sure there's more than one category before displaying.
						echo '<span class="cat-links">' . twentyseventeen_get_svg( array( 'icon' => 'folder-open' ) ) . '<span class="screen-reader-text">' . __( 'Categories', 'twentyseventeen' ) . '</span>' . $categories_list . '</span>';
					}

					if ( $tags_list && ! is_wp_error( $tags_list ) ) {
						echo '<span class="tags-links">' . twentyseventeen_get_svg( array( 'icon' => 'hashtag' ) ) . '<span class="screen-reader-text">' . __( 'Tags', 'twentyseventeen' ) . '</span>' . $tags_list . '</span>';
					}


					echo '</span>';
				}
			}

			twentyseventeen_edit_link();

			echo '</footer> <!-- .entry-footer -->';
		}
	}
endif;
