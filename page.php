<?php 
$page_template = get_page_template_slug(get_the_ID());
if($page_template == 'templates/page-event.php') {
	get_template_part( 'templates/page', 'event' );
} else {
	get_template_part( 'templates/page', 'default' );
}
?>