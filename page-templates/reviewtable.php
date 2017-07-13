<?php
/**
 * Template Name: Review Table
 *
 * Description: A custom game ranking template - Table
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

          <?php echo anorlondo_get_shortscore_table(); ?>

</div>
  </main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
