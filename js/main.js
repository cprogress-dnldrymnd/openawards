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
jQuery('.team-swiper').each(function (index, element) {

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

jQuery(document).ready(function () {
    footer_functions();
    team_modal_trigger();
    swiper_sliders();
});


function footer_functions() {
    if (jQuery('.select-input, .select-input-wrapper select').length > 0) {
        jQuery('.select-input, .select-input-wrapper select').select2();
    }
    jQuery('[data-toggle="offcanvas"]').on('click', function () {
        jQuery('.offcanvas').toggleClass('open on');
        jQuery('.offcanvas-collapse').toggleClass('open');
        jQuery('body').toggleClass('lockscroll');
    });
}

function team_modal_trigger() {
    jQuery('.team-modal-trigger').click(function (e) {
        title = jQuery(this).attr('title');
        body = jQuery(this).attr('content');
        image = jQuery(this).attr('image');
        linkedin = jQuery(this).attr('linkedin');
        jQuery('#teamModal .description-box').html(body);
        jQuery('#teamModal .modal-title').html(title);
        e.preventDefault();
    });
}