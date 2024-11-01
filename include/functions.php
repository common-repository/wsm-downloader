<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_ajax_nopriv_wsmd_download_controler_admin', 'wsmd_download_controler_admin');
add_action('wp_ajax_wsmd_download_controler_admin', 'wsmd_download_controler_admin');
function wsmd_download_controler_admin()
    {
	
        $link = sanitize_text_field($_POST['link']);
        $option = sanitize_text_field($_POST['option']);
        $class = wsmd_class_detector($link);
        if ($class != "CantDetect")
            {
                require_once (WSMD_PLUGIN_FILE . 'dl_engine/' . $class . '/decoder.php');
                $detail = new $class;
                $output = $detail->decoder($link);
				$result = wsmd_output_generator($output , $option , $class);
                die($result);
            }
        else
            {
                die(__("Cant detect site or file name from url!", 'wsm-downloader'));
            }
    }
	
	
	

	
function wsmd_output_generator($data, $option , $class) {

    $data_decoder = json_decode($data);
    $success = $data_decoder->success;
    $videtab = '';
    $audiotab = '';
    $phototab = '';
    $othertab = '';
    $dl_body = '';
    $dl_body_inner = '';
	$source = get_option('siteurl').'?WSMD_Thumnail=';
	$mlip_ip = isset($_POST['mlpipCache']) ? 'data-ml="'.base64_encode(sanitize_text_field($_POST['mlpipCache'])).'"' : '';

    if($class == "youtube"){
     $mlip_ip = isset($data_decoder->mlip) ? 'data-ml="'.base64_encode($data_decoder->mlip).'"' : ''; 
    }
    

    if ($success == true) {
        $dl_body = '<div class="wsmd_result_html"><div class="wsmd_preview_holder"><a href="'.$data_decoder->thumnail_src.
        '" target="_blank"><img class="wsmd_preview_img" src="'.$source.$data_decoder->thumnail_src.
        '" ></a><h3 class="wsmd_title_preview" style="text-align:center;">'.$data_decoder->title.
        '</h3></div>';
        $dl_body .= '<div class="wsmd_result_table_holder">';

		if($class == "youtube"){
        $mlip_ip = isset($data_decoder->mlip) ? 'data-ml="'.base64_encode($data_decoder->mlip).'"' : $mlip_ip;
		}
		
        //////video streams
        if (isset($data_decoder->streams)) {
            $videtab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_video_tab')".
            '"><span class="dashicons dashicons-editor-video"></span>'.__('Videos', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_video_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr><th>'.__('File type', 'wsm-downloader').
            '</th><th>'.__('File Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->streams as $streams) {
                $dl_body_inner .= '<tr><td>'.$streams->type.
                '&nbsp;('.$streams->quality.
                ')</td><td>'.wsmd_formatBytes($streams->size).
                '</td><td><button type="button" class="wsmd_download_button"  data-class="'.$class.'" '.$mlip_ip.' data-type="'.$streams->type.'" data-option="'.$option.
                '" data-dl="'.base64_encode($streams->direct_url).
                '">'.__('Add To WP Media', 'wsm-downloader').
                '</button>
				</td></tr>';
            }
            $dl_body_inner .= '</table></div>';
        }


        //////photo parts
        if (isset($data_decoder->photo)) {
            $phototab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_photo_tab')".
            '"><span class="dashicons dashicons-images-alt2"></span>'.__('Photos', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_photo_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr><th>'.__('File type', 'wsm-downloader').
            '</th><th>'.__('File Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->photo as $photos) {
                $dl_body_inner .= '<tr><td>'.$photos->type.
                '&nbsp;('.$photos->quality.
                ')</td><td>'.wsmd_formatBytes($photos->size).
                '</td><td><button type="button" class="wsmd_download_button"  data-class="'.$class.'" '.$mlip_ip.'  data-type="'.$photos->type.'" data-option="'.$option.
                '" data-dl="'.base64_encode($photos->direct_url).
                '">'.__('Add To WP Media', 'wsm-downloader').
                '</button></td></tr>';
            }
            $dl_body_inner .= '</table></div>';
        }

        ////audio format
        if (isset($data_decoder->audio)) {
            $audiotab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_audio_tab')".
            '"><span class="dashicons dashicons-format-audio"></span>'.__('Audios', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_audio_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr><th>'.__('File type', 'wsm-downloader').
            '</th><th>'.__('File Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->audio as $audios) {
                $dl_body_inner .= '<tr><td>'.$audios->type.
                '&nbsp;('.$audios->quality.
                ')</td><td>'.wsmd_formatBytes($audios->size).
                '</td><td><button type="button" class="wsmd_download_button"  data-class="'.$class.'" '.$mlip_ip.'  data-type="'.$audios->type.'" data-option="'.$option.
                '" data-dl="'.base64_encode($audios->direct_url).
                '">'.__('Add To WP Media', 'wsm-downloader').
                '</button></td></tr>';
            }
            $dl_body_inner .= '</table></div>';
        }

        /////other formats
        if (isset($data_decoder->formats)) {
            $othertab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_otherf_tab')".
            '"><span class="dashicons dashicons-controls-volumeoff"></span>'.__('Mute version', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_otherf_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr><th>'.__('File type', 'wsm-downloader').
            '</th><th>'.__('File Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->formats as $formats) {
                $dl_body_inner .= '<tr><td>'.$formats->type.
                '&nbsp;('.$formats->quality.
                ')</td><td>'.wsmd_formatBytes($formats->size).
                '</td><td><button type="button" class="wsmd_download_button"  data-class="'.$class.'" '.$mlip_ip.'  data-type="'.$formats->type.'" data-option="'.$option.
                '" data-dl="'.base64_encode($formats->direct_url).
                '">'.__('Add To WP Media', 'wsm-downloader').
                '</button></td></tr>';
            }
            $dl_body_inner .= '</table></div>';
        }


		
        /////Documents formats
        if (isset($data_decoder->duc)) {
            $othertab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_otherf_tab')".
            '"><span class="dashicons dashicons-media-default"></span>'.__('Documents', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_otherf_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr><th>'.__('File type', 'wsm-downloader').
            '</th><th>'.__('File Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->duc as $duc) {
                $dl_body_inner .= '<tr><td>'.$duc->type.
                '&nbsp;('.$duc->quality.
                ')</td><td>'.wsmd_formatBytes($duc->size).
                '</td><td><button type="button" class="wsmd_download_button"  data-class="'.$class.'" '.$mlip_ip.'  data-type="'.$duc->type.'" data-option="'.$option.
                '" data-dl="'.base64_encode($duc->direct_url).
                '">'.__('Add To WP Media', 'wsm-downloader').
                '</button></td></tr>';
            }
            $dl_body_inner .= '</table></div>';
        }
		
		

        $dl_body .= ' <div class = "wsmd_tab" >
        '.$videtab.'
        '.$audiotab.'
        '.$phototab.'
        '.$othertab.' </div>
        '.$dl_body_inner;


        $dl_body .= '</div></div>';

        return $dl_body;

    } else {

        $user = wp_get_current_user();
        $allowed_roles = array('editor', 'administrator', 'author');
        if (array_intersect($allowed_roles, $user->roles)) {
            return $data_decoder->body; ///show download error only to admin
        }

        return __("Sorry , We cant Download this video!", 'wsm-downloader');
    }


}
	
	
	
function wsmd_class_detector($link)
    {
        $link = str_replace("www.", "", $link);
        $link = str_replace("https://", "", $link);
        $link = str_replace("http://", "", $link);
        $purelink = explode("/", $link);			
        if (strpos($purelink[0], 'instagram') !== false)
            {
                $class = 'instagram';
                return $class;
            }
        if (strpos($purelink[0], 'facebook') !== false)
            {
                $class = 'facebook';
                return $class;
            }
        if (strpos($purelink[0], 'bandcamp') !== false)
            {
                $class = 'bandcamp';
                return $class;
            }
 
        if (pathinfo(explode("?" , $link)[0], PATHINFO_EXTENSION) !== '')
            {
                $class = 'directdownload';
                return $class;
            }
        return 'CantDetect';
    }
	
	
	

	
	
	
function wsmd_file_get_content($url)
    {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING , "gzip");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
	return $data;
    }
	
	

	
	
	
	
	
	
	
	
	
function wsmd_get_file_size($url)
    {
		$ch = curl_init($url);
        $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);		
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        $data = curl_exec($ch);
        $bytes = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($ch);
		
		
		   return $bytes;	
    }
	
	
	
	
    function wsmd_formatBytes($bytes)
    {
		$bytes_out = '';
        if ($bytes >= 1073741824)
            {
                $bytes_out = number_format($bytes / 1073741824, 2) . __(' GB','wsm-downloader');
            }
        elseif ($bytes >= 1048576)
            {
                $bytes_out = number_format($bytes / 1048576, 2) . __(' MB','wsm-downloader');
            }
        elseif ($bytes >= 1024)
            {
                $bytes_out = number_format($bytes / 1024, 2) . __(' KB','wsm-downloader');
            }
        elseif ($bytes > 1)
            {
                $bytes_out = $bytes . __(' bytes','wsm-downloader');
            }
        elseif ($bytes == 1)
            {
                $bytes_out = $bytes . __(' byte','wsm-downloader');
            }
        else
            {
                $bytes_out = __('NaN','wsm-downloader');
            }
        return $bytes_out;
    }	
	


    function wsmd_getCleanedTitle($title)
    {
        $filename = utf8_decode($title);
        $special_chars = ['.', '?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+' , '”' , '“', chr(0)];
        $filename = str_replace($special_chars, ' ', $filename);
        $filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
        $filename = str_replace(['%20', '+', ' '], '-', $filename);
        $filename = preg_replace('/[\r\n\t -]+/', '-', $filename);
        $filename = trim($filename, '.-_');

		if(wmsd_is_arabic(utf8_decode($title))){
			$filename = wp_generate_password(15 , false , false );
		}
		if ($filename == ''){
			$filename = wp_generate_password(15 , false , false );
		}
		
		if(mb_strlen($filename) > 20){
		$filename = mb_substr($filename,0,20);
		}
			
        return $filename;
    }
	
	
function wmsd_uniord($u) {
    // i just copied this function fron the php.net comments, but it should work fine!
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
function wmsd_is_arabic($str) {
	if(function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding') && function_exists('mb_strpos')){
    if(mb_detect_encoding($str) !== 'UTF-8') {
        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
    }
    preg_match_all('/.|\n/u', $str, $matches);
    $chars = $matches[0];
    $arabic_count = 0;
    $latin_count = 0;
    $total_count = 0;
    foreach($chars as $char) {
        //$pos = ord($char); we cant use that, its not binary safe 
        $pos = wmsd_uniord($char);

        if($pos >= 1536 && $pos <= 1791) {
            $arabic_count++;
        } else if($pos > 123 && $pos < 123) {
            $latin_count++;
        }
        $total_count++;
    }
    if($arabic_count > 10) {
        // 60% arabic chars, its probably arabic
        return true;
    }
    $arabic_alphabet = ['ا','ب','ج',"چ","ح","خ","د","ذ","ر","ز","س","ش","ص","ض","ط","ظ","ع","غ","ف","ق","ک","گ","ل","م","ن","و","ه","ی"];
	foreach($arabic_alphabet as $aw){
	if(mb_strpos($str , $aw) > 0){
	   return true;
	}
	}
    return false;
	
	}else{
		return true;
	}
}	
	

	
	function wsmd_get_random_ip($wp_option){
		
        if(isset($_POST['mlpipCache'])){
		     $outgoing_ip = sanitize_text_field($_POST['mlpipCache']);
		}else{
        	$ips = $wp_option->mips->iplist;
			$outgoing_ip = $ips[mt_rand(0, count($ips) - 1)];			
		}
		
        $_POST['mlpipCache'] = $outgoing_ip;
        
		return $outgoing_ip;
	}	

?>