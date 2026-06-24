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
	? sprintf(_n('%d result found.', '%d results found.', $found, 'naked'), $found)
	: __('Type a search term to begin.', 'naked');
?>
<div id="primary" class="row-fluid">
	<div id="content" role="main" class="span8 offset2">

		<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>

		<?= hero($hero_title, $hero_desc, false) ?>

		<section class="archive-section search-results-section position-relative">
			<div class="container">

				<?php
				// In-page search form so users can refine without reopening the modal.
				get_search_form();
				?>

				<?php if (have_posts()) : ?>

					<div class="search-results-list">
						<?php
						while (have_posts()) :
							the_post();
							// Shared renderer keeps cards identical to the modal preview.
							echo oa_search_result_item(get_the_ID(), 'page');
						endwhile;
						?>
					</div>

					<div class="pagination-holder text-center mt-5">
						<?php open_awards_pagination($GLOBALS['wp_query']); ?>
					</div>

				<?php else : ?>

					<div class="search-no-results">
						<h2><?php esc_html_e('No results found', 'naked'); ?></h2>
						<p><?php esc_html_e('Sorry, nothing matched your search. Try a different keyword.', 'naked'); ?></p>
					</div>

				<?php endif; ?>

			</div>
		</section>

	</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
