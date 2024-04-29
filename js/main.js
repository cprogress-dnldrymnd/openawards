jQuery(document).ready(function () {
    footer_functions();
    team_modal_trigger();
    ajax_form();
    load_more_button_listener();
});

function ajax_form() {
	jQuery("#archive-form-filter").change(function (e) {
		e.preventDefault();
		ajax(0);
	});
}

function load_more_button_listener($) {
	jQuery(document).on("click", '#load-more', function (event) {
		event.preventDefault();
		var offset = jQuery('.post-item').length;
        event.preventDefault();
		ajax(offset, 'append');
	});

}

function ajax($offset, $event_type = 'html') {
	var $loadmore = jQuery('#load-more');

	var $archive_section = jQuery('.archive-section');

	var $result_holder = jQuery('#results .results-holder');

	var $category = jQuery("select[name='category']").val();

	var $post_type = jQuery("input[name='post-type']").val();

	$loading = jQuery('<div class="loading-results"> <div class="spinner d-inline-block"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--> <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" /> </svg> </div></div>');

	$archive_section.addClass('loading-post');

	if ($event_type == 'html') {
		jQuery('#results  .results-holder').html($loading);
		$loadmore.addClass('d-none');
	} else {
		$loadmore.addClass('loading');
		$loadmore.find('span').text('Loading');
	}

	jQuery.ajax({

		type: "POST",

		url: "/wp-admin/admin-ajax.php",

		data: {

			action: 'archive_ajax',

			category: $category,

			post_type: $post_type,

			offset: $offset
		},

		success: function (response) {
			if ($event_type == 'append') {
				$result_holder_row = $result_holder.find('.row');
				jQuery(response).appendTo($result_holder_row);
			} else {
				$result_holder.html(response);
			}
			$loadmore.removeClass('d-none loading');

			$loadmore.find('span').text('Load more');

			$archive_section.removeClass('loading-post');

		}

	});

}
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
        team_name = jQuery(this).attr('team_name');
        body = jQuery(this).attr('content');
        image = jQuery(this).attr('image');
        position = jQuery(this).attr('position');
        linkedin = jQuery(this).attr('linkedin');
        jQuery('#teamModal .description-box').html(body);
        jQuery('#teamModal .position').html(position);
        jQuery('#teamModal .modal-title').html(team_name);
        jQuery('#teamModal .linkedin').attr('href', linkedin);
        jQuery('#teamModal .image').attr('src', image);

        
        e.preventDefault();
    });
}