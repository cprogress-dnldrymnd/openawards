<?php

/**
 * 	Template Name: Page Template : Full Width   
 */
?>
<?php get_header();  ?>
<main>

    <div id="content" role="main">
        <?php if (have_posts()) :
            // Do we have any posts/pages in the databse that match our query?
        ?>
            <?php while (have_posts()) : the_post();
                // If we have a page to show, start a loop that will display it
            ?>
                <?php if (!get_field('hide_breadcrumbs')) { ?>
                    <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
                <?php }  ?>
                <!--
                    <section class="breadcrumbs wocom">
                        <nav aria-label="breadcrumb">
                            <div class="container">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/community/">OpenAwards Community</a></li>
                                    <li class="breadcrumb-item"><span><?php the_title() ?></span></li>
                                </ol>
                            </div>
                        </nav>
                    </section>-->

                <?php the_content() ?>


            <?php endwhile; // OK, let's stop the page loop once we've displayed it 
            ?>

        <?php endif ?>


    </div><!-- #content .site-content -->
</main>
<?php get_footer();
