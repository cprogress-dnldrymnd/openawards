<?php
$post_type = $args['post_type'];


$args = array(
    'post_type' => $post_type,
    'posts_per_page' => 5

);
$query = new WP_Query($args);
?>

<div class="swiperPostSlider-holder position-relative swiper-button-style-1 p-0">
    <div class="swiper swiperPostSlider-Related">
        <div class="swiper-wrapper">
            <?php while ($query->have_posts()) {
                $query->the_post(); ?>
                <div class="swiper-slide">
                    <?= do_shortcode('[post_box id="' . get_the_ID() . '"]') ?>
                </div>
            <?php } ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    <div class="swiper-button-next swiper-button-next-post"></div>
    <div class="swiper-button-prev swiper-button-next-post"></div>
</div>