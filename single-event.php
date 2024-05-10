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
            <?php while (have_posts()) : the_post();
                // If we have a page to show, start a loop that will display it
            ?>


                <section class="single-event-section">
                    <div class="container wide width1400">

                        <?php the_content();
                        // This call the main content of the page, the stuff in the main text box while composing.
                        // This will wrap everything in p tags
                        ?>

                        <?php
                        $event_code = carbon_get_the_post_meta('event_code');
                        $args = array(
                            'post_type' => 'event',
                            'numberposts' => -1,
                            'meta_query' => array(
                                array(
                                    'key'   => '_event_code',
                                    'value' => $event_code,
                                )
                            )
                        );
                        $posts = get_posts($args);
                        if ($posts) {
                        ?>

                            <div class="booking-table poppins">
                                <h4 class="mb-3">Click on any of the following dates to book your place:</h4>
                                <table class="table">
                                    <tr>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Time
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    <?php foreach ($posts as $post) { ?>
                                        <?php
                                        $_event_start_date = get_post_meta($post->ID, '_event_start_date', true);
                                        $_event_start_time = get_post_meta($post->ID, '_event_start_time', true);
                                        ?>
                                        <tr class="<?= $post->ID == get_the_ID() ? 'active' : '' ?>">
                                            <td>
                                                <?= _date_format($_event_start_date) ?>
                                            </td>
                                            <td>
                                                <?= _date_format($_event_start_time, 'g:i a') ?>
                                            </td>
                                            <td>
                                                <div class="button-box button-readmore">
                                                    <a href="<?= get_the_permalink($post->ID) ?>">Book Now</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </section>



            <?php endwhile; // OK, let's stop the page loop once we've displayed it 
            ?>
        <?php endif ?>

    </div><!-- #content .site-content -->
</main>
<?php get_footer();
?>