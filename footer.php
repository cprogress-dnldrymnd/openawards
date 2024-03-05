<?php
/*-----------------------------------------------------------------------------------*/
/* This template will be called by all other template files to finish 
  /* rendering the page and display the footer area/content
  /*-----------------------------------------------------------------------------------*/
?>

</div><!-- / end page container, begun in the header -->

<?php global $theme_settings; ?>
<footer>
  <div class="main-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4">
          <div class="logo-holder">
            <img src="<?php echo $theme_settings['alt_logo'] ?>" alt="White Logo" />
          </div>
          <div class="contact-details">
            <ul>
              <li><i class="fas fa-map-marker-alt"></i><span class="location"><?php echo $theme_settings['address'] ?></span></li>
              <li><i class="fas fa-phone-alt"></i><span class="phone"><a href="tel:<?php echo $theme_settings['contact_number'] ?>"><?php echo $theme_settings['contact_number'] ?></a></span>
              </li>
              <li><i class="fas fa-envelope"></i><span class="email"><a href="mailto:<?php echo $theme_settings['email_address'] ?>"><?php echo $theme_settings['email_address'] ?></a></span>
              </li>
            </ul>
          </div>
          <a class="btn btn-outline-primary light" href="<?php echo $redux_demo['opt-button-link'] ?>"><?php echo $redux_demo['opt-button-text'] ?></a>
        </div>
        <div class="col-lg-2 col-md-2">
          <?php dynamic_sidebar('footer4'); ?>
        </div>
        <?php dynamic_sidebar('footer1'); ?>
        <?php dynamic_sidebar('footer2'); ?>
        <?php dynamic_sidebar('footer3'); ?>
      </div>
    </div>
  </div>

  <div class="bottom-footer">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8 col-md-8">
          <div class="copyright-text">
            <p><?php echo $redux_demo['opt-copyright'] ?></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <ul class="other-links links inline">
            <li><a href="<?php echo $redux_demo['opt-cookies'] ?>">Cookies Policy</a></li>
            <li><a href="<?php echo $redux_demo['opt-privacy'] ?>">Privacy Policy</a></li>
            <?php if ($redux_demo['opt-additional-1-text']) { ?>
              <li><a href="<?= $redux_demo['opt-additional-1-url'] ?>"><?= $redux_demo['opt-additional-1-text'] ?></a>
              </li>
            <?php } ?>
            <?php if ($redux_demo['opt-additional-2-text']) { ?>
              <li><a href="<?= $redux_demo['opt-additional-2-url'] ?>"><?= $redux_demo['opt-additional-2-text'] ?></a>
              </li>
            <?php } ?>

          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<script>
  jQuery(document).ready(function() {

    if (jQuery('.select-input, .select-input-wrapper select').length > 0) {
      jQuery('.select-input, .select-input-wrapper select').select2();
    }
    jQuery('[data-toggle="offcanvas"]').on('click', function() {
      jQuery('.offcanvas').toggleClass('open on');
      jQuery('.offcanvas-collapse').toggleClass('open');
      jQuery('body').toggleClass('lockscroll');
    })
  })
</script>
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


  $key = 1;

  jQuery('.team-swiper').each(function(index, element) {

    var $id = 'swiper' + $key;
    var $id = new Swiper(".team-swiper", {
      loop: true,
      breakpoints: {
        480: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
        1200: {
          slidesPerView: 4,
          spaceBetween: 40,
        },
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });

    $key++;
  });
</script>
<?php wp_footer();
// This fxn allows plugins to insert themselves/scripts/css/files (right here) into the footer of your website. 
// Removing this fxn call will disable all kinds of plugins. 
// Move it if you like, but keep it around.
?>

</body>

</html>