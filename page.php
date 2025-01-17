<section class="hero-style-1"
	style="background-image: url(https://openawards.theprogressteam.com/wp-content/uploads/2024/12/qual-hero-bg.png)">
	<div class="container">
		<div class="title-box">
			<h1>
				<?php the_title() ?>
			</h1>
		</div>
	</div>
</section>
<?php
$page_template = get_page_template_slug(get_the_ID());
if ($page_template == 'templates/page-event.php') {
	get_template_part('templates/page', 'event');
} else {
	get_template_part('templates/page', 'default');
}
?>