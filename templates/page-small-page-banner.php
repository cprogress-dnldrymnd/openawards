<?php 
/**
 * 	Template Name: Page Template : Small Page Banner  
*/
?>
<?php get_header();  ?>
<main id="page-components">


     <div id="content" role="main">
        <?php if ( have_posts() ) : 
               // Do we have any posts/pages in the databse that match our query?
          ?>
          <?php if(!get_field('hide_breadcrumbs')) { ?>
               <?php get_template_part('template-parts/page', 'breadcrumbs');?>
          <?php } ?>
          <?php get_template_part('template-parts/page', 'banner');?>

          <div class="container-holder">
               <div class="container">

                    <?php while ( have_posts() ) : the_post(); 
                    // If we have a page to show, start a loop that will display it
                         ?>

                         <article class="post">
                              <div class="the-content">
                                   <?php the_content(); 
                                   // This call the main content of the page, the stuff in the main text box while composing.
                                   // This will wrap everything in p tags
                                   ?>

                                   <?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
                              </div><!-- the-content -->

                         </article>

                    <?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

               <?php endif ?>


          </div>
     </div>

</div><!-- #content .site-content -->
</main>
<?php get_footer();