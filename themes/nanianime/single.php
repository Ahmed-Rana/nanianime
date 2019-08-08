<?php get_header();  ?>
<!-- Page Content Start -->
<div class="page-content">
   <div class="news-details-area">
      <div class="container">
         <div class="row">
            <!-- Service Details Left Sidebar Start -->
            <div class="col-lg-8 col-md-12 col-sm-12">
               <!-- LATEST UPDATES Strat -->
               <section class="tailer-area indicator-style-two">
                  <div class="row">
                     <div class="col-md-3 col-sm-12">
                        <img class="anime-img" src="<?php echo get_the_post_thumbnail_url() ?>"/>
                     </div>
                     <!-- Section Titel -->
                     <div class="col-md-9 col-sm-12">
                        <div class="section-titel style-3 text-left">
                           <h2 class="anime_title"><?php the_title(); ?></h2>
                           <br>
                           <p class="anime-other">Other name: 
                              <span><?php echo CFS()->get('other_name'); ?></span>
                           </p>
                           <?php
                              echo get_the_term_list( $post->ID, 'genres', '<ul class="genres"><li class="anime-genres"> Genres: </li><li>', ',</li><li>', '</li></ul>' ); 
                           ?>
                           <p class="anime-status">Status: 
                              <span>
                              <?php echo get_the_term_list( $post->ID, 'status'); 
                                 ?>
                              </span>
                           </p>
                        </div>
                     </div>
                     <!-- Section Titel -->
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <p class="anime-summary">Summary:</p>
                        <P class="anime-desc"><?php echo CFS()->get('summary'); ?></p>
                     </div>
                  </div>
                  <!-- Recent Upload Item Area Start -->
                  <div class="main-section">
                     <div class="row">
                        <div class="col-md-12">
                           <h2 class="anime_title">Episodes</h2>
                           <br>
                        </div>
                     </div>
                     <!-- Episodes Start -->  
                     <div class="row">
                        <div class="col-md-12">
                           <div class="panel panel-default">
                              <div class="panel-body">
                                 <div class="table-responsive">
                                    <table class="table table-hover" id="dataTables-example">
                                       <thead style="display:none">
                                          <tr>
                                             <th></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
					     global $post;
                                             $page_link = $post->post_name; 
                                             $post_id = get_the_ID();  
                                             $episodes = CFS()->get('episodes');
                                             foreach ( $episodes as $episode ) { 
                                             $episode_number  =  $episode['episode_number'];
                                             $arr_params = array('number' => $episode_number, 
                                                'post_id' => $post_id );   
                                                ?>
                                          <tr>
                                             <td>
                                                <a class="single-title" href="<?Php echo esc_url(add_query_arg($arr_params , site_url($page_link))); ?>" >
                                                <?php  the_title(); ?> Episode <?php echo $episode_number; ?> 
                                                <br>
                                                <span>Released on <?php echo date( 'F j, Y', strtotime($episode['released_date']));?>
                                                </span>
                                                </a>     
                                             </td>
                                          </tr>
                                          <?php } ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                     </div>
                     <!-- Episodes End -->
                  </div>
                  <!-- Recent Upload Item Area End -->
                  <br>
               </section>
               <!-- LATEST UPDATES  End -->
            </div>
            <!-- Service Details Left Sidebar End -->
            <!-- Service Details Right Sidebar Start -->
            <div class="col-lg-4 col-md-12 col-sm-12">
               <div class="service-details-right widgets-area">
                  <!-- Single Widget -->
                  <div class="single-widget widget-recent-post">
                     <h4 class="widget-title">Related <span style="color:#e50101"> Animes </span></h4>
                     <ul class="sidebar-anime">
                        <?php
                           $terms = get_terms( 'genres', array( 'hide_empty' => false ) );
                           $post  = get_post();
                           $rating = wp_get_object_terms( $post->ID, 'genres', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
                           $name  = '';
                           $my_query = new WP_Query(array('post_type' => 'anime',
                            'posts_per_page' => 4, 
                            'tax_query' => array(
                           array (
                           'taxonomy' => 'genres',
                           'terms' =>  $rating[0]->name,
                           'field' => 'slug',
                           )
                           ),
                           'orderby' => 'date',
                           'order' => 'DESC',
                           ));
                           if ( $my_query->have_posts() ) {
                           while ( $my_query->have_posts()) {
                           $my_query->the_post();   
                           ?> 
                        <li>
                           <a href="<?php the_permalink(); ?>">
                           <img src="<?php  the_post_thumbnail_url();?>">
                           </a>
                           <div class="sidebar-title">
                              <a href="<?php the_permalink(); ?>">
                              <?php the_title();  ?>
                              </a><br>
                              <span>Released on <?php echo get_the_date(); ?></span>
                           </div>
                        </li>
                        <?php  } } ?>
                     </ul>
                  </div>
                  <!--Add Images Start--
                  <div class="add-image">
                     <img src="<?php echo get_theme_file_uri('/img/add.PNG') ?>;" >
                  </div>
                  Add Images End -->
               </div>
            </div>
            <!-- Service Details Right Sidebar End -->
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
      </div>
   </div>
</div>
<!-- Page Content End -->
<?php get_footer();  ?>
<script>
   jQuery(document).ready(function() {
        jQuery('#dataTables-example').DataTable({
            responsive: true,
            "ordering": false,
            "pageLength": 20,
            "aLengthMenu": [[20, 40, 100], [20, 40, "100"]],
            "iDisplayLength": 20,
               language: {
            searchPlaceholder: "By Episode Number"
           }
        });
      jQuery("#newepisode").trigger("click");
    });
</script>