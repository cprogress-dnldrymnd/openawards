<?php

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it 
while (have_posts()) {
	the_post();
	$cta_heading = carbon_get_the_post_meta('cta_heading');
	$button_text = carbon_get_the_post_meta('button_text');
	$button_link = carbon_get_the_post_meta('button_link');
	$bottom_text = carbon_get_the_post_meta('bottom_text');
?>
	<div id="primary" class="row-fluid overflow-hidden">

		<div id="content" role="main" class="span8 offset2">
			<div class="bg-accent"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1757.229" height="1005.347" viewBox="0 0 1757.229 1005.347">
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
				</svg></div>
			<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
			<div class="title-wrapper title-wrapper-v2">
				<div class="container text-center">
					<div class="heading-box">
						<h2>
							<?= get_the_title() ?>
						</h2>
					</div>
					<div class="date-box">
						<?= get_the_date() ?>
					</div>
				</div>
			</div>

			<section class="the-content">
				<div class="container">
					<div class="image-box content-holder">
						<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'large') ?>" alt="">
					</div>
					<div class="content-holder">
						<?php the_content() ?>
					</div>
					<?php if ($cta_heading) { ?>
						<div class="cta-box">
							<div class="content-holder">
								<div class="row g-4 align-items-center">
									<div class="col-lg-8">
										<div class="heading-box">
											<h2>
												<?= $cta_heading ?>
											</h2>
										</div>
									</div>
									<?php if ($button_text) { ?>
										<div class="col-lg-4">
											<div class="vc_btn3-container vc_btn3-inline text-start  text-lg-end"><a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-white" href="<?= $button_link ?>"><?= $button_text ?></a></div>
										</div>
									<?php } ?>

								</div>
							</div>
						</div>
					<?php } ?>
					<?php if ($bottom_text) { ?>
						<div class="content-holder">
							<?= wpautop($bottom_text) ?>
						</div>
					<?php } ?>

				</div>
			</section>
			<?php

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 5

			);
			$query = new WP_Query($args);
			?>
			<section class="post-slider post-slider-related">
				<div class="container">
					<div class="row mb-5 mt-5">
						<div class="col">
							<div class="heading-box">
								<h2>Latest News</h2>
							</div>
						</div>
						<div class="col-auto">
							<div class="vc_btn3-container vc_btn3-inline"><a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" href="#" title="">All News</a></div>
						</div>
					</div>
					<div class="swiperPostSlider-holder position-relative swiper-button-style-1 p-0">
						<div class="swiper swiperPostSlider-Related">
							<div class="swiper-wrapper">
								<?php while ($query->have_posts()) {
									$query->the_post(); ?>
									<div class="swiper-slide">
										<div class="post-box post-box-slider">
											<div class="image-box">
												<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
											</div>
											<div class="content-box">
												<div class="heading-box">
													<h4><?php the_title() ?></h4>
												</div>
												<div class="description-box">
													<?php the_excerpt() ?>
												</div>
												<div class="button-box">
													<a href="<?php the_permalink() ?>">Read more</a>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
						<div class="swiper-button-next swiper-button-next-post"></div>
						<div class="swiper-button-prev swiper-button-next-post"></div>
					</div>

				</div>
			</section>
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->
<?php } ?>
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>