<?php
/**
 * Template Name: Game Ranking
 *
 * Description: A custom game ranking template
 *
 */
get_header();
?>

<div class="wrap">

	<?php if (have_posts()) : ?>
		<header class="page-header">
      <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
      <?php twentyseventeen_edit_link(get_the_ID()); ?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
      <div class="entry-content">
      <ol>
          <?php
          $args = array(
              'post_type' => 'post',
              'meta_key' => "_shortscore_user_rating",
              'orderby' => 'meta_value_num',
              'posts_per_page' => '200',
              'order' => 'DESC'
          );

          $the_query = new WP_Query($args);

          while ($the_query->have_posts()) :
              $the_query->the_post();
                  echo '<li>';
                  echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a> - [' . get_post_meta( get_the_ID(), "_shortscore_user_rating", true ) . '/10]';
                  echo '</li>';
            endwhile;
    ?>
  </ol>
</div>
  </main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
