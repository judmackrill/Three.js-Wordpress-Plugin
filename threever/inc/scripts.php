<?php

//in case jquery is not active
function add_jquery() {
    wp_enqueue_script( 'jquery' );
}    

add_action('init', 'add_jquery');

//Script Control
function add_scripts() {
	wp_deregister_script( 'threejs' );
	wp_register_script( 'threejs', plugins_url('inc/js/three.min.js',dirname(__FILE__)));
	wp_enqueue_script( 'threejs' );

	//collada loader
	//wp_deregister_script( 'threeverDAE' );
	//wp_register_script( 'threeverDAE', plugins_url('inc/js/loaders/ColladaLoader.js',dirname(__FILE__)));
	//wp_enqueue_script( 'threeverDAE' );
	
	//obj loader
	//wp_deregister_script( 'threeverOBJ' );
	//wp_register_script( 'threeverOBJ', plugins_url('inc/js/loaders/OBJLoader.js',dirname(__FILE__)));
	//wp_enqueue_script( 'threeverOBJ' );
	
	//CTM loader
	//wp_deregister_script( 'threeverLZMA' );
	//wp_register_script( 'threeverLZMA', plugins_url('inc/js/loaders/ctm/lzma.js',dirname(__FILE__)));
	//wp_enqueue_script( 'threeverLZMA' );
	
	//wp_deregister_script( 'threeverCTM' );
	//wp_register_script( 'threeverCTM', plugins_url('inc/js/loaders/ctm/ctm.js',dirname(__FILE__)));
	//wp_enqueue_script( 'threeverCTM' );
	
	//wp_deregister_script( 'threeverCTMLoader' );
	//wp_register_script( 'threeverCTMLoader', plugins_url('inc/js/loaders/ctm/CTMLoader.js',dirname(__FILE__)));
	//wp_enqueue_script( 'threeverCTMLoader' );
	
	//Custom Class
	wp_deregister_script( 'threeverElement' );
	wp_register_script( 'threeverElement', plugins_url('inc/js/threeverElement.js',dirname(__FILE__)));
	wp_enqueue_script( 'threeverElement' );
	
	//Main script
	wp_deregister_script( 'threever' );
	wp_register_script( 'threever', plugins_url('inc/js/threever.js',dirname(__FILE__)));
	wp_enqueue_script( 'threever' );
	
	
}    

add_filter('upload_mimes', 'custom_upload_mimes');

//Add mime types for upload support
function custom_upload_mimes ( $existing_mimes=array() ) {
// Add file extension 'extension' with mime type 'mime/type'
$existing_mimes['extension'] = 'mime/type';
 
// add as many as you like e.g. 

$existing_mimes['obj'] = 'application/octet-stream'; 
$existing_mimes['dae'] = 'application/octet-stream';
$existing_mimes['js'] = 'application/javascript';
$existing_mimes['ctm'] = 'application/javascript';
 
// and return the new full result
return $existing_mimes;

}
?>