jQuery(document).ready(function () {
    footer_functions();
    team_modal_trigger();
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