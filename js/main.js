$(document).ready(function () {
    
});


function team_modal_trigger() {
    jQuery('.team-modal-trigger').click(function (e) { 
        title = jQuery(this).attr('title');
        body = jQuery(this).attr('content');
        jQuery('#teamModal .modal-body').html(body);
        e.preventDefault();
    });
}