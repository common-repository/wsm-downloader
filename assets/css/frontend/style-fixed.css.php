<?php 
//header("Content-type:text/css");
/**
 * Stylesheet for wsm downloader
 *
 * @version 2017-12-12
 */
?>

<style type="text/css">
/* share button */
ul.wsmd_share_bottons_holder_inner {
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    list-style: none;
    width: 100%;
    margin: unset;
    padding: initial;
}


li.wsmd_share_button {
    margin-left: 5px;
    margin-right: 5px;
}

	

.wsmd_downloader_modal {
    z-index: 9999999999;
}

table.wsmd_result_table {
	    border-spacing: inherit;
    width: 100%;
}

.wsmd_result_table_holder{
    width: 100%;
}

.wsmd_downloader_result_holder {
    display: inline-flex  !important;
	    width: 100%;
}


#wsmd_downloader_form_button{
z-index: 99999;
}

.wsmd_downloader_modal_content {
margin: 10% auto;
min-height : 250px;
}

.wsmd_downloader_modal_body {
    position: relative;
}


.wsmd_loading_holder {
    position: relative;
    left: 0;
    top: 0;
    width: 100%;
    text-align: center;
}

.wsmd_loading_nomodal_holder{
	position: relative;
    width: 100%;
    text-align: center;	
	display:none;
}

img#wsmd_loading_img {
    margin: 7% auto;
    margin-bottom: 10px;
}

div#wsmd_loading h3 {
    font-weight: 600;
    font-size: 20px;
}
.wsmd_close_modal {
    position: relative;
    right: 0;
    top: 0;
    width: 100%;
    cursor: pointer;
    z-index: 99;
    text-align: right;
}

.wsmd_close_modal svg {
    fill: #8e8e8e;
    width: unset;
    height: unset;	
}


.wsmd_tab button {
display: inline-flex;
line-height: 30px;
}


table.wsmd_result_table td {
    font-size: 12px !important;
    padding: 5px;
    vertical-align: middle;
	text-align: center;
}

table.wsmd_result_table th {
    font-size: 13px;
	    padding: 5px;
    text-align: center;
    font-weight: 600;
}

.wsmd_downloader_modal::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE and Edge */
.wsmd_downloader_modal {
  -ms-overflow-style: none;
}


    

.wsmd_sorry_face svg {
    width: unset;
    height: unset;
    fill: #464646a3;
}

.wsmd_sorry_output {
    width: 100%;
}

.wsmd_sorry_text {
    font-size: 20px;
    margin-top: 10px;
    color: #737171;
}

ul.wsmd_share_bottons_holder_inner svg {
    width: unset;
    height: unset;
}

.wsmd_downloader_no_modal_content {
    border: 1px solid #d6d4d445;
    border-radius: 5px;
	display:none;
	    padding-bottom: 5%;
}


button.wsmd_download_button {
    cursor: pointer !important;
		padding : 5px;
}

button#wsmd_downloader_form_button {
    cursor: pointer !important;
	padding : 5px;
	margin : unset !important;
		height:auto;
}


.wsmd_downloader_modal_content .wsmd_downloader_result_holder {
    max-width: 90% !important;
}

.wsmd_sk-chase {
  margin: auto;
  width: 25px;
  height: 25px;
  position: relative;
  animation: wsmd_sk-chase 2.5s infinite linear both;
}

.wsmd_sk-chase-dot {
  width: 100%;
  height: 100%;
  position: absolute;
  left: 0;
  top: 0; 
  animation: wsmd_sk-chase-dot 2.0s infinite ease-in-out both; 
}

.wsmd_sk-chase-dot:before {
  content: '';
  display: block;
  width: 25%;
  height: 25%;
  background-color: #fff;
  border-radius: 100%;
  animation: wsmd_sk-chase-dot-before 2.0s infinite ease-in-out both; 
}

.wsmd_sk-chase-dot:nth-child(1) { animation-delay: -1.1s; }
.wsmd_sk-chase-dot:nth-child(2) { animation-delay: -1.0s; }
.wsmd_sk-chase-dot:nth-child(3) { animation-delay: -0.9s; }
.wsmd_sk-chase-dot:nth-child(4) { animation-delay: -0.8s; }
.wsmd_sk-chase-dot:nth-child(5) { animation-delay: -0.7s; }
.wsmd_sk-chase-dot:nth-child(6) { animation-delay: -0.6s; }
.wsmd_sk-chase-dot:nth-child(1):before { animation-delay: -1.1s; }
.wsmd_sk-chase-dot:nth-child(2):before { animation-delay: -1.0s; }
.wsmd_sk-chase-dot:nth-child(3):before { animation-delay: -0.9s; }
.wsmd_sk-chase-dot:nth-child(4):before { animation-delay: -0.8s; }
.wsmd_sk-chase-dot:nth-child(5):before { animation-delay: -0.7s; }
.wsmd_sk-chase-dot:nth-child(6):before { animation-delay: -0.6s; }

@keyframes wsmd_sk-chase {
  100% { transform: rotate(360deg); } 
}

@keyframes wsmd_sk-chase-dot {
  80%, 100% { transform: rotate(360deg); } 
}

@keyframes wsmd_sk-chase-dot-before {
  50% {
    transform: scale(0.4); 
  } 100%, 0% {
    transform: scale(1.0); 
  } 
}

.wsmd_error_holder {
    padding: 20px;
    font-weight : 500;
    color: #737171;
    font-size: 20px;
    border : 1px solid #f1f1f1;
    margin : 5px auto;
    border-radius : 5px;
    display : none;
}

.wsmd_error_holder svg {
    fill: #ff7777;
    width: 50px;
    height: 50px;
}


input#wsmd_downloader_form_input{
	padding-left: 10px;
	padding-right: 10px;
	text-align : center;
	margin: unset;
}






<?php
$template = $wsmds_admin_options['shortcode']['template'];

if($template == 'darkblue' or $template == 'lightblue'){
	$fixed_color = '#003f77';
	$fixed_head_color = '#003f77';
	$fixed_dl_button = '#003f77';
	$fixed_dl_button_font = '#ffffff';
    $fixed_tabs_color = '#747d8a';	
}
if($template == 'darkred' or $template == 'lightred'){
	$fixed_color = '#f91540';
	$fixed_head_color = '#f91540';
	$fixed_dl_button = '#f91540';	
	$fixed_dl_button_font = '#ffffff';
    $fixed_tabs_color = '#747d8a';		
}
if($template == 'darkcustom' or $template == 'lightcustom'){
	$fixed_color = $wsmds_admin_options['shortcode']['customcolor'];
	$fixed_head_color = $wsmds_admin_options['shortcode']['customcolor'];
	$fixed_dl_button = $wsmds_admin_options['shortcode']['customcolor'];
	$fixed_tabs_color = '#747d8a';
}
if($template == 'custom'){
	$fixed_color = $wsmds_admin_options['shortcode']['form']['button']['bgcolor'];
	$fixed_head_color = $wsmds_admin_options['shortcode']['table']['header']['bgcolor'];
	$fixed_dl_button = $wsmds_admin_options['shortcode']['table']['button']['bgcolor'];	
	$fixed_tabs_color = $wsmds_admin_options['shortcode']['table']['header']['color'];
	$fixed_modal_background =  'background-color: rgba(0, 0, 0, 0.63);';
}

if(strpos($template , 'dark') !== false){
	$fixed_modal_background =  'background-color: rgba(0, 0, 0, 0.63);';
}

if(strpos($template , 'light') !== false){
	$fixed_modal_background =  'background-color: rgba(0, 0, 0, 0.78);';
}
?>

.wsmd_sk-chase-dot:before {
    background : <?php echo $fixed_dl_button;?> !important;	
}

.wsmd_close_modal svg:hover {
    fill: <?php echo $fixed_dl_button;?> !important;	
}

#wsmd_downloader_form_button:focus , #wsmd_downloader_form_button:hover{
    background : <?php echo $fixed_color;?> !important;	
}	


.wsmd_tab button.active:focus , .wsmd_tab button:focus , .wsmd_tab button:hover , .wsmd_tab button.active:hover  {
    background : <?php echo $fixed_head_color;?> !important;			 	 
}

button.wsmd_download_button:focus , button.wsmd_download_button:hover {
	<?php if(isset($fixed_dl_button_font)){ ?>
	color : <?php echo $fixed_dl_button_font;?> !important;
	<?php } ?>
    background : <?php echo $fixed_dl_button;?> !important;
}


button.wsmd_tablinks svg {
	fill : <?php echo $fixed_tabs_color ;?> !important;
	padding: 2px;
	width: unset;
    height: unset;
}

.wsmd_downloader_modal{
<?php echo $fixed_modal_background; ?>
}

<?php if(is_rtl()){ ?>

#wsmd_downloader_form_input{
    border-bottom-left-radius: unset !important;
    border-top-left-radius: unset !important;
}

#wsmd_downloader_form_input:focus{
    border-bottom-left-radius: unset !important;
    border-top-left-radius: unset !important;
}

#wsmd_downloader_form_button{
    border-bottom-right-radius: unset !important;
    border-top-right-radius: unset !important;		
}




<?php }else{ ?>
	
#wsmd_downloader_form_input{
    border-bottom-right-radius: unset !important;
    border-top-right-radius: unset !important;	
}

#wsmd_downloader_form_input:focus{
    border-bottom-right-radius: unset !important;
    border-top-right-radius: unset !important;	
}
	
#wsmd_downloader_form_button{
    border-bottom-left-radius: unset !important;
    border-top-left-radius: unset !important;
}	

<?php }?>



@media screen and (max-width: 1200px){
.wsmd_downloader_result_holder {
    display: grid !important;
}
}

@media screen and (max-width: 782px){
   
 .wsmd_result_table_holder {  
 padding : unset;
 }
 
.wsmd_downloader_result_holder {
     display: block;
}

table.wsmd_result_table {
    min-width: 320px;
	padding : unset;
}

.wsmd_tab {
    display: flex;
    overflow: auto;
}

.wsmd_tabcontent {
overflow: auto;	
}



	
}


</style>

	
