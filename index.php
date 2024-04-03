<?php

/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it 
?>
<div id="primary" class="row-fluid">
	<div id="content" role="main" class="span8 offset2">

		<?php if (is_home()) {
			$title = 'Latest News';
		}
		?>

		<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
		<div class="title-wrapper">
			<div class="container text-center">
				<div class="heading-box">
					<h2>
						<?= $title ?>
					</h2>
				</div>
				<div class="subheading">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa accusamus, quis optio vel ullam quae perferendis esse nostrum rem, odio ratione error asperiores soluta aperiam? Ratione deserunt molestiae qui eaque?</p>
				</div>
			</div>
		</div>

		<section class="post-slider">
			<div class="container">
				<div class="swiper swiperPostSlider">
					<div class="swiper-wrapper">
						<?php while (have_posts()) {
							the_post(); ?>
							<div class="swiper-slide">
								<div class="post-box">
									<div class="row">
										<div class="col-lg-6">
											<div class="column-holder">
												<div class="image-box">
													<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
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
						<?php } ?>
					</div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
		</section>
		<section class="archive-section">
			<div class="container">
				<div class="row">
					<?php while (have_posts()) {
						the_post(); ?>
						<div class="col-lg-4">
							<div class="column-holder post-box">
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
				</div>

				<div class="vc_btn3-container custom-button text-center mt-5">
					<a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet" href="#" title="">Load More</a>
				</div>
			</div>
		</section>
	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>