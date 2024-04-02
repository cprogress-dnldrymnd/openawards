<?php

/**
 * 	Template Name: Event Manager Template : Dark Header    
 */
?>
<?php get_header();  ?>
<main id="page-components">


     <div id="content" role="main">
          <?php if (have_posts()) :
               // Do we have any posts/pages in the databse that match our query?
          ?>

               <?php if (!get_field('hide_breadcrumbs')) { ?>
                    <?php get_template_part('template-parts/page-event', 'breadcrumbs'); ?>
               <?php } else { ?>
                    <div class="spacing" style="margin-bottom: 50px;"></div>
               <?php } ?>
               <div class="title-wrapper">
                    <div class="container">
                         <div class="heading-box">
                              <h2>
                                   <?php the_title() ?>
                              </h2>
                         </div>
                         <div class="subheading">
                              <p>Take a look at some of our upcoming events</p>
                         </div>
                    </div>
               </div>
               <div class="container-holder">
                    <div class="container wide width1400">

                         <?php while (have_posts()) : the_post();
                              // If we have a page to show, start a loop that will display it
                         ?>
                              <article class="post">
                                   <div class="the-content">
                                        <div class="row g-5">
                                             <div class="col-lg-3 event-sidebar">
                                                  <div class="row no-gutters">
                                                       <div class="col-lg-12 col-md-4">
                                                            <div class="calendar-box">
                                                                 <?= do_shortcode('[events_calendar]') ?>

                                                            </div>
                                                       </div>
                                                       <div class="col-lg-12 col-md-4 col-sm-6">
                                                            <?php get_template_part('template-parts/page-event', 'upcoming-events'); ?>
                                                       </div>
                                                       <div class="col-lg-12 col-md-4 col-sm-6">
                                                            <?php get_template_part('template-parts/page-event', 'categories'); ?>
                                                       </div>

                                                  </div>
                                             </div>
                                             <div class="col-lg-9">
                                                  <?php the_content();
                                                  // This call the main content of the page, the stuff in the main text box while composing.
                                                  // This will wrap everything in p tags
                                                  ?>

                                                  <?php wp_link_pages(); // This will display pagination links, if applicable to the page 
                                                  ?>
                                             </div>

                                        </div>
                                   </div><!-- the-content -->

                              </article>

                         <?php endwhile; // OK, let's stop the page loop once we've displayed it 
                         ?>

                    <?php endif ?>


                    </div>
               </div>

     </div><!-- #content .site-content -->
</main>
<?php get_footer();
?>

<script>
     jQuery(document).ready(function() {

          key = 1;
          jQuery('.event-date-list-header').each(function(index, element) {
               let myStr = jQuery(this).text();
               let month = myStr.split(" ")[0];
               let year = myStr.split(" ")[1];
               let daynum = myStr.split(" ")[2];
               let dayword = myStr.split(" ")[3];

               jQuery(this).attr('key', key);
               jQuery(this).attr('month', month);
               jQuery(this).attr('year', year);
               jQuery(this).attr('daynum', daynum);
               jQuery(this).attr('dayword', dayword);

               jQuery(this).next().find('.eventList-Swiper').addClass('eventList-Swiper-' + key);
               key++;
          });

          key = 1;
          jQuery('.event-date-list-header').each(function(index, element) {

               let month = jQuery(this).attr('month');
               let year = jQuery(this).attr('year');
               let daynum = jQuery(this).attr('daynum');
               let dayword = jQuery(this).attr('dayword');


               if (key != 1) {
                    key_prev = parseInt(key - 1);
                    let myStrPrev = jQuery('.event-date-list-header[key="' + key_prev + '"]');
                    let monthPrev = myStrPrev.attr('month');
                    let yearPrev = myStrPrev.attr('year');

                    if (monthPrev != month || yearPrev != year) {
                         $new_text = '<div class="day-month"> ' + month + ' ' + year + ' </div><div class="day-nav"><span class="list-date"><span class="day-num"> ' + daynum + ' </span><span class="day-word"> ' + dayword + ' </span></span><div class="swiper-nav-holder"><div class="swiper-button-next swiper-button-next-' + key + '"></div> <div class="swiper-button-prev swiper-button-prev-' + key + '"></div></div></div>';
                    } else {
                         $new_text = '<div class="day-nav"><span class="list-date"><span class="day-num"> ' + daynum + ' </span><span class="day-word"> ' + dayword + ' </span></span><div class="swiper-nav-holder"><div class="swiper-button-next swiper-button-next-' + key + '"></div> <div class="swiper-button-prev swiper-button-prev-' + key + '"></div></div></div>';
                    }
               } else {
                    $new_text = '<div class="day-month"> ' + month + ' ' + year + ' </div><div class="day-nav"><span class="list-date"><span class="day-num"> ' + daynum + ' </span><span class="day-word"> ' + dayword + ' </span></span><div class="swiper-nav-holder"><div class="swiper-button-next swiper-button-next-' + key + '"></div> <div class="swiper-button-prev swiper-button-prev-' + key + '"></div></div></div>';
               }
               jQuery(this).html($new_text);

               key++;

          });
          setTimeout(function() {
               $key = 1;
               jQuery('.eventList-Swiper').each(function(index, element) {

                    var $id = 'swiper' + $key;
                    var $name = '.eventList-Swiper-' + $key;
                    var $id = new Swiper($name, {
                         loop: false,
                         breakpoints: {
                              480: {
                                   slidesPerView: 2,
                                   spaceBetween: 20,
                              },
                              768: {
                                   slidesPerView: 3,
                                   spaceBetween: 30,
                              },

                         },
                         navigation: {
                              nextEl: ".swiper-button-next-" + $key,
                              prevEl: ".swiper-button-prev-" + $key,
                         },
                    });

                    $key++;
               });
          }, 1000);

     });
</script>