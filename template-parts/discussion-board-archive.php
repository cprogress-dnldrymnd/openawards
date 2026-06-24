<?php 
$oderby = $_GET['oderby'];
$order = $_GET['order'];

$orderby_val = $oderby ? $oderby : 'date';
$order_val = $order ? $order : 'desc';

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
	'post_type' => 'discussion-topics',
	'posts_per_page' => 5,
	'paged' => $paged,
	'orderby' => $orderby_val,
	'order'   => $order_val,
);
$query = new WP_Query($args);

$orderby_fields = array(
	'date' => 'By Date',
	'title' => 'Topic Title',
);

$order_fields = array(
	'desc' => 'Descending',
	'asc' => 'Ascending',
);
?>
<section class="open-awards-discussion-board" id="open-awards-discussion-board">
	<div class="create-topic">
		<a type="button" class="btn btn-secondary" href="/topics/new-topic/">
			Create Topic
		</a>
	</div>
	<div class="filter clearfix">
		<div class="left">
			<span>All latest posts</span>
		</div>
		<div class="right">
			<form action="" name="forum-filter">
				<select class="filter-select" name="oderby" id="">
					<?php foreach($orderby_fields as $key => $orderby_field) { ?>
						<option <?= selected_option($key, $orderby_val) ?> value="<?= $key ?>"><?= $orderby_field ?></option>
					<?php } ?>
				</select>
				<select class="filter-select" name="order" id="">
					<?php foreach($order_fields as $key => $order_field) { ?>
						<option <?= selected_option($key, $order_val) ?> value="<?= $key ?>"><?= $order_field ?></option>
					<?php } ?>
				</select>
			</form>
		</div>
	</div>
	<?php if($query->have_posts()) { ?>
		<table class="table">

			<?php while($query->have_posts()) { ?>
				<?php 
				$query->the_post();
				?>
				<tr>
					<td>
						<h2>
							<a href="<?php the_permalink() ?>"><?php the_title() ?> </a>
						</h2>
					</td>
					<td class="meta number">
						<?= gt_get_post_view(); ?>
					</td>
					<td class="meta number">
						<span><?= get_comments_number() ?></span>
						<span>Replies</span>
					</td>
					<td class="meta date">
						<span><?= get_the_date('d-m-Y') ?></span>
						<span>by <?php the_author() ?></span>
					</td>
				</tr>
			<?php } ?>
		</table>
		<div class="pagination">
			<?php if($query->max_num_pages > 1) { ?>
				<?php if($paged == 1) { ?>
					<span>First</span> 
				<?php } else {?>
					<a href="/topics/?oderby=<?= $orderby_val ?>&order=<?= $order_val ?>">First</a> 
				<?php } ?>
			<?php } ?>

			<?php open_awards_pagination($query) ?> 
			<?php if($query->max_num_pages > 1) { ?>
				<a href="/topics/page/<?= $query->max_num_pages ?>?oderby=<?= $orderby_val ?>&order=<?= $order_val ?>">Last</a> 
			<?php } ?>
		</div>
	<?php } ?>
</section>
<script>
	jQuery(document).ready(function() {
		jQuery('.filter-select').on('change', function() {
			document.forms['forum-filter'].submit();
		});

	});
</script>