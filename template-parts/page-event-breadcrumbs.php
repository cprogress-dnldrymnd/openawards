<?php $id = get_the_ID() ?>
<?php $post_type = get_post_type() ?>
<section class="breadcrumbs wocom">
	<nav aria-label="breadcrumb">
		<div class="container wide width1400">
			<?php if (is_single()) { ?>
				<h1>
					<?php the_title() ?>
				</h1>
			<?php } ?>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>

				<?php if ($id == 1079) { ?>
					<li class="breadcrumb-item"><span>Events</span></li>
				<?php } else { ?>
					<li class="breadcrumb-item"><a href="<?= get_permalink(1079) ?>">Events</a></li>
				<?php } ?>


				<?php if ($post_type == 'location') { ?>
					<li class="breadcrumb-item"><a href="<?= get_permalink(1080) ?>">Locations</a></li>
				<?php } ?>

				<?php if (is_single()) { ?>
					<li class="breadcrumb-item"><span><?php the_title() ?></span></li>
				<?php } ?>



				<?php if ($id == 1080) {  ?>
					<li class="breadcrumb-item"><span>Locations</span></li>
				<?php } ?>

				<?php if ($id == 1081) {  ?>
					<?php
					$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$link_array = explode('/', $link);
					$page = end(array_filter($link_array));
					?>
					<?php if ($page != 'categories') { ?>
						<li class="breadcrumb-item"><a href="<?= get_permalink($id) ?>"><?= get_the_title($id) ?></a></li>
						<li class="breadcrumb-item"><span class="cap"> <?= $page ?></span></li>
					<?php } else {  ?>
						<li class="breadcrumb-item"><span class="cap"><?= get_the_title($id) ?></span></li>
					<?php } ?>
				<?php } ?>
			</ol>
		</div>
	</nav>
</section>