<?php

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it 
while (have_posts()) {
	the_post();
?>
	<div id="primary" class="row-fluid">
		<div id="content" role="main" class="span8 offset2">
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
					<div class="image-box mb-5">
						<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'large') ?>" alt="">
					</div>
					<div class="content-box">
						<?php the_content() ?>
					</div>
				</div>
			</section>
			<?php

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 5

			);
			$query = new WP_Query($args);
			?>
			<section class="post-slider">
				<div class="container">
					<div class="row">
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
											<div class="row g-4 align-items-center">
												<div class="col-12">
													<div class="column-holder">
														<div class="image-box">
															<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
														</div>
													</div>
												</div>
												<div class="col-12">
													<div class="column-holder">

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