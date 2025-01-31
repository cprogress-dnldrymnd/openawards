<?php get_header() ?>
<?php
$level = carbon_get_the_post_meta('level');
$qualificationreferencenumber = carbon_get_the_post_meta('qualificationreferencenumber');
$reviewdate = carbon_get_the_post_meta('reviewdate');
$regulationstartdate = carbon_get_the_post_meta('regulationstartdate');
$minage = carbon_get_the_post_meta('minage');
$tqt = carbon_get_the_post_meta('tqt');
$glh = carbon_get_the_post_meta('glh');
$type = carbon_get_the_post_meta('type');

function key_info($key, $label, $type = 'string')
{
  $keyinfo = carbon_get_the_post_meta($key);
  if ($type == 'date') {
    $originalDate = $keyinfo;
    $keyinfo = date("d F Y", strtotime($originalDate));
  }
  if ($keyinfo) {
    return "<div class='key-info-item'><strong>$label:</strong> $keyinfo</div>";
  }
}
?>
<div id="primary" class="row-fluid">
  <div id="content" role="main" class="span8 offset2">
    <section class="hero-style-1"
      style="background-image: url(https://openawards.theprogressteam.com/wp-content/uploads/2024/12/qual-hero-bg.png)">
      <div class="container">
        <div class="title-box">
          <h1>
            <?php the_title() ?>
          </h1>
        </div>
        <div class="key-information-box">
          <h3>Key Information</h3>
          <div class="key-information-holder">
            <div class="row">
              <div class="col-sm-6">
                <div class="key-info-items">
                  <?php
                  echo key_info('type', 'Sector');
                  echo key_info('qualificationreferencenumber', 'Qualification Code');
                  echo key_info('level', 'Level');
                  echo key_info('regulationstartdate', 'Start Date', 'date');
                  ?>
                  <div class="key-info-item"><strong>Start Date:</strong> 31 July 2020</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="key-info-items">
                  <?php
                  echo key_info('reviewdate', 'Review Date', 'date');
                  echo key_info('glh', 'Guided Learning Hours');
                  echo key_info('minage', 'Min Age');
                  echo key_info('tqt', 'TQT');
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="info-boxes">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-6">
            <div class="info-box">
              <div class="inner">
                <h2 class="h2-style-1">Purpose Statement<span>.</span></h2>
                <ul>
                  <li>About the Qualifitcation</li>
                  <li>Qualification Units</li>
                  <li>Delivering this Qualification</li>
                  <li>Appendices and Links</li>
                </ul>
                <div class="button-box-v2 button-primary">
                  <a href="#">Purpose Statement</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="info-box">
              <div class="inner">
                <h2 class="h2-style-1">Purpose Statement<span>.</span></h2>
                <ul>
                  <li>Who is it for?</li>
                  <li>What does this qualification cover?</li>
                  <li>What are the Entry Requirements?</li>
                  <li>What are the Assessment Methods?</li>
                  <li>What are the Progression Opportunities?</li>
                  <li>Who supports this qualification?</li>
                </ul>
                <div class="button-box-v2 button-accent">
                  <a href="#">Qualification Guide</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="info-box info-box-v2">
              <div class="inner">
                <div class="row align-items-center g-3">
                  <div class="col">
                    <p>
                      This occupation is found in horticulture grounds maintenance, landscaping, parks, greenspaces and
                      gardens (historic, botanic, destination and estate). They might be working for a charity, a
                      consultancy, governmental organisation, private estate/client or commercial contractor. The broad
                      purpose of the occupation is to develop, build and manage parks, gardens, greenspaces and grounds
                      (e.g. business parks, schools, retail sites etc..). This includes planning the site, engaging with
                      clients, customers and visitors, financial management and income generation.
                    </p>
                    <p>
                      Open Awards has
                      committed, in principle, to develop this End-point Assessment. Development will start in September
                      2023.
                    </p>
                    <p>
                      To talk to a member of the team about how we can support you with your end-point assessment
                      needs, please call us on 0151 494 2072 or enquiries@openawards.org.uk
                    </p>
                  </div>
                  <div class="col-auto">
                    <img src="https://openawards.theprogressteam.com/wp-content/uploads/2024/12/NoPath.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="back-to mt-4">
          <div class="button-box-v2 button-accent">
            <a href="/qualifications/"><svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
              </svg> Back to Qualifications</a>
          </div>
        </div>
      </div>
    </section>
    <section class="related-qualifications archive-section archive-section-qualifications pt-0">
      <div class="container">
        <h2 class="h2-style-1">
          Explore our Qualifications
        </h2>
        <?= do_shortcode('[related_qualifications]') ?>
      </div>
    </section>
    <?= do_shortcode('[template template_id=2969]') ?>
  </div>
</div>
<?php get_footer() ?>