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
                    <div class="post-box post-box-slider">
                        <div class="image-box">
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
                        </div>
                        <div class="content-box content-box-v1">
                            <div class="heading-excerpt-box">
                                <div class="heading-box">
                                    <h4><?php the_title() ?></h4>
                                </div>
                                <div class="description-box">
                                    <?php the_excerpt() ?>
                                </div>
                            </div>
                            <div class="button-box button-readmore">
                                <a href="<?php the_permalink() ?>">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    <div class="swiper-button-next swiper-button-next-post"></div>
    <div class="swiper-button-prev swiper-button-next-post"></div>
</div>