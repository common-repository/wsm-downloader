<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    ob_start();
add_action('wp' , 'wsmd_show_thumnail');
function wsmd_show_thumnail(){

	$access_code = 'WSMD_Thumnail';    
	$url = explode("WSMD_Thumnail=" , $_SERVER['REQUEST_URI']);
	if(isset($_GET[$access_code])){
	
	ob_end_clean();	
	$url_of_file = sanitize_text_field($_GET[$access_code]);
if (strpos($url_of_file , '.png') !== false){
header("content-type: image/png");
}else{
header("content-type: image/jpg");	
}
              
				$data = wsmd_file_get_content($url[1]);				
				echo $data;
die();
	}
	
}