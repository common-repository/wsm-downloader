<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

ob_start();
add_action('wp' , 'wsmd_start_download_remote_file');
function wsmd_start_download_remote_file(){
if(isset($_POST['dl'])){
	$dl = base64_decode(sanitize_text_field($_POST['dl']));
	$json_url = base64_decode(sanitize_text_field($_POST['token']));
	$option = sanitize_text_field($_POST['option']);
	$type = sanitize_text_field($_POST['type']); 
	$filename = sanitize_text_field($_POST['filename']);
	$size = sanitize_text_field($_POST['size']);
	ob_end_clean();	
            // Generate the server headers

            header('Content-Type: "' . $type . '"');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Content-Length: ' . (string)$size);
            header("Content-Range: 0-".($size-1)."/".$size);
			header('Pragma: no-cache');

            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
            }


	        ////load content if proxy is active
           $context_options = array(
                              "ssl" => array(
                                       "verify_peer" => false,
                                       "verify_peer_name" => false,
                                       ),
                              );


    ob_clean();
    ob_end_flush();
    readfile($dl, "", stream_context_create($context_options));
    exit;
}	
}
?>