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
			<div class="title-wrapper">
				<div class="container text-center">
					<div class="heading-box">
						<h2>
							<?= get_the_title() ?>
						</h2>
					</div>
				</div>
			</div>
			<div class="image-box">
				<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
			</div>
			<section class="the-content">
				<?php the_content() ?>
			</section>
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->
<?php } ?>
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>