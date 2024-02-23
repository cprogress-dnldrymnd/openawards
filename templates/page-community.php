<?php 
/**
 * 	Template Name: Page Template : Community   
*/
?>
<?php get_header();  ?>
<main id="page-components">


     <div id="content" role="main">
        <?php if ( have_posts() ) : 
               // Do we have any posts/pages in the databse that match our query?
          ?>
          <?php get_template_part('template-parts/page', 'banner');?>
          <?php if(!get_field('hide_breadcrumbs')) { ?>
               <?php get_template_part('template-parts/page', 'breadcrumbs');?>
          <?php } else { ?>
               <section class="breadcrumbs wocom">
                    <nav aria-label="breadcrumb">
                         <div class="container<?= container_width() ?>">
                              <ol class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="<?= get_site_url() ?>">Home</a></li>
                                   <li class="breadcrumb-item"><a href="/community/">OpenAwards Community</a></li>
                                   <li class="breadcrumb-item"><span><?php the_title() ?></span></li>
                              </ol>
                         </div>
                    </nav>
               </section>
          <?php } ?>

          <section class="community-notice" id="community-notice">
               <div class="container">
                    <p>
                        <span>By using the Open Awards Community discussion boards you are automatically agreeing to be professional and abide by the </span> <button type="button" data-toggle="modal" data-target="#oaModal">
                            Open Awards Community Etiquette
                       </button>.
                  </p>
             </div>
        </section>

        <div class="container-holder">
          <div class="container<?= container_width() ?>">

               <?php while ( have_posts() ) : the_post(); 
                    // If we have a page to show, start a loop that will display it
                    ?>

                    <article class="post">
                         <div class="the-content">
                              <?php the_content(); 
                                   // This call the main content of the page, the stuff in the main text box while composing.
                                   // This will wrap everything in p tags
                              ?>

                              <?php wp_link_pages(); // This will display pagination links, if applicable to the page ?>
                         </div><!-- the-content -->

                    </article>

               <?php endwhile; // OK, let's stop the page loop once we've displayed it ?>

          <?php endif ?>


     </div>
</div>
<div class="modal fade etiquette" id="oaModal" tabindex="-1" role="dialog" aria-labelledby="oaModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h3>
                         The Open Awards Community Etiquette
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
               <div class="modal-body">
                    <p>
                         By using the Open Awards Community discussion boards you are automatically agreeing to be professional and abide by the Open Awards Community Etiquette:
                    </p>
                    <ul>
                         <li>Be polite</li>
                         <li>Be brief and concise</li>
                         <li>Don’t mock or badmouth others</li>
                         <li>Respect others opinions</li>
                         <li>Don’t type in ALL CAPS</li>
                         <li>Stay on topic – Don’t post irrelevant links, comment, thoughts or pictures</li>
                         <li>Don’t write anything that sounds angry or sarcastic</li>
                         <li>Run a spelling and grammar check before posting</li>
                         <li>Before posting your question to a discussion board, check if anyone has asked it already and received a reply.</li>
                         <li>If you ask a question and many people respond, summarize all the answers and post that summary to help the group.</li>
                         <li>If you reply to a question, make sure your answer is accurate</li>
                         <li>If you refer to an earlier discussion quote a few lines from that post so that others won’t have to go back and figure out what you are referring to</li>
                         <li>Check the most recent comments before replying to an older comment, just in case the comment has been answered or an issued resolved</li>
                         <li>If someone makes a mistake, be forgiving</li>
                    </ul>
               </div>
          </div>
     </div>
</div>
</div><!-- #content .site-content -->
</main>
<?php get_footer();