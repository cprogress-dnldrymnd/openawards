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

				<div class="button-box">
					<a href="">Load More</a>
				</div>
			</div>
		</section>
	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>