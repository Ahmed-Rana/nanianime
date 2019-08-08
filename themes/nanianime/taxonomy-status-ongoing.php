<?php get_header(); ?>
<?php
   $paged1 = isset( $_GET['paged1'] ) ? (int) $_GET['paged1'] : 1;
   $product_query = new WP_Query( array( 
               'post_type' => 'anime',
			    'tax_query' => array(
                              array (
                              'taxonomy' => 'status',
                              'terms' =>  'ongoing',
                              'field' => 'slug',
                              )
                              ),
               'posts_per_page' => 20,
               'paged'  => $paged1 ));
   if ($product_query->have_posts() ){ 
   ?>
<!-- Page Content Start -->
<div class="page-content">
   <!-- LATEST UPDATES Strat -->
   <section class="tailer-area indicator-style-two" style="margin-bottom: 60px;">
      <div class="container">
         <!-- Recent Upload Item Area Start -->
         <div class="main-section browse-images" >
            <div class="row">
               <div class="col-md-12 my_archive">
                  <?php the_archive_title( '<h2 class="anime_title">', '</h2>' ); ?>
               </div>
            </div>
            <br>
            <div class="row">
               <?php
                  while ( $product_query->have_posts() ){
                  $product_query->the_post();
                  $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
                  ?>    
               <!-- Single Item -->
               <div class="col-lg-3 col-md-4 col-sm-6 col-mobile">
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
               <?php  }  ?>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="blog-pagination"> 
                     <?php  
                       global $paged2;
                        echo paginate_links(
                            array(
                              'format'   => '?paged1=%#%',
                              'current'  => $paged1,
                              'total'    => $product_query->max_num_pages,
                              'add_args' => array( 'paged2' => $paged2 )
                            )
                          );
                          wp_reset_postdata()                        
                        ?>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
         <!-- Recent Upload Item Area End -->
      </div>
   </section>
   <!-- LATEST UPDATES  End -->
</div>
<!-- Page Content End -->
<?php get_footer(); ?>