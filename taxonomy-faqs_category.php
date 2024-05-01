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
?>
<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <div class="title-wrapper title-wrapper-v3">
            <div class="container text-center">
                <div class="heading-box mb-3">
                    <h2>
                        Frequently Asked Questions
                    </h2>
                </div>
                <div class="faqs-category-filter">
                    <div class="container">
                        <div class="row justify-content-center faqs-filter-holder">
                            <?php foreach ($terms as $term) { ?>
                                <?php
                                $color = carbon_get_term_meta($term->term_id, 'color');
                                if ($term->term_id == $current_term) {
                                    $class = 'active';
                                } else {
                                    $class = '';
                                }
                                ?>
                                <div class="col-auto">
                                    <a class="<?= $class ?>" style="--color: <?= $color ?>" href="<?= get_term_link($term->term_id) ?>"><?= $term->name ?></a>
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

                    </div>
                </div>
                <div class="vc_btn3-container custom-button text-center mt-5 load-more d-none">
                    <button class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" title="" id="load-more">
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

<script>
	jQuery(document).ready(function() {
		ajax_faqs(0);
	});
</script>