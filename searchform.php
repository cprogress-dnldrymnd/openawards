<?php

/**
 * Default search form.
 *
 * Used by get_search_form() (e.g. on search.php to let users refine). Posts a
 * GET `s` to the site root, which WordPress routes to search.php.
 *
 * @package openawards
 */
?>
<form role="search" method="get" class="oa-searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="screen-reader-text" for="oa-searchform-input"><?php esc_html_e('Search for:', 'naked'); ?></label>
	<div class="oa-searchform__field">
		<input
			type="search"
			id="oa-searchform-input"
			class="oa-searchform__input"
			placeholder="<?php esc_attr_e('Search…', 'naked'); ?>"
			value="<?php echo esc_attr(get_search_query()); ?>"
			name="s" />
		<button type="submit" class="oa-searchform__submit">
			<i class="fas fa-search" aria-hidden="true"></i>
			<span class="screen-reader-text"><?php esc_html_e('Search', 'naked'); ?></span>
		</button>
	</div>
</form>
