<?php

add_theme_support( 'title-tag');
add_theme_support( 'post-thumbnails'); 

/*----------------- StyleSheet Links --------------*/

function nanianime_theme_scripts() {

  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
  wp_enqueue_style('dataTables-css', get_template_directory_uri() . '/css/dataTables/dataTables.bootstrap.css');
  wp_enqueue_style('dataTables-responsive', get_template_directory_uri() . '/css/dataTables/dataTables.responsive.css');
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
  wp_enqueue_style('icofont', get_template_directory_uri() . '/css/icofont.css');
  wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');
  wp_enqueue_style('plugins-css', get_template_directory_uri() . '/css/plugins.css');
  wp_enqueue_style('shortcodes', get_template_directory_uri() . '/css/shortcodes.css');
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css');

}
add_action( 'wp_enqueue_scripts', 'nanianime_theme_scripts');

/*----------------- Nanianime Post Type--------------*/

function nanianime_post_type() {
    $args = array(
        'public'       => true,
		'has_archive' => true,
        'labels'       => array(
        'name'         => __('Anime'),
        'singular_name'=> __('Add Anime'),
        'add_new_item' => __('Add New Anime'),
        'all_items'    => __('All Animes'),
        'edit_item'    => __('Edit Anime'),
        ),
        'menu_icon' => 'dashicons-playlist-video',
        'supports' => array( 'title', 'thumbnail','comments', 'revisions'),
        'taxonomies' => array('genres','status','category'),
    );
    register_post_type('anime', $args );
}
add_action( 'init', 'nanianime_post_type') ;

/*----------------- Add taxonomies in  Custom Post Type --------------*/

function nanianime_taxonomy() {  
    register_taxonomy('genres', 'anime',        
        array(  
            'hierarchical' => true,  
            'label' => 'Genres',  
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'genres', 
                'with_front' => false  
            )
        )  
    ); 
  register_taxonomy('status', 'anime',        
        array(  
            'hierarchical' => true,  
            'label' => 'Status',  
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'status', 
                'with_front' => false  
            )
        )  
    );
    register_taxonomy('category', 'anime',        
        array(  
            'hierarchical' => true,  
            'label' => 'Categories',  
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'category', 
                'with_front' => false  
            )
        )  
    );

}  
add_action( 'init', 'nanianime_taxonomy');

/*----------------- Add Custom colunms in custom Post Type --------------*/

add_filter("manage_anime_posts_columns" , "anime_add_columns");
add_action("manage_anime_posts_custom_column" , "anime_column_data" , 10 , 2);

function anime_add_columns($columns){
	$newcolumns = array();
	$newcolumns["title"] = "Anime Name";
	$newcolumns["category"] = "Anime Categories";
	$newcolumns["status"] = "Anime Status";
	$newcolumns["author"] = "Author";
	$newcolumns["date"] = "Date";

	return $newcolumns; 
}
function anime_column_data($column_name , $post_id ){
	switch ($column_name) {
    case 'status':
      $taxonomy = "status";
        $post_type = get_post_type($post_id);
        $terms = get_the_terms($post_id, $taxonomy);

        if (!empty($terms) ) {
            foreach ( $terms as $term )
            $post_terms[] ="<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " .esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
            echo join('', $post_terms );
        }
      break;
	  case 'category':
     $taxonomy = "category";
        $post_type = get_post_type($post_id);
        $terms = get_the_terms($post_id, $taxonomy);

        if (!empty($terms) ) {
            foreach ( $terms as $term )
            $post_terms[] ="<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " .esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
            echo join('', $post_terms );
        }
      break;
  }

}

/*----------------- Browse Anime Search --------------*/

function buildSelect($tax){
  $terms = get_terms($tax);
  $x = '<select name="'. $tax .'">';
  $x .= '<option value="">Select '. ucfirst($tax) .'</option>';
  foreach ($terms as $term) {
     $x .= '<option value="' . $term->slug . '">' . $term->name . '</option>';
  }
  $x .= '</select>';
  return $x;
}

/*----------------- Header Search --------------*/

add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
   
function data_fetch(){
       $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => array('anime') ) );
       if( $the_query->have_posts() ) :?>
<ul class="searchResults">
   <?php while( $the_query->have_posts() ): $the_query->the_post(); ?>
   <li><a href="<?php echo esc_url( post_permalink() ); ?>">
    <img src="<?php echo get_the_post_thumbnail_url(); ?>">
    <p> <?php the_title();?> </p> </a></br></li>
   <?php endwhile; ?>
</ul>
<?php wp_reset_postdata();  
   else: 
       echo '<h5 style="color:#e50101;padding:7px 20px 7px 20px;text-align:left;border-top: 1px solid #000;">
       No Results Found</h5>';
   endif;
   die();
   }
   
add_action( 'wp_footer', 'ajax_fetch' );
   
function ajax_fetch() {
   ?>
<script type="text/javascript">
   function fetchResults(){
       var keyword = jQuery('#searchInput').val();
       if(keyword == ""){
           jQuery('#datafetch').html("");
       } else {
           jQuery.ajax({
               url: '<?php echo admin_url('admin-ajax.php'); ?>',
               type: 'post',
               data: { action: 'data_fetch', keyword: keyword  },
                beforeSend: function(){
                  // Show image container
                  $("#loader").show();
                 },
               success: function(data) {
                   jQuery('#datafetch').html( data );
               },
               complete:function(data){
                  // Hide image container
                  $("#loader").hide();
                 }
           });
       }
   }
</script>
<?php  } 

/*----------------- Create Anime Pages Dynamically --------------*/

function anime_add_pages() { ?>
  <script type="text/javascript">
    jQuery(document).ready( function () { 
      jQuery("#publishing-action input[name = 'publish']").click(function(){
        var page_title = jQuery("input[name = 'post_title']").val(); 
            
            var data = {
                  'action': 'add_new_page',
                  'page_title': page_title
                };
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            $.post(ajaxurl, data, function(response) {
           });           
      });
    });      
 </script>
<?php }
add_action('admin_head', 'anime_add_pages');

function add_new_page(){

    $page_title = $_POST['page_title'];
    $my_post = array(
   'post_title'    =>  $page_title,
   'post_type' =>'page',
   'comment_status' => 'open',
   'post_content'  => 'This is my post.',
   'post_status'   => 'publish',
   'post_author'   => 1
 
 );
wp_insert_post( $my_post );
}

add_action( 'wp_ajax_add_new_page', 'add_new_page' );
add_action( 'wp_ajax_nopriv_add_new_page', 'add_new_page' );

?>