<?php
add_action('wp_ajax_nopriv_resources', 'resources'); // for not logged in users
add_action('wp_ajax_resources', 'resources');
function resources()
{
  $args = array(

    'post_type'      => 'product',

    'posts_per_page' => -1,

    'orderby'        => 'modified',

    'order'          => 'DESC',

  );

  $the_query = new WP_Query($args);

  $resources_array = array();
  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
      $the_query->the_post();
      $resources = carbon_get_the_post_meta('resources');
      if ($resources) {
        foreach ($resources as $resource) {
          if (isset($_GET['resource_type'])) {
            if ($_GET['resource_type'] == 'Videos') {
              if ($resource['resource_type'] == 'Videos' || $resource['resource_type'] == 'Videos Embed') {
                $resources_array[] = array(
                  'resource_product'   => get_the_title(),
                  'resource_type'      => $resource['resource_type'],
                  'resource_title'     => $resource['resource_title'],
                  'resource_thumbnail' => $resource['resource_thumbnail'],
                  'resource_file'      => $resource['resource_file'],
                  'embed_video_url'    => $resource['embed_video_url'],
                );
              }
            } else {
              if ($resource['resource_type'] == $_GET['resource_type']) {
                $resources_array[] = array(
                  'resource_product'   => get_the_title(),
                  'resource_type'      => $resource['resource_type'],
                  'resource_title'     => $resource['resource_title'],
                  'resource_thumbnail' => $resource['resource_thumbnail'],
                  'resource_file'      => $resource['resource_file'],
                  'embed_video_url'    => $resource['embed_video_url'],
                );
              }
            }
          } else {
            $resources_array[] = array(
              'resource_product'   => get_the_title(),
              'resource_type'      => $resource['resource_type'],
              'resource_title'     => $resource['resource_title'],
              'resource_thumbnail' => $resource['resource_thumbnail'],
              'resource_file'      => $resource['resource_file'],
            );
          }
        }
      }
      wp_reset_postdata();
    }
  }
?>
  <ul class="row" id="resources">

    <?php if ($resources_array) { ?>

      <?php foreach ($resources_array as $resource_val) { ?>

        <?php
        $resource_product = $resource_val['resource_product'];
        $resource_type = $resource_val['resource_type'];
        $resource_title = $resource_val['resource_title'];
        $resource_thumbnail = $resource_val['resource_thumbnail'];
        $resource_file = $resource_val['resource_file'];
        ?>

        <li class="col-md-4">
          <div class="inner">
            <a href="<?= wp_get_attachment_url($resource_file) ?>" target="_blank" class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-fancybox>

              <div class="image-box">

                <?= get_resource_image($resource_type, $resource_thumbnail) ?>

              </div>

              <div class="bottom-box">
                <div class="heading-box">
                  <h3><?= $resource_product ?></h3>
                </div>
                <div class="title-box">
                  <h2>
                    <?= $resource_title ?>
                  </h2>
                </div>

                <span class="resource-btn d-inline-flex align-items-center disable-default-hover-no w-100 justify-content-between">
                  <?php
                  if ($resource_type == 'Brochure') {

                    echo 'READ THE BROCHURE';
                  } else if ($resource_type == 'Technical Data') {

                    echo 'READ THE SPEC';
                  } else {
                    echo 'WATCH THE VIDEO';
                  }
                  ?>
                  <span class="icon-after btn-icon"><i aria-hidden="true" class="fas fa-arrow-right"></i></span>
                </span>
              </div>
            </a>
          </div>

        </li>

      <?php } ?>

    <?php } else { ?>

      <li class="no-resource col-md-12">

        <h2>No resources found</h2>

      </li>

    <?php } ?>

  </ul>

<?php

  die();
}
add_action('wp_ajax_nopriv_archive_ajax', 'archive_ajax'); // for not logged in users
add_action('wp_ajax_archive_ajax', 'archive_ajax');
function archive_ajax()
{
  $category = $_POST['category'];
  $post_type = $_POST['post_type'];
  $offset = $_POST['offset'];
  $posts_per_page = 6;

  $args = array(
    'post_type' => $post_type,
    'posts_per_page' => $posts_per_page,
  );

  if ($offset) {
    $args['offset'] = $offset;
  }



  if ($category) {
    $args['cat'] = $category;
  }

  $the_query = new WP_Query($args);

  $count = $the_query->found_posts;
  echo hide_load_more($count, $offset, $posts_per_page);
?>
  <?php if (!$offset) { ?>
    <div class="row g-4">
    <?php } ?>
    <?php
    if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();
    ?>
        <div class="col-lg-4 post-item">
          <?php
          if ($post_type == 'post') {
            echo do_shortcode('[post_box id="' . get_the_ID() . '" class="column-holder -100"]');
          } else if ($post_type == 'successstories') {
            echo do_shortcode('[successstories successstories_id="' . get_the_ID() . '" ]');
          }
          ?>
        </div>
      <?php }
    } else {
      ?>
      <h2>No Results Found</h2>
    <?php
    }
    wp_reset_postdata();
    ?>
    <?php if (!$offset) { ?>
    </div>
  <?php } ?>


<?php

  die();
}


add_action('wp_ajax_nopriv_faqs_ajax', 'faqs_ajax'); // for not logged in users
add_action('wp_ajax_faqs_ajax', 'faqs_ajax');
function faqs_ajax()
{
  $faqs_category = $_POST['faqs_category'];
  $offset = $_POST['offset'];
  $s = $_POST['s'];
  $posts_per_page = 10;

  $args = array(
    'post_type' => 'faqs',
    'posts_per_page' => $posts_per_page,
  );

  if ($faqs_category) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'faqs_category',
        'field' => 'term_id',
        'terms' => $faqs_category,
      ),
    );
  }

  if ($offset) {
    $args['offset'] = $offset;
  }

  if ($s) {
    $args['s'] = $s;
  }

  /*
  if ($faqs_category) {
    $args['cat'] = $faqs_category;
  }*/

  $the_query = new WP_Query($args);

  $count = $the_query->found_posts;
  echo hide_load_more($count, $offset, $posts_per_page);
?>
  <?php if (!$offset) { ?>
    <div class="accordion-holder accordion-style-2">
      <div class="accordion" id="accordion">
      <?php } ?>
      <?php
      if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
          $the_query->the_post();
      ?>
          <div class="accordion-item post-item">
            <h2 class="accordion-header" id="heading<?= get_the_ID() ?>">
              <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= get_the_ID() ?>" aria-expanded="false" aria-controls="collapse<?= get_the_ID() ?>">
                <span> <?php the_title() ?></span>

                <svg class="icon-inactive" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
                <svg class="icon-active" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                  <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                </svg>
              </button>
            </h2>
            <div id="collapse<?= get_the_ID() ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= get_the_ID() ?>" data-bs-parent="#accordion">
              <div class="accordion-body">
                <?php the_content() ?>
              </div>
            </div>
          </div>
        <?php }
      } else {
        ?>
        <h2>No Results Found</h2>
      <?php
      }
      wp_reset_postdata();
      ?>
      <?php if (!$offset) { ?>
      </div>
    </div>
  <?php } ?>


<?php

  die();
}

add_action('wp_ajax_nopriv_archive_ajax_qualifications', 'archive_ajax_qualifications'); // for not logged in users
add_action('wp_ajax_archive_ajax_qualifications', 'archive_ajax_qualifications');
function archive_ajax_qualifications()
{
  $category = $_POST['category'];
  $post_type = $_POST['post_type'];
  $offset = $_POST['offset'];
  $posts_per_page = 6;

  $args = array(
    'post_type' => 'qualifications',
    'posts_per_page' => $posts_per_page,
  );

  if ($offset) {
    $args['offset'] = $offset;
  }



  if ($category) {
    $args['cat'] = $category;
  }

  $the_query = new WP_Query($args);

  $count = $the_query->found_posts;
  echo hide_load_more($count, $offset, $posts_per_page);
?>
  <?php if (!$offset) { ?>
    <div class="row g-4">
    <?php } ?>
    <?php
    if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();
        $fee = carbon_get_the_post_meta('fee');
        $level = carbon_get_the_post_meta('level');
        if ($level == 'E1' || $level == 'E2' || $level == 'E3') {
          $level_val = str_replace('E', 'Entry Level ', $level);
        } else {
          $level_val = str_replace('L', 'Level ', $level);
        }
    ?>
        <div class="col-lg-4 post-item">
          <div class="post-box">
            <div class="image-box image-box-placeholder">
              <img src="https://openawards.theprogressteam.com/wp-content/uploads/2023/10/logo-new.svg">
              <span class="level <?= $level ?>">
                <?= $level_val ?>
              </span>
            </div>
            <div class="content-box content-box-v1">
              <div class="heading-excerpt-box">
                <div class="heading-box">
                  <h4><?php the_title() ?></h4>
                </div>
                <div class="description-box">
                  <?php the_excerpt() ?>
                </div>
              </div>
            </div>
            <div class="button-group-box row g-0 align-items-center">

              <div class="fee-box col">
                <?php
                if ($fee) {
                  echo $fee;
                } else {
                  echo 'None';
                }
                ?>

              </div>

              <div class="button-box-v2 button-accent col">
                <a class="w-100 text-center" href="<?php the_permalink() ?>">Read more</a>
              </div>
            </div>
          </div>
        </div>
      <?php }
    } else {
      ?>
      <h2>No Results Found</h2>
    <?php
    }
    wp_reset_postdata();
    ?>
    <?php if (!$offset) { ?>
    </div>
  <?php } ?>


  <?php

  die();
}


function hide_load_more($count, $offset, $posts_per_page)
{
  ob_start();
  if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) {
  ?>
    <script>
      jQuery(document).ready(function() {
        jQuery('.load-more').addClass('d-none');
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      jQuery(document).ready(function() {
        jQuery('.load-more').removeClass('d-none');
      });
    </script>
<?php
  }
  return ob_get_clean();
}
