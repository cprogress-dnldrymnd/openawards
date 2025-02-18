<?php get_header() ?>

<?php
$chev = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/> </svg>';
?>
<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <?= do_shortcode('[template template_id=3722]') ?>

        <section class="qualification-filter" id="qualification-filter" search_type="qualifications">
            <div class="container">
                <div class="qualification-filter-wrapper ">
                    <div class="qualification-filter-buttons">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="filter-button filter-active">
                                    <button post_type="qualifications" search_type=".search-qual"
                                        class="search-change-trigger w-100 text-center d-flex justify-content-between align-items-center">
                                        Search Qualifications <?= $chev ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="filter-button filter-units">
                                    <button post_type="units" search_type=".search-units"
                                        class="search-change-trigger w-100 text-center d-flex justify-content-between align-items-center">
                                        Search Units <?= $chev ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4 d-none">
                                <div class="filter-button filter-access-to-he">
                                    <button search_type=".search-access-to-he"
                                        class="search-change-trigger w-100 text-center d-flex justify-content-between align-items-center">
                                        Search Access To HE <?= $chev ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qualification-filter-holder position-relative">
                        <div class="spinner-holder">
                            <div class="spinner d-inline-block"> <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z">
                                    </path>
                                </svg> </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 search-field search-qual search-units search-access-to-he keywords">
                                <input type="text" name="Title" placeholder="Keywords e.g. warehousing"
                                    class="trigger-type">
                            </div>
                            <div class="col-lg-6 search-field search-qual qualification-code">
                                <input type="text" name="qualificationNumber" placeholder="Qualification Code e.g. 600/5640/X"
                                    class="trigger-type">
                            </div>
                            <div class="col-lg-6 search-field search-qual regulator">
                                <select class="trigger-ajax-change" name="regulator" id="regulator">
                                    <option value="Qualification in Wales">Regulator</option>
                                    <option value="Ofqual">Regulator</option>
                                    <option value="QAA">Regulator</option>
                                    <option value="Non-regulated">Regulator</option>
                                </select>
                            </div>
                            <div class="col-lg-6 search-field search-units unit-code d-none">
                                <input type="text" name="qcaCode" placeholder="Unit Code e.g. Y/505/4889"
                                    class="trigger-type">
                            </div>
                            <div class="col-lg-6 search-field search-access-to-he open-awards-code d-none">
                                <input type="text" name="open_awards_unit_id"
                                    placeholder="Open Awards Unit Code e.g. UA33ART12" class="trigger-type">
                            </div>
                            <div
                                class="col-lg-6 search-field search-units search-access-to-he open-awards-unit-id d-none">
                                <input type="text" name="unitID"
                                    placeholder="Open Awards Unit ID e.g. CBF498" class="trigger-type">
                            </div>
                            <div class="col-lg-6 search-field search-qual search-units search-access-to-he level">
                                <?php
                                $levels = get_unique_meta_values('_level');
                                ?>
                                <select class="trigger-ajax-change" name="Level" id="level">
                                    <option value="">Level</option>
                                    <?php foreach ($levels as $level) { ?>
                                        <option value="<?= $level ?>"><?= $level ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 search-field search-qual search-units search-access-to-he sector">
                                <?php
                                $sectors = QUBA_GetQCASectors();
                                ?>
                                <select class="trigger-ajax-change" name="qcaSector" id="qcaSector">
                                    <option value="">Sector</option>
                                    <?php foreach ($sectors as $sector) { ?>
                                        <option value="<?= $sector->Code ?>"><?= $sector->Classification ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 search-field search-qual type">
                                <?php
                                $types = get_unique_meta_values('_type');
                                sort($types);
                                ?>
                                <select class="trigger-ajax-change" name="qualificationType" id="type">
                                    <option value="">Qualification Type</option>
                                    <?php foreach ($types as $type) { ?>
                                        <?php if ($type) { ?>
                                            <option value="<?= $type ?>"><?= $type ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 search-field min-age d-none">
                                <?php
                                $minages = get_unique_meta_values('_minage');
                                ?>
                                <select class="trigger-ajax-change" name="minage" id="minage">
                                    <option value="">Minimum age e.g.16</option>
                                    <?php foreach ($minages as $minage) { ?>
                                        <?php if ($minage) { ?>
                                            <option value="<?= $minage ?>"><?= $minage ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="archive-section archive-section-qualifications position-relative">
            <div class="container">
                <div id="results">
                    <div class="results-holder">

                    </div>
                </div>

                <div class="vc_btn3-container custom-button text-center mt-5 load-more d-none">
                    <button
                        class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-violet"
                        title="" id="load-more-qualifications">
                        <span>Load More</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path fill="currentColor"
                                d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <?= do_shortcode('[template template_id=2969]') ?>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); // This fxn gets the footer.php file and renders it 
?>
<script>
    jQuery(document).ready(function() {
        ajax_qualifications(0, 'post');
        search_change();
        var typingTimer;
        var search_functionInterval = 500;

        jQuery('.trigger-type').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(search_function, search_functionInterval);
        });

        jQuery('.trigger-ajax-change').change(function(e) {
            search_function();
        });
    });

    function search_change() {
        jQuery('.search-change-trigger').click(function(e) {
            jQuery('.qualification-filter-holder').addClass('searching');
            jQuery('.filter-button').removeClass('filter-active');
            jQuery(this).parent().addClass('filter-active');
            $search_type = jQuery(this).attr('search_type');
            $post_type = jQuery(this).attr('post_type');
            jQuery('.search-field').addClass('d-none');
            jQuery($search_type).removeClass('d-none');
            jQuery('#qualification-filter').attr('search_type', $post_type);
            setTimeout(function() {
                jQuery('.qualification-filter-holder').removeClass('searching');
            }, 500);
            e.preventDefault();
        });
    }

    function search_function() {
        $post_type = jQuery('#qualification-filter').attr('search_type');

        if ($post_type == 'qualifications') {
            ajax_qualifications(0);
        } else if ($post_type == 'units') {
            ajax_units(0);
        }
    }
</script>