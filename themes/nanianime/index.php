<?php get_header();  ?>
<!-- Page Content Start -->
<div class="page-content">
   <div class="container home-slider">
      <div class="row">
         <div class="col-md-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
               <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
               </ol>
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <img class="d-block w-100" src="<?php echo get_theme_file_uri('/img/slider1.jpg') ?>" alt="First slide">
                  </div>
                  <div class="carousel-item">
                     <img class="d-block w-100" src="<?php echo get_theme_file_uri('/img/slider2.jpg') ?>" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                     <img class="d-block w-100" src="<?php echo get_theme_file_uri('/img/slider3.jpg') ?>" alt="Third slide">
                  </div>
                  <div class="carousel-item">
                     <img class="d-block w-100" src="<?php echo get_theme_file_uri('/img/slider4.jpg') ?>" alt="Four slide">
                  </div>
               </div>
               <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="sr-only">Next</span>
               </a>
            </div>
         </div>
      </div>
   </div>

<div class="container">
<div class="row">
<div class="col-md-12">
<a href="<?php echo site_url("request"); ?>">   
<div class="request">
   <h3>Request For Your Favourite Anime </h3>
</div>
</a>
</div>
</div>   
</div>
  <!-- New Episodes -->
   <section class="tailer-area pt-40 indicator-style-two">
      <div class="container">
         <div class="row">
            <!-- Section Titel -->
            <div class="col-md-12">
               <div class="section-titel style-3 text-left">
                  <h2>New <span>Episodes</span></h2>
               </div>
            </div>
            <!-- Section Titel -->
         </div>
         <!-- Recent Upload Item Area Start -->
         <div class="main-section">
            <div class="recent-upload-active popular owl-carousel owl-theme">
               <?php
                  $my_query = new WP_Query(array('post_type' => 'anime',
                               'posts_per_page' => 15, 
                               'tax_query' => array(
                              array (
                              'taxonomy' => 'category',
                              'terms' =>  'new-episodes',
                              'field' => 'slug',
                              )
                              ),
                              'orderby' => 'date',
                              'order' => 'DESC',
                              ));
                              if ( $my_query->have_posts() ) {
                              while ( $my_query->have_posts()) {
                              $my_query->the_post();
                              $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
                              $post_id  = get_the_ID();
			      $page_link = $post->post_name;
                              $number = CFS()->get('new_episodes_number');  
                              $arr_params = array('number'=>$number, 'post_id' => $post_id );  
                        ?> 
               <!-- Single Item -->
               <div class="trailer-single">
                  <div class="trailer-img" style="
                     background-image: url('<?php echo $backgroundImg[0]; ?>')">
                     <a href="<?php echo esc_url(add_query_arg($arr_params , site_url($page_link))); ?>" class="vedio-link">
                     <i class="icofont icofont-thin-double-right"></i>
                     </a>
                  </div>
                  <div class="trailer-titel">
                     <div class="main-titel">
                        <h5><a href="<?php echo esc_url(add_query_arg($arr_params , site_url($page_link))); ?>">
                           <?php echo wp_trim_words( get_the_title(), 3, '...' ); ?></a>
                           <br>
                        </h5>
                     </div>
                     <span>Latest Episode: <?php echo CFS()->get('new_episodes_number'); ?></span>
                  </div>
               </div>
               <!-- Single Item -->
               <?php  }  wp_reset_postdata(); }  ?>
            </div>
         </div>
         <!-- Recent Upload Item Area End -->
      </div>
   </section>
   <!-- New Episodes  End -->

   <!-- Recent additions Strat -->
   <section class="tailer-area pt-40 indicator-style-two">
      <div class="container">
         <div class="row">
            <!-- Section Titel -->
            <div class="col-md-12">
               <div class="section-titel style-3 text-left">
                  <h2>Recent <span>Additions</span></h2>
               </div>
            </div>
            <!-- Section Titel -->
         </div>
         <!-- Recent Upload Item Area Start -->
         <div class="main-section">
            <div class="recent-additios owl-carousel owl-theme">
               <?php
                  $my_query = new WP_Query(array('post_type' => 'anime',
                               'posts_per_page' => 15, 
                               'tax_query' => array(
                              array (
                              'taxonomy' => 'category',
                              'terms' =>  'recent-additions',
                              'field' => 'slug',
                              )
                              ),
                              'orderby' => 'date',
                              'order' => 'DESC',
                              ));
                              if ( $my_query->have_posts() ) {
                              while ( $my_query->have_posts()) {
                              $my_query->the_post();
                              $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );   
                  ?> 
               <!-- Single Item -->
               <div class="trailer-single">
                  <div class="trailer-img" style="
                     background-image: url('<?php echo $backgroundImg[0]; ?>')">
                     <a href="<?php the_permalink(); ?>" class="vedio-link">
                     <i class="icofont icofont-thin-double-right"></i>
                     </a>
                  </div>
                  <div class="trailer-titel">
                     <div class="main-titel">
                        <h5><a href="<?php the_permalink(); ?>"><?php  echo wp_trim_words( get_the_title(), 4, '...' ); ?></a>
                           <br>
                        </h5>
                     </div>
                     <span>Date: <?php echo get_the_date(); ?></span>
                  </div>
               </div>
               <!-- Single Item -->
               <?php  }  wp_reset_postdata(); }  ?>
            </div>
         </div>
         <!-- Recent Upload Item Area End -->
      </div>
   </section>
   <!--Recent additions  End -->
 

   <!-- Most popular Strat -->
   <section class="tailer-area pt-40 indicator-style-two">
      <div class="container">
         <div class="row">
            <!-- Section Titel -->
            <div class="col-md-12">
               <div class="section-titel style-3 text-left">
                  <h2>Most <span>Popular</span></h2>
               </div>
            </div>
            <!-- Section Titel -->
         </div>
         <!-- Recent Upload Item Area Start -->
         <div class="main-section">
            <div class="recent-upload-active popular owl-carousel owl-theme">
               <?php
                  $my_query = new WP_Query(array('post_type' => 'anime',
                               'posts_per_page' => 15, 
                               'tax_query' => array(
                              array (
                              'taxonomy' => 'category',
                              'terms' =>  'most-popular',
                              'field' => 'slug',
                              )
                              ),
                              'orderby' => 'date',
                              'order' => 'DESC',
                              ));
                              if ( $my_query->have_posts() ) {
                              while ( $my_query->have_posts()) {
                              $my_query->the_post();
                              $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );      
                  ?>   
               <!-- Single Item -->
               <div class="trailer-single">
                  <div class="trailer-img" style="
                     background-image: url('<?php echo $backgroundImg[0]; ?>')">
                     <a href="<?php the_permalink(); ?>" class="vedio-link">
                     <i class="icofont icofont-thin-double-right"></i>
                     </a>
                  </div>
                  <div class="trailer-titel">
                     <div class="main-titel">
                        <h5><a href="<?php the_permalink(); ?>"><?php  echo wp_trim_words( get_the_title(), 3, '...' ); ?></a>
                           <br>
                        </h5>
                     </div>
                     <span>Date: <?php echo get_the_date(); ?></span>
                  </div>
               </div>
               <!-- Single Item -->
               <?php  }  wp_reset_postdata(); }  ?>  
            </div>
         </div>
         <!-- Recent Upload Item Area End -->
      </div>
   </section>
   <!--Most popular  End -->

   <!-- LATEST UPDATES Strat -->
   <section class="tailer-area pt-40 indicator-style-two" style="margin-bottom: 60px;">
      <div class="container">
         <div class="row">
            <!-- Section Titel -->
            <div class="col-md-12">
               <div class="section-titel style-3 text-left">
                  <h2>Latest <span>Updates</span></h2>
               </div>
            </div>
            <!-- Section Titel -->
         </div>
         <!-- Recent Upload Item Area Start -->
         <div class="main-section latest-updates">
            <div class="row">
               <?php
                  $my_query = new WP_Query(array('post_type' => 'anime',
                               'posts_per_page' => 12, 
                               'tax_query' => array(
                              array (
                              'taxonomy' => 'category',
                              'terms' =>  'latest-updates',
                              'field' => 'slug',
                              )
                              ),
                              'orderby' => 'date',
                              'order' => 'DESC',
                              ));
                              if ( $my_query->have_posts() ) {
                              while ( $my_query->have_posts()) {
                              $my_query->the_post();
                              $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );      
                  ?>      
               <!-- Single Item -->
               <div class="col-lg-2 col-md-4 col-sm-6 col-mobile">
                  <div class="trailer-single">
                     <div class="trailer-img" style="
                        background-image: url('<?php echo $backgroundImg[0]; ?>')">
                        <a href="<?php the_permalink(); ?>" class="vedio-link">
                        <i class="icofont icofont-thin-double-right"></i>
                        </a>
                     </div>
                     <div class="trailer-titel">
                        <div class="main-titel">
                           <h5><a href="<?php the_permalink(); ?>"><?php  echo wp_trim_words( get_the_title(), 3, '...' ); ?></a>
                              <br>
                           </h5>
                        </div>
                        <span>Date: <?php echo get_the_date(); ?></span>
                     </div>
                  </div>
               </div>
               <!-- Single Item -->
               <?php  }  wp_reset_postdata(); }  ?>  
            </div>
         </div>
         <!-- Recent Upload Item Area End -->
      </div>
   </section>
   <!-- LATEST UPDATES  End -->
   <br>
</div>
<!-- Page Content End -->
<?php get_footer();  ?>