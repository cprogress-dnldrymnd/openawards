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
		<?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
		<div class="title-wrapper">
			<div class="container text-center">
				<div class="heading-box">
					<h2>
						Frequently Asked Questions
					</h2>
				</div>
				<div class="subheading">
					<p>Open Awards believes in fair and transparent pricing. We believe this enables people to make decisions effectively. View our prices for the 2023/2024 courses below.</p>
				</div>
			</div>
		</div>

		
	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>