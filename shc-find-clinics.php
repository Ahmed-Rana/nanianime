<?php
/*
Plugin Name: SHC Find Clinics
Plugin URI: https://skinhealthcanada.com/
Description: Show all of our clinics on the map by region and by brands they carry in real time.
Version: 1.0
Author: Computan Dev
Author URI: https://skinhealthcanada.com/
License: GPLv2 or later
*/

class ShcFindClinics {
	public $companies;
	
	function shc_load_scripts(){
	 	wp_enqueue_style('shc_style', plugins_url('assets/style.css',__FILE__ ));
	    wp_enqueue_script('shc_map_acript','https://maps.googleapis.com/maps/api/js?key=AIzaSyBojEkEloV8J3i27XXEXxFBrv-wJJhfGao&libraries=geometry');
	}
	
	function shc_map_shortcode() {  
		ob_start();
		$args = array(
		'role__in' => array('wholesale_customer', 'Main3Star', 'Main2Star', 'Main1Star', 'MainBasic'),
		'meta_query' => array(
        'relation' => 'AND',
		    array(
                'key'     => 'wcb2brp_company',
                'value'   => '',
				'compare' => '!=',
            ),
            array(
                'key'     => 'wcb2brp_company_user_role',
                'value'   => 'company_admin',
            ),
            array(
                'key'     => 'wcb2brp_company_owner',
                'value'   => 'on',
            )
    )
);
 
$get_users = new WP_User_Query($args);

$user_profile_id = array();
		
if (!empty($get_users->get_results())){
	foreach ($get_users->get_results() as $user){
		$user_profile_id[] = $user->ID;
	}	
}else {
	echo 'No users found.';
}
		
global $wpdb;
$date_to = date('Y-m-d');
$date_from = date('Y-m-d', strtotime('-90 days'));
$post_status = implode("','", array('wc-completed'));

$get_orders = $wpdb->get_results( "SELECT * FROM $wpdb->posts 
            WHERE post_type = 'shop_order'
            AND post_status IN ('{$post_status}')
            AND post_date BETWEEN '{$date_from}' AND '{$date_to}'");

$customer_id = array();

if(!empty($get_orders)){
	
	$user_result = array();
	
	foreach ($get_orders as $order){
		$user_id = get_post_meta($order->ID, '_customer_user', true);
		if (in_array($user_id , $user_profile_id)){
			$billing_address = get_user_meta( $user_id, 'billing_address_1', true );
			$google_api_response =  wp_remote_get("https://maps.googleapis.com/maps/api/geocode/json?address=$billing_address&key=AIzaSyDJP42HzDhZId8cXxt2hjKVETxLkJXk1oI");			
			$results = json_decode($google_api_response['body']);
  
			$results = (array) $results; 
			$status = $results["status"]; 
			$location_all_fields = (array) $results["results"][0];
			$location_geometry = (array) $location_all_fields["geometry"];
			$location_lat_long = (array) $location_geometry["location"];
			
			if( $status == 'OK'){
				$latitude = $location_lat_long["lat"];
				$longitude = $location_lat_long["lng"];
			}
			
			$user_result[$user_id] = array(
				"address" => $billing_address,
				"lng" => $longitude,
				"lat" => $latitude,	
			);
			
			$get_order = wc_get_order($order->ID);
			$items = $get_order->get_items();
			foreach ($items as $key => $item) {
				 $product_id = $item['product_id'];
			 	 $terms = get_the_terms( $product_id, 'product_cat' );
				 foreach ( $terms as $term ) {
				  //echo	$product_cat_slug = $term->slug;
				  //echo "<br>";
				}
			}
		}
		//echo "<hr>";
		//$customer_id[] = $user_id;
	}
}

print_r($user_result);



/*		
$customer_unique_id = array_unique($customer_id);
$user_unique_profile_id = array_unique($user_profile_id);
				
$final_id_result = array_intersect($customer_unique_id, $user_unique_profile_id);

echo "<pre>";		
var_dump($final_id_result);
echo "</pre>";
*/	


?>
<table border=1>
  <tr>
    <td>
      <div id="map" style="width: 550px; height: 450px"></div>
    </td>
    <td valign="top" style="width:150px; text-decoration: underline; color: #4444ff;">
      <div id="side_bar"></div>
    </td>
  </tr>
</table>
<form action="#">
  Theatres:
  <input type="checkbox" id="theatrebox" onclick="boxclick(this,'theatre')" />&nbsp;&nbsp; Golf Courses:
  <input type="checkbox" id="golfbox" onclick="boxclick(this,'golf')" />&nbsp;&nbsp; Tourist Information:
  <input type="checkbox" id="infobox" onclick="boxclick(this,'info')" />&nbsp;&nbsp; Ahmed Raza:
  <input type="checkbox" id="ahmedbox" onclick="boxclick(this,'ahmed')" />
  <br />
</form>

<?php
$this->$companies = array( 
         array (   
            "name" => 'Grand Theatre',
            "address" => '33 Church St, Blackpool',    
            "lng" => -3.053102,
			"lat" => 53.817260,
			"category" => 'theatre'
            ),
	     array (   
            "name" => 'Khan',
            "address" => '33 Church St, Blackpool',    
            "lng" => -3.053102,
			"lat" => 53.817260,
			"category" => 'theatre'
            ),
		array (   
            "name" => 'Claremont Theatre Club',
            "address" => 'Burwood Dr, Blackpool, Lancashire, FY3 8NS',    
            "lng" => -3.049690,
			"lat" => 53.829649,
			"category" => 'theatre'
            ),
		array (   
            "name" => 'Barbara Jackson Arts',
            "address" => 'Rossall La, Fleetwood, Lancashire, FY7 8JP',    
            "lng" => -3.043305,
			"lat" => 53.839898,
			"category" => 'golf'
            ),
		array (   
            "name" => 'Tourist Information 6',
            "address" => 'Rossall La, Fleetwood, Lancashire, FY7 8JP',    
            "lng" => -3.052919,
			"lat" => 53.810556,
			"category" => 'info'
            ),
		array (   
            "name" => 'Ahmed Raza 1',
            "address" => 'Rossall La, Fleetwood, Lancashire, FY7 8JP',    
            "lng" => -3.052919,
			"lat" => 53.810556,
			"category" => 'ahmed'
            ),
		array (   
            "name" => 'Ahmed Raza 2',
            "address" => 'Rossall La, Fleetwood, Lancashire, FY7 8JP',    
            "lng" => -3.052919,
			"lat" => 53.810556,
			"category" => 'ahmed'
            )			
     );

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}


	function shc_load_map_js(){ ?>
	
	<script>
		var side_bar_html = "";

		var gmarkers = [];
		var gicons = [];
		var map = null;

		var infowindow = new google.maps.InfoWindow({
		  size: new google.maps.Size(150, 50)
		});

		gicons["red"] = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/red.png",
		  // This marker is 32 pixels wide by 32 pixels tall.
		  new google.maps.Size(32, 32),
		  // The origin for this image is 0,0.
		  new google.maps.Point(0, 0),
		  // The anchor for this image is at 16,32.
		  new google.maps.Point(16, 32));
		// Marker sizes are expressed as a Size of X,Y
		// where the origin of the image (0,0) is located
		// in the top left of the image.

		function getMarkerImage(iconColor) {
		  if ((typeof(iconColor) == "undefined") || (iconColor == null)) {
			iconColor = "red";
		  }
		  if (!gicons[iconColor]) {
			gicons[iconColor] = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/" + iconColor + ".png",
			  // This marker is 20 pixels wide by 34 pixels tall.
			  new google.maps.Size(32, 32),
			  // The origin for this image is 0,0.
			  new google.maps.Point(0, 0),
			  // The anchor for this image is at 6,20.
			  new google.maps.Point(16, 32));
		  }
		  return gicons[iconColor];

		}

		function category2color(category) {
		  var color = "red";
		  switch (category) {
			case "theatre":
			  color = "blue";
			  break;
			case "golf":
			  color = "green";
			  break;
			case "info":
			  color = "yellow";
			  break;
			default:
			  color = "red";
			  break;
		  }
		  return color;
		}

		gicons["theatre"] = getMarkerImage(category2color("theatre"));
		gicons["golf"] = getMarkerImage(category2color("golf"));
		gicons["info"] = getMarkerImage(category2color("info"));

		// A function to create the marker and set up the event window
		function createMarker(latlng, name, html, category) {
		  var contentString = html;
		  var marker = new google.maps.Marker({
			position: latlng,
			icon: gicons[category],
			map: map,
			title: name,
			zIndex: Math.round(latlng.lat() * -100000) << 5
		  });
		  // === Store the category and name info as a marker properties ===
		  marker.mycategory = category;
		  marker.myname = name;
		  gmarkers.push(marker);

		  google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(contentString);
			infowindow.open(map, marker);
		  });
		}

		// == shows all markers of a particular category, and ensures the checkbox is checked ==
		function show(category) {
		  for (var i = 0; i < gmarkers.length; i++) {
			if (gmarkers[i].mycategory == category) {
			  gmarkers[i].setVisible(true);
			}
		  }
		  // == check the checkbox ==
		  document.getElementById(category + "box").checked = true;
		}

		// == hides all markers of a particular category, and ensures the checkbox is cleared ==
		function hide(category) {
		  for (var i = 0; i < gmarkers.length; i++) {
			if (gmarkers[i].mycategory == category) {
			  gmarkers[i].setVisible(false);
			}
		  }
		  // == clear the checkbox ==
		  document.getElementById(category + "box").checked = false;
		  // == close the info window, in case its open on a marker that we just hid
		  infowindow.close();
		}

		// == a checkbox has been clicked ==
		function boxclick(box, category) {
		  if (box.checked) {
			show(category);
		  } else {
			hide(category);
		  }
		  // == rebuild the side bar
		  makeSidebar();
		}

		function myclick(i) {
		  google.maps.event.trigger(gmarkers[i], "click");
		}

		// == rebuilds the sidebar to match the markers currently displayed ==
		function makeSidebar() {
		  var html = "";
		  for (var i = 0; i < gmarkers.length; i++) {
			if (gmarkers[i].getVisible()) {
			  html += '<a href="javascript:myclick(' + i + ')">' + gmarkers[i].myname + '<\/a><br>';
			}
		  }
		  document.getElementById("side_bar").innerHTML = html;
		}

		function initialize() {
		  var myOptions = {
			zoom: 11,
			center: new google.maps.LatLng(53.8363, -3.0377),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		  }
		  map = new google.maps.Map(document.getElementById("map"), myOptions);


		  google.maps.event.addListener(map, 'click', function() {
			infowindow.close();
		  });

		  // Read the data
		  // downloadUrl("categories.xml", function(doc) {
		  var xml = xmlParse(xmlData);
		  var markers = xml.documentElement.getElementsByTagName("span");

		  for (var i = 0; i < markers.length; i++) {
			// obtain the attribues of each marker
			var lat = parseFloat(markers[i].getAttribute("lat"));
			var lng = parseFloat(markers[i].getAttribute("lng"));
			var point = new google.maps.LatLng(lat, lng);
			var address = markers[i].getAttribute("address");
			var name = markers[i].getAttribute("name");
			var html = "<b>" + name + "<\/b><p>" + address;
			var category = markers[i].getAttribute("category");
			// create the marker
			var marker = createMarker(point, name, html, category);
		  }

		  // == show or hide the categories initially ==
		  show("theatre");
		  show("golf");
		  show("info");
		  hide("ahmed");
		  // == create the initial sidebar ==
		  makeSidebar();
		  // });
		}
		google.maps.event.addDomListener(window, 'load', initialize);

		var xmlData =  <?php
		echo '"<markers>';
		foreach($this->$companies as $companie){
			echo "<span name='".$companie['name']."' address='".$companie['address']."' lng='".$companie['lng']."' lat='".$companie['lat']."' category='".$companie['category']."'></span>";   
		  }
		echo '</markers>"';

		  ?>;
		function xmlParse(str) {
		  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
			var doc = new ActiveXObject('Microsoft.XMLDOM');
			doc.loadXML(str);
			return doc;
		  }

		  if (typeof DOMParser != 'undefined') {
			return (new DOMParser()).parseFromString(str, 'text/xml');
		  }

		  return createElement('div', null);
		}
	</script>
	<?php 
	}	
}

$shcobject = new ShcFindClinics();


add_action('wp_enqueue_scripts', array($shcobject , 'shc_load_scripts'));
add_action('wp_footer', array($shcobject , 'shc_load_map_js'));
add_shortcode('shc_find_clinics', array( $shcobject , 'shc_map_shortcode'));



