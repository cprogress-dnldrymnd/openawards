<?php
$args = array(
    'numberposts' => 10,
    'post_type'   => 'post'
);

$posts = get_posts($args);
?>

<section class="post-slider latest-news">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2>Latest News from Open Awards</h2>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="vc_btn3-container vc_btn3-inline"><a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" href="#" title="">
                    All News
                </a></div>
            </div>
        </div>
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
            <div class="swiper-button-prev swiper-button-prev-post"></div>
        </div>
    </div>
</section>