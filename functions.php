<?php
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
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

add_action('after_setup_theme', 'anorlondo_content_width', 1);


/* filter AMP and comment pages from google analytics widget */


function super_unique($array, $key)
{
    $temp_array = array();
    foreach ($array as &$v) {
        if (!isset($temp_array[$v[$key]])) {
            $temp_array[$v[$key]] =& $v;
        }
    }
    $array = array_values($temp_array);
    return $array;
}


function gtc_pages_filter_automatically_remove_items($pages)
{
    $strings_to_exclude = array(
    '/amp/',
    '/comment-page-',
    '/blog/'
  );

if(count($pages) <= 0){
  return $pages;
}

    foreach ($pages as $index => &$page) {

      // get position of each string in array
      foreach ($strings_to_exclude as $string) {
          $last_string_start = strrpos($page['path'], $string);

          if ($last_string_start !== false) {
              $overflow = substr($page['path'], $last_string_start + 1, 1000);
              $page['path'] = str_replace($overflow, "", $page['path']);
          }
      }
    }
    $pages = super_unique($pages, 'path');

    return $pages;
}

add_filter('gtc_pages_filter', 'gtc_pages_filter_automatically_remove_items');
