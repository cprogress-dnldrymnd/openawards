 <header class="woocommerce-products-header dark page-dark-header">
     <div class="page-shop-banner <?php the_field('page_banner_text_align') ?>">
          <div class="container">
               <?php if(is_account_page()) { ?>
                    <h1 class="woocommerce-products-header__title page-title my-account-header">
                         Hello <?= wp_get_current_user()->display_name ?>!
                         <span class="logout-url-mobile">
                              <a href="<?= wp_logout_url(wc_get_page_permalink( 'myaccount' ))  ?>">Logout</a>
                         </span>
                    </h1>
               <?php } else { ?>
               <h1 class="woocommerce-products-header__title page-title"><?php the_title() ?></h1>
               <?php } ?>
               <?php if(get_field('subheading')) { ?>
                    <div class="subheading">
                         <p><?php the_field('subheading') ?></p>
                    </div>
               <?php } ?>
          </div>
     </div>

</header>