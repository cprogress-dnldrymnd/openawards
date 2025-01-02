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

$faqs_page_heading = carbon_get_theme_option('faqs_page_heading');
$faqs_page_description = carbon_get_theme_option('faqs_page_description');
$faqs_image = carbon_get_theme_option('faqs_image');
$faqs_image_url = wp_get_attachment_image_url($faqs_image, 'large');
?>
<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <div class="title-wrapper title-wrapper-v3">
            <div class="container">
                <div class="heading-box">
                    <h2>
                        <?= $faqs_page_heading ?>
                    </h2>
                </div>
                <div class="subheading">
                    <?= wpautop($faqs_page_description) ?>
                </div>
            </div>
        </div>

        <section class="faqs-categories">
            <div class="container">
                <div class="row row-cat g-5 h-100">
                    <?php foreach ($terms as $term) { ?>
                        <?php
                        $icon = carbon_get_term_meta($term->term_id, 'icon');
                        ?>
                        <div class="col-lg-3">
                            <a href="<?= get_term_link($term->term_id) ?>" class="h-100">
                                <?php
                                if ($icon) {
                                    $url = wp_get_attachment_image_url($icon, 'medium', true);
                                    echo "<img class='faqs-img-icon' src='$url'/>";
                                } else {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="40.997" height="51.246" viewBox="0 0 40.997 51.246"> <g id="gui-questions-svgrepo-com" transform="translate(-2.2 -1)"> <path id="Path_2315" data-name="Path 2315" d="M38.072,12.449V48.321H2.2V2.2H27.823Z" transform="translate(0 3.925)" fill="#9d9aad" /> <path id="Path_2316" data-name="Path 2316" d="M39.272,11.249V47.121H3.4V1H29.023Z" transform="translate(3.925)" fill="#fab0ff" /> <path id="Path_2317" data-name="Path 2317" d="M18.709,11.059H9.1V1.45Z" transform="translate(22.567 1.472)" fill="#f4f5f7" /> <path id="Path_2318" data-name="Path 2318" d="M10.29,19.573c0-6.021,4.612-5.637,4.612-9.224a2.393,2.393,0,0,0-2.562-2.69,2.421,2.421,0,0,0-2.69,2.562H6.19c0-.9.384-5.381,6.15-5.381,5.893,0,6.021,4.612,6.021,5.509,0,4.484-4.868,5.125-4.868,9.352h-3.2Zm-.256,4.484a1.774,1.774,0,0,1,1.922-1.922,1.863,1.863,0,0,1,1.922,1.922,1.745,1.745,0,0,1-1.922,1.794A1.745,1.745,0,0,1,10.033,24.057Z" transform="translate(13.049 12.559)" fill="#fff" /> </g> </svg>';
                                }
                                ?>

                                <div class="faq-cat-title">
                                    <?= $term->name ?>
                                </div>
                                <div class="faq-cat-desc">
                                    <?= wpautop($term->description) ?>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?= do_shortcode('[template template_id=2969]') ?>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>