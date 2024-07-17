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
                <svg xmlns="http://www.w3.org/2000/svg" id="Group_866" data-name="Group 866" width="56" height="56" viewBox="0 0 56 56">
                    <g id="Ellipse_275" data-name="Ellipse 275" fill="#fff" stroke="none" stroke-width="1">
                        <circle cx="28" cy="28" r="28" stroke="none" />
                        <circle cx="28" cy="28" r="27.5" fill="none" />
                    </g>
                    <g id="Group_577" data-name="Group 577" transform="translate(24.795 19.591)">
                        <path id="Path_2151" data-name="Path 2151" d="M0,16.818l8.41-8.41L0,0" fill="none" stroke="none" stroke-width="4" />
                    </g>
                </svg>
            </div>
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56">
                    <g id="Group_865" data-name="Group 865" transform="translate(454 1351) rotate(180)">
                        <g id="Ellipse_275" data-name="Ellipse 275" transform="translate(398 1295)" fill="#fff" stroke="none" stroke-width="1">
                            <circle cx="28" cy="28" r="28" stroke="none" />
                            <circle cx="28" cy="28" r="27.5" fill="none" />
                        </g>
                        <g id="Group_577" data-name="Group 577">
                            <path id="Path_2151" data-name="Path 2151" d="M4506.365,14956l8.41,8.41-8.41,8.408" transform="translate(-4083.57 -13641.41)" fill="none" stroke="none" stroke-width="4" />
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </section>
</main>