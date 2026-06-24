<?php
$args = array(
    'numberposts' => 10,
    'post_type'   => 'post'
);

$posts = get_posts($args);
?>

<section class="post-slider latest-news">
	<?php if(!is_front_page()) { ?>
    <div class="container">
		<?php } ?>
        <div class="row align-items-center mb-4 mb-lg-0">
            <div class="col-lg-8">
                <h2>Latest News from Open Awards</h2>
            </div>
            <div class="d-none d-lg-block col-lg-4 text-center text-lg-end">
                <div class="vc_btn3-container vc_btn3-inline"><a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" href="/blog" title="">
                    All News
                </a></div>
            </div>
        </div>
        <div class="swiperPostSlider-holder swiperPostSlider-holder-style-2 position-relative swiper-button-style-1">
            <div class="swiper  swiperPostSlider-latestnews">
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
            <div class="swiper-button-next swiper-button-next-post d-none d-lg-flex"></div>
            <div class="swiper-button-prev swiper-button-prev-post d-none d-lg-flex"></div>
            <div class="swiper-pagination swiper-pagination-latest-news d-block d-lg-none mt-4 mb-4"></div>
			
        </div>
		<div class="d-lg-none text-center mb-5">
			 <div class=" vc_btn3-container vc_btn3-inline"><a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" href="/blog" title="">
                    All News
                </a></div>
		</div>
	<?php if(!is_front_page()) { ?>
		
    </div>
		<?php } ?>
	
</section>