<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class directdownload {
	
	
    ///////////////////////////////////////////////decoder functions
    function decoder($url) {
		$msg['success'] = true;

  
        $pure_url = explode("?" , $url)[0];
        $file_type = pathinfo( $pure_url , PATHINFO_EXTENSION);
		$file_name = pathinfo( $pure_url , PATHINFO_FILENAME);
		$src = $url;
		
        $msg['title'] = $file_name;

		if(strpos($this->c_mime_content_type($file_type) , 'image') !== false){
			
        $msg['thumnail_src'] = $url;
		$msg['photo'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $file_type, 'quality' => '!?' , 'size' => wsmd_get_file_size($src), ];
		}elseif(strpos($this->c_mime_content_type($file_type) , 'audio') !== false){	
         $msg['thumnail_src'] =  "https://via.placeholder.com/360x160?text=Audio%20File";		
        $msg['audio'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $file_type , 'quality' => '!?' , 'size' => wsmd_get_file_size($src), ];
		}elseif(strpos($this->c_mime_content_type($file_type) , 'video') !== false){
         $msg['thumnail_src'] =  "https://via.placeholder.com/360x160?text=Video%20File";			
        $msg['streams'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $file_type, 'quality' => '!?', 'size' => wsmd_get_file_size($src), ];
		}else{	
		 $msg['thumnail_src'] =  "https://via.placeholder.com/360x160?text=Document";
		$msg['duc'][] = ['direct_url' => $src, 'feu_url' => $src, 'type' => $file_type, 'quality' => '!?' , 'size' => wsmd_get_file_size($src), ];
		} 

		
		return json_encode($msg);
		}
        

	
	
    function get_string_between($string, $start, $end) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini+= strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
	
    function c_mime_content_type($file_type) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
			'psd' => 'image/psd',
			'webp' => 'image/webp',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'aac' => 'audio/aac',
			'wma' => 'audio/wma',
			'flac' => 'audio/flac',
			'alac' => 'audio/alac',
			'wav' => 'audio/wav',
			'aiff' => 'audio/aiff',
			
            'qt' => 'video/qt',
            'mov' => 'video/quicktime',
			'webm' => 'video/webm',
            'mpg' => 'video/mpg', 
			'mp2' => 'video/mp2', 
			'mpeg' => 'video/mpeg', 
			'mpe' => 'video/mpe', 
			'mpv' => 'video/mpv', 
            'ogg' => 'video/ogg',
            'mp4' => 'video/mp4', 
			'm4p' => 'video/m4p', 
			'm4v' => 'video/m4v',
            'avi' => 'video/avi', 
			'wmv' => 'video/wmv',
            'flv' => 'video/flv', 
			'swf' => 'video/swf', 
            'avchd' => 'video/avchd',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower($file_type);
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }else{
            return 'application/octet-stream';
        }
    }	

}