<?php /* Template Name: Request  */ ?>
<?php  get_header(); ?>

<!-- Page Content Start -->
<div class="page-content">
   <!-- LATEST UPDATES Strat -->
   <section class="tailer-area indicator-style-two" style="margin-bottom: 60px;">
      <div class="container">
         <!-- Recent Upload Item Area Start -->
         <div class="requst-page">
            <div class="row">
               <div class="col-md-12">
                 <?php  echo do_shortcode( '[contact-form-7 id="174" title="Request"]' );  ?>
               </div>
            </div>
        </div>
         <!-- Recent Upload Item Area End -->
             <div class="col-md-12" style="margin-top: 30px; margin-bottom: 10px;">
               <?php
                  if(have_posts()){
                     while(have_posts()){
                        the_post();                 
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                            }
                        }
                     }
                  ?>
            </div>
      </div>
   </section>
   <!-- LATEST UPDATES  End -->
</div>
<!-- Page Content End -->
<?php  get_footer(); ?>