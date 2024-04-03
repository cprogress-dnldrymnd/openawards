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
            <a href="<?= get_site_url() ?>">
              <img src="<?php echo $theme_settings['alt_logo_url'] ?>" alt="White Logo" />
            </a>
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
          <a class="btn btn-outline-primary light" href="<?php echo $theme_settings['footer_button_url'] ?>"><?php echo $theme_settings['footer_button_text'] ?></a>
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
            <p><?php echo $theme_settings['footer_copyright'] ?></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 footer-bottom-links">
          <?php dynamic_sidebar('footer_bottom_links'); ?>
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="teamModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-4">
            <div class="image-box">
              <img src="">
            </div>
          </div>
          <div class="col-lg-8">
            <div class="description-box">

            </div>
            <a class="linkedin" href="" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                <path id="Icon_akar-linkedin-fill" data-name="Icon akar-linkedin-fill" d="M14.144,13.453h5.571v2.775c.8-1.6,2.861-3.03,5.952-3.03C31.593,13.2,33,16.375,33,22.2V33H27V23.532c0-3.319-.8-5.191-2.846-5.191-2.833,0-4.011,2.017-4.011,5.19V33h-6V13.453ZM3.855,32.745h6V13.2h-6V32.745Zm6.86-25.92a3.8,3.8,0,0,1-1.13,2.7A3.856,3.856,0,0,1,3,6.825a3.8,3.8,0,0,1,1.129-2.7,3.88,3.88,0,0,1,5.456,0A3.807,3.807,0,0,1,10.715,6.825Z" transform="translate(-3 -3)" fill="#b57cff" />
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  jQuery(document).ready(function() {

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