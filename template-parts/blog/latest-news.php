<?php
$args = array(
    'numberposts' => 10,
    'post_type'   => 'post'
);

$posts = get_posts($args);
?>

<section class="post-slider">
    <div class="container">
        <div class="swiperPostSlider-holder swiperPostSlider-holder-shadow position-relative swiper-button-style-1">
            <div class="swiper swiperPostSlider swiperPostSlider-latestnews bg-light">
                <div class="swiper-wrapper">
                    <?php foreach ($posts as $post) { ?>
                        <div class="swiper-slide">
                            <div class="post-box post-box-slider">
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-6">
                                        <div class="column-holder">
                                            <div class="image-box">
                                                <img src="<?= get_the_post_thumbnail_url($post->ID, 'medium') ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="column-holder">
                                            <div class="content-box">
                                                <div class="heading-box">
                                                    <h4><?= $post->post_title ?></h4>
                                                </div>
                                                <div class="description-box">
                                                    <?= $post->post_excerpt ?>
                                                </div>
                                                <div class="button-box button-readmore">
                                                    <a href="<?= get_the_permalink($post->ID) ?>">Read more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="swiper-button-next swiper-button-next-post"></div>
            <div class="swiper-button-prev swiper-button-next-post"></div>
        </div>
    </div>
</section>