<?php
/**
 * The template for displaying a single Discussion Topic post type
 * Follow the guidance at wpdiscussionboard.com to update this for your theme
 */

get_header(); ?>


<main id="page-components">
	<div id="content" role="main">

		<?php
	/*
	 * The hook for the template's opening tags
	 * @hooked ctdb_open_wrapper_single
	*/ ?>
	<?php get_template_part('template-parts/page', 'banner');?>
	<section class="breadcrumbs wocom">
		<nav aria-label="breadcrumb">
			<div class="container<?= hero-style-1) ?>">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
					<li class="breadcrumb-item"><a href="/community/">OpenAwards Community</a></li>
					<li class="breadcrumb-item"><span><?php the_title() ?></span></li>
				</ol>
			</div>
		</nav>
	</section>

	<?php do_action ( 'ctdb_open_wrapper_single' ); ?>
	
	<?php
		// Start the loop.
	while ( have_posts() ) : the_post(); ?>
		

		<?php gt_set_post_view(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


			<div class="container">
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>

		</article>

			<?php // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				?>
			<div class="comments-holder">
				<div class="container">
					<?php comments_template(); ?>
				</div>
			</div>
			<?php
		endif;
		
			// Previous/next post navigation.
		the_post_navigation ( array(
			'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'wp-discussion-board' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Next topic:', 'wp-discussion-board' ) . '</span> ' .
			'<span class="post-title">%title</span>',
			'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'wp-discussion-board' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Previous topic:', 'wp-discussion-board' ) . '</span> ' .
			'<span class="post-title">%title</span>',
		) );

		// End the loop.
	endwhile;
	?>

	<?php
	/*
	 * The hook for the template's closing tags
	 * @hooked ctdb_close_wrapper_single
	*/ ?>
	<?php do_action ( 'ctdb_close_wrapper_single' ); ?>
	<button type="button" class="btn btn-danger report-btn" data-toggle="modal" data-target="#oaModal">
		<i class="fas fa-exclamation-triangle"></i> <span>Report Abuse</span>
	</button>
	<div class="modal fade etiquette report-abuse" id="oaModal" tabindex="-1" role="dialog" aria-labelledby="oaModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3>
						Report Abuse
					</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?= do_shortcode( '[contact-form-7 id="3766" title="Community Topic Report"]' ); ?>
				</div>
			</div>
		</div>
	</div>

</div><!-- #content .site-content -->

</main>
<?php get_footer(); ?>
<script>
	jQuery(document).ready(function() {
		jQuery('.report-btn').appendTo('.logged-in-as');
	});
</script>