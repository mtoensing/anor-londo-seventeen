<?php
/*
YARPP Template: Thumbnails Anor Londo
Description: Requires a theme which supports post thumbnails
Author: Marc Tönsing
*/ ?>

<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
    <h3 class="jp-relatedposts-headline"><em>Ähnliche Beiträge</em></h3>

    <?php if (have_posts()):?>
        <div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid ">

        <?php while (have_posts()) : the_post(); ?>
            <?php if (has_post_thumbnail()):?>

                <div class="jp-relatedposts-post jp-relatedposts-post0 jp-relatedposts-post-thumbs">
                    <a class="jp-relatedposts-post-a" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="nofollow" ><?php the_post_thumbnail(); ?></a>
                    <h4 class="jp-relatedposts-post-title"><a class="jp-relatedposts-post-a" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                    <p class="jp-relatedposts-post-date" style="display: block;"><?php the_date(); ?></p>
                </div>

            <?php endif; ?>
        <?php endwhile; ?>

        </div>

</div>

<?php endif; ?>
