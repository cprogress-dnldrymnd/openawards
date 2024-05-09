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
    <div class="container<?= container_width() ?>">
        <?php if (get_post_type() == 'event') { ?>
            <h1>
                <?php the_title() ?>
            </h1>
        <?php } ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                <?php if (is_tax('faqs_category')) { ?>
                    <li class="breadcrumb-item"><a href="<?= get_post_type_archive_link('faqs') ?>">FAQs</a></li>
                <?php } ?>
                <li class="breadcrumb-item"><span><?= $title ?></span></li>
            </ol>
        </nav>
    </div>
</section>