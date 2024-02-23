<?php 
/**
 * 	Template Name: Page Template : Sign-in Links    
*/
?>
<?php get_header();  ?>
<main id="page-components" style="background-color:#06263F;">

     <div id="content" role="main">
          <?php 
          $heading = get_field('heading') ? get_field('heading') : get_the_title();
          $description = get_field('description') ? get_field('description') : get_the_content();
          $icon_box = get_field('icon_box');
          $bottom_description = get_field('bottom_description');
          $icon_box_columns = get_field('icon_box_columns');
          $icon_box_large_margin = get_field('icon_box_large_margin');

          $column_class = 'col column-5';
          if($icon_box_columns == 3) {
               $column_class = 'col-lg-4 col-md-6';
          } else if($icon_box_columns == 4) {
               $column_class = 'col-lg-3 col-sm-6';
          }
          ?>
<?php get_template_part('template-parts/page', 'breadcrumbs');?>
          
          <section class="icon-box-section" style="color: #fff;  ">
               <div class="container<?= container_width() ?>">
                    <?php if($heading) { ?>
                         <div class="heading-box">
                              <h1>
                                   <?= $heading ?>
                              </h1>
                         </div>
                    <?php } ?>
                    <?php if($description) { ?>
                         <div class="desc-box">
                              <?= wpautop($description) ?>
                         </div>
                    <?php } ?>
                    <?php if($icon_box) { ?>
                         <div class="icons-holder">
                              <div class="row <?= $icon_box_large_margin ?>">
                                   <?php foreach($icon_box as $icon) { ?>
                                        <?php 
                                        $heading = $icon['heading'];
                                        $image = $icon['image'];
                                        $link_text = $icon['link_text'];
                                        $link_url = $icon['link_url'];
                                        $open_in_new_tab = $icon['open_in_new_tab'] ? 'target="_blank"' : '';
                                        ?>
                                        <div class="<?= $column_class ?>">
                                             <div class="column-holder">
                                                  <a href="<?= $link_url ?>" <?= $open_in_new_tab ?>>
                                                       <?php if($image) { ?>
                                                            <div class="image-box">
                                                                 <img src="<?= wp_get_attachment_image_url($image, 'medium'); ?>" alt="<?= $heading ?>">
                                                            </div>
                                                       <?php } ?>

                                                       <?php if($icon_box) { ?>
                                                            <div class="heading-box">
                                                                 <h4>
                                                                      <?= $heading ?>
                                                                 </h4>
                                                            </div>
                                                       <?php } ?>
                                                       <?php if($link_text) { ?>
                                                            <div class="button-box">
                                                                 <span class="button">
                                                                      <?= $link_text ?>
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="12.681" height="10.229" viewBox="0 0 12.681 10.229">
                                                                           <g id="Group_8" data-name="Group 8" transform="translate(-432.5 -1015.385)">
                                                                                <path id="Path_480" data-name="Path 480" d="M422.713,1013.9l4.761,4.761-4.761,4.761" transform="translate(17 1.843)" fill="none" stroke="#492583" stroke-width="1"/>
                                                                                <line id="Line_1" data-name="Line 1" x2="12" transform="translate(432.5 1020.5)" fill="none" stroke="#492583" stroke-width="1"/>
                                                                           </g>
                                                                      </svg>
                                                                 </span>
                                                            </div>
                                                       <?php } ?>

                                                  </a>
                                             </div>
                                        </div>
                                   <?php } ?>

                              </div>
                         </div>
                    <?php } ?>
                    <div class="desc-box">
                         <p>
                              If you wish to discuss your qualification requirements in more detail please <a href="">contact us</a>.
                         </p>
                    </div>
               </div>
          </section>
     </div>
</main>
<?php get_footer();