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
  $posts_per_page = 2;

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
        <div class="col-lg-4">
          <div class="column-holder post-box h-100">
            <div class="image-box">
              <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" alt="">
            </div>
            <div class="content-box">
              <div class="heading-box">
                <h4><?php the_title() ?></h4>
              </div>
              <div class="description-box">
                <?php the_excerpt() ?>
              </div>
              <div class="button-box">
                <a href="<?php the_permalink() ?>">Read more</a>
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
  if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) {
    return '<script>.load-more {display: block !important} </style>';
  }
}
