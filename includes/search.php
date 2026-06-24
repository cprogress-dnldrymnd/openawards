<?php

/**
 * Advanced Search module for the Open Awards theme.
 *
 * Provides a single, unified search engine that powers BOTH:
 *   1. The AJAX live-search modal (instant results as you type).
 *   2. The native WordPress search results page (search.php), used as a
 *      robust, JS-free fallback and as the "view all results" destination.
 *
 * Both paths run through the exact same data scope so results never diverge:
 *   - Post types:  post, page, qualifications, units, faqs (filterable).
 *   - Taxonomy:    term names within `faqs_category` (filterable).
 *   - Meta:        every post meta value (full Carbon Fields + ACF coverage).
 *
 * The native query is widened cleanly with pre_get_posts +
 * posts_join / posts_search / posts_groupby, with a GROUP BY to prevent the
 * row-duplication that meta/term JOINs would otherwise cause.
 *
 * @package openawards
 */

if (!defined('ABSPATH')) {
	exit; // Block direct file access.
}

/*-----------------------------------------------------------------------------------*/
/* Configuration helpers
/*-----------------------------------------------------------------------------------*/

/**
 * Post types that the search engine should look in.
 *
 * Returned as a filterable list so it stays correct as the data model grows.
 * `qualifications` and `units` are included by request even though they are
 * currently commented out in includes/post-types.php — if/when they are
 * registered (here or by a plugin) they will be searched automatically; if
 * they do not exist WP_Query simply ignores them, so this is always safe.
 *
 * @return string[] Array of post type slugs.
 */
function oa_searchable_post_types()
{
	$post_types = array('post', 'page', 'qualifications', 'units', 'faqs');

	/**
	 * Filter the list of post types included in site search.
	 *
	 * @param string[] $post_types Default searchable post types.
	 */
	return apply_filters('oa_searchable_post_types', $post_types);
}

/**
 * Taxonomies whose term names should be matched during search.
 *
 * @return string[] Array of taxonomy slugs.
 */
function oa_searchable_taxonomies()
{
	/**
	 * Filter the taxonomies whose term names are searched.
	 *
	 * @param string[] $taxonomies Default searchable taxonomies.
	 */
	return apply_filters('oa_searchable_taxonomies', array('faqs_category'));
}

/**
 * Number of results shown in the live AJAX modal preview.
 *
 * @return int
 */
function oa_live_search_limit()
{
	return (int) apply_filters('oa_live_search_limit', 6);
}

/*-----------------------------------------------------------------------------------*/
/* Asset loading (script + style + localized nonce)
/*-----------------------------------------------------------------------------------*/

/**
 * Enqueue the search modal stylesheet and the vanilla-JS controller, and pass
 * the AJAX endpoint + a security nonce + the search results URL to the script.
 *
 * Localising the data (rather than hard-coding it in JS) keeps the AJAX call
 * secure (nonce) and portable (works on any domain / sub-directory install).
 */
function oa_search_enqueue_assets()
{
	wp_enqueue_style(
		'oa-search',
		get_template_directory_uri() . '/search.css',
		array(),
		NAKED_VERSION
	);

	wp_enqueue_script(
		'oa-search',
		get_template_directory_uri() . '/js/search.js',
		array(),
		NAKED_VERSION,
		true // Load in footer.
	);

	wp_localize_script('oa-search', 'OA_SEARCH', array(
		'ajaxUrl'    => admin_url('admin-ajax.php'),
		'nonce'      => wp_create_nonce('oa_search_nonce'),
		'action'     => 'oa_live_search',
		'resultsUrl' => home_url('/'),       // Base for the ?s= redirect.
		'minChars'   => 2,                   // Minimum query length before firing.
		'debounce'   => 300,                 // Debounce window in milliseconds.
		'i18n'       => array(
			'placeholder' => __('Search qualifications, units, FAQs…', 'naked'),
			'noResults'   => __('No results found.', 'naked'),
			'searching'   => __('Searching…', 'naked'),
			'viewAll'     => __('View all results', 'naked'),
			'typeMore'    => __('Keep typing to search…', 'naked'),
		),
	));
}
add_action('wp_enqueue_scripts', 'oa_search_enqueue_assets');

/*-----------------------------------------------------------------------------------*/
/* Search modal markup (rendered globally in the footer)
/*-----------------------------------------------------------------------------------*/

/**
 * Print the search modal overlay into the page footer on every front-end view.
 *
 * Kept here (hooked to wp_footer) rather than in footer.php so the whole
 * feature stays modular and self-contained. The visible toggle icon lives in
 * header.php; this is the panel it opens.
 */
function oa_render_search_modal()
{
	if (is_admin()) {
		return;
	}
	?>
	<div class="oa-search-modal" id="oaSearchModal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Site search', 'naked'); ?>">
		<div class="oa-search-modal__backdrop" data-oa-search-close></div>
		<div class="oa-search-modal__dialog" role="document">
			<button type="button" class="oa-search-modal__close" data-oa-search-close aria-label="<?php esc_attr_e('Close search', 'naked'); ?>">&#10005;</button>

			<form class="oa-search-modal__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				<label class="oa-search-modal__label" for="oaSearchInput"><?php esc_html_e('Search', 'naked'); ?></label>
				<div class="oa-search-modal__field">
					<i class="fas fa-search oa-search-modal__icon" aria-hidden="true"></i>
					<input
						type="search"
						id="oaSearchInput"
						name="s"
						class="oa-search-modal__input"
						placeholder="<?php esc_attr_e('Search qualifications, units, FAQs…', 'naked'); ?>"
						autocomplete="off"
						aria-controls="oaSearchResults"
						aria-expanded="false" />
					<button type="submit" class="oa-search-modal__submit"><?php esc_html_e('Search', 'naked'); ?></button>
				</div>
			</form>

			<div class="oa-search-modal__results" id="oaSearchResults" role="listbox" aria-live="polite"></div>
		</div>
	</div>
	<?php
}
add_action('wp_footer', 'oa_render_search_modal');

/**
 * Output the header search toggle button.
 *
 * Echoed from header.php (see header.php) so the icon sits inside the nav.
 * Provided as a function to keep the markup in one place.
 */
function oa_search_toggle_button()
{
	?>
	<button type="button" class="oa-search-toggle" data-oa-search-open aria-label="<?php esc_attr_e('Open search', 'naked'); ?>" aria-haspopup="dialog">
		<i class="fas fa-search" aria-hidden="true"></i>
	</button>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Native search query widening (search.php fallback + AJAX share this)
/*-----------------------------------------------------------------------------------*/

/**
 * Constrain the main search query to the searchable post types and tag it so
 * our JOIN/WHERE/GROUP BY filters know to act on it.
 *
 * Runs only for the real front-end search query (not admin, not sub-queries),
 * which is exactly the query that search.php renders.
 *
 * @param WP_Query $query The query being prepared.
 */
function oa_search_pre_get_posts($query)
{
	if (is_admin() || !$query->is_main_query() || !$query->is_search()) {
		return;
	}

	$query->set('post_type', oa_searchable_post_types());
	$query->set('post_status', 'publish');

	// Flag this query so the SQL filters below opt in (instead of touching
	// every query on the site).
	$query->set('oa_enhanced_search', true);
}
add_action('pre_get_posts', 'oa_search_pre_get_posts');

/**
 * Whether the given query has opted in to the enhanced search clauses.
 *
 * True for the tagged main search query AND for the AJAX live-search query
 * (which sets the same flag), so both code paths share identical SQL.
 *
 * @param WP_Query $query
 * @return bool
 */
function oa_is_enhanced_search($query)
{
	return $query instanceof WP_Query && $query->get('oa_enhanced_search');
}

/**
 * JOIN the postmeta and taxonomy tables so the WHERE clause can reach meta
 * values and term names in a single query.
 *
 * LEFT JOINs are used so posts with no meta/terms are still returned on a
 * title/content match. The resulting row multiplication is collapsed again by
 * oa_search_groupby().
 *
 * @param string   $join  Existing JOIN SQL.
 * @param WP_Query $query
 * @return string Modified JOIN SQL.
 */
function oa_search_join($join, $query)
{
	if (!oa_is_enhanced_search($query)) {
		return $join;
	}

	global $wpdb;

	$join .= " LEFT JOIN {$wpdb->postmeta} AS oa_sm ON ({$wpdb->posts}.ID = oa_sm.post_id) ";
	$join .= " LEFT JOIN {$wpdb->term_relationships} AS oa_tr ON ({$wpdb->posts}.ID = oa_tr.object_id) ";
	$join .= " LEFT JOIN {$wpdb->term_taxonomy} AS oa_tt ON (oa_tr.term_taxonomy_id = oa_tt.term_taxonomy_id) ";
	$join .= " LEFT JOIN {$wpdb->terms} AS oa_t ON (oa_tt.term_id = oa_t.term_id) ";

	return $join;
}
add_filter('posts_join', 'oa_search_join', 10, 2);

/**
 * Replace WordPress' default (title/content only) search WHERE clause with a
 * comprehensive one that also matches post excerpt, ALL post meta values
 * (Carbon Fields + ACF), and term names in the configured taxonomies.
 *
 * Matching logic mirrors core: every search term must match (AND between
 * terms), and within a term any field may match (OR between fields). Each
 * term is escaped for both LIKE wildcards and SQL via $wpdb->prepare.
 *
 * @param string   $search Existing search SQL (discarded when we opt in).
 * @param WP_Query $query
 * @return string Modified search SQL.
 */
function oa_search_where($search, $query)
{
	if (!oa_is_enhanced_search($query)) {
		return $search;
	}

	global $wpdb;

	// Use the terms WP already parsed; fall back to the raw `s` string.
	$terms = (array) $query->get('search_terms');
	if (empty($terms)) {
		$raw = trim((string) $query->get('s'));
		if ($raw === '') {
			return $search; // Nothing to search for.
		}
		$terms = array($raw);
	}

	// Build the taxonomy restriction once: only match term names in the
	// configured taxonomies (e.g. faqs_category). Taxonomy slugs come from a
	// trusted (filterable) config, so we sanitise + quote them directly rather
	// than nesting $wpdb->prepare() inside the per-term prepare() below.
	$taxonomies = array_map('sanitize_key', oa_searchable_taxonomies());
	$tax_in = '';
	if (!empty($taxonomies)) {
		$quoted = array_map(function ($tax) {
			return "'" . $tax . "'";
		}, $taxonomies);
		$tax_in = ' AND oa_tt.taxonomy IN (' . implode(', ', $quoted) . ') ';
	}

	$clauses = array();

	foreach ($terms as $term) {
		$term = trim($term);
		if ($term === '') {
			continue;
		}

		$like = '%' . $wpdb->esc_like($term) . '%';

		$clauses[] = $wpdb->prepare(
			"(
				{$wpdb->posts}.post_title   LIKE %s
				OR {$wpdb->posts}.post_content LIKE %s
				OR {$wpdb->posts}.post_excerpt LIKE %s
				OR oa_sm.meta_value LIKE %s
				OR ( oa_t.name LIKE %s $tax_in )
			)",
			$like,
			$like,
			$like,
			$like,
			$like
		);
	}

	if (empty($clauses)) {
		return $search;
	}

	// AND the per-term clauses together; respect post_password like core does.
	$search = ' AND (' . implode(' AND ', $clauses) . ') ';

	if (!is_user_logged_in()) {
		$search .= " AND ({$wpdb->posts}.post_password = '') ";
	}

	return $search;
}
add_filter('posts_search', 'oa_search_where', 10, 2);

/**
 * GROUP BY the post ID to collapse the duplicate rows produced by the
 * one-to-many postmeta / term JOINs. Without this a post with several matching
 * meta rows would appear multiple times and inflate found_posts.
 *
 * @param string   $groupby Existing GROUP BY SQL.
 * @param WP_Query $query
 * @return string Modified GROUP BY SQL.
 */
function oa_search_groupby($groupby, $query)
{
	if (!oa_is_enhanced_search($query)) {
		return $groupby;
	}

	global $wpdb;

	$id_col = "{$wpdb->posts}.ID";

	// Don't add it twice if something already grouped by the ID.
	if (strpos((string) $groupby, $id_col) !== false) {
		return $groupby;
	}

	return $id_col;
}
add_filter('posts_groupby', 'oa_search_groupby', 10, 2);

/*-----------------------------------------------------------------------------------*/
/* AJAX live search endpoint
/*-----------------------------------------------------------------------------------*/

/**
 * AJAX handler for the live-search modal.
 *
 * Verifies the nonce, runs the SAME enhanced query used by search.php (capped
 * to a small preview count), and returns rendered result HTML as JSON. Logged
 * in and logged out visitors are both served via wp_ajax_ / wp_ajax_nopriv_.
 */
function oa_live_search_callback()
{
	// Security: reject requests without a valid, current nonce.
	check_ajax_referer('oa_search_nonce', 'nonce');

	$term = isset($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_REQUEST['s'])) : '';

	if (mb_strlen($term) < 2) {
		wp_send_json_success(array(
			'html'  => '',
			'count' => 0,
		));
	}

	$query = new WP_Query(array(
		's'                   => $term,
		'post_type'           => oa_searchable_post_types(),
		'post_status'         => 'publish',
		'posts_per_page'      => oa_live_search_limit(),
		'no_found_rows'       => false, // We want a total count for "view all".
		'ignore_sticky_posts' => true,
		'oa_enhanced_search'  => true,  // Opt in to the shared SQL filters.
	));

	ob_start();

	if ($query->have_posts()) {
		echo '<ul class="oa-search-results__list">';
		while ($query->have_posts()) {
			$query->the_post();
			echo oa_search_result_item(get_the_ID(), 'live');
		}
		echo '</ul>';
	}

	$html = ob_get_clean();
	$found = (int) $query->found_posts;

	wp_reset_postdata();

	wp_send_json_success(array(
		'html'       => $html,
		'count'      => $found,
		'shown'      => (int) $query->post_count,
		'viewAllUrl' => esc_url_raw(add_query_arg('s', $term, home_url('/'))),
	));
}
add_action('wp_ajax_oa_live_search', 'oa_live_search_callback');
add_action('wp_ajax_nopriv_oa_live_search', 'oa_live_search_callback');

/*-----------------------------------------------------------------------------------*/
/* Shared result renderer (used by both the AJAX modal and search.php)
/*-----------------------------------------------------------------------------------*/

/**
 * Render a single search result item.
 *
 * One renderer is used everywhere so the modal preview and the full results
 * page stay visually and structurally consistent.
 *
 * @param int    $post_id The post to render. Defaults to the current post.
 * @param string $context 'live' for the compact modal row, 'page' for the
 *                        full search.php card.
 * @return string HTML markup for the result.
 */
function oa_search_result_item($post_id = 0, $context = 'page')
{
	$post_id = $post_id ? $post_id : get_the_ID();

	$title     = get_the_title($post_id);
	$permalink = get_permalink($post_id);
	$type_obj  = get_post_type_object(get_post_type($post_id));
	$type_lbl  = $type_obj ? $type_obj->labels->singular_name : '';

	// Trim a short, plain-text snippet for context.
	$raw     = has_excerpt($post_id) ? get_the_excerpt($post_id) : get_post_field('post_content', $post_id);
	$snippet = wp_trim_words(wp_strip_all_tags(strip_shortcodes($raw)), $context === 'live' ? 18 : 40, '…');

	ob_start();

	if ($context === 'live') {
		?>
		<li class="oa-search-results__item">
			<a class="oa-search-results__link" href="<?php echo esc_url($permalink); ?>" role="option">
				<span class="oa-search-results__title"><?php echo esc_html($title); ?></span>
				<?php if ($type_lbl) : ?>
					<span class="oa-search-results__type"><?php echo esc_html($type_lbl); ?></span>
				<?php endif; ?>
				<?php if ($snippet) : ?>
					<span class="oa-search-results__snippet"><?php echo esc_html($snippet); ?></span>
				<?php endif; ?>
			</a>
		</li>
		<?php
	} else {
		?>
		<article class="oa-result-card">
			<?php if ($type_lbl) : ?>
				<span class="oa-result-card__type"><?php echo esc_html($type_lbl); ?></span>
			<?php endif; ?>
			<h2 class="oa-result-card__title">
				<a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
			</h2>
			<?php if ($snippet) : ?>
				<p class="oa-result-card__snippet"><?php echo esc_html($snippet); ?></p>
			<?php endif; ?>
			<a class="oa-result-card__more" href="<?php echo esc_url($permalink); ?>"><?php esc_html_e('Read more', 'naked'); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
		</article>
		<?php
	}

	return ob_get_clean();
}
