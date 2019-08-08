<?php /* Template Name: Browse Page */ ?>
<?php  get_header(); ?>
<?php
   $list = array();
   $item = array();
   foreach($_POST as $key => $value){
    if($value != ''){
      $item['taxonomy'] = htmlspecialchars($key);
      $item['terms'] = htmlspecialchars($value);
      $item['field'] = 'slug';
      $list[] = $item;
    }
   }
   $cleanArray = array_merge(array('relation' => 'AND'), $list);
   ?>
<?php
   //$paged1 = isset( $_GET['paged1'] ) ? (int) $_GET['paged1'] : 1;
   
   $args['post_type'] = 'anime';
   $args['showposts'] = 10;
  // $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  // $args['paged'] = $paged1;
   $args['tax_query'] = $cleanArray;
   $the_query = new WP_Query( $args );
   ?>
<div class="page-content archive">
   <section class="tailer-area indicator-style-two" style="margin-bottom: 60px;">
      <div class="container">
         <div class="main-section browse-images" >
            <div class="row">
               <div class="col-md-12">
                  <form  method="post" id="target" action="<?php bloginfo('url');?>/browse-anime">
                     <?php  $taxonomies = get_object_taxonomies('anime');
                        foreach($taxonomies as $tax){
                            echo buildSelect($tax);
                        }
                        ?>
                     <input type="submit" />
                  </form>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <?php
                     echo ($the_query->found_posts > 0) ? '<h2 class="anime_title">' . $the_query->found_posts. ' listings found</h2>' : '<h2 style="color:#e50101">We found no results</h2>';
                     ?>
               </div>
            </div>
            <br>
            <div class="row">
               <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                  $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
                  ?>
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
               <?php endwhile; ?>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="blog-pagination"> 
				  
					<div class="post_nav">
						<div class="loadmore">Load More</div>
					</div>
                     <?php  
					/*	
					   global $paged2;
                        echo paginate_links(
                            array(
                              'format'   => '?paged1=%#%',
                              'current'  => $paged1,
                              'total'    => $the_query->max_num_pages,
                              'add_args' => array( 'paged2' => $paged2 )
                            )
                          );
                          wp_reset_postdata() 
					*/		
                        ?>
                  </div>
               </div>
            </div>
            <?php wp_reset_postdata();?>
         </div>
      </div>
</div>
</section>
</div>
<?php  get_footer(); ?>