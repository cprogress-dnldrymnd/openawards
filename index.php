<?php

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it 
if (is_home()) {
	$post_type = 'post';
	$heading = carbon_get_theme_option('post_page_heading');
	$description = carbon_get_theme_option('post_page_description');
	$title = $heading ? $heading : 'Latest News';
	
} else if (is_post_type_archive('successstories')) {
	$post_type = 'successstories';
	$heading = carbon_get_theme_option('successstories_page_heading');
	$description = carbon_get_theme_option('successstories_page_description');

	$title = $heading ? $heading : 'Success Stories';

}
?>
<div id="primary" class="row-fluid">
	<div id="content" role="main" class="span8 offset2">
		<div class="bg-image">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1757.229" height="1005.347" viewBox="0 0 1757.229 1005.347">
				<defs>
					<clipPath id="clip-path">
						<rect width="1757.229" height="1005.347" fill="none" />
					</clipPath>
					<clipPath id="clip-path-2">
						<rect id="Rectangle_361" data-name="Rectangle 361" width="1740.476" height="975.12" transform="translate(0 -0.001)" fill="none" stroke="#fab0ff" stroke-width="1" />
					</clipPath>
				</defs>
				<g id="Repeat_Grid_14" data-name="Repeat Grid 14" clip-path="url(#clip-path)">
					<g transform="translate(601.615 -221.887)">
						<g id="Group_568" data-name="Group 568" transform="translate(1155.614 1196.857) rotate(179)" opacity="0.43">
							<g id="Group_567" data-name="Group 567" clip-path="url(#clip-path-2)">
								<path id="Path_2150" data-name="Path 2150" d="M1711.385,588.47c23.708,149.191-77.277,308.074-222.424,349.94s-315.236-38.824-374.626-177.723-.219-317.618,130.327-393.631C1320.7,322.783,1427.565,400,1424.4,487.928s-93.123,156.42-181.088,154.535-167.281-60.53-214.838-134.554S960.316,346,945.376,259.293C922.761,128.049,795.712,23.107,662.559,25.685S406.517,138.048,389,270.068,461.495,540.119,589.368,577.33c45.572,13.262,98.837-7.811,123-48.663s16.977-97.681-16.595-131.232C603.653,305.373,468.2,258.667,338.912,274.388s-249.6,93.53-316.97,204.986" fill="none" stroke="#fab0ff" stroke-width="51.277" />
							</g>
						</g>
					</g>
				</g>
			</svg>
		</div>

		<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
		<div class="title-wrapper">
			<div class="container text-center">
				<div class="heading-box">
					<h2>
						<?= $title ?>
					</h2>
				</div>
				<div class="subheading">
					<?= wpautop($description) ?>
				</div>
			</div>
		</div>
		<?php if ($post_type == 'post') { ?>
			<?php get_template_part('template-parts/blog/featured-blog') ?>

			<?php
			$terms = get_terms(array(
				'taxonomy'   => 'category',
				'hide_empty' => false,
			));
			?>
			<?php if ($terms) { ?>
				<section class="blog-filter position-relative">
					<div class="container text-end">
						<select id="archive-form-filter" name="category">
							<option value=""> Filter by Category </option>
							<?php foreach ($terms as  $term) { ?>
								<option value="<?= $term->term_id ?>"> <?= $term->name ?> </option>
							<?php } ?>
						</select>
					</div>
				</section>
			<?php } ?>

		<?php } ?>

		<input type="hidden" name="post-type" value="<?= $post_type ?>">


		<section class="archive-section position-relative">
			<div class="container">
				<div id="results">
					<div class="results-holder">

					</div>
				</div>

				<div class="vc_btn3-container custom-button text-center mt-5 load-more d-none">
					<button class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" title="" id="load-more">
						<span>Load More</span>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
							<path fill="currentColor" d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"></path>
						</svg>
					</button>
				</div>
			</div>
		</section>
	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>
<script>
	jQuery(document).ready(function() {
		ajax(0);
	});
</script>