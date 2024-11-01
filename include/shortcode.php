<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_shortcode('wsmd_downloader', 'wsmd_downloader_shortcode');
function wsmd_downloader_shortcode(){
$wsmds_admin_options = get_option('wsmds_admin_options');
$html = '';	
$modal_content = '';
$no_modal_content = '';
$active_downloaders = array();
$downloaders = isset($wsmds_admin_options['downloader']) ? $wsmds_admin_options['downloader'] : array();
foreach($downloaders as $key => $val){
	$active_downloaders[] = ucfirst($key);
}
$active_downloaders[] = __("Paste link here" , 'wsm-downloader');

if($wsmds_admin_options['shortcode']['template'] == 'custom'){
include WSMD_PLUGIN_FILE.'assets/css/frontend/themes/custom_template.php';
}else{
$template = $wsmds_admin_options['shortcode']['template'];
include WSMD_PLUGIN_FILE.'assets/css/frontend/themes/'.$template.'.css.php';	
}



$custom_styles = isset($wsmds_admin_options['shortcode']['custom_style']) ? '<style type="text/css">'.$wsmds_admin_options['shortcode']['custom_style'].'</style>' : "";

        wp_register_script('wsmd_downloader', WSMD_PLUGIN_URL.'/assets/js/frontend/user.js', array('jquery'), WSMD_SCRIPT_VERSION, true);
        $values = array(
            'blog' => get_option('siteurl'),
            'wpajax' => admin_url('admin-ajax.php'),
            'availabe' => json_encode($active_downloaders),
            'urlvalid' => __("Please insert a valid url! A valid url should start with http:// or https://",'wsm-downloader'),
            'onpaste' => isset($wsmds_admin_options['shortcode']['onpaste']) ? "true" : "false",
            'sharable' => isset($wsmds_admin_options['shortcode']['sharable']) ? "true" : "false",	
            'modal' => isset($wsmds_admin_options['shortcode']['modal']['active']) ? "true" : "false", 
            'animph' =>  isset($wsmds_admin_options['shortcode']['animatedph']) ? "true" : "false"			
        );
        wp_localize_script('wsmd_downloader', 'wsmd_user', $values);
        wp_enqueue_script('wsmd_downloader');
        wp_enqueue_style('wsmd_animate', WSMD_PLUGIN_URL.'/assets/css/frontend/animate.css', false, WSMD_SCRIPT_VERSION, false);

$button_icon = $wsmds_admin_options['shortcode']['form']['button_icon'] ? $wsmds_admin_options['shortcode']['form']['button_icon'] : '';
$button_text = $wsmds_admin_options['shortcode']['form']['button_text'] ? $wsmds_admin_options['shortcode']['form']['button_text'] : __("Start",'wsm-downloader');
$modal_mode  = isset($wsmds_admin_options['shortcode']['modal']['active']) ? true : false;

$close_button = '
<div class="wsmd_close_modal">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
</div>';


if($modal_mode == true){
	
$modal_content .= '<div id="wsmd_downloader_modal" class="wsmd_downloader_modal">';
  $modal_content .= '<div class="wsmd_downloader_modal_content">';  
   $modal_content .= '<div class="wsmd_downloader_modal_body" style="padding:10px;">'.$close_button;
    $modal_content .= '<div class="wsmd_downloader_ads1">'.do_shortcode($wsmds_admin_options['shortcode']['modal']['ads1']).'</div>';
     $modal_content .= '<div class="wsmd_loading_holder" id="wsmd_loading" ><img width="64" height="64" id="wsmd_loading_img" src="'.$wsmds_admin_options['shortcode']['preloader'].'" /><h3>'.__("Preparing download links ...",'wsm-downloader').'</h3></div><div class="wsmd_downloader_result_holder"></div>';
    $modal_content .= '<div class="wsmd_downloader_ads2">'.do_shortcode($wsmds_admin_options['shortcode']['modal']['ads2']).'</div>';
   $modal_content .= '</div>';
  $modal_content .= '</div>';
$modal_content .= '</div>';	
	
}else{

$no_modal_content .= '<div  class="wsmd_downloader_no_modal_content" style="text-align: center;margin:20px auto;"><div class="wsmd_loading_nomodal_holder" id="wsmd_loading" ><img width="64" height="64" id="wsmd_loading_img" src="'.$wsmds_admin_options['shortcode']['preloader'].'" /><h3>'.__("Preparing download links ...",'wsm-downloader').'</h3></div><div class="wsmd_downloader_result_holder"></div></div>';
	
}




$html .= '<div class="wsmd_downloader_form_holder">';	


     $html .= '<div style="display:flex;">';
       $html .= '<input type="text" value="" id="wsmd_downloader_form_input" placeholder="'.__("Paste link here" , 'wsm-downloader').'"/><button type="button" id="wsmd_downloader_form_button">'.$button_icon.'&nbsp;'.$button_text.'</button>';	
     $html .= '</div>';	
     $html .= '<div class="wsmd_error_holder"></div>';	 
     $html .= $modal_content;	
	
$html .= '</div>';
$html .= $no_modal_content;
$html .= $custom_styles;


include WSMD_PLUGIN_FILE.'assets/css/frontend/style-fixed.css.php';

return $html;	
}