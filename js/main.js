$(document).ready(function () {
    
});


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