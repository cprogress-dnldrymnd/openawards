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
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
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
                                        <div class="col-lg-6 col-md-6">
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
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
</main>