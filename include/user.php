<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_ajax_nopriv_wsmd_user_download_request', 'wsmd_user_download_request');
add_action('wp_ajax_wsmd_user_download_request', 'wsmd_user_download_request');
function wsmd_user_download_request()
    {
		
        $link = sanitize_text_field($_POST['link']);
		$wsmds_admin_options = get_option('wsmds_admin_options');
		$downloaders = isset($wsmds_admin_options['downloader']) ? $wsmds_admin_options['downloader'] : array();
        foreach($downloaders as $key => $val){
	       $active_downloaders[] = $key;
        }
		
        $class = wsmd_class_detector($link);
        if ($class != "CantDetect")
            {
				
				if($class == 'breakcom'){
					$class_d = 'break'; 
				}else{
					$class_d = $class;
				}
				
				if(in_array($class_d , $active_downloaders)){
                require_once (WSMD_PLUGIN_FILE . 'dl_engine/' . $class . '/decoder.php');
                $detail = new $class;
				
				if(isset($wsmds_admin_options["mlpip"]["use_mlpip"])){
					$_POST['option'] = 'mlpip';
                }
				
				$output = $detail->decoder($link);
				
				if(isset($wsmds_admin_options["proxy"]["use_proxy"])){
					$output_check = json_decode($output);
					if($output_check->success == false){
						$_POST['option'] = 'proxy';
						$output = $detail->decoder($link);					
					}
				}
				
				$option = isset($_POST['option']) ? sanitize_text_field($_POST['option']) : ''; 
				$result = wsmd_user_output_generator($output , $option , $class , $wsmds_admin_options);
				
                die($result);
				}else{

		$parse = parse_url($link);
		
        $sorry_output = '
		<div class="wsmd_sorry_output" >
		<div class="wsmd_sorry_face">
		<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 25 25"><path d="M4.47 21h15.06c1.54 0 2.5-1.67 1.73-3L13.73 4.99c-.77-1.33-2.69-1.33-3.46 0L2.74 18c-.77 1.33.19 3 1.73 3zM12 14c-.55 0-1-.45-1-1v-2c0-.55.45-1 1-1s1 .45 1 1v2c0 .55-.45 1-1 1zm1 4h-2v-2h2v2z"/></svg>
		</div>
		<div class="wsmd_sorry_text">'.sprintf( esc_html__( 'Sorry , downloading from " %1$s " is not supported by our downloader!', 'wsm-downloader' ), $parse['host'] ).'</div>';
		die($sorry_output);				
				
				}
            }
        else
            {
				
		$parse = parse_url($link);

        $sorry_output = '
		<div class="wsmd_sorry_output" >
		<div class="wsmd_sorry_face">
		<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 25 25"><path d="M4.47 21h15.06c1.54 0 2.5-1.67 1.73-3L13.73 4.99c-.77-1.33-2.69-1.33-3.46 0L2.74 18c-.77 1.33.19 3 1.73 3zM12 14c-.55 0-1-.45-1-1v-2c0-.55.45-1 1-1s1 .45 1 1v2c0 .55-.45 1-1 1zm1 4h-2v-2h2v2z"/></svg>
		</div>
		<div class="wsmd_sorry_text">'.sprintf( esc_html__( 'Sorry , downloading from " %1$s " is not supported by our downloader!', 'wsm-downloader' ), $parse['host'] ).'</div>';
		die($sorry_output);
            }
    }
	
	



function wsmd_user_output_generator($output , $option , $class , $wsmds_options){

    $this_page = sanitize_text_field($_POST['requestlink']);
    $data_decoder = json_decode($output);
    $success = $data_decoder->success;
    $videtab = '';
    $audiotab = '';
    $phototab = '';
    $othertab = '';
    $dl_body = '';
    $dl_body_inner = '';
    $share_html = '';
	$source = get_option('siteurl').'?WSMD_Thumnail=';
	$clean_title = wsmd_getCleanedTitle($data_decoder->title);


    
$facebook_svg = '
<span class="wsmds_facebook" style="fill:#4172B8;"><svg role="img" height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title><path d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z"></path></svg></span>';

$twitter_svg = '
<span class="wsmds_twitter" style="fill:#1DA1F2;"><svg role="img" height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Twitter</title><path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"></path></svg></span>';


$pinterest_svg ='
<span class="wsmds_pinterest" style="fill:#BD081C;"><svg role="img"  height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Pinterest</title><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"></path></svg></span>';

$telegram_svg = '
<span class="wsmds_telegram" style="fill:#2CA5E0;;"><svg role="img"  height="32" width:30px xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>Telegram</title><path d="M23.91 3.79L20.3 20.84c-.25 1.21-.98 1.5-2 .94l-5.5-4.07-2.66 2.57c-.3.3-.55.56-1.1.56-.72 0-.6-.27-.84-.95L6.3 13.7l-5.45-1.7c-1.18-.35-1.19-1.16.26-1.75l21.26-8.2c.97-.43 1.9.24 1.53 1.73z"></path></svg></span>';
$whatsapp_svg = '
<span class="wsmds_whatsapp" style="fill:#25D366;"><svg role="img"  height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>WhatsApp</title><path d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345m-5.446 7.443h-.016c-1.77 0-3.524-.48-5.055-1.38l-.36-.214-3.75.975 1.005-3.645-.239-.375c-.99-1.576-1.516-3.391-1.516-5.26 0-5.445 4.455-9.885 9.942-9.885 2.654 0 5.145 1.035 7.021 2.91 1.875 1.859 2.909 4.35 2.909 6.99-.004 5.444-4.46 9.885-9.935 9.885M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411"></path></svg></span>
';
$linkedin_svg = '
<span class="wsmds_linkedin" style="fill:#0077B5;"><svg role="img"  height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>LinkedIn</title><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path></svg></span>
';
	
    if ($success === true) {
	

    if(isset($wsmds_options['shortcode']['sharable'])){
		
    $share_buttons = isset($wsmds_options['shortcode']['sharebuttons']) ? $wsmds_options['shortcode']['sharebuttons'] : array();
	
	$share_html .= '<div class="wsmd_share_bottons_holder"><b style="font-size: 11px;">'.__("Share On : ",'wsm-downloader').'</b><br><ul class="wsmd_share_bottons_holder_inner">';
	
    foreach($share_buttons as $key => $val){
	
    if($key == 'facebook'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_facebook" target="_blank" href="https://www.facebook.com/sharer.php?u='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$facebook_svg.'</a></li>';
	}
	
    if($key == 'telegram'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_telegram" target="_blank" href="https://t.me/share/url?url='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$telegram_svg.'</a></li>';
	}

    if($key == 'whatsapp'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_whatsapp" target="_blank" href="https://api.whatsapp.com/send?text='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$whatsapp_svg.'</a></li>';
	}

    if($key == 'twitter'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_twitter" target="_blank" href="https://twitter.com/intent/tweet?url='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$twitter_svg.'</a></li>';
	}

    if($key == 'pinterest'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_pinterest" target="_blank" href="http://pinterest.com/pin/create/link/?url='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$pinterest_svg.'</a></li>';
	}

    if($key == 'linkedin'){	
       $share_html .= '<li class="wsmd_share_button"><a class="wsmd_linkedin" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url='.$this_page.'?wsmd_share='.sanitize_text_field($_POST['link']).'">'.$linkedin_svg.'</a></li>';
	}

    }
	
	$share_html .= '</ul></div>';
	}
	
		
        $dl_body = '<div class="wsmd_preview_holder">
		<a href="'.$data_decoder->thumnail_src.
        '" target="_blank"><img class="wsmd_preview_img" id="wsmd_preview_img" style="margin:auto" src="'.$source.$data_decoder->thumnail_src.
        '" ></a><br>'.$share_html.'</div>';
        $dl_body .= '<div class="wsmd_result_table_holder"><b class="wsmd_title_preview" id="wsmd_title_preview" style="text-align:center;">'.$data_decoder->title.'</b>';

		
        //////video streams
        if (isset($data_decoder->streams)) {
            $videtab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_video_tab')".
            '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M18 4v1h-2V4c0-.55-.45-1-1-1H9c-.55 0-1 .45-1 1v1H6V4c0-.55-.45-1-1-1s-1 .45-1 1v16c0 .55.45 1 1 1s1-.45 1-1v-1h2v1c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-1h2v1c0 .55.45 1 1 1s1-.45 1-1V4c0-.55-.45-1-1-1s-1 .45-1 1zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/></svg>'.__('Videos', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_video_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr>
			<th>'.__('Format', 'wsm-downloader').
		    '</th><th>'.__('Quality', 'wsm-downloader').
            '</th><th>'.__('Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->streams as $streams) {

				if(max(0 , $streams->size) !== 0 or isset($wsmds_options['shortcode']['show']['zerosize'])){	
			
				    $type = $streams->type;
				    if(strpos($type , '/') !== false){
						$yt = explode('/' , $type); 
						$type = $yt[1];
					}

	               $filename = $clean_title.'.'.$type;
	               $mime = wp_check_filetype($filename, null );
				
				
                $dl_body_inner .= '<tr><td>'.$streams->type.
                '</td><td>'.$streams->quality.
                '</td><td>'.wsmd_formatBytes($streams->size).
                '</td><td>
				
				<button type="button" class="wsmd_download_button">'.__('Download', 'wsm-downloader').'
				<form style="display:none;" action="" method="POST">
				<input name="class" value="'.$class.'" />
				<input name="type" value="'.$mime['type'].'" />
				<input name="option" value="'.$option.'" />
				<input name="dl" value="'.base64_encode($streams->direct_url).'" />
				<input name="filename" value="'.$filename.'" />
				<input name="size" value="'.$streams->size.'" />			
                <input name="token" value="'.base64_encode(WSMD_PLUGIN_FILE).'" />					
				</form>
                </button>
				
				</td></tr>';
				
				}
				
            }
            $dl_body_inner .= '</table></div>';
        }


        //////photo parts
        if (isset($data_decoder->photo)) {
            $phototab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_photo_tab')".
            '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.9 13.98l2.1 2.53 3.1-3.99c.2-.26.6-.26.8.01l3.51 4.68c.25.33.01.8-.4.8H6.02c-.42 0-.65-.48-.39-.81L8.12 14c.19-.26.57-.27.78-.02z"/></svg>'.__('Photos', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_photo_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr>
			<th>'.__('Format', 'wsm-downloader').
		    '</th><th>'.__('Quality', 'wsm-downloader').
            '</th><th>'.__('Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->photo as $photos) {
				
				if(max(0 , $photos->size) !== 0 or isset($wsmds_options['shortcode']['show']['zerosize'])){	

				
				    $type = $photos->type;
				    if(strpos($type , '/') !== false){
						$yt = explode('/' , $type); 
						$type = $yt[1];
					}

	               $filename = $clean_title.'.'.$type;
	               $mime = wp_check_filetype($filename, null );
				
				
                $dl_body_inner .= '<tr><td>'.$photos->type.
                '</td><td>'.$photos->quality.
                '</td><td>'.wsmd_formatBytes($photos->size).
                '</td><td>
				
				<button type="button" class="wsmd_download_button">'.__('Download', 'wsm-downloader').'
				<form style="display:none;" action="" method="POST">
				<input name="class" value="'.$class.'" />
				<input name="type" value="'.$mime['type'].'" />
				<input name="option" value="'.$option.'" />
				<input name="dl" value="'.base64_encode($photos->direct_url).'" />
				<input name="filename" value="'.$filename.'" />
				<input name="size" value="'.$photos->size.'" />			
                <input name="token" value="'.base64_encode(WSMD_PLUGIN_FILE).'" />					
				</form>
                </button>
				
				</td></tr>';
				
				}
            }
            $dl_body_inner .= '</table></div>';
        }

        ////audio format
        if (isset($data_decoder->audio)) {
            $audiotab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_audio_tab')".
            '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M12 5v8.55c-.94-.54-2.1-.75-3.33-.32-1.34.48-2.37 1.67-2.61 3.07-.46 2.74 1.86 5.08 4.59 4.65 1.96-.31 3.35-2.11 3.35-4.1V7h2c1.1 0 2-.9 2-2s-.9-2-2-2h-2c-1.1 0-2 .9-2 2z"/></svg>'.__('Audios', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_audio_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr>
			<th>'.__('Format', 'wsm-downloader').
		    '</th><th>'.__('Quality', 'wsm-downloader').
            '</th><th>'.__('Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->audio as $audios) {

				if(max(0 , $audios->size) !== 0 or isset($wsmds_options['shortcode']['show']['zerosize'])){	
				
				    $type = $audios->type;
					$type_al = $type;
					if($type == 'mp4'){
						$type = 'audio/mp3';
					}
					
				    if(strpos($type , '/') !== false){
						$yt = explode('/' , $type); 
						$type_al = $yt[1];
					}

	               $filename = $clean_title.'.'.$type_al;
	               $mime = wp_check_filetype($filename, null );
	
				//if($mime['type'] == ''){
                   //$mime['type'] = 'audio/mp4';
				//}	
				
                $dl_body_inner .= '<tr><td>'.$type_al.
                '</td><td>'.$audios->quality.
                '</td><td>'.wsmd_formatBytes($audios->size).
                '</td><td>
				
				<button type="button" class="wsmd_download_button">'.__('Download', 'wsm-downloader').'
				<form style="display:none;" action="" method="POST">
				<input name="class" value="'.$class.'" />
				<input name="type" value="'.$mime['type'].'" />
				<input name="option" value="'.$option.'" />
				<input name="dl" value="'.base64_encode($audios->direct_url).'" />
				<input name="filename" value="'.$filename.'" />
				<input name="size" value="'.$audios->size.'" />	
                <input name="token" value="'.base64_encode(WSMD_PLUGIN_FILE).'" />					
				</form>
                </button>
				
				</td></tr>';
				
				}
            }
            $dl_body_inner .= '</table></div>';
        }

        /////other formats
        if (isset($data_decoder->formats)) {
            $othertab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_otherf_tab')".
            '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M7 9v6h4l5 5V4l-5 5H7z"/></svg>'.__('Mute version', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_otherf_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr>
			<th>'.__('Format', 'wsm-downloader').
		    '</th><th>'.__('Quality', 'wsm-downloader').
            '</th><th>'.__('Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->formats as $formats) {

				if(max(0 , $formats->size) !== 0 or isset($wsmds_options['shortcode']['show']['zerosize'])){			
	
				    $type = $formats->type;
				    if(strpos($type , '/') !== false){
						$yt = explode('/' , $type); 
						$type = $yt[1];
					}

	               $filename = $clean_title.'.'.$type;
	               $mime = wp_check_filetype($filename, null );
				


                
				$dl_body_inner .= '<tr><td>'.$formats->type.
                '</td><td>'.$formats->quality.
                '</td><td>'.wsmd_formatBytes($formats->size).
                '</td><td>
				
				<button type="button" class="wsmd_download_button">'.__('Download', 'wsm-downloader').'
				<form style="display:none;" action="" method="POST">
				<input name="class" value="'.$class.'" />
				<input name="type" value="'.$mime['type'].'" />
				<input name="option" value="'.$option.'" />
				<input name="dl" value="'.base64_encode($formats->direct_url).'" />
				<input name="filename" value="'.$filename.'" />
				<input name="size" value="'.$formats->size.'" />
                <input name="token" value="'.base64_encode(WSMD_PLUGIN_FILE).'" />					
				</form>
                </button>
				
				</td></tr>';
				
			   }
            }
            $dl_body_inner .= '</table></div>';
        }


		
        /////Documents formats
        if (isset($data_decoder->duc)) {
            $othertab = '<button class="wsmd_tablinks" onclick="wsmd_open_tab(event,'.
            "'wsmd_otherf_tab')".
            '"><span class="dashicons dashicons-media-default"></span>'.__('Documents', 'wsm-downloader').
            '</button>';
            $dl_body_inner .= '<div id="wsmd_otherf_tab" class="wsmd_tabcontent"><table class="wsmd_result_table"><tr>
			<th>'.__('Format', 'wsm-downloader').
		    '</th><th>'.__('Quality', 'wsm-downloader').
            '</th><th>'.__('Size', 'wsm-downloader').
            '</th><th>'.__('Download', 'wsm-downloader').
            '</th></tr>';
            foreach($data_decoder->duc as $duc) {

          
				if(max(0 , $duc->size) !== 0 or isset($wsmds_options['shortcode']['show']['zerosize'])){
			
				    $type = $formats->duc;
				    if(strpos($type , '/') !== false){
						$yt = explode('/' , $type); 
						$type = $yt[1];
					}

	               $filename = $clean_title.'.'.$type;
	               $mime = wp_check_filetype($filename, null );
				
				

				
                $dl_body_inner .= '<tr><td>'.$duc->type.
                '</td><td>'.$duc->quality.
                '</td><td>'.wsmd_formatBytes($duc->size).
                '</td><td>
				
				<button type="button" class="wsmd_download_button">'.__('Download', 'wsm-downloader').'
				<form style="display:none;" action="" method="POST">
				<input name="class" value="'.$class.'" />
				<input name="type" value="'.$mime['type'].'" />
				<input name="option" value="'.$option.'" />
				<input name="dl" value="'.base64_encode($duc->direct_url).'" />
				<input name="filename" value="'.$filename.'" />
				<input name="size" value="'.$duc->size.'" />
                <input name="token" value="'.base64_encode(WSMD_PLUGIN_FILE).'" />				
				</form>
                </button>
				
				</td></tr>';
				
				}
            }
            $dl_body_inner .= '</table></div>';
        }
		
		

        $dl_body .= ' <div class = "wsmd_tab" >
        '.$videtab.'
        '.$audiotab.'
        '.$phototab.'
        '.$othertab.' </div>
        '.$dl_body_inner;


        $dl_body .= '</div>';

        return $dl_body;

    } else {
		
		$sorry_output = '
		<div class="wsmd_sorry_output" >
		<div class="wsmd_sorry_face">
		<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 25 25"><path fill="none" d="M0 0h24v24H0V0z"/><circle cx="15.5" cy="9.5" r="1.5"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-6c-2.33 0-4.32 1.45-5.12 3.5h1.67c.69-1.19 1.97-2 3.45-2s2.75.81 3.45 2h1.67c-.8-2.05-2.79-3.5-5.12-3.5z"/></svg>
		</div>
		<div class="wsmd_sorry_text">'.__("Sorry , We cant extract any download link from this url!", 'wsm-downloader').'</div>';
		
		
        return $sorry_output;
    }


}	

?>