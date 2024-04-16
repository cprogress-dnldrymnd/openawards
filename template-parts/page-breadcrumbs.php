<?php
if (is_single() || is_page()) {
    $title = get_the_title();
} else if (is_archive()) {
    $title = get_the_archive_title();
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