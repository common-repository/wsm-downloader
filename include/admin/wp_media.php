<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_ajax_nopriv_wsmd_download_media_and_addtowp', 'wsmd_download_media_and_addtowp');
add_action('wp_ajax_wsmd_download_media_and_addtowp', 'wsmd_download_media_and_addtowp');
function wsmd_download_media_and_addtowp()
    {
	
        $link = base64_decode(sanitize_text_field($_POST['link']));
        $option = sanitize_text_field($_POST['option']);
        $proxy = sanitize_text_field($_POST['proxy']);
        $_POST['mlpipCache'] = base64_decode(sanitize_text_field($_POST['mlip']));
        $class = sanitize_text_field($_POST['class']);
        $title = wsmd_getCleanedTitle(sanitize_text_field($_POST['title']));		
        $format = pathinfo(explode("?" , $link)[0], PATHINFO_EXTENSION);
        if($format == ''){
			if(strpos(sanitize_text_field($_POST['format']) , '/') === false){
              $format = sanitize_text_field($_POST['format']);
			}else{
			  $format = explode("/" , sanitize_text_field($_POST['format']))[1];
              if(sanitize_text_field($_POST['format']) == "audio/mp4"){
                 $format = 'mp3';
			  }			  
			}
        }	

	///////////progressbar ############
        wsmd_progressbar('30%');
	   
        $temp_file = download_url( $link );
		
	///////////progressbar ############
        wsmd_progressbar('80%');
	   
        $filename = $title.'.'.$format;
        wsmd_upload_downloaded_file_to_wordpress_media($temp_file , $filename);

        wsmd_progressbar('100%');
	   
		die();
	
    }
	
	
	
	
	
	
function wsmd_upload_downloaded_file_to_wordpress_media($temp_file , $filename){	
$file = $temp_file;
$parent_post_id = 0;
$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
if (!$upload_file['error']) {
	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_parent' => $parent_post_id,
		'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
	if (!is_wp_error($attachment_id)) {
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
		wp_update_attachment_metadata( $attachment_id,  $attachment_data );
	}
}

unlink($temp_file);

return 'success';
}


function wsmd_progressbar($pre){
	///////////progressbar ############
	   $array = array();   
	   $progress_id = sanitize_text_field($_POST['progressid']);
	   $json_p = file_get_contents(WSMD_PLUGIN_URL.'/assets/json/progressbar.json');
	   if($json_p !== ''){
		  $array_o = json_decode($json_p);  
          $array = 	(array)$array_o;
	   }
	   $array[$progress_id] = $pre;
       file_put_contents( WSMD_PLUGIN_FILE.'assets/json/progressbar.json', json_encode($array));		
}