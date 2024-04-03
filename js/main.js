$(document).ready(function () {
    
});


function team_modal_trigger() {
    jQuery('.team-modal-trigger').click(function (e) { 
        title = jQuery(this).attr('title');
        body = jQuery(this).attr('content');
        image = jQuery(this).attr('image');
        jQuery('#teamModal .description-box').html(body);
        jQuery('#teamModal .modal-title').html(title);
        e.preventDefault();
    });
}