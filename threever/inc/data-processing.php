<?php
include('scriptsPanel.php');

/* Define the custom box */

add_action( 'add_meta_boxes', 'threever_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

/* Do something with the data entered */
add_action('pre_post_update', 'threever_save_postdata' );
add_action('edit_post', 'threever_save_postdata');
add_action('save_post', 'threever_save_postdata');
add_action('publish_post', 'threever_save_postdata');
add_action('edit_page_form', 'threever_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function threever_add_custom_box() {
    add_meta_box( 
        'threever_sectionid',
        __( 'Threever - Generate threever shortcode ', 'threever_textdomain' ),
        'threever_inner_custom_box',
        'post' 
    );
    
	add_meta_box(
        'threever_sectionid',
        __( 'Threever - Generate threever shortcode ', 'threever_textdomain' ), 
        'threever_inner_custom_box',
        'page'
    );
}

/* Prints the box content */
function threever_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'threever_nonce' );
  $data = get_post_custom($post->{'id'});

  echo '<button id="toggleIframe" href="#" onclick="return false" >Open Dialog</button>';
  echo '<button id="togglePreview" href="#" onclick="return false" >3D Preview</button>';
  echo '<canvas style="position:absolute; display:none; z-index:9500; border:2px solid #000; border-radius:5px; background:#666; padding:0px; left:700px; top:50px; background-image:url('.plugins_url('inc/adminPanel/images/gradient.png',dirname(__FILE__)).'); background-size:100%; background-position: center center;" id="myCanvas"></canvas>';
  echo '<textarea name="mycodearea" id="mycode" cols="30" rows="10" readonly="readonly" style="width:100%; height:100px;">'.$data['threeverCode'][0].'</textarea>';
  echo '<div id="iframeholder" >'.plugins_url('adminPanel/index.html', __FILE__).'</div>';

}

/* When the post is saved, saves our custom data */
function threever_save_postdata( $post_id ) {
  
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['threever_nonce'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['mycodearea'];
  
  add_post_meta($post_id, 'threeverCode', $mydata, true);
  update_post_meta($post_id, 'threeverCode', $mydata);

}

function processdatahandler($atts, $content = null ) {
   if(!$hasThree){
		$hasThree = true;
		add_scripts();	
   }
   
   $content = str_replace("&#8220;", "\"", $content);
   $content = str_replace("&#8221;", "\"", $content);
   $content = json_decode($content);
   
   if($content !== NULL){

		$content->{'id'} = $GLOBALS["threeverId"];
		echo($content->{'id'});
		$GLOBALS["threeverId"]++;
		return '<canvas class="threever">'.json_encode($content).'</canvas>';
   
   }else{
   
		echo '<p class="error">There was an error with the shortcode</p>';
   }
}

add_shortcode( 'threever', 'processdatahandler' );

?>