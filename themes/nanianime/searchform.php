<!-- Code for searchForm.php file Start -->
<?php global $post_type; ?>
<div class="header-search">   
<form 
   method="get" 
   class="search-form searchform clearfix" 
   id="searchform" 
   action="<?php echo esc_url( home_url( '/' ) ); ?>" 
   autocomplete="off">
   <div class="search-wrap">
      <input type="text" placeholder="<?php  esc_attr_e( 'Search', 'spacious' ); ?>" class="s field" name="s" id="searchInput" onkeyup="fetchResults()">
       <img id="loader" src="<?php echo get_theme_file_uri('/img/tenor.gif') ?>">
      <?php 
         if ('any' != $post_type) {?>
      <input type="hidden" name="post_type" class="email" value="<?php echo esc_attr($post_type); ?>">
      <?php } ?>
     <!-- <button class="search-icon" type="submit"></button> -->
   </div>
</form>
<div id="datafetch" class="search-result"></div>
</div>
<!-- Code for searchForm.php file End -->