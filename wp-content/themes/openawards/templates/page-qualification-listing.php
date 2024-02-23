<?php 
/**
 *  Template Name: Page Template : Qualifications Listing  
*/
?>
<?php get_header();  ?>
<main class="qualificationListing">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php if(!get_field('hide_breadcrumbs')) { ?>
                <?php get_template_part('template-parts/page', 'breadcrumbs');?>
            <?php } ?>
            <section class="page-banner">
                <div class="container<?= container_width() ?>">
                    <h1>Arts, Media and Publishing</h1>
                </div>
            </section>
            <?php if(get_the_content()) { ?>
                <section class="rich-text bg-dirtyWhite">
                    <div class="container<?= container_width() ?>">
                        <div class="inner">
                            <?php the_content() ?>
                        </div>
                    </div>
                </section>
            <?php } ?>
            <section class="filter-section">
                <div class="container<?= container_width() ?>">
                    <form action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-wrapper">
                                    <select name="" id="">
                                        <option value="">Select Topic</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 1</option>
                                        <option value="3">Option 1</option>
                                        <option value="4">Option 1</option>
                                        <option value="5">Option 1</option>
                                        <option value="6">Option 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-wrapper">
                                    <select name="" id="">
                                        <option value="">Size</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 1</option>
                                        <option value="3">Option 1</option>
                                        <option value="4">Option 1</option>
                                        <option value="5">Option 1</option>
                                        <option value="6">Option 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-wrapper">
                                    <input type="text" placeholder="Search Qualifications..." />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <section class="main-content padCon qualification-listing">
                <div class="container<?= container_width() ?>">
                    <?php 
                    $tabs = array(
                        'Entry Level 1',
                        'Entry Level 2',
                        'Entry Level 3',
                        'Level 1',
                        'Level 2',
                        'Level 3',
                        'Level 3',
                    );
                    ?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php foreach($tabs as $key => $tab) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $key == 0 ? 'active' : '' ?>" id="id-tab-<?= $key ?>" data-toggle="tab" href="#id-<?= $key ?>" role="tab" aria-controls="id" aria-selected="true"><?= $tab ?></a>
                            </li>
                        <?php } ?>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <?php foreach($tabs as $key => $tab) { ?>
                            <div class="tab-pane fade <?= $key == 0 ? 'show active' : '' ?>" id="id-<?= $key ?>" role="tabpanel" aria-labelledby="id-tab-<?= $key ?>">
                                <div class="card-holder">
                                    <?php $i = 1 ?>
                                    <?php while($i != 5) { ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-4 display-none-sm">
                                                    <div class="image-holder">
                                                        <img src="https://openawards.theprogressteam.com/wp-content/uploads/2021/04/qualification-guide.png" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-8">
                                                    <div class="details">
                                                        <div class="row row-image-title align-items-center">
                                                            <div class="col-sm-4 display-none-md">
                                                                <div class="image-holder">
                                                                    <img src="https://openawards.theprogressteam.com/wp-content/uploads/2021/04/qualification-guide.png" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-sm-8">
                                                                <h2>Open Awards Entry Level Award in Creative Arts</h2>
                                                            </div>
                                                        </div>
                                                        <div class="row row-details">
                                                            <div class="col-md-3 col-sm-6 col-6">
                                                                <div class="meta-details">
                                                                    <div class="meta-item">
                                                                        <label>Qualification Code</label>
                                                                        <p>603/6089/6</p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Qualification Type</label>
                                                                        <p> &lt;Qualification Type&gt; </p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Grading Type</label>
                                                                        <p> &lt;Grading Type&gt; </p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Assessment Methods</label>
                                                                        <p> &lt;Assessment Methods&gt; </p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 col-6">
                                                                <div class="meta-details">
                                                                    <div class="meta-item">
                                                                        <label>Credit Value</label>
                                                                        <p> &lt;Credit Value&gt; </p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Minimum Age</label>
                                                                        <p> &lt;Minimum Age&gt; </p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Guided Learning Hours</label>
                                                                        <p> &lt;Guided Learning Hours&gt; </p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>TQT</label>
                                                                        <p> &lt;TQT&gt; </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="meta-details">
                                                                    <div class="meta-item">
                                                                        <label>Qualification Code</label>
                                                                        <p>A national awarding organisation approved by the regulator Ofqual and the Quality Assurance Agency for higher education (QAA). A national awarding organisation approved by the regulator Ofqual</p>
                                                                    </div>
                                                                    <div class="meta-item column-50">
                                                                        <label>Start Date</label>
                                                                        <p>12/01/2022</p>
                                                                    </div>
                                                                    <div class="meta-item column-50">
                                                                        <label>Review Date</label>
                                                                        <p>14/01/2022</p>
                                                                    </div>
                                                                    <div class="meta-item">
                                                                        <label>Operational End Date</label>
                                                                        <p>14/01/2022</p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="btn-group row" id="btn-group">
                                                            <div class="col-4">
                                                                <a href="#" class="btn btn-secondary">Qualification Guide</a>
                                                            </div>
                                                            <div class="col-4">
                                                                <a href="#" class="btn btn-outline-primary">Purpose Statement</a>
                                                            </div>
                                                            <div class="col-4">
                                                                <a href="#" class="btn btn-purple">Sample Assessment</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++ ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="page-holder">
                        <hr class="separator" />
                        <div class="pagination">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item disabled"><a class="page-link" href="#">First</a></li>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#"><i class="fas fa-arrow-left"></i></a>
                                    </li>
                                    <li class="page-item current"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-arrow-right"></i></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">Last</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        <?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

    <?php endif ?>
</main>
<?php get_footer();
