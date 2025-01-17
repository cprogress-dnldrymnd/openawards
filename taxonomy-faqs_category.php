<?php

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it 
$terms = get_terms(array(
    'taxonomy'   => 'faqs_category',
    'hide_empty' => false,
));
$current_term = get_queried_object()->term_id;
$count = $GLOBALS['wp_query']->post_count;
echo hide_load_more($count, 0, 10);
?>
<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <?= hero('Frequently Asked Questions') ?>
        <div class="title-wrapper title-wrapper-v3">
            <div class="container text-center">
                <div class="faqs-category-filter">
                    <div class="container">
                        <div class="row justify-content-center faqs-filter-holder">
                            <?php foreach ($terms as $term) { ?>
                                <?php
                                $color = carbon_get_term_meta($term->term_id, 'color');
                                if ($term->term_id == $current_term) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                                ?>
                                <div class="col-auto">
                                    <input id="faqs_category_<?= $term->term_id ?>" type="radio" name="faqs_category" value="<?= $term->term_id ?>" <?= $checked ?>>
                                    <label for="faqs_category_<?= $term->term_id ?>" style="--color: <?= $color ?>"><?= $term->name ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="search-input">
                            <input type="text" name="faqs-search" placeholder="Search for specific questions">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="faqs-accordion">
            <div class="container">
                <div id="results">
                    <div class="results-holder">
                        <div class="accordion-holder accordion-style-2">
                            <div class="accordion" id="accordion">
                                <?php
                                if (have_posts()) {
                                    while (have_posts()) {
                                        the_post();
                                ?>
                                        <div class="accordion-item post-item">
                                            <h2 class="accordion-header" id="heading<?= get_the_ID() ?>">
                                                <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= get_the_ID() ?>" aria-expanded="false" aria-controls="collapse<?= get_the_ID() ?>">
                                                    <span> <?php the_title() ?></span>

                                                    <svg class="icon-inactive" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                    </svg>
                                                    <svg class="icon-active" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                    </svg>
                                                </button>
                                            </h2>
                                            <div id="collapse<?= get_the_ID() ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= get_the_ID() ?>" data-bs-parent="#accordion">
                                                <div class="accordion-body">
                                                    <?php the_content() ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else {
                                    ?>
                                    <h2>No Results Found</h2>
                                <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="vc_btn3-container custom-button text-center mt-5 load-more d-none">
                    <button class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" title="" id="load-more-faqs">
                        <span>Load More</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path fill="currentColor" d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <?= do_shortcode('[template template_id=2969]') ?>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>