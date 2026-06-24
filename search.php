<?php

/**
 * Search results template.
 *
 * Robust, JS-free fallback for the AJAX modal and the destination of the
 * "view all results" link / Enter-key submit. The main query has already been
 * widened by includes/search.php (post types, meta, taxonomy terms) via
 * pre_get_posts + the posts_join/search/groupby filters, so here we simply
 * render the loop and paginate it.
 *
 * @package openawards
 */

get_header();

$search_query = get_search_query(); // Already escaped for display.
$found        = (int) $GLOBALS['wp_query']->found_posts;

// Build the hero copy describing the search.
$hero_title = $search_query
	? sprintf(__('Search results for &ldquo;%s&rdquo;', 'naked'), esc_html($search_query))
	: __('Search', 'naked');

$hero_desc = $search_query
	? oa_search_count_text($found)
	: __('Type a search term to begin.', 'naked');

$current_page = max(1, (int) get_query_var('paged'));

// Currently active post-type filters (from ?oa_types[]=…), for pre-checking
// the refine form and preserving the scope in pagination links.
$selected_types = isset($_GET['oa_types']) ? oa_get_selected_search_types($_GET['oa_types']) : array();
?>
<div id="primary" class="row-fluid">
	<div id="content" role="main" class="span8 offset2">

		<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>

		<?= hero($hero_title, $hero_desc, false) ?>

		<section class="archive-section search-results-section position-relative">
			<div class="container">

				<?php
				// In-page search form so users can refine without reopening the modal.
				// The JS controller upgrades this to live, AJAX-driven search; with
				// JS off it still submits a normal GET and reloads search.php.
				get_search_form();
				?>

				<?php
				// #oaSearchResultsArea is the region the JS swaps on live search /
				// pagination. The initial render and the AJAX updates both come from
				// oa_render_search_results(), so the markup is identical either way.
				?>
				<div id="oaSearchResultsArea" class="oa-search-results-area">
					<?php echo oa_render_search_results($GLOBALS['wp_query'], $current_page, $search_query, $selected_types); ?>
				</div>

			</div>
		</section>

	</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
