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
          <a class="btn btn-outline-primary btn-green light" href="<?php echo $theme_settings['footer_button_url'] ?>"><?php echo $theme_settings['footer_button_text'] ?></a>
          <?php if ($theme_settings['footer_logos']) { ?>
            <div class="footer-logos mt-4">
              <?php foreach ($theme_settings['footer_logos'] as $logo) { ?>
                <div class="footer-logo">
                  <img src="<?= wp_get_attachment_image_url($logo, 'medium') ?>">
                </div>
              <?php } ?>
            </div>
          <?php } ?>
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
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body">
        <button type="button" class="team-modal-close" data-bs-dismiss="modal" aria-label="Close">
          &#10005;
        </button>
        <div class="container">
          <div class="row g-5">
            <div class="col-lg-4">
              <div class="image-box mb-3">
                <img class="image" src="">
              </div>
              <h5 class="modal-title" id="teamModalLabel"></h5>
              <p class="position mb-3"></p>
              <a class="linkedin" href="" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                  <path id="Icon_akar-linkedin-fill" data-name="Icon akar-linkedin-fill" d="M14.144,13.453h5.571v2.775c.8-1.6,2.861-3.03,5.952-3.03C31.593,13.2,33,16.375,33,22.2V33H27V23.532c0-3.319-.8-5.191-2.846-5.191-2.833,0-4.011,2.017-4.011,5.19V33h-6V13.453ZM3.855,32.745h6V13.2h-6V32.745Zm6.86-25.92a3.8,3.8,0,0,1-1.13,2.7A3.856,3.856,0,0,1,3,6.825a3.8,3.8,0,0,1,1.129-2.7,3.88,3.88,0,0,1,5.456,0A3.807,3.807,0,0,1,10.715,6.825Z" transform="translate(-3 -3)" fill="#b57cff" />
                </svg>
              </a>
            </div>
            <div class="col-lg-8">
              <div class="description-box">

              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Listen for clicks on the team members
    $('.team-modal-trigger').on('click', function() {
        // Get the linkedin attribute from the clicked button
        var linkedin = $(this).attr('linkedin');
        
        // Find the linkedin link inside the modal
        var $modalLinkedin = $('#teamModal .linkedin');

        // Check if the attribute exists and is not empty
        if (linkedin && linkedin.trim() !== "" && linkedin !== "undefined") {
            $modalLinkedin.attr('href', linkedin);
            $modalLinkedin.show(); // Show it if there is a link
        } else {
            $modalLinkedin.hide(); // Hide it if there is no link
        }
    });
});
	
	jQuery(document).ready(function($) {
		function fixSalarySpacing() {
			// Replace '.salary-class' with the actual class name you found when inspecting
			jQuery('.job-wrapper, .job-holder, .salary').each(function() {
				var $el = jQuery(this);
				var originalHtml = $el.html();

				// REGEX EXPLAINED:
				// £     -> matches the pound sign
				// \s+   -> matches one or more whitespace characters
				// This replaces "£ " with "£" but leaves "150 per day" alone.
				var updatedHtml = originalHtml.replace(/£\s+/g, '£');

				// Only update the DOM if a change was actually made
				if (originalHtml !== updatedHtml) {
					$el.html(updatedHtml);
				}
			});
		}

		// Run it on initial page load
		fixSalarySpacing();

		// Since your site uses AJAX for Load More, we watch for AJAX completions
		jQuery(document).ajaxComplete(function() {
			fixSalarySpacing();
		});
	});
</script>

<script>
  jQuery(document).ready(function() {
	  column_responsive();
  });

	function column_responsive() {
		jQuery('.append-this .wpb_column').appendTo('.append-here');
	}

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

  var swiperRelated = new Swiper(".swiperPostSlider-Related", {
    slidesPerView: 3,
    spaceBetween: 0,
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


var $key = 1;

jQuery('.team-swiper').each(function(index, element) {
    var $container = jQuery(this);
    var $wrapper = $container.find('.swiper-wrapper');
    var $slides = $wrapper.find('.swiper-slide');

    // 1. Sort the slides alphabetically by text content
    $slides.sort(function(a, b) {
        var textA = jQuery(a).text().trim().toUpperCase();
        var textB = jQuery(b).text().trim().toUpperCase();
        return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
    });

    // 2. Re-append the sorted slides back to the wrapper
    jQuery.each($slides, function(index, slide) {
        $wrapper.append(slide);
    });

    // 3. Continue with your ID assignment and initialization
    var $idName = 'swiper' + $key;
    $container.attr('id', $idName);
    $container.find('.swiper-button-next').attr('id', $idName + '-next');
    $container.find('.swiper-button-prev').attr('id', $idName + '-prev');
    $container.find('.swiper-pagination-team').attr('id', $idName + '-pagination');

    var swiperInstance = new Swiper('#' + $idName, {
        loop: true,
        breakpoints: {
            0: { slidesPerView: 1, spaceBetween: 20 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 3, spaceBetween: 30 },
            1200: { slidesPerView: 4, spaceBetween: 40 }
        },
        navigation: {
            nextEl: '#' + $idName + '-next',
            prevEl: '#' + $idName + '-prev',
        },
        pagination: {
            el: '#' + $idName + '-pagination',
            clickable: true,
        },
    });
    
    $key++;
});


  var swiper = new Swiper(".swiperPostSlider", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next-post",
      prevEl: ".swiper-button-prev-post",
    },
  });



  var swiper = new Swiper(".swiperPostSlider-latestnews", {
    spaceBetween: 0,
    loop: true,
    breakpoints: {
      480: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      1200: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
    },
    pagination: {
      el: ".swiper-pagination-latest-news",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next-post",
      prevEl: ".swiper-button-prev-post",
    },
  });

 
</script>

<script>
let lastScrollTop = 0;
const delta = 5;
const header = document.querySelector('header');

window.addEventListener('scroll', function() {
    // Check if we are on Desktop (992px and up)
    if (window.innerWidth >= 992) {
        let st = window.pageYOffset || document.documentElement.scrollTop;

        // Make sure they've scrolled more than the delta
        if (Math.abs(lastScrollTop - st) <= delta) return;

        if (st > lastScrollTop && st > header.offsetHeight) {
            // Scrolling Down - Hide Header
            header.classList.add('nav-up');
        } else {
            // Scrolling Up - Show Header
            header.classList.remove('nav-up');
        }
        lastScrollTop = st;
    } else {
        // Mobile: Always ensure the header is visible (remove hide class if screen resized)
        header.classList.remove('nav-up');
    }
});
</script>
<?php wp_footer();
// This fxn allows plugins to insert themselves/scripts/css/files (right here) into the footer of your website. 
// Removing this fxn call will disable all kinds of plugins. 
// Move it if you like, but keep it around.
?>

</body>

</html>