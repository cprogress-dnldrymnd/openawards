<?php

/**
 * 	Template Name: Page Template : Wide Width   
 */
?>
<?php get_header();  ?>
<main>
	    <?php if (!get_field('hide_breadcrumbs')) { ?>
          <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
     <?php } ?>
     <?= hero() ?>

    <div id="content" class="wide-width" role="main">
        <?php if (have_posts()) :
            // Do we have any posts/pages in the databse that match our query?
        ?>
            <?php while (have_posts()) : the_post();
                // If we have a page to show, start a loop that will display it
            ?>
               
                <div class="container">
                    <?php the_content() ?>
                </div>


            <?php endwhile; // OK, let's stop the page loop once we've displayed it 
            ?>

        <?php endif ?>


    </div><!-- #content .site-content -->
</main>
<?php get_footer();
