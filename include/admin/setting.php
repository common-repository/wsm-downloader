<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_init', function(){
    register_setting('wsmds-admin-settings', 'wsmds_admin_options');  
});

function wsm_downloader_setting_page(){	
	$wsmds_admin_options = get_option('wsmds_admin_options');
    $activedownloaders = array('youtube' , 'instagram' , 'facebook' , 'vimeo' , 'bandcamp' , 'break' , 'buzzfeed' , 'dailymotion'  , 'flickr' , 'imdb' , 'imgur' , 'liveleak' , 'mashable' , 'ninegag' , 'ted' , 'tiktok' , 'tv' , 'twitter' , 'vk');
	$upgrade_style = 'style="
    background: #ff219226;
    text-decoration: none;
    color: #ff0081;
    padding: 5px;
    border-radius: 5px;
    "';
	$upgrade = '<a '.$upgrade_style.' href="https://www.codester.com/items/17496/wordpress-social-media-downloader-plugin?ref=sjafarhosseini007" target="_blank"><span class="dashicons dashicons-star-filled"></span>'.__("Go pro",'wsm-downloader').'</a>';
?>


<div class="wsmds_tabs_holder">
<!-- #### Setting Tabs -->
<div class="wsmds_tab">
  <button class="wsmds_tablinks" onclick="openTab(event, 'shortcode')" id="wsmds_tab_default"><?php echo __("Shortcode",'wsm-downloader'); ?></button>
  <button class="wsmds_tablinks" onclick="openTab(event, 'styles')"><?php echo __("Styles",'wsm-downloader'); ?></button>   
  <button class="wsmds_tablinks" onclick="openTab(event, 'setting')"><?php echo __("Settings",'wsm-downloader'); ?></button>     
</div> 
<!-- #### End Setting Tabs -->
</div>


<!-- ## Setting Page -->
<div class="wsmds_settings_holder">

<!-- ######################## Setting Form -->
	 <form action="options.php" method="post" id="wsmds_setting_form">  
		<?php
        	settings_fields('wsmds-admin-settings');
	        do_settings_sections('wsmds-admin-settings');
         ?> 


		    <!-- ###################################################################### shortcode Part -->
            <div id="shortcode" class="wsmds_tabcontent">
			
			<div class="wsmds_shortcode_holder">
			        <b>shortcode <span style="font-size:20px;" class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("Copy and paste this shortcode directly into the page, post or widget where you'd like 'download form' to show up",'wsm-downloader'); ?>"></span>: </b><input type="text" class="wsmds_shortcode_code" readonly  value="[wsmd_downloader]" />
			</div>
			
	          <table class="form-table">
			  
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Shortcode Configuration",'wsm-downloader'); ?></b></th> 
                    <td></td>	  
	            </tr>	


				
				
				
				
				<!-- #### Downloaders NAme ##### -->
	            <tr>
                    <th ><b><?php echo __("Show active downloaders name in url field?",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("If this option is enabled the name of the active downloaders will be animated in the URL field.Otherwise 'paste linke here' will be displayed.",'wsm-downloader'); ?>"></span>
					</th> 
                    <td><input type="checkbox" name="wsmds_admin_options[shortcode][animatedph]" id="wsmd_show_downloaders_name" <?php echo isset($wsmds_admin_options['shortcode']['animatedph'])  ? 'checked="checked"' : '';?> /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>
				<!-- #### End Downloaders NAme ##### -->
				
	
				<!-- #### Downloaders On Paste ##### -->
	            <tr>
                    <th ><b><?php echo __("Start Download on Paste?",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("If this option is enabled download will be started automatically after user paste link in download form.",'wsm-downloader'); ?>"></span>
					</th> 
                    <td><input type="checkbox" name="wsmds_admin_options[shortcode][onpaste]" <?php echo isset($wsmds_admin_options['shortcode']['onpaste'])  ? 'checked="checked"' : '';?> /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>
				<!-- #### End Downloaders Paste ##### -->

	

				<!-- #### Share Download results ##### -->
	            <tr>
                    <th ><b><?php echo __("Allow users to share download results?",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("If this option is enabled user can share download results on social networks",'wsm-downloader'); ?>"></span>
					</th> 
                    <td>
					
					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharable]" id="wsmds_allow_share_results" <?php echo isset($wsmds_admin_options['shortcode']['sharable'])  ? 'checked="checked"' : '';?> /><?php echo __("Yes",'wsm-downloader');?>
                    <br><br>
					
					<div  id="wsmds_choose_share_buttons" style="display:none;">
					<?php echo __("Choose Share buttons : ",'wsm-downloader'); ?>
                    <div style="display: inline-block;">
                    <div class="wsmd_active_downloader">
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][facebook]"  <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['facebook'])  ? 'checked="checked"' : '';?> /><?php echo __("Facebook",'wsm-downloader');?>
					</div>
                    <div class="wsmd_active_downloader">					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][telegram]"  <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['telegram'])  ? 'checked="checked"' : '';?> /><?php echo __("Telegram",'wsm-downloader');?>
					</div>
                    <div class="wsmd_active_downloader">					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][whatsapp]"  <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['whatsapp'])  ? 'checked="checked"' : '';?> /><?php echo __("Whatsapp",'wsm-downloader');?>
					</div>
                    <div class="wsmd_active_downloader">					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][twitter]"  <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['twitter'])  ? 'checked="checked"' : '';?> /><?php echo __("Twitter",'wsm-downloader');?>
					</div>
                    <div class="wsmd_active_downloader">					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][pinterest]" <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['pinterest'])  ? 'checked="checked"' : '';?> /><?php echo __("Pinterest",'wsm-downloader');?>
					</div>
                    <div class="wsmd_active_downloader">					
					<input type="checkbox" name="wsmds_admin_options[shortcode][sharebuttons][linkedin]" <?php echo isset($wsmds_admin_options['shortcode']['sharebuttons']['linkedin'])  ? 'checked="checked"' : '';?> /><?php echo __("Linkedin",'wsm-downloader');?>				
                    </div>					
					</div>
					</div>
					
					
					</td>	  
	            </tr>
				<!-- #### Share Download results ##### -->

	
				
				<!-- #### Form text and icon  ##### -->
	            <tr>
                    <th ><b><?php echo __("Download form's button text",'wsm-downloader'); ?></b>
					</th> 
                    <td>
					<input name="wsmds_admin_options[shortcode][form][button_text]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button_text']; ?>" />
					</td>	  
	            </tr>
				
	            <tr>
                    <th><b><?php echo __("Download form's button icon",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __('put your favorite icon here.you can use standard emojies or if your template supports fontawesome icons ,you can use it by putting fontawesome icon as html format ; like : <i class=&quot;fa fa-cloud-download&quot;></i>.also you can use material icons , themify icons and etc if your template supports these icons but dont forget to add your icon in html format.','wsm-downloader'); ?>"></span>
					</th> 
                    <td>
					<input name="wsmds_admin_options[shortcode][form][button_icon]" type="text" value='<?php echo $wsmds_admin_options['shortcode']['form']['button_icon']; ?>' />
					</td>	  
	            </tr>				
				<!-- #### End Form text and icon ##### -->				
				
				
				
	            <tr>
                    <th ><b><?php echo __("Loading image (gif format)",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("choose a loading image.if you do not choose an image then default loading image will be used.This image will be displayed after clicking on the 'download form' button.",'wsm-downloader'); ?>"></span>
					</th> 
                    <td>
					<div style="display: table-cell;text-align: center;">
					<div class="wsmd_option_holder" style="display: grid;">
					<?php echo $wsmds_admin_options['shortcode']['preloader'] ? '<img id="wsmds_loader_img_holder" width="64" height="64" style="margin: auto;" src="'.$wsmds_admin_options['shortcode']['preloader'].'" />' : '<img id="wsmds_loader_img_holder" width="64" height="64" style="margin: auto;" src="'.WSMD_PLUGIN_URL.'/assets/img/preloader.gif'.'" />';?>
					<input type="hidden"  name="wsmds_admin_options[shortcode][preloader]" id="wsmd_show_preloader_input" value="<?php echo esc_attr($wsmds_admin_options['shortcode']['preloader'])?>" />
					<input type="button" onclick="wsmds_open_media_uploader_image_plus();" id="wsmd_show_preloader_choose" value="<?php echo __("Change Loading",'wsm-downloader'); ?>" />
					</div>
					</div>
					</td>	  
	            </tr>				
				


	            <tr>
                    <th ><b><?php echo __("Show download links with no size?",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("Download links with no size will not be shown up to user By default, enable this option to show all size even 0!",'wsm-downloader'); ?>"></span>
					</th> 
                    <td><input type="checkbox" name="wsmds_admin_options[shortcode][show][zerosize]"  <?php echo isset($wsmds_admin_options['shortcode']['show']['zerosize'])  ? 'checked="checked"' : '';?> /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>	


                <!-- #### MODAL ##### -->
	            <tr>
                    <th ><b><?php echo __("Show download results in Modal window?",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("If this setting is enabled the download results will be displayed to users in a modal window. This feature allows you to show some ads in this section. Otherwise the download results will be displayed below the input field.",'wsm-downloader'); ?>"></span>
					</th> 
                    <td><input type="checkbox" name="wsmds_admin_options[shortcode][modal][active]" id="wsmd_show_results_in_modal" <?php echo isset($wsmds_admin_options['shortcode']['modal']['active'])  ? 'checked="checked"' : '';?> /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>				
			  
		
		
	            <tr class="wsmd_modal_mode">
                    <th ><b><?php echo __("Ads content 1 : ",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("This ads will be shown before download results",'wsm-downloader'); ?>"></span>
					</th> 
                    <td>
	                <?php
	                 $setting = array(
	                            'textarea_name' => 'wsmds_admin_options[shortcode][modal][ads1]',
                                'textarea_rows' => 10
                                );
	                            wp_editor( $wsmds_admin_options['shortcode']['modal']['ads1'] , 'wsmds_modal_ads1' , $setting );
	                ?>						
					<br>
					
					</td>	  
	            </tr>			
	
	

	            <tr class="wsmd_modal_mode">
                    <th ><b><?php echo __("Ads content 2 : ",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("This ads will be shown after download results",'wsm-downloader'); ?>"></span>
					</th> 
                    <td>
	                <?php
	                 $setting = array(
	                            'textarea_name' => 'wsmds_admin_options[shortcode][modal][ads2]',
                                'textarea_rows' => 10
                                );
	                            wp_editor( $wsmds_admin_options['shortcode']['modal']['ads2'] , 'wsmds_modal_ads2' , $setting );
	                ?>						
					<br>
					</td>	  
	            </tr>
				
			  </table>
			 <?php submit_button(); ?> 
            </div>	
		    <!-- ###################################################################### End shortcode Part -->	
	

	
	
		    <!-- ###################################################################### styles -->		
            <div id="styles" class="wsmds_tabcontent">	
	

	          <table class="form-table">

	            <tr class="wsmd_th_header wsmd_modal_mode">
                    <th ><b><?php echo __("Shortcode Template",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("Choose a template or choose custom template to create your own styles",'wsm-downloader'); ?>"></span>
					</th> 
                    <td></td>	  
	            </tr>

	            <tr>
                    <th><b><?php echo __("Template : ",'wsm-downloader'); ?></b></th> 
                    <td>
					
					<div style="display: grid;">

                    <div class="wsmd_option_holder">					
	                   <select id="wsmds_template_chooser" name="wsmds_admin_options[shortcode][template]">
	                       <option value="darkblue" <?php selected($wsmds_admin_options['shortcode']['template'], "darkblue"); ?>><?php echo __("Dark Blue",'wsm-downloader'); ?></option>		                       
		                   <option value="darkred" <?php selected($wsmds_admin_options['shortcode']['template'], "darkred"); ?>><?php echo __("Dark Red",'wsm-downloader'); ?></option>
		                   <option value="darkcustom" <?php selected($wsmds_admin_options['shortcode']['template'], "darkcustom"); ?>><?php echo __("Dark + Custom Color",'wsm-downloader'); ?></option>						   
	                       <option value="lightblue" <?php selected($wsmds_admin_options['shortcode']['template'], "lightblue"); ?>><?php echo __("Light Blue",'wsm-downloader'); ?></option>
	                       <option value="lightred" <?php selected($wsmds_admin_options['shortcode']['template'], "lightred"); ?>><?php echo __("Light Red",'wsm-downloader'); ?></option>
	                       <option value="lightcustom" <?php selected($wsmds_admin_options['shortcode']['template'], "lightcustom"); ?>><?php echo __("Light + Custom Color",'wsm-downloader'); ?></option>						   
	                       <option value="custom" <?php selected($wsmds_admin_options['shortcode']['template'], "custom"); ?>><?php echo __("Custom Template",'wsm-downloader'); ?></option>
	                   </select>
					   
					   
					<div id = "wsmds_template_custom_color"> 
                    <div style="display:inline-flex;" >					
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
					<b><?php echo __("Custom Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input  name = "wsmds_admin_options[shortcode][customcolor]" type="text" value="<?php echo esc_attr($wsmds_admin_options['shortcode']['customcolor']); ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="red" />		
                    </div>					
                    </div>					  

					  
	                </div>

					</div>
					</td>	  
	            </tr>				
				
				 <?php submit_button(); ?>	
				
              </table>	

			 <?php if($wsmds_admin_options['shortcode']['template'] !== 'custom'){ ?>
                 <img src="<?php echo WSMD_PLUGIN_URL.'/assets/img/'.$wsmds_admin_options['shortcode']['template'].'.png';?>" id="wsmds_template_demo" />			  
			 <?php }else{ ?>
			      <img  id="wsmds_template_demo" />	
			 <?php } ?>
			
			<div id="wsmds_custom_template_styles" >
	          <table class="form-table">


				
				
	            <tr class="wsmd_th_header wsmd_modal_mode">
                    <th ><b><?php echo __("Styles (Modal window)",'wsm-downloader'); ?></b></th> 
                    <td></td>	  
	            </tr>

				
	            <tr class="wsmd_modal_mode">
                    <th><b><?php echo __("Colors : ",'wsm-downloader'); ?></b></th> 
                    <td>

					  <div style="display: grid;">
					<div class="wsmd_option_holder">
					<b><?php echo __("Content Font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_modal_fonts_color" name = "wsmds_admin_options[shortcode][modal][fontcolor]" type="text" value="<?php echo esc_attr($wsmds_admin_options['shortcode']['modal']['fontcolor']); ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#000000" />
					</div>

					<div class="wsmd_option_holder">
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_modal_background_color" name = "wsmds_admin_options[shortcode][modal][background]" type="text" value="<?php echo esc_attr($wsmds_admin_options['shortcode']['modal']['background']); ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />
                    </div>
                      </div>    
					
					</td>	  
	            </tr>	

				
	            <tr class="wsmd_modal_mode">
                    <th><b><?php echo __("Border : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][modal][border-width]" id="wsmds_modal_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['modal']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['modal']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][modal][border-color]" id = "wsmds_modal_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['modal']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['modal']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
					</div>
	                 
                    <div class="wsmd_option_holder">					 
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_modal_border_style" name="wsmds_admin_options[shortcode][modal][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['modal']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                </div>

					<div class="wsmd_option_holder">
						<b><?php echo __("Border Radius : ",'wsm-downloader'); ?></b>&nbsp;	
	                    <input name="wsmds_admin_options[shortcode][modal][border-radius]" id="wsmds_modal_border_radius" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['modal']['border-radius'] ? esc_attr($wsmds_admin_options['shortcode']['modal']['border-radius']) : '0'; ?>"  />&nbsp;<b>px</b>
                    </div>

                    </div>	
					</td>	  
	            </tr>				

	            <tr class="wsmd_modal_mode">
                    <th><b><?php echo __("Animation type : ",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("How the modal window should be appeared.",'wsm-downloader'); ?>"></span>
					</th> 
                    <td>
                    <select id="wsmds_wpinq_price_animation" name="wsmds_admin_options[shortcode][modal][animation]">
                      <optgroup label="Attention Seekers">
                        <option value="bounce" <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounce"); ?>>bounce</option>
                        <option value="flash" <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flash"); ?>>flash</option>
                        <option value="pulse" <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "pulse"); ?>>pulse</option>
                        <option value="rubberBand"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rubberBand"); ?>>rubberBand</option>
                        <option value="shake"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "shake"); ?>>shake</option>
                        <option value="swing"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "swing"); ?>>swing</option>
                        <option value="tada"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "tada"); ?>>tada</option>
                        <option value="wobble"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "wobble"); ?>>wobble</option>
                        <option value="jello"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "jello"); ?>>jello</option>
                        <option value="heartBeat"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "heartBeat"); ?>>heartBeat</option>
                      </optgroup>

                      <optgroup label="Bouncing Entrances">
                        <option value="bounceIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceIn"); ?>>bounceIn</option>
                        <option value="bounceInDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceInDown"); ?>>bounceInDown</option>
                        <option value="bounceInLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceInLeft"); ?>>bounceInLeft</option>
                        <option value="bounceInRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceInRight"); ?>>bounceInRight</option>
                        <option value="bounceInUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceInUp"); ?>>bounceInUp</option>
                      </optgroup>

                      <optgroup label="Bouncing Exits">
                        <option value="bounceOut"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceOut"); ?>>bounceOut</option>
                        <option value="bounceOutDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceOutDown"); ?>>bounceOutDown</option>
                        <option value="bounceOutLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceOutLeft"); ?>>bounceOutLeft</option>
                        <option value="bounceOutRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceOutRight"); ?>>bounceOutRight</option>
                        <option value="bounceOutUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "bounceOutUp"); ?>>bounceOutUp</option>
                      </optgroup>

                      <optgroup label="Fading Entrances">
                        <option value="fadeIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeIn"); ?>>fadeIn</option>
                        <option value="fadeInDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInDown"); ?>>fadeInDown</option>
                        <option value="fadeInDownBig"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInDownBig"); ?>>fadeInDownBig</option>
                        <option value="fadeInLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInLeft"); ?>>fadeInLeft</option>
                        <option value="fadeInLeftBig"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInLeftBig"); ?>>fadeInLeftBig</option>
                        <option value="fadeInRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInRight"); ?>>fadeInRight</option>
                        <option value="fadeInRightBig"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInRightBig"); ?>>fadeInRightBig</option>
                        <option value="fadeInUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInUp"); ?>>fadeInUp</option>
                        <option value="fadeInUpBig"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "fadeInUpBig"); ?>>fadeInUpBig</option>
                      </optgroup>

                      <optgroup label="Flippers">
                        <option value="flip"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flip"); ?>>flip</option>
                        <option value="flipInX"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flipInX"); ?>>flipInX</option>
                        <option value="flipInY"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flipInY"); ?>>flipInY</option>
                        <option value="flipOutX"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flipOutX"); ?>>flipOutX</option>
                        <option value="flipOutY"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "flipOutY"); ?>>flipOutY</option>
                      </optgroup>

                      <optgroup label="Lightspeed">
                        <option value="lightSpeedIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "lightSpeedIn"); ?>>lightSpeedIn</option>
                        <option value="lightSpeedOut"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "lightSpeedOut"); ?>>lightSpeedOut</option>
                      </optgroup>

                      <optgroup label="Rotating Entrances">
                        <option value="rotateIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateIn"); ?>>rotateIn</option>
                        <option value="rotateInDownLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateInDownLeft"); ?>>rotateInDownLeft</option>
                        <option value="rotateInDownRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateInDownRight"); ?>>rotateInDownRight</option>
                        <option value="rotateInUpLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateInUpLeft"); ?>>rotateInUpLeft</option>
                        <option value="rotateInUpRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateInUpRight"); ?>>rotateInUpRight</option>
                      </optgroup>

                      <optgroup label="Rotating Exits">
                        <option value="rotateOut"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateOut"); ?>>rotateOut</option>
                        <option value="rotateOutDownLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateOutDownLeft"); ?>>rotateOutDownLeft</option>
                        <option value="rotateOutDownRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateOutDownRight"); ?>>rotateOutDownRight</option>
                        <option value="rotateOutUpLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateOutUpLeft"); ?>>rotateOutUpLeft</option>
                        <option value="rotateOutUpRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rotateOutUpRight"); ?>>rotateOutUpRight</option>
                      </optgroup>

                      <optgroup label="Sliding Entrances">
                        <option value="slideInUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideInUp"); ?>>slideInUp</option>
                        <option value="slideInDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideInDown"); ?>>slideInDown</option>
                        <option value="slideInLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideInLeft"); ?>>slideInLeft</option>
                        <option value="slideInRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideInRight"); ?>>slideInRight</option>

                      </optgroup>
                      <optgroup label="Sliding Exits">
                        <option value="slideOutUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideOutUp"); ?>>slideOutUp</option>
                        <option value="slideOutDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideOutDown"); ?>>slideOutDown</option>
                        <option value="slideOutLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideOutLeft"); ?>>slideOutLeft</option>
                        <option value="slideOutRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "slideOutRight"); ?>>slideOutRight</option>
                        
                      </optgroup>
                      
                      <optgroup label="Zoom Entrances">
                        <option value="zoomIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "zoomIn"); ?>>zoomIn</option>
                        <option value="zoomInDown"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "zoomInDown"); ?>>zoomInDown</option>
                        <option value="zoomInLeft"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "zoomInLeft"); ?>>zoomInLeft</option>
                        <option value="zoomInRight"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "zoomInRight"); ?>>zoomInRight</option>
                        <option value="zoomInUp"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "zoomInUp"); ?>>zoomInUp</option>
                      </optgroup>
                      


                      <optgroup label="Specials">
                        <option value="hinge"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "hinge"); ?>>hinge</option>
                        <option value="jackInTheBox"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "jackInTheBox"); ?>>jackInTheBox</option>
                        <option value="rollIn"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rollIn"); ?>>rollIn</option>
                        <option value="rollOut"  <?php selected($wsmds_admin_options['shortcode']['modal']['animation'], "rollOut"); ?>>rollOut</option>
                      </optgroup>
                    </select>
					</td>	  
	            </tr>					

                <!-- #### END MODAL ##### -->				
		
		
		
		
		
		
		
		
		
		       <!-- #### Download Form Styles ##### -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Styles (Download form)",'wsm-downloader'); ?></b></th> 
                    <td></td>	  
	            </tr>
			

	
	            <tr>
                    <th><b><?php echo __("Form Width : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">

					<div class="wsmd_option_holder">
					<b><?php echo __("Desktop (width > 760px) : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_holder_width_desktop" name="wsmds_admin_options[shortcode][form][desktop][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['desktop']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['desktop']['width']) : '760'; ?>"  />&nbsp;<b>px</b>
					&nbsp;&nbsp;&nbsp;&nbsp;
                    <b><?php echo __("Mobile (width < 760px) : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_holder_width_mobile" name="wsmds_admin_options[shortcode][form][mobile][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['mobile']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['mobile']['width']) : '80'; ?>"  />&nbsp;<b>%</b>						
                     </div>	
					 
                    </div>					
					</td>	  
	            </tr>	

			
	            <tr>
                    <th><b><?php echo __("Size & Colors (URL input) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">
					<b><?php echo __("font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_form_field_fonts_color" name = "wsmds_admin_options[shortcode][form][field][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['color'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['color']) : "#000000"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#000000" />
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_form_field_background_color" name = "wsmds_admin_options[shortcode][form][field][bgcolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['bgcolor'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['bgcolor']) : "#ffffff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />
                    </div>					
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Placeholder Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_form_field_pholder_color" name = "wsmds_admin_options[shortcode][form][field][pholdercolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['pholdercolor'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['pholdercolor']) : "#e4e4e4"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#e4e4e4" />
                    </div>

					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_fonts_size" name="wsmds_admin_options[shortcode][form][field][size]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['size'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['size']) : '15'; ?>"  />&nbsp;<b>px</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Font Size (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_fonts_size_mobile" name="wsmds_admin_options[shortcode][form][field][mobile][size]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['size'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['mobile']['size']) : '15'; ?>"  />&nbsp;<b>px</b>					
                     </div>					


					<div class="wsmd_option_holder">
					<b><?php echo __("Input width : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_input_width" name="wsmds_admin_options[shortcode][form][field][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['width']) : '75'; ?>"  />&nbsp;<b>%</b>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Input width (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_input_width_mobile" name="wsmds_admin_options[shortcode][form][field][mobile][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['mobile']['width']) : '75'; ?>"  />&nbsp;<b>%</b>						
                     </div>	

					<div class="wsmd_option_holder">
					<b><?php echo __("Input height : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_input_height" name="wsmds_admin_options[shortcode][form][field][height]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['height'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['height']) : '80'; ?>"  />&nbsp;<b>px</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					<b><?php echo __("Input height (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_field_input_height_mobile" name="wsmds_admin_options[shortcode][form][field][mobile][height]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['height'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['mobile']['height']) : '80'; ?>"  />&nbsp;<b>px</b>					
                     </div>	

					 
                    </div>					
					</td>	  
	            </tr>


	            <tr>
                    <th><b><?php echo __("Border (URL input) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][form][field][border-width]" id="wsmds_input_field_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][form][field][border-color]" id = "wsmds_input_field_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
					</div>
	                 
                    <div class="wsmd_option_holder">					 
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_input_field_border_style" name="wsmds_admin_options[shortcode][form][field][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['form']['field']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                </div>

					<div class="wsmd_option_holder">
						<b><?php echo __("Border Radius : ",'wsm-downloader'); ?></b>&nbsp;	
	                    <input name="wsmds_admin_options[shortcode][form][field][border-radius]" id="wsmds_input_field_border_radius" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['field']['border-radius'] ? esc_attr($wsmds_admin_options['shortcode']['form']['field']['border-radius']) : '0'; ?>"  />&nbsp;<b>px</b>
                    </div>

                    </div>					
					</td>	  
	            </tr>					
								
	

	            <tr>
                    <th><b><?php echo __("Size & Colors (Form Button) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					<b><?php echo __("font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_form_button_fonts_color" name = "wsmds_admin_options[shortcode][form][button][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['color'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['color']) : "#ffffff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />
					</div>
					
					<div class="wsmd_option_holder">					
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_form_button_background_color" name = "wsmds_admin_options[shortcode][form][button][bgcolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['bgcolor'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['bgcolor']) : "#3f00ff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#3f00ff" />		
                    </div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_fonts_size" name="wsmds_admin_options[shortcode][form][button][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					<b><?php echo __("Font Size (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_fonts_size_mobile" name="wsmds_admin_options[shortcode][form][button][mobile][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['mobile']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>	
                     </div>


					<div class="wsmd_option_holder">
					<b><?php echo __("Button width : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_input_width" name="wsmds_admin_options[shortcode][form][button][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['width']) : '25'; ?>"  />&nbsp;<b>%</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					<b><?php echo __("Button width (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_input_width_mobile" name="wsmds_admin_options[shortcode][form][button][mobile][width]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['mobile']['width']) : '25'; ?>"  />&nbsp;<b>%</b>
                     </div>						 

					<div class="wsmd_option_holder">
					<b><?php echo __("Button height : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_input_height" name="wsmds_admin_options[shortcode][form][button][height]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['height'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['height']) : '80'; ?>"  />&nbsp;<b>px</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
					<b><?php echo __("Button height (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_form_button_input_height" name="wsmds_admin_options[shortcode][form][button][mobile][height]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['height'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['mobile']['height']) : '80'; ?>"  />&nbsp;<b>px</b>				
                     </div>						 
					 
                    </div>					
					</td>	  
	            </tr>


	            <tr>
                    <th><b><?php echo __("Border (Form Button) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][form][button][border-width]" id="wsmds_input_button_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][form][button][border-color]" id = "wsmds_input_button_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
	                </div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_input_button_border_style" name="wsmds_admin_options[shortcode][form][button][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['form']['button']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                </div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Radius : ",'wsm-downloader'); ?></b>&nbsp;	
	                    <input name="wsmds_admin_options[shortcode][form][button][border-radius]" id="wsmds_input_button_border_radius" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['form']['button']['border-radius'] ? esc_attr($wsmds_admin_options['shortcode']['form']['button']['border-radius']) : '0'; ?>"  />&nbsp;<b>px</b>					
					</div>
					
					</div>
					</td>	  
	            </tr>	 	
				<!-- #### End Download Form ##### -->


				
				
				
				
				
				<!-- #### Download Results Styles ##### -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Styles (Results table)",'wsm-downloader'); ?></b></th> 
                    <td></td>	  
	            </tr>
	
	
	
	            <tr>
                    <th><b><?php echo __("Title Style : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_result_title_font_color" name = "wsmds_admin_options[shortcode][result][title][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['title']['color'] ? esc_attr($wsmds_admin_options['shortcode']['result']['title']['color']) : "#000000"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#000000" />
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][title][size]" id="wsmds_result_title_font_size" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['title']['size'] ? esc_attr($wsmds_admin_options['shortcode']['result']['title']['size']) : '15'; ?>"  />&nbsp;<b>px</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Font Size (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][title][mobile][size]" id="wsmds_result_title_font_size_mobile" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['title']['mobile']['size'] ? esc_attr($wsmds_admin_options['shortcode']['result']['title']['mobile']['size']) : '15'; ?>"  />&nbsp;<b>px</b>					
                     </div>

                    </div>					 
					</td>	  
	            </tr>	

	            <tr>
                    <th><b><?php echo __("Thumbnail style : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					<b><?php echo __("width : ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][thumnail][width]" id="wsmds_result_thumnail_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['width'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['width']) : '250'; ?>"  />&nbsp;<b>px</b>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("width (Mobile) : ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][thumnail][mobile][width]" id="wsmds_result_thumnail_width_mobile" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['width'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['width']) : '250'; ?>"  />&nbsp;<b>px</b>					
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Height : ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][thumnail][height]" id="wsmds_result_thumnail_height" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['height'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['height']) : '250'; ?>"  />&nbsp;<b>px</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Height (Mobile) : ",'wsm-downloader'); ?></b>&nbsp;
	                <input name="wsmds_admin_options[shortcode][result][thumnail][mobile][height]" id="wsmds_result_thumnail_height_mobile" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['height'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['height']) : '250'; ?>"  />&nbsp;<b>px</b>					
                    </div>

					<div class="wsmd_option_holder">
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][result][thumnail][border-width]" id="wsmds_result_thumnail_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][result][thumnail][border-color]" id = "wsmds_result_thumnail_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
	                </div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_result_thumnail_border_style" name="wsmds_admin_options[shortcode][result][thumnail][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['result']['thumnail']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                </div>

                    <div class="wsmd_option_holder">					
						<b><?php echo __("Border Radius : ",'wsm-downloader'); ?></b>&nbsp;	
	                    <input name="wsmds_admin_options[shortcode][result][thumnail][border-radius]" id="wsmds_result_thumnail_border_radius" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-radius'] ? esc_attr($wsmds_admin_options['shortcode']['result']['thumnail']['border-radius']) : '0'; ?>"  />&nbsp;<b>px</b>					
					</div>					

                    </div>					
					</td>	  
	            </tr>
	
				
	            <tr>
                    <th><b><?php echo __("Size & Colors (Table Header) : ",'wsm-downloader'); ?></b></th> 
                    <td>

					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					<b><?php echo __("font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_head_fonts_color" name = "wsmds_admin_options[shortcode][table][header][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['color']) : "#000000"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#000000" />
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_head_background_color" name = "wsmds_admin_options[shortcode][table][header][bgcolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['bgcolor'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['bgcolor']) : "#ffffff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />	
                    </div>

					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_head_fonts_size" name="wsmds_admin_options[shortcode][table][header][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Font Size (Mobile) : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_head_fonts_size_mobile" name="wsmds_admin_options[shortcode][table][header][mobile][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['mobile']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['mobile']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>					
                     </div>						
					
                     </div>					
					</td>	  
	            </tr>


	            <tr>
                    <th><b><?php echo __("Border (Table Header) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					
					<div style="display: grid;">
					
					<div class="wsmd_option_holder">					
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][header][border-width]" id="wsmds_table_head_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

					<div class="wsmd_option_holder">
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][header][border-color]" id = "wsmds_table_head_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['header']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['header']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
	                </div>

					<div class="wsmd_option_holder">
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_table_head_border_style" name="wsmds_admin_options[shortcode][table][header][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['table']['header']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                </div>


						
					</div>	
					</td>	  
	            </tr>					
								
	

	            <tr>
                    <th><b><?php echo __("Size & Colors (Table body) : ",'wsm-downloader'); ?></b></th> 
                    <td>

					<div style="display: grid;">					
					
					<div class="wsmd_option_holder">
					<b><?php echo __("font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_body_fonts_color" name = "wsmds_admin_options[shortcode][table][body][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['color']) : "#ffffff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_body_background_color" name = "wsmds_admin_options[shortcode][table][body][bgcolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['bgcolor'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['bgcolor']) : "#3f00ff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#3f00ff" />	
                    </div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_body_fonts_size" name="wsmds_admin_options[shortcode][table][body][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Font Size (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_body_fonts_size_mobile" name="wsmds_admin_options[shortcode][table][body][mobile][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['mobile']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['mobile']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>						
                     </div>						
					
					
					</div>
					
					</td>	  
	            </tr>


	            <tr>
                    <th><b><?php echo __("Border (Table body) : ",'wsm-downloader'); ?></b></th> 
                    <td>
					
					<div style="display: grid;">					
					
					<div class="wsmd_option_holder">					
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][body][border-width]" id="wsmds_table_body_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

					<div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][body][border-color]" id = "wsmds_table_body_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['body']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['body']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
	                </div>

					<div class="wsmd_option_holder">					
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_table_body_border_style" name="wsmds_admin_options[shortcode][table][body][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['table']['body']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                 </div>



                    </div>					
					</td>	  
	            </tr>	



	            <tr>
                    <th><b><?php echo __("Download links (Table body) : ",'wsm-downloader'); ?></b></th> 
                    <td>

					<div style="display: grid;">					
					
					<div class="wsmd_option_holder">
					<b><?php echo __("font Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_button_fonts_color" name = "wsmds_admin_options[shortcode][table][button][color]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['color']) : "#ffffff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#ffffff" />
					</div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Background Color : ",'wsm-downloader'); ?></b>&nbsp;
					<input id = "wsmds_table_button_background_color" name = "wsmds_admin_options[shortcode][table][button][bgcolor]" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['bgcolor'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['bgcolor']) : "#3f00ff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#3f00ff" />	
                    </div>
					
					<div class="wsmd_option_holder">
					<b><?php echo __("Font Size : ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_button_fonts_size" name="wsmds_admin_options[shortcode][table][button][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b><?php echo __("Font Size (Mobile): ",'wsm-downloader'); ?></b>&nbsp;
	                <input id="wsmds_table_button_fonts_size_mobile" name="wsmds_admin_options[shortcode][table][button][mobile][fsize]"  class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['mobile']['fsize'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['mobile']['fsize']) : '15'; ?>"  />&nbsp;<b>px</b>	
                     </div>						
					
					<div class="wsmd_option_holder">					
					    <b><?php echo __("Border Width : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][button][border-width]" id="wsmds_table_button_border_width" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['border-width'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['border-width']) : '0'; ?>"  />&nbsp;<b>px</b>
					</div>

					<div class="wsmd_option_holder">					
						<b><?php echo __("Border Color : ",'wsm-downloader'); ?></b>&nbsp;
	                    <input name="wsmds_admin_options[shortcode][table][button][border-color]" id = "wsmds_table_button_border_color" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['border-color'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['border-color']) : "#effeff"; ?>" class="wsmd-color-field color-picker" data-alpha="true" data-default-color="#effeff" />
	                </div>

					<div class="wsmd_option_holder">					
						<b><?php echo __("Border Style : ",'wsm-downloader'); ?></b>&nbsp;
	                   <select id="wsmds_table_button_border_style" name="wsmds_admin_options[shortcode][table][button][border-style]">
	                       <option value="solid" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "solid"); ?>>solid</option>		                       
		                   <option value="dashed" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "dashed"); ?>>dashed</option>
	                       <option value="dotted" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "dotted"); ?>>dotted</option>
	                       <option value="double" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "double"); ?>>double</option>
	                       <option value="groove" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "groove"); ?>>groove</option>
	                       <option value="hidden" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "hidden"); ?>>hidden</option>
	                       <option value="ridge" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "ridge"); ?>>ridge</option>
	                       <option value="outset" <?php selected($wsmds_admin_options['shortcode']['table']['button']['border-style'], "outset"); ?>>outset</option> 
	                   </select>
	                 </div>

					<div class="wsmd_option_holder">					 
						<b><?php echo __("Border Radius : ",'wsm-downloader'); ?></b>&nbsp;	
	                    <input name="wsmds_admin_options[shortcode][table][button][border-radius]" id="wsmds_table_button_border_radius" class="wsmds_spinner-width" type="text" value="<?php echo $wsmds_admin_options['shortcode']['table']['button']['border-radius'] ? esc_attr($wsmds_admin_options['shortcode']['table']['button']['border-radius']) : '0'; ?>"  />&nbsp;<b>px</b>
                    </div>

					
					</div>
					
					</td>	  
	            </tr>				
				<!-- #### End Download Results Styles ##### -->

				
			  </table>
			 
			  
			  
			  </div>
			  
			
			  <table class="form-table">
				<!-- #### Download Custom Styles ##### -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Custom Styles",'wsm-downloader'); ?></b></th> 
                    <td></td>	  
	            </tr>



	            <tr>
                    <th ><b><?php echo __("CSS Code Editor",'wsm-downloader'); ?></b></th> 
                    <td>
					 <div style="text-align : left;">
                        <textarea class="wsmd_input" id="wsmd_custom_styles" name="wsmds_admin_options[shortcode][custom_style]"><?php echo esc_attr($wsmds_admin_options['shortcode']['custom_style']); ?></textarea><br>
	                 </div>
					</td>	  
	            </tr>				
				<!-- #### End Custom Styles ##### -->
			  
			  </table>	
	
	
	
            </div>
		    <!-- ###################################################################### end styles -->	
			
			
			
	        <!-- ###################################################################### Settings Part -->
            <div id="setting" class="wsmds_tabcontent">	
	          <table class="form-table">
			  
	
			    <!-- active downloaders -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Downloaders",'wsm-downloader'); ?></b><span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("Your Site visitors are only allowed to download medias from websites that are activated in this section.Choose which downloader should be enabled.",'wsm-downloader'); ?>"></span><?php echo '&nbsp;&nbsp;'.$upgrade;?></th> 
                    <td></td>	  
	            </tr>

	            <tr>
                    <th ><b><?php echo __("Active / Deactive Downloaders : ",'wsm-downloader'); ?></b>
					</th> 
                    <td style="display: inline-block;text-align: center;">
					
					<?php foreach($activedownloaders as $downloader){
                    $disabled = '';
					$dis_styles = '';
                    if($downloader != 'facebook' and $downloader != 'instagram' and $downloader != 'bandcamp'){
						$disabled = 'disabled';
						$dis_styles = 'style="opacity: 0.4;"';

					}
					?>
					
					<div class="wsmd_active_downloader">
					<input type="checkbox" name="wsmds_admin_options[downloader][<?php echo $downloader;?>]" id="wsmd_active_downloader" <?php echo isset($wsmds_admin_options['downloader'][$downloader]) ? 'checked="checked"' : '';?> <?php echo $disabled;?>/><b class="wsmd_downloader_name" <?php echo $dis_styles;?>><img class="wsmd_downloader_images" width="16" height="16" src="<?php echo WSMD_PLUGIN_URL.'/assets/img/'.$downloader.'.png';?>" /><?php echo $downloader;?></b>
					</div>
				    
					<?php } ?>
					
					</td>	  
	            </tr>
                <!-- end downloaders -->				

	
			     <!-- proxy -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Proxy Settings",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("Sites like YouTube sometimes restrict access to certain videos to a specific country. By setting up a proxy, you can bypass this restriction.When the user tries to download a file , WSMD first downloads the file without proxy then starts downloading using proxy if it fails.",'wsm-downloader'); ?>"></span><?php echo '&nbsp;&nbsp;'.$upgrade;?>
					</th> 
                    <td></td>	  
	            </tr>	


	            <tr>
                    <th ><b><?php echo __("Use Proxy?",'wsm-downloader'); ?></b></th> 
                    <td><input disabled type="checkbox" name="" id="use_proxy"  /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>
				
	            <tr>
                    <th ><b><?php echo __("Proxy Configuration : ",'wsm-downloader'); ?></b></th> 
                    <td>
					<div style="display:inline-block">
					<div class="wsmd_active_downloader">
					<?php echo __("Proxy IP : ",'wsm-downloader'); ?>
					<input disabled name=""  type="text" placeholder="123.456.7.89"  /></div>
					<div class="wsmd_active_downloader">
					&nbsp;&nbsp;
					<?php echo __("Proxy Port : ",'wsm-downloader'); ?>
					<input disabled name="" style="width: 50px;" placeholder="8080" type="text"  /></div>
					
					<div class="wsmd_active_downloader">
					&nbsp;&nbsp;
					<?php echo __("Proxy Type : ",'wsm-downloader'); ?>
	                <select disabled id="wsmds_proxy_type" name="">
                           <option value="CURLPROXY_HTTP" >HTTP</option>	   
                           <option value="CURLPROXY_HTTPS" >HTTPS</option>
                           <option value="CURLPROXY_SOCKS4" >SOCKS4</option>
                           <option value="CURLPROXY_SOCKS5" >SOCKS5</option>	 						   
                    </select>
					</div>
					
					<div class="wsmd_active_downloader">
					&nbsp;&nbsp;
					<?php echo __("Proxy Authentication : ",'wsm-downloader'); ?>
					<input disabled name=""  type="text" placeholder="USER:PASSWORD" value="" />
					</div>
                    </div>					
					</td>	  
	            </tr>			
                 <!-- End proxy -->				

				
				
				
				 <!-- multiple ips -->
	            <tr class="wsmd_th_header">
                    <th ><b><?php echo __("Multiple IPs",'wsm-downloader'); ?></b>
					<span class="dashicons dashicons-editor-help wsmd_help" data-tooltip-text="<?php echo __("You can enable this option if you are having problems with Dailymotion,Youtube,... IP limit / IP ban. This option will work only if the IP you add are available for the server.That means you have to buy some additionnal public IPs and assign these new static IPs to the server.This should work only if you have a dedicated server...Be very careful, you may block yourself",'wsm-downloader'); ?>"></span><?php echo '&nbsp;&nbsp;'.$upgrade;?>		
					</th> 
                    <td></td>	  
	            </tr>				

	            <tr>
                    <th ><b><?php echo __("Use Multiple IPs?",'wsm-downloader'); ?></b></th> 
                    <td><input disabled type="checkbox" name="" id="use_mlpip" /><?php echo __("Yes",'wsm-downloader');?></td>	  
	            </tr>	

	            <tr>
                    <th ><b><?php echo __("IPs List:",'wsm-downloader'); ?></b></th> 
                    <td><textarea disabled rows="5" cols="45" placeholder="111.125.11.70&#10;123.456.78.90" name=""></textarea><br>
					<?php echo __("Enter your IPs in this field, each on a separate line.",'wsm-downloader'); ?>
					</td>	  
	            </tr>				
			    <!-- end multiple ips -->

			  
			  

			  
			  </table>
			<?php submit_button(); ?> 
            </div>	
	        <!-- ###################################################################### End Settings Part -->



		
	
	</form>	
<!-- ######################## End Setting Form -->	





	
</div>
<!-- ## End Setting Page -->
	
<?php

}