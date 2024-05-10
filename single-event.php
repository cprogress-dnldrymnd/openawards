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
                $post_id = get_the_ID();
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
                            ),
                            'meta_key'          => '_event_start_date',
                            'orderby'           => 'meta_value_num',
                            'order'             => 'ASC'
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
                                        $_event_start = get_post_meta($post->ID, '_event_start', true);
                                        $_event_start_date = get_post_meta($post->ID, '_event_start_date', true);
                                        $_event_start_time = get_post_meta($post->ID, '_event_start_time', true);
                                        $_eventbrite_event_url = get_post_meta($post->ID, '_eventbrite_event_url', true);
                                        $title = $post->post_title;
                                        $title = $post->post_title;
                                        ?>
                                        <tr class="<?= $post->ID == $post_id ? 'active' : '' ?>">
                                            <td>
                                                <?= _date_format($_event_start_date) ?>
                                            </td>
                                            <td>
                                                <?= _date_format($_event_start_time, 'g:i a') ?>
                                            </td>
                                            <td>
                                                <div class="button-group-box d-inline-flex">
                                                    <div class="button-box-v2 button-accent">
                                                        <a href="<?= $_eventbrite_event_url ?>" target="_blank">Book Now</a>
                                                    </div>
                                                    <div class="button-box-v2 button-bordered button-icon">
                                                        <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= $title ?>&dates=<?=$_event_start?>&" target="_blank">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                            </svg>
                                                            <span>Add to calendar</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                                            </svg>
                                                        </a>
                                                    </div>
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