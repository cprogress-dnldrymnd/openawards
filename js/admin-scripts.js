jQuery(document).ready(function($) {
	jQuery('#vc_ui-save-template-btn').removeAttr('disabled');
	jQuery('.vc_panel-templates-name').click(function(event) {
		jQuery('#vc_ui-save-template-btn').removeAttr('disabled');
	});
});