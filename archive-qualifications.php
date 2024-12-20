<?php get_header() ?>


<div id="primary" class="row-fluid">
    <div id="content" role="main" class="span8 offset2">
        <?php get_template_part('template-parts/page', 'breadcrumbs'); ?>
        <?= do_shortcode('[template template_id=3722]') ?>

        <section class="qualification-filter">
            <div class="container">
                <div class="qualification-filter-wrapper">
                    <div class="qualification-filter-button">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="button-box-v2 button-accent">
                                    <a class="w-100 text-center"
                                        href="https://openawards.theprogressteam.com/qualifications/open-awards-level-3-end-point-assessment-for-st0433-engineering-construction-erector-rigger/">View
                                        Course</a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="button-box button-accent ">
                                    <a class="w-100 text-center"
                                        href="https://openawards.theprogressteam.com/qualifications/open-awards-level-3-end-point-assessment-for-st0433-engineering-construction-erector-rigger/">View
                                        Course</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qualification-filter-holder">
                    <div class="row">
                        <div class="col-lg-5">
                            <label for="">Search</label>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" name="s" placeholder="Keywords" class="trigger-type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <label for="">Qualifications</label>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" name="code" placeholder="Qualification code" class="trigger-type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <label for="">Units</label>
                        </div>
                        <div class="col-lg-7">
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

                    <div class="row">
                        <div class="col-lg-5">
                            <label for="">Access to HE</label>
                        </div>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-6">
                                    <?php
                                    $levels = get_unique_meta_values('_level');
                                    ?>
                                    <select class="trigger-ajax-change" name="level" id="level">
                                        <option value="">Entry level</option>
                                        <?php foreach ($levels as $level) { ?>
                                            <option value="<?= $level ?>"><?= $level ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <?php
                                    $sectors = get_unique_meta_values('_type');
                                    ?>
                                    <select class="trigger-ajax-change" name="sector" id="sector">
                                        <option value="">Sector</option>
                                        <?php foreach ($sectors as $sector) { ?>
                                            <option value="<?= $sector ?>"><?= $sector ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
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
    jQuery(document).ready(function () {
        ajax_qualifications(0);


        var typingTimer;
        var doneTypingInterval = 500;

        jQuery('.trigger-type').on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        jQuery('.trigger-ajax-change').change(function (e) {
            ajax_qualifications(0);
        });
    });

    function doneTyping() {
        ajax_qualifications(0);
    }
</script>