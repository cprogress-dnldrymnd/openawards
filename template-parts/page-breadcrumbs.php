<section class="breadcrumbs wocom">
    <nav aria-label="breadcrumb">
        <div class="container<?= container_width() ?>">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                <?php if (is_single() || is_page()) { ?>
                    <li class="breadcrumb-item"><span><?php the_title() ?></span></li>
                <?php } ?>

                <?php if (is_archive()) { ?>
                    <li class="breadcrumb-item"><span><?php post_type_archive_title(false) ?></span></li>
                <?php } ?>
            </ol>
        </div>
    </nav>
</section>