<?php
if (is_single() || is_page()) {
    $title = get_the_title();
} else if (is_post_type_archive()) {
    $title = post_type_archive_title(false, false);
} else if (is_home()) {
    $title = 'Latest News';
} else if (is_tax()) {
    $title = get_queried_object()->name;
}
?>
<section class="breadcrumbs wocom position-relative">
    <nav aria-label="breadcrumb">
        <div class="container<?= container_width() ?>">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                <?php if (is_tax()) { ?>
                    <li class="breadcrumb-item"><a href="<?= get_site_url() ?>"><?= get_post_type() ?></a></li>
                <?php } ?>
                <li class="breadcrumb-item"><span><?= $title ?></span></li>
            </ol>
        </div>
    </nav>
</section>