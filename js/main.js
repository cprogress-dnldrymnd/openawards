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

	jQuery("input[name='faqs_category']").change(function (e) {
		e.preventDefault();
		ajax_faqs(0);
	});



	var typingTimer;
	var doneTypingInterval = 500;

	jQuery('input[name="faqs-search"]').on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	jQuery('input[name="faqs-search"]').on('keydown', function () {
		clearTimeout(typingTimer);
	});

	function doneTyping() {
		ajax_faqs(0);
	}
}

function load_more_button_listener($) {
	jQuery(document).on("click", '#load-more', function (event) {
		event.preventDefault();
		var offset = jQuery('.post-item').length;
		ajax(offset, 'append');
	});

	jQuery(document).on("click", '#load-more-faqs', function (event) {
		event.preventDefault();
		var offset = jQuery('.post-item').length;
		ajax_faqs(offset, 'append');
	});

	jQuery(document).on("click", '#load-more-qualifications', function (event) {
		event.preventDefault();
		var offset = jQuery('.post-item').length;
		ajax_qualifications(offset, 'append');
	});





}

function ajax_faqs($offset, $event_type = 'html') {
	var $loadmore = jQuery('#load-more-faqs');

	var $archive_section = jQuery('.faqs-accordion');

	var $result_holder = jQuery('#results .results-holder');

	var $faqs_category = jQuery("input[name='faqs_category']:checked").val();

	var $s = jQuery('input[name="faqs-search"]').val();

	$loading = jQuery('<div class="loading-results"> <div class="spinner d-inline-block"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--> <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" /> </svg> </div></div>');
	$archive_section.addClass('loading-post');

	if ($event_type == 'html') {
		jQuery('#results  .results-holder').html($loading);
		$loadmore.addClass('d-none');
	} else {
		$loadmore.addClass('loading');
		$loadmore.find('span').text('Loading');
	}
	console.log($faqs_category);
	jQuery.ajax({

		type: "POST",

		url: "/wp-admin/admin-ajax.php",

		data: {

			action: 'faqs_ajax',

			faqs_category: $faqs_category,

			s: $s,

			offset: $offset
		},
/*
		success: function (response) {
			console.log($event_type);
			if ($event_type == 'append') {
				$result_holder_row = $result_holder.find('#accordion');
				jQuery(response).appendTo($result_holder_row);
			} else {
				$result_holder.html(response);
			}
			$loadmore.removeClass('d-none loading');

			$loadmore.find('span').text('Load more');

			$archive_section.removeClass('loading-post');
		}
		*/
		success: function (response) {
			console.log($event_type);
			if ($event_type == 'append') {
				$result_holder_row = $result_holder.find('#accordion');
				jQuery(response).appendTo($result_holder_row);
			} else {
				$result_holder.html(response);
				
				if ($offset === 0) {
					var $checkedRadio = jQuery("input[name='faqs_category']:checked");
					var categoryUrl = $checkedRadio.data('url');

					if (categoryUrl) {
						if ($s) {
							categoryUrl += '?s=' + encodeURIComponent($s);
						}
						window.history.pushState({ faqs_category: $faqs_category, s: $s }, '', categoryUrl);
					}
				}
			}

			$loadmore.removeClass('d-none loading');
			$loadmore.find('span').text('Load more');
			$archive_section.removeClass('loading-post');

			// --- ADD THIS HERE ---
			autoOpenFaq(); 
		}
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
			console.log($event_type);
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


function ajax_qualifications($offset, $source = 'quba', $event_type = 'html') {
	
	var $loadmore = jQuery('#load-more-qualifications');

	var $archive_section = jQuery('.archive-section');

	var $result_holder = jQuery('#results .results-holder');

	var $qualificationLevel = jQuery("select[name='Level']").val();

	var $qcaSector = jQuery("select[name='qcaSector']").val();

	var $qualificationNumber = jQuery("input[name='qualificationNumber']").val();

	var $qualificationType = jQuery("select[name='qualificationType']").val();

	var $qualificationTitle = jQuery("input[name='Title']").val();
	
	var $qualificationRegulator = jQuery("select[name='regulator']").val();
	
	var $qualificationRiskRating = jQuery("select[name='risk']").val();
	
	var $qualificationQualAccreditationNumber = jQuery("input[name='qualAccreditationNumber']").val();
	
	var $qualificationMinage = jQuery("select[name='minage']").val();
	
	var $qualificationEndDate = jQuery("input[name='endDate']").val();

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
			action: 'archive_ajax_qualifications',
			source: $source,
			qcaSector: $qcaSector,
			qualificationLevel: $qualificationLevel,
			qualificationNumber: $qualificationNumber,
			qualificationTitle: $qualificationTitle,
			qualificationType: $qualificationType,
			qualificationRegulator: $qualificationRegulator,
			qualificationRiskRating: $qualificationRiskRating,
			qualificationQualAccreditationNumber: $qualificationQualAccreditationNumber, 
			qualificationMinage: $qualificationMinage, 
			qualificationEndDate: $qualificationEndDate,
		},

		success: function (response) {
			
			if ($event_type == 'append') {
				$result_holder_row = $result_holder.find('.row-results');
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

function ajax_units($offset, $source = 'quba', $event_type = 'html') {
	console.log("calling API ............................",$source)
	var $loadmore = jQuery('#load-more-qualifications');

	var $archive_section = jQuery('.archive-section');

	var $result_holder = jQuery('#results .results-holder');

	var $unitLevel = jQuery("select[name='Level']").val();

	var $qcaSector = jQuery("select[name='qcaSector']").val();

	var $qcaCode = jQuery("input[name='qcaCode']").val();

	var $unitID = jQuery("input[name='unitID']").val();

	var $unitTitle = jQuery("input[name='Title']").val();
    // Get current Unit Type
    var unitType = jQuery('#unitType').val();
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
			action: 'archive_ajax_units',
			unitType: unitType,
			source: $source,
			qcaCode: $qcaCode,
			qcaSector: $qcaSector,
			unitLevel: $unitLevel,
			unitTitle: $unitTitle,
			unitID: $unitID,
		},

		success: function (response) {
			console.log("eventtype",$event_type);
			if ($event_type == 'append') {
				$result_holder_row = $result_holder.find('.row-results');
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

/*
// Unit details
document.addEventListener('DOMContentLoaded', function() {
    const qualificationHeaders = document.querySelectorAll('.qualification-header');
    document.getElementById("glh").value = ""
	document.getElementById("tqt").value = ""
    qualificationHeaders.forEach(header => {
        header.addEventListener('click', function() {
            // Get parent box and its elements
            const box = this.parentElement;
            const expandBtn = this.querySelector('.expand-btn');
            const details = box.querySelector('.qualification-details');
            
            // Toggle the expanded state
            const isExpanded = box.classList.contains('expanded');
            
            // First close all boxes
            document.querySelectorAll('.qualification-box').forEach(item => {
                item.classList.remove('expanded');
                const itemBtn = item.querySelector('.expand-btn');
                if (itemBtn) itemBtn.textContent = '+';
                const itemDetails = item.querySelector('.qualification-details');
                if (itemDetails) itemDetails.style.display = 'none';
            });
            
            // Then open this one if it wasn't already open
            if (!isExpanded) {
                box.classList.add('expanded');
                expandBtn.textContent = '−';
                details.style.display = 'block';
            }
        });
    });
});
*/

function autoOpenFaq() {
	var urlParams = new URLSearchParams(window.location.search);
	var faqId = urlParams.get('faq');
	
	if (faqId) {
		var $targetFaq = jQuery('#collapse' + faqId);
		if ($targetFaq.length) {
			// Trigger the Bootstrap collapse
			$targetFaq.collapse('show');
			
			// Scroll to the item
			jQuery('html, body').animate({
				scrollTop: jQuery('#heading' + faqId).offset().top - 100
			}, 500);
		}
	}
}
jQuery(document).ready(function () {
	footer_functions();
	team_modal_trigger();
	ajax_form();
	load_more_button_listener();

	// --- ADD THIS HERE ---
	// 1. Detect when an FAQ is opened and update URL
	jQuery(document).on('shown.bs.collapse', '.accordion-collapse', function () {
		var faqId = jQuery(this).attr('id').replace('collapse', '');
		var currentUrl = new URL(window.location.href);
		currentUrl.searchParams.set('faq', faqId);
		window.history.replaceState({ faqId: faqId }, '', currentUrl.toString());
	});

	// 2. Clear URL if closed
	jQuery(document).on('hidden.bs.collapse', '.accordion-collapse', function () {
		var currentUrl = new URL(window.location.href);
		currentUrl.searchParams.delete('faq');
		window.history.replaceState({}, '', currentUrl.toString());
	});

	// 3. Run auto-open once on initial page load
	autoOpenFaq();
});

// This listens for the Back/Forward button clicks
window.onpopstate = function(event) {
    // If the user hits back, we want to reload the content 
    // based on the URL they just "returned" to.
    
    // In this specific taxonomy setup, a reload is often 
    // the safest way to ensure all WordPress globals reset correctly.
    window.location.reload();
};