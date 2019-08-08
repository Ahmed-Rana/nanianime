<?php 
   get_header(); 
   $number = @$_GET["number"];
   $post_id  =  @$_GET["post_id"];


if(isset($_GET['post_id'])){ ?>

<div class="page-content" style="margin-bottom: 70px">
   <div class="container">
		<div class="row">
         <div class="col-md-12">
            <h2 class="anime_title episod"><?php the_title(); ?></h2>
			<button type="button" id="nova" class="btn btn-success">Server With Ads</button>
			<button type="button" id="beta" class="btn btn-danger">Good Server</button>
		 </div>
		</div>
	
    <div class="row mediaPlayerone" style="display:none">
		<?php 
		$my_query = new WP_Query( array( 'post_type' => 'anime', 'p' => $post_id ));
		if ($my_query->have_posts()){
		while ($my_query->have_posts()) {
		$my_query->the_post();
		$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		?>
        <div class="col-md-12">
          <div class="container-player">
          <div id="mediaPlayer1">
            <iframe id='media_video1' class="embed-responsive-item" src="" allowfullscreen></iframe>
          </div>
        <div id="playlist1">
          <?php
              
              $episodes = CFS()->get('episodes');
              foreach ($episodes as $episode ) {
              $episode_number  = $episode['episode_number'];
            if((int)$episode_number == (int)$number){ 
                $myclass = "video playing";
            }
            else{
             $myclass = "video";
            }
          ?>
          <div id="<?Php echo $episode['episodes_source'];  ?>" class="<?php echo $myclass ?>">
              <div class="video-imagen" style="
               background-image: url('<?php echo $backgroundImg[0]; ?>')">
              </div>
              <div class="video-information">
                <p>Episode <span class="episode_number"><?php echo $episode['episode_number']; ?></span> </p>
                <span>Released on <?php echo date( 'F j, Y', strtotime($episode['released_date']));?></span>
              </div>
          </div>
            <?php  } }  wp_reset_postdata(); }?>
        </div>
        </div>
        </div>
    </div>
		 
	
	<div class="row mediaPlayertwo">
		<?php 
		$my_query = new WP_Query( array( 'post_type' => 'anime', 'p' => $post_id ));
		if ($my_query->have_posts()){
		while ($my_query->have_posts()) {
		$my_query->the_post();
		$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		?>
        <div class="col-md-12">
          <div class="container-player">
          <div id="mediaPlayer2">
           <video autoplay id='media_video2' width="100%"  controls src=""></video>
          </div>
        <div id="playlist2">
          <?php
              
              $episodes = CFS()->get('episodes');
              foreach ($episodes as $episode ) {
              $episode_number  = $episode['episode_number'];
            if((int)$episode_number == (int)$number){ 
                $myclass = "video1 playing1";
            }
            else{
             $myclass = "video1";
            }
          ?>
          <div id="<?Php echo $episode['mp_4_source'];  ?>" class="<?php echo $myclass ?>">
              <div class="video-imagen" style="
               background-image: url('<?php echo $backgroundImg[0]; ?>')">
              </div>
              <div class="video-information">
                <p>Episode <span class="episode_number"><?php echo $episode['episode_number']; ?></span> </p>
                <span>Released on <?php echo date( 'F j, Y', strtotime($episode['released_date']));?></span>
              </div>
          </div>
            <?php  } }  wp_reset_postdata(); }?>
        </div>
        </div>
        </div>
    </div>
		
		 
		 
		 
    <div class="col-md-12" style="margin-top: 30px; margin-bottom: 10px;">
        <?php
        if(have_posts()){
            while(have_posts()){
            the_post();
            if ( comments_open() || get_comments_number()){
            comments_template();
            } } }
        ?>
    </div>
    </div>
</div>
 
<?php } get_footer(); ?>
<script>
   jQuery(document).ready(function() {
     //var playvedio1 = jQuery(".video.playing").attr("id");
     //jQuery('#media_video1').attr('src' , playvedio1);
	
	var playvedio2 = jQuery(".video1.playing1").attr("id");
	jQuery('#media_video2').attr('src' , playvedio2);

    jQuery(".video1").click(function(){ 
     var number =  jQuery(this).find('.episode_number').text();    
     var urllink  = "?number="+ number +"&post_id="+ <?php echo $post_id;  ?>;
	 history.pushState({}, "", urllink);
	 
	 var link  = jQuery(this).attr("id");
     jQuery(".video1").removeClass("playing1");
     jQuery(this).addClass("playing1");
     jQuery('#media_video2').attr('src' , link);
	});
	
	
	jQuery(".video").click(function(){ 
     var number =  jQuery(this).find('.episode_number').text(); 
     var urllink  = "?number="+ number +"&post_id="+ <?php echo $post_id;  ?>;
     history.pushState({}, "", urllink);

     var link  = jQuery(this).attr("id");
     jQuery(".video").removeClass("playing");
     jQuery(this).addClass("playing");
     jQuery('#media_video1').attr('src' , link);
    });
	
	
	jQuery("#nova").click(function(){
	  jQuery("#media_video2").attr('src', '');
	  jQuery(".mediaPlayertwo").css("display" ,"none");
	  jQuery(".mediaPlayerone").css("display" ,"block");
	  var playvedio1 = jQuery(".video.playing").attr("id");
      jQuery('#media_video1').attr('src' , playvedio1);
	 
	});
	
	jQuery("#beta").click(function(){
	   jQuery("#media_video1").attr('src', '');
	   jQuery(".mediaPlayerone").css("display" ,"none");
	   jQuery(".mediaPlayertwo").css("display" ,"block");
	   var playvedio2 = jQuery(".video1.playing1").attr("id");
      jQuery('#media_video2').attr('src' , playvedio2);
	   
	});

	window.setInterval(function(){
    var frame = document.getElementById("#media_video2");
    if(frame.src  !== expectedSource){
        window.location.href = "unauthorized.html" // or something like that
    }
}, 300);
	
	
   });
</script>