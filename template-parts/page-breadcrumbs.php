<?php
/**
 * Breadcrumbs partial.
 *
 * The breadcrumb logic now lives in the [breadcrumbs] shortcode
 * (open_awards_breadcrumbs() in includes/shortcodes.php) so it can be reused
 * outside the theme templates. This partial just renders it, keeping every
 * existing get_template_part('template-parts/page', 'breadcrumbs') call working.
 */

if (function_exists('open_awards_breadcrumbs')) {
	echo open_awards_breadcrumbs();
}
