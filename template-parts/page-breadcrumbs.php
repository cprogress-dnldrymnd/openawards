<?php
$title = '';
if (is_search()) {
    $title = 'Search results for "' . get_search_query() . '"';
} else if (is_single() || is_page()) {
    $title = get_the_title();
} else if (is_post_type_archive()) {
    $title = post_type_archive_title(false, false);
} else if (is_home()) {
    $title = 'Latest News';
} else if (is_tax()) {
    $title = get_queried_object()->name;
}

// If the visitor arrived from a search results page (same origin, carrying a
// non-empty `s` query), offer a quick way back to that search. This takes
// priority over the default parent crumb on single/page views.
$back_to_search_url = '';
$referer = wp_get_referer();
if ($referer && parse_url($referer, PHP_URL_HOST) === parse_url(home_url(), PHP_URL_HOST)) {
    parse_str((string) parse_url($referer, PHP_URL_QUERY), $referer_params);
    if (!empty($referer_params['s'])) {
        $back_to_search_url = $referer;
    }
}
?>
<section class="breadcrumbs wocom position-relative">
    <nav aria-label="breadcrumb">
        <div class="container">
            <div class="inner-container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                    <?php if (is_tax('faqs_category')) { ?>
                        <li class="breadcrumb-item"><a href="<?= get_post_type_archive_link('faqs') ?>">FAQs</a></li>
                    <?php } ?>
					
					<?php
					$title_2nd = '';
					$link = '';
					if ($back_to_search_url && (is_single() || is_page())) {
						// Came from search → let this crumb take the user back.
						$title_2nd = 'Back to search';
						$link = $back_to_search_url;
					} else if (is_single()) {
						if (get_post_type() == 'post') {
							$title_2nd = 'Latest News';
							$link = get_permalink(get_option('page_for_posts'));
						} else if (get_post_type() == 'jobs') {
							$title_2nd = 'Jobs';
							$link = get_post_type_archive_link('jobs');
						} else if (get_post_type() == 'faqs') {
							$title_2nd = 'FAQs';
							$link = get_post_type_archive_link('faqs');
						}
					} else if (is_page()) {
						if ($post->post_parent) {
							$title_2nd = get_the_title($post->post_parent);
							$link = get_the_permalink($post->post_parent);
						}
					}
					?>
					<?php if ($title_2nd) { ?>
                        <li class="breadcrumb-item"><a href="<?= esc_url($link) ?>"><?= esc_html($title_2nd) ?></a></li>
                    <?php } ?>
                    <li class="breadcrumb-item"><span><?= ucfirst($title) ?></span></li>
                </ol>
            </div>
        </div>
    </nav>
</section>
<?php do_action('after_breadcrumbs') ?>