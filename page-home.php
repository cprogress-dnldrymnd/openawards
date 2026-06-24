<?php

/**
 * 	Template Name: Sidebar/Home Page
 *
 *	This page template has a sidebar built into it, 
 * 	and can be used as a home page, in which case the title will not show up.
 *
 */
get_header(); // This fxn gets the header.php file and renders it 
?>
<style>
  @media(min-width: 992px) {
    .hero-slider .row {
      flex-wrap: nowrap;
    }
  }

  .swiper-button-next,
  .swiper-button-prev {
    color: #06263F;
  }

  .swiper-pagination-bullet-active {
    background-color: #492482;
  }
</style>
<main>
  <section class="hero-slider">
    <div class="swiper mySwiperSlider">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <section class="hero-banner" style="background-image:url('<?php the_field('banner_background'); ?>')">
            <div class="container">
              <div class="content">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="banner-content">
                      <?php the_field('banner_heading'); ?>
                      <div class="button-group">
                        <a href="<?php the_field('button_1_link'); ?>" class="btn btn-secondary big"><?php the_field('button1_text'); ?></a>
                        <a href="<?php the_field('button_2_link'); ?>" class="btn btn-outline-primary big"><?php the_field('button2_text'); ?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="banner-image">
                      <img src="<?php the_field('banner_image'); ?>" alt="Book Lover" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <div class="swiper-slide">
          <section class="hero-banner" style="background-image:url('<?php the_field('banner_background'); ?>')">
            <div class="container">
              <div class="content">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="banner-content">
                      <?php the_field('banner_heading'); ?>
                      <div class="button-group">
                        <a href="<?php the_field('button_1_link'); ?>" class="btn btn-secondary big"><?php the_field('button1_text'); ?></a>
                        <a href="<?php the_field('button_2_link'); ?>" class="btn btn-outline-primary big"><?php the_field('button2_text'); ?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="banner-image">
                      <img src="<?php the_field('banner_image'); ?>" alt="Book Lover" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>

  <div class="main-content" style="background-image:url('<?php the_field('body_background'); ?>')">
    <section class="benefits">
      <div class="container">
        <div class="row">
          <?php
          if (have_rows('benefits_section')) :
            while (have_rows('benefits_section')) : the_row();
              $cardTitle = get_sub_field('card_heading');
              $cardText = get_sub_field('card_description');
              $cardLink = get_sub_field('card_link');
          ?>
              <div class="col-lg-3 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title"><?php echo $cardTitle; ?></h3>
                    <p class="card-text"><?php echo $cardText; ?></p>
                    <a href="<?php echo $cardLink['url']; ?>" class="card-link">Read More <span class="arrow"><i class="fas fa-arrow-right"></i></span></a>
                  </div>
                </div>
              </div>
          <?php
            endwhile;
          endif;
          ?>
        </div>
      </div>
    </section>

    <section class="qualifications">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="section-image">
              <img src="<?php the_field('qualifications_image'); ?>" alt="Certification" />
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="content">
              <?php the_field('qualifications_heading'); ?>
              <a href="<?= get_field('qualifications_button_link')['url']; ?>" class="btn btn-outline-primary big"><?php the_field('qualifications_button_text'); ?></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="qualifications">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="content">
              <?php the_field('qualifications_heading'); ?>
              <a href="<?= get_field('qualifications_button_link')['url']; ?>" class="btn btn-outline-primary big"><?php the_field('qualifications_button_text'); ?></a>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="section-image">
              <img src="<?php the_field('qualifications_image'); ?>" alt="Certification" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="shop">
      <div class="container">
        <div class="row">
          <?php the_field('eshop_heading'); ?>
        </div>
        <div class="row">
          <?php
          $eshop_repeater = get_field('eshop_product_repeater');
          ?>
          <?php
          if ($eshop_repeater) {
            foreach ($eshop_repeater as $product) {
          ?>
              <?php $product_obj = wc_get_product($product['product']->ID); ?>
              <!--  <div class="col-lg-3 col-md-6">
              <div class="item">
                <div class="product-image">
                  <img src="<?= wp_get_attachment_image_url($product_obj->get_image_id(), 'thumbnail'); ?>" />
                </div>
                <h4 class="product-name"><a href="/product/<?= $product_obj->get_slug(); ?>"><?= $product_obj->get_name(); ?></a></h4>
                <h5 class="product-price">£<?= $product_obj->get_price(); ?></h5>
              </div>
            </div>    -->
          <?php
            } //closes the foreach
          } //closes the if statement
          ?>
          <?php
          $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'order' => 'DESC',
            'orderby' => 'ID',
          );
          $loop = new WP_Query($args);
          if ($loop->have_posts()) {
            while ($loop->have_posts()) : $loop->the_post();
              $product_obj = wc_get_product(get_the_ID());
          ?>
              <div class="col-lg-3 col-md-6">
                <div class="item">
                  <div class="product-image">
                    <img src="<?= wp_get_attachment_image_url($product_obj->get_image_id(), 'thumbnail'); ?>" />
                  </div>
                  <h4 class="product-name"><a href="/product/<?= $product_obj->get_slug(); ?>"><?= $product_obj->get_name(); ?></a></h4>
                  <h5 class="product-price">£<?= $product_obj->get_price(); ?></h5>
                </div>
              </div>
          <?php
            endwhile;
          } else {
            echo __('No products found');
          }
          wp_reset_postdata();
          ?>
        </div>
        <a class="btn btn-secondary center big" href="<?= get_field('shop_button_link')['url'] ?>"><?php the_field('shop_button_text'); ?></a>
      </div>
    </section>
  </div>
</main>
<script>
  var swiper = new Swiper(".mySwiperSlider", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>