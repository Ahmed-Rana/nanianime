<div class="top-link">
 <div class="container">
   <div class="row">
      <div class="col-md-12">
         <ul>
            <li><a href="#">Terms of Use</a></li>
            <li class="link"><a href="#">Privacy Policy</a></li>
            <li class="link"><a href="#">Notifications</a></li>
         </ul>
      </div>
    </div>  
 </div>
</div>


<!-- Footer Area Start -->
<footer class="bg-5 bg-overlay-2">
   <!-- Footer Top Area Start -->
   <div class="footer-top">
      <div class="container">
         <div class="row">
            <!-- Footer Single Item -->
            <div class="col-lg-8 col-md-12 col-sm-12">
               <div class="footer-single">
                  <img src="<?php echo get_theme_file_uri('/img/footer.png') ?>">
                  <div class="stay-with-content">
                     <p>Stream high quality anime on <b style="color:#e50101">Nani-Anime</b> without getting redirected to countless add pages. Nani-Anime provides the most popular anime using the best servers available, you won't get stuck while watching your favorite Anime. Tune in now and start streaming.</p>
                  </div>
               </div>
            </div>
            <!-- Footer Single Item -->
        
         </div>
      </div>
   </div>
   <!-- Footer Top Area End -->
</footer>
<!-- Footer Area End -->
<!-- Footer Bottom Area Start -->
<div class="footer-bottom">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <p>Copyright © All Right Reserved.</p>
         </div>
      </div>
   </div>
</div>
<!-- Footer Bottom Area End -->  
</div>
<!-- Page Wraper End -->   
<!-- all js here -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery-1.12.4.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/popper.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/dataTables/jquery.dataTables.min.js"></script> 
<script src="<?php bloginfo('template_directory'); ?>/js/dataTables/dataTables.bootstrap.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/plugins.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/main.js"></script>
<?php wp_footer();  ?>
<script>
   $(".search-form").keypress(function(e) {
   //Enter key
   if (e.which == 13) {
     return false;
   }
   });
</script>
</body>
</html>