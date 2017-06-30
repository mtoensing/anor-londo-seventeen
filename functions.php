<?php

add_filter( 'auto_update_theme', '__return_true' );

add_action( 'after_setup_theme', 'anorlondo_theme_setup' );

function anorlondo_theme_setup() {
    add_image_size( 'article-retina', 1480 ); // 1480 pixels wide (and unlimited height)
    add_image_size( 'square-game', 240, 240, true ); // game
	add_image_size( 'square-game-retina', 480, 480, true ); // game retina
	add_image_size( 'yarpp', 231, 100, true ); // yarpp image
	add_image_size( 'yarpp-retina', 462, 200, true ); // yarpp image
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'dashicons' );
}

/* Add has-sidebar class to body tag on single pages */
function wpse15850_body_class($wp_classes, $extra_classes)
{
    if (is_single()) {
        $blacklist = array('has-sidebar');

        $wp_classes = array_diff($wp_classes, $blacklist);

        // Add the extra classes back untouched
        return array_merge($wp_classes, (array)$extra_classes);
    } else {
        return array_merge($wp_classes, (array)$extra_classes);
    }
}


function get_Shortscore() {

	$id = get_the_ID();

	$score_count = get_post_meta($id, 'score_count', true);

	$markup = '';

	if ($score_count > 0) {

		$shortscore = get_post_meta($id, 'score_value', true);

		$score_int = floor($shortscore);

		$markup .= '<div class="average shortscore shortscore-' . $score_int . '">' . $shortscore . '</div>';

	} else {
		$markup .= '<div class="shortscore shortscore-0">?</div>';

	}

	return $markup;

}


add_filter('body_class', 'wpse15850_body_class', 100, 2);

/* set content width to 740 (image width) */
function anorlondo_content_width()
{
    $content_width = 740;

    if (twentyseventeen_is_frontpage()) {
        $content_width = 1120;
    }

    $GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);

}

add_action('after_setup_theme', 'anorlondo_content_width', 100);

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

function anorlondo_get_shortscore_list(){

    $args = array(
        'post_type' => 'post',

        'orderby' => 'meta_value_num',
        'orderby'  => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
        'meta_key' => '_shortscore_user_rating',
        'posts_per_page' => '200',
        'order' => 'DESC'
    );

    $the_query = new WP_Query($args);
    $html = '';
    $score = '';

    while ($the_query->have_posts()) :
        $the_query->the_post();
        $result = get_post_meta( get_the_ID(), "_shortscore_result", true );
        $title = $result->game->title;
        $shortscore = get_post_meta( get_the_ID(), "_shortscore_user_rating", true );

        if( $score != $shortscore ) {
            if($score != '') {
                $html .= "</ul> \n";
            }
            $html .= '<h2>SHORTSCORE ' . $shortscore . '/10</h2>';
            $html .= '<ul>';
        }
        $html .= '<li>';
        $html .= '[' . $shortscore . '/10] - <a href="' . get_permalink() . '">' .  $title . '</a>';
        $html .= "</li> \n";

        $score = $shortscore;
    endwhile;

    return $html;
}
