<section class="post-slider">
    <div class="container">
        <div class="swiperPostSlider-holder swiperPostSlider-holder-shadow position-relative swiper-button-style-1">
            <div class="swiper swiperPostSlider bg-light">
                <div class="swiper-wrapper">
                    <?php while (have_posts()) {
                        the_post(); ?>
                        <div class="swiper-slide">
                            <div class="post-box post-box-slider">
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-6">
                                        <div class="column-holder">
                                            <div class="image-box">
                                                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="column-holder">
                                            <div class="content-box">
                                                <div class="heading-box">
                                                    <h4><?php the_title() ?></h4>
                                                </div>
                                                <div class="description-box">
                                                    <?php the_excerpt() ?>
                                                </div>
                                                <div class="button-box button-readmore">
                                                    <a href="<?php the_permalink() ?>">Read the article</a>
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
            <div class="swiper-button-next swiper-button-next-post d-none d-lg-flex"></div>
            <div class="swiper-button-prev swiper-button-next-post d-none d-lg-flex"></div>
			<div class="swiper-pagination swiper-pagination-latest-news d-block d-lg-none mt-4 mb-4"></div>

        </div>
    </div>
</section>