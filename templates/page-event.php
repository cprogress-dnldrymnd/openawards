<?php 
/**
 * 	Template Name: Event Manager Template : Dark Header    
*/
?>
<?php get_header();  ?>
<main id="page-components">


     <div id="content" role="main">
        <?php if ( have_posts() ) : 
               // Do we have any posts/pages in the databse that match our query?
          ?>
          <header class="woocommerce-products-header dark page-dark-header">
               <div class="page-shop-banner text-left">
                    <div class="container wide width1400">
                         <h1 class="woocommerce-products-header__title page-title">OpenAwards Events</h1>
                         <div class="subheading">
                              <p>Take a look at some of our upcoming events</p>
                         </div>
                    </div>
               </div>
          </header>
          <?php if(!get_field('hide_breadcrumbs')) { ?>
               <?php get_template_part('template-parts/page-event', 'breadcrumbs');?>
          <?php } else { ?>
               <div class="spacing" style="margin-bottom: 50px;"></div>
          <?php } ?>
          <div class="container-holder">
               <div class="container wide width1400">

                    <?php while ( have_posts() ) : the_post(); 
                    // If we have a page to show, start a loop that will display it
                         ?>
                         <article class="post">
                              <div class="the-content">
                                   <div class="row">
                                        <div class="col-lg-9">

                                             <?php the_content(); 
                                   // This call the main content of the page, the stuff in the main text box while composing.
                                   // This will wrap everything in p tags
                                             ?>

                                             <?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
                                        </div>
                                        <div class="col-lg-3 event-sidebar">
                                             <div class="row no-gutters">
                                                  <div class="col-lg-12 col-md-4">
                                                       <div class="calendar-box">
                                                            <?= do_shortcode( '[events_calendar]' ) ?>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-12 col-md-4 col-sm-6">
                                                       <?php get_template_part('template-parts/page-event', 'upcoming-events');?>
                                                  </div>
                                                  <div class="col-lg-12 col-md-4 col-sm-6">
                                                       <?php get_template_part('template-parts/page-event', 'categories');?>
                                                  </div>

                                             </div>
                                        </div>
                                   </div>
                              </div><!-- the-content -->

                         </article>

                    <?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

               <?php endif ?>


          </div>
     </div>

</div><!-- #content .site-content -->
</main>
<?php get_footer();