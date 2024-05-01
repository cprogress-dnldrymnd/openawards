<?php
if (is_single() || is_page()) {
    $title = get_the_title();
} else if (is_post_type_archive() || is_tax()) {
    $title = post_type_archive_title(false, false);
} else if (is_home()) {
    $title = 'Latest News';
}
?>
<section class="breadcrumbs wocom position-relative">
    <nav aria-label="breadcrumb">
        <div class="container<?= container_width() ?>">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><span><?= $title ?></span></li>
            </ol>
        </div>
    </nav>
</section>