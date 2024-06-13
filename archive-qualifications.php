<?php get_header() ?>


<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <?= do_shortcode('[template template_id=3722]') ?>

        <section class="archive-section archive-section-qualifications position-relative">
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
		ajax_qualifications(0);
	});
</script>