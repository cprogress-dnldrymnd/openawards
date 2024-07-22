<?php
$args = array(
    'numberposts' => 10,
    'post_type'   => 'post'
);

$posts = get_posts($args);
?>

<section class="post-slider">
    <div class="container">
        <div class="swiperPostSlider-holder position-relative swiper-button-style-1">
            <div class="swiper  swiperPostSlider-latestnews ">
                <div class="swiper-wrapper">
                    <?php foreach ($posts as $post) { ?>
                        <div class="swiper-slide">
                            <?php
                            echo do_shortcode('[post_box id="' . $post->ID . '" class="column-holder h-100"]');
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next-post"></div>
            <div class="swiper-button-prev swiper-button-next-post"></div>
        </div>
    </div>
</section>