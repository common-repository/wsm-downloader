<?php
/**
 * Plugin Name: WSM Downloader
 * Description: Download Video , Audio And images from social networks
 * Author: S.J.Hossseini
 * Author URI: https://t.me/ttmga
 * Version: 1.4.0
 * Text Domain: wsm-downloader
 * Domain Path: /languages
 */


// Define WSMD_PLUGIN_FILE.
if (!defined('WSMD_PLUGIN_FILE'))
  {
    define('WSMD_PLUGIN_FILE', plugin_dir_path(__FILE__));
    define('WSMD_PLUGIN_URL', plugins_url('', __FILE__));
    define('WSMD_SCRIPT_VERSION', '1.4.0');	
  }
  
  
// load plugin file
require WSMD_PLUGIN_FILE . 'include/functions.php';  
require WSMD_PLUGIN_FILE . 'include/thumnail.php';
require WSMD_PLUGIN_FILE . 'include/download.php';
require WSMD_PLUGIN_FILE . 'include/shortcode.php';
require WSMD_PLUGIN_FILE . 'include/user.php';
require WSMD_PLUGIN_FILE . 'include/admin/wp_media.php';
require WSMD_PLUGIN_FILE . 'include/admin/setting.php';

 
// global downloadprogree
global $downloadprogress;
global $downloadholder;  
global $fastdownload;
global $activedownloaders;
$activedownloaders = array('instagram' , 'facebook' , 'bandcamp');
  
// setting links  
function wsmd_add_settings_link($links)
  {
    $settings_link = '<a href="' . admin_url('admin.php?page=wsm_downloader') . '">'.__("Setting",'wsm-downloader').'</a>';
    array_push($links, $settings_link);
    return $links;
  }
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'wsmd_add_settings_link');  
  
 
 
/// loading text domian
function wsmd_load_textdomain() {
    load_plugin_textdomain( 'wsm-downloader', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wsmd_load_textdomain' ); 
 
////////////////////////////////////////////admin setting page
add_action('admin_menu', function(){add_options_page(__("Downloader Setting",'wsm-downloader') , __("WSM Downloader",'wsm-downloader') , 'manage_options', 'wsm_downloader', 'wsm_downloader_setting_page');});   
 
// admin scripts  
add_action('admin_enqueue_scripts', function(){


	$screens = get_post_types();
	$current = get_current_screen();
	if (in_array($current->post_type , $screens)){
        wp_register_script('wsmd_admin_js', plugins_url('assets/js/admin/admin.js', __FILE__), array('jquery'), WSMD_SCRIPT_VERSION, true);
        $values = array(
            'blog' => get_option('siteurl'),
            'wpajax' => admin_url('admin-ajax.php'),
			'linkplch' => __("Paste URL Here",'wsm-downloader'),
			'dlbuttontxt' => __("Download",'wsm-downloader'),
			'proxy_option' => __("Use Proxy",'wsm-downloader'),
			'mlip_option' => __("Use Multiple Ip",'wsm-downloader'),	
			'alert' => __("Please insert link",'wsm-downloader'),			
            'tabname' => __("WSM Downloader",'wsm-downloader'),
            'jsonfile' => WSMD_PLUGIN_URL.'/assets/json/progressbar.json',
            'errorfile' => WSMD_PLUGIN_URL.'/assets/json/error.json'			
        );
        wp_localize_script('wsmd_admin_js', 'wsmd_admin', $values);
        wp_enqueue_script('wsmd_admin_js');

		 if(is_rtl()){
        wp_enqueue_style('wsmd_admin_css', plugins_url('assets/css/admin/admin_rtl.css', __FILE__), false, WSMD_SCRIPT_VERSION, false);
		 }else{
        wp_enqueue_style('wsmd_admin_css', plugins_url('assets/css/admin/admin.css', __FILE__), false, WSMD_SCRIPT_VERSION, false);			 
		 }
	}
	
      if (isset($_GET['page']) && ($_GET['page'] == 'wsm_downloader'))
      {

        wp_enqueue_script(  'wsmd_admin_cm_js', plugins_url('assets/plugins/codemirror/lib/codemirror.js', __FILE__),array('jquery'),'',true);	
        wp_enqueue_script(  'wsmd_admin_cssmode_js', plugins_url('assets/plugins/codemirror/mode/css/css.js', __FILE__),array('jquery'),'',true);				
        wp_enqueue_script(  'wsmd_admin_refresh_js', plugins_url('assets/plugins/codemirror/display/autorefresh.js', __FILE__),array('jquery'),'',true);	  
  
  
        wp_register_script('wsmd_admin_setting_js', plugins_url('assets/js/admin/admin-settings.js', __FILE__), array('jquery'), WSMD_SCRIPT_VERSION, true);
        $values = array(
            'blog' => get_option('siteurl'),
			'assets' => WSMD_PLUGIN_URL.'/assets/img/',
            'wpajax' => admin_url('admin-ajax.php'),
            'title' => __("Loading image",'wsm-downloader'),
            'button' => __("Choose",'wsm-downloader'),			
        );
        wp_localize_script('wsmd_admin_setting_js', 'wsmd_admin_setting', $values);
        wp_enqueue_script('wsmd_admin_setting_js');
		wp_enqueue_script('jquery-ui-spinner');	
		wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker-alpha', plugins_url('assets/js/admin/wp-color-picker-alpha.js', __FILE__), array( 'wp-color-picker' ), WSMD_SCRIPT_VERSION, true );


		 wp_enqueue_style( 'wp-color-picker' );
		 
		 if(is_rtl()){
         wp_enqueue_style('wsmd_admin_setting_css', plugins_url('assets/css/admin/admin-settings_rtl.css', __FILE__), false, WSMD_SCRIPT_VERSION, false);
		 }else{
         wp_enqueue_style('wsmd_admin_setting_css', plugins_url('assets/css/admin/admin-settings.css', __FILE__), false, WSMD_SCRIPT_VERSION, false);			 
		 }
		 
         wp_enqueue_style('wsmd_admin_jquery_css', plugins_url('assets/css/admin/jquery-ui.css', __FILE__), false, WSMD_SCRIPT_VERSION, false);
		 wp_enqueue_style('wsmd_admin_cm_style', plugins_url('assets/plugins/codemirror/lib/codemirror.css', __FILE__));			 
		 
		 
	  }  
		
});


register_activation_hook( __FILE__, 'wsmd_plugin_activation_hook' ); 

function wsmd_plugin_activation_hook(){
$options = get_option('wsmds_admin_options');
if(!$options){


$defaults["shortcode"]["animatedph"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["facebook"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["telegram"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["whatsapp"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["twitter"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["pinterest"] = "on" ;
$defaults["shortcode"]["sharebuttons"]["linkedin"] = "on" ;
$defaults["shortcode"]["form"]["button_text"] = "" ;
$defaults["shortcode"]["form"]["button_icon"] = "" ;
$defaults["shortcode"]["form"]["desktop"]["width"] = "760" ;
$defaults["shortcode"]["form"]["mobile"]["width"] = "80" ;
$defaults["shortcode"]["form"]["field"]["color"] = "#000000" ;
$defaults["shortcode"]["form"]["field"]["bgcolor"] = "#ffffff" ;
$defaults["shortcode"]["form"]["field"]["pholdercolor"] = "#e4e4e4" ;
$defaults["shortcode"]["form"]["field"]["size"] = "15" ;
$defaults["shortcode"]["form"]["field"]["mobile"]["size"] = "15" ;
$defaults["shortcode"]["form"]["field"]["mobile"]["width"] = "75" ;
$defaults["shortcode"]["form"]["field"]["mobile"]["height"] = "80" ;
$defaults["shortcode"]["form"]["field"]["width"] = "75" ;
$defaults["shortcode"]["form"]["field"]["height"] = "80" ;
$defaults["shortcode"]["form"]["field"]["border-width"] = "0" ;
$defaults["shortcode"]["form"]["field"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["form"]["field"]["border-style"] = "solid" ;
$defaults["shortcode"]["form"]["field"]["border-radius"] = "0" ;
$defaults["shortcode"]["form"]["button"]["color"] = "#ffffff" ;
$defaults["shortcode"]["form"]["button"]["bgcolor"] = "#3f00ff" ;
$defaults["shortcode"]["form"]["button"]["fsize"] = "15" ;
$defaults["shortcode"]["form"]["button"]["mobile"]["fsize"] = "15" ;
$defaults["shortcode"]["form"]["button"]["mobile"]["width"] = "25" ;
$defaults["shortcode"]["form"]["button"]["mobile"]["height"] = "80" ;
$defaults["shortcode"]["form"]["button"]["width"] = "25" ;
$defaults["shortcode"]["form"]["button"]["height"] = "80" ;
$defaults["shortcode"]["form"]["button"]["border-width"] = "0" ;
$defaults["shortcode"]["form"]["button"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["form"]["button"]["border-style"] = "solid" ;
$defaults["shortcode"]["form"]["button"]["border-radius"] = "0" ;
$defaults["shortcode"]["preloader"] = str_replace('_' , '-' , WSMD_PLUGIN_URL).'/assets/img/preloader.gif' ;
$defaults["shortcode"]["modal"]["active"] = "on" ;
$defaults["shortcode"]["modal"]["ads1"] = "" ;
$defaults["shortcode"]["modal"]["ads2"] = "" ;
$defaults["shortcode"]["modal"]["fontcolor"] = "" ;
$defaults["shortcode"]["modal"]["background"] = "" ;
$defaults["shortcode"]["modal"]["border-width"] = "0" ;
$defaults["shortcode"]["modal"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["modal"]["border-style"] = "solid" ;
$defaults["shortcode"]["modal"]["border-radius"] = "0" ;
$defaults["shortcode"]["modal"]["animation"] = "flipInY" ;
$defaults["shortcode"]["template"] = "lightred" ;
$defaults["shortcode"]["customcolor"] = "#00c65c" ;
$defaults["shortcode"]["result"]["title"]["color"] = "#000000" ;
$defaults["shortcode"]["result"]["title"]["size"] = "15" ;
$defaults["shortcode"]["result"]["title"]["mobile"]["size"] = "15" ;
$defaults["shortcode"]["result"]["thumnail"]["width"] = "250" ;
$defaults["shortcode"]["result"]["thumnail"]["mobile"]["width"] = "250" ;
$defaults["shortcode"]["result"]["thumnail"]["mobile"]["height"] = "250" ;
$defaults["shortcode"]["result"]["thumnail"]["height"] = "250" ;
$defaults["shortcode"]["result"]["thumnail"]["border-width"] = "0" ;
$defaults["shortcode"]["result"]["thumnail"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["result"]["thumnail"]["border-style"] = "solid" ;
$defaults["shortcode"]["result"]["thumnail"]["border-radius"] = "0" ;
$defaults["shortcode"]["table"]["header"]["color"] = "#000000" ;
$defaults["shortcode"]["table"]["header"]["bgcolor"] = "#ffffff" ;
$defaults["shortcode"]["table"]["header"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["header"]["mobile"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["header"]["border-width"] = "0" ;
$defaults["shortcode"]["table"]["header"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["table"]["header"]["border-style"] = "solid" ;
$defaults["shortcode"]["table"]["body"]["color"] = "#ffffff" ;
$defaults["shortcode"]["table"]["body"]["bgcolor"] = "#3f00ff" ;
$defaults["shortcode"]["table"]["body"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["body"]["mobile"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["body"]["border-width"] = "0" ;
$defaults["shortcode"]["table"]["body"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["table"]["body"]["border-style"] = "solid" ;
$defaults["shortcode"]["table"]["button"]["color"] = "#ffffff" ;
$defaults["shortcode"]["table"]["button"]["bgcolor"] = "#3f00ff" ;
$defaults["shortcode"]["table"]["button"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["button"]["mobile"]["fsize"] = "15" ;
$defaults["shortcode"]["table"]["button"]["border-width"] = "0" ;
$defaults["shortcode"]["table"]["button"]["border-color"] = "#effeff" ;
$defaults["shortcode"]["table"]["button"]["border-style"] = "solid" ;
$defaults["shortcode"]["table"]["button"]["border-radius"] = "0" ;
$defaults["shortcode"]["custom_style"] = "" ;
$defaults["downloader"]["instagram"] = "on" ;
$defaults["downloader"]["facebook"] = "on" ;
$defaults["downloader"]["bandcamp"] = "on" ;
$defaults["proxy"]["proxy_ip"] = "" ;
$defaults["proxy"]["proxy_port"] = "" ;
$defaults["proxy"]["proxy_type"] = "CURLPROXY_HTTP" ;
$defaults["proxy"]["userpass"] = "" ;
$defaults["mlpip"]["outgoing_ips"] = "" ;	
update_option('wsmds_admin_options' , $defaults);	
}


}	








////////////add this function to functions.php

add_action( 'update_option' , 'wsmd_save_options_in_json' , 10 , 3);
function wsmd_save_options_in_json($option, $old_value, $value){
if($option == 'wsmds_admin_options'){
$mltip = array();

if(isset($value["mlpip"]["outgoing_ips"])){
$mltips = explode(PHP_EOL,str_replace("\r" , "" ,$value["mlpip"]["outgoing_ips"]));	
$mltip = array_values(array_filter($mltips));
}

$json = array(
"proxy" => array(
              "active" => isset($value["proxy"]["use_proxy"]) ? true : false,
			  "ip" =>  $value["proxy"]["proxy_ip"],
			  "port" => $value["proxy"]["proxy_port"],
			  "type" => $value["proxy"]["proxy_type"],
			  "loginpassw" => $value["proxy"]["userpass"],
			  ),
"mips" => array(
             "active" => isset($value["mlpip"]["use_mlpip"]) ? true : false,
             "iplist" => $mltip, 
            )
);	

file_put_contents(WSMD_PLUGIN_FILE.'dl_engine/config.json' , json_encode($json));		 

}	
}