<?php
$slider = carbon_get_post_meta($args['slider_id'], 'slides');
?>
<main>
    <section class="hero-slider">
        <div class="swiper mySwiperSlider">
            <div class="swiper-wrapper">
                <?php foreach ($slider as $slide) { ?>
                    <?php
                    $background = wp_get_attachment_image_url($slide['background_image'], 'full');
                    $image_url = wp_get_attachment_image_url($slide['image'], 'full');
                    ?>
                    <div class="swiper-slide">
                        <section class="hero-banner" style="background-image:url('<?= $background ?>')">
                            <div class="container">
                                <div class="content">
                                    <div class="row align-items-center g-4">
                                        <div class="col-lg-8">
                                            <div class="banner-content">
                                                <h2><?= $slide['heading'] ?></h2>
                                                <div class="description-box">
                                                    <?= wpautop($slide['description']) ?>
                                                </div>
                                                <div class="button-group">
                                                    <?php if ($slide['button_text_1']) { ?>
                                                        <a href="<?= $slide['button_link_1'] ?>" class="btn btn-secondary big"><?= $slide['button_text_1'] ?></a>
                                                    <?php } ?>
                                                    <?php if ($slide['button_text_2']) { ?>
                                                        <a href="<?= $slide['button_link_2'] ?>" class="btn btn-outline-primary big"><?= $slide['button_text_2'] ?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <?php if ($image_url) { ?>
                                                <div class="banner-image">
                                                    <img src="<?= $image_url ?>" alt="<?= esc_html($slide['heading']) ?>" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                </svg>
            </div>
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg>
            </div>
        </div>
    </section>
</main>