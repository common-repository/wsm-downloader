<?php 
//header("Content-type:text/css");
/**
 * Stylesheet for wsm downloader
 *
 * @version 2017-12-12
 */
?>

<style type="text/css">
.wsmd_downloader_form_holder {
    width: <?php echo $wsmds_admin_options['shortcode']['form']['desktop']['width'];?>px;
    text-align: center;
	margin: auto !important;
	display : inherit;
}

#wsmd_downloader_form_input{
    color: <?php echo $wsmds_admin_options['shortcode']['form']['field']['color'];?>;
    background : <?php echo $wsmds_admin_options['shortcode']['form']['field']['bgcolor'];?>;
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['field']['size'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['field']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['field']['height'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-radius'];?>px;
}

#wsmd_downloader_form_input:focus{
    color: <?php echo $wsmds_admin_options['shortcode']['form']['field']['color'];?>;
    background : <?php echo $wsmds_admin_options['shortcode']['form']['field']['bgcolor'];?>;
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['field']['size'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['field']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['field']['height'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['form']['field']['border-radius'];?>px;
	outline : unset;
}

#wsmd_downloader_form_input::placeholder { /* Firefox, Chrome, Opera */ 
    color: <?php echo $wsmds_admin_options['shortcode']['form']['field']['pholdercolor'];?>; 
} 
  
#wsmd_downloader_form_input:-ms-input-placeholder { /* Internet Explorer 10-11 */ 
    color: <?php echo $wsmds_admin_options['shortcode']['form']['field']['pholdercolor'];?>; 
} 
  
#wsmd_downloader_form_input::-ms-input-placeholder { /* Microsoft Edge */ 
    color: <?php echo $wsmds_admin_options['shortcode']['form']['field']['pholdercolor'];?>;  
} 





#wsmd_downloader_form_button{
    color: <?php echo $wsmds_admin_options['shortcode']['form']['button']['color'];?>;
    background : <?php echo $wsmds_admin_options['shortcode']['form']['button']['bgcolor'];?>;
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['button']['fsize'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['button']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['button']['height'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['form']['button']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['form']['button']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['form']['button']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['form']['button']['border-radius'];?>px;
    margin-left : -5px;	
	outline : unset;	
	
}

.wsmd_downloader_modal {
  display: none; 
  position: fixed; 
  z-index: 999; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4);
}

.wsmd_downloader_modal_content {
    background-color: <?php echo $wsmds_admin_options['shortcode']['modal']['background'];?>;
    color: <?php echo $wsmds_admin_options['shortcode']['modal']['fontcolor'];?>;
    border : <?php echo $wsmds_admin_options['shortcode']['modal']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['modal']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['modal']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['modal']['border-radius'];?>px;  
    margin: 70px auto;
    width: 60%;
    -webkit-animation-name: <?php echo $wsmds_admin_options['shortcode']['modal']['animation']; ?>;
    -webkit-animation-duration: 0.6s;
    animation-name: <?php echo $wsmds_admin_options['shortcode']['modal']['animation']; ?>;
    animation-duration: 0.6s;  	
}


/* Style the tab */
.wsmd_tab {
    display: flex;
    overflow: hidden;	
}

/* Style the buttons inside the tab */
.wsmd_tab button {
  color : <?php echo $wsmds_admin_options['shortcode']['table']['body']['color'];?>;	
  background : <?php echo $wsmds_admin_options['shortcode']['table']['body']['bgcolor'];?>;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: <?php echo $wsmds_admin_options['shortcode']['table']['header']['fsize'];?>px;
  border-radius : unset;
}

/* Change background color of buttons on hover */
.wsmd_tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.wsmd_tab button.active {
    color : <?php echo $wsmds_admin_options['shortcode']['table']['header']['color'];?>;	
    background : <?php echo $wsmds_admin_options['shortcode']['table']['header']['bgcolor'];?>;
     border-left : <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-color'];?>; 
    border-right : <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-color'];?>; 	 
}

/* Style the tab content */
.wsmd_tabcontent {

  display: none;
}


.wsmd_downloader_result_holder {
    display: flex;
}

.wsmd_preview_holder {
    padding: 20px;
    min-width : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['width'] + 20;?>px;	
    min-height : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['height'] + 20;?>px;		
}

img#wsmd_preview_img {
    border : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['border-radius'];?>px;  
    width : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['width'];?>px;	
    height : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['height'];?>px;	
}

b.wsmd_title_preview {
    color: <?php echo $wsmds_admin_options['shortcode']['result']['title']['color'];?>;
    font-size : <?php echo $wsmds_admin_options['shortcode']['result']['title']['size'];?>px;	
    display: block;
    margin-bottom: 20px;	
}

table.wsmd_result_table {
    margin: unset;
	border-width: 0px 0 0 0px;
}


table.wsmd_result_table th {
    color : <?php echo $wsmds_admin_options['shortcode']['table']['header']['color'];?>;	
    background : <?php echo $wsmds_admin_options['shortcode']['table']['header']['bgcolor'];?>;
	font-size : <?php echo $wsmds_admin_options['shortcode']['table']['header']['fsize'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['table']['header']['border-color'];?> !important;  
	
	border-top: unset;
}

table.wsmd_result_table td {
    color : <?php echo $wsmds_admin_options['shortcode']['table']['body']['color'];?>;	
    background : <?php echo $wsmds_admin_options['shortcode']['table']['body']['bgcolor'];?>;
	font-size : <?php echo $wsmds_admin_options['shortcode']['table']['body']['fsize'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['table']['body']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['table']['body']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['table']['body']['border-color'];?> !important;  
	
}

button.wsmd_download_button {
    color: <?php echo $wsmds_admin_options['shortcode']['table']['button']['color'];?>;
    background : <?php echo $wsmds_admin_options['shortcode']['table']['button']['bgcolor'];?>;
    font-size : <?php echo $wsmds_admin_options['shortcode']['table']['button']['fsize'];?>px;
    border : <?php echo $wsmds_admin_options['shortcode']['table']['button']['border-width'];?>px <?php echo $wsmds_admin_options['shortcode']['table']['button']['border-style'];?> <?php echo $wsmds_admin_options['shortcode']['table']['button']['border-color'];?>; 
    border-radius : <?php echo $wsmds_admin_options['shortcode']['table']['button']['border-radius'];?>px;
	outline : unset;	
    padding : <?php echo $wsmds_admin_options['shortcode']['table']['button']['fsize'];?>px;	
}

.wsmd_result_table_holder {
    padding: 20px;
}



@media screen and (max-width: 1500px){
.wsmd_downloader_modal_content {
  width: 70%;
}
}	


@media screen and (max-width: 1200px){
.wsmd_downloader_modal_content {
  width: 80%;
}

.wsmd_downloader_result_holder {
    display: grid;
}
}	



@media screen and (max-width: 782px){
.wsmd_downloader_form_holder {
    width: <?php echo $wsmds_admin_options['shortcode']['form']['mobile']['width'];?>%;
}

#wsmd_downloader_form_input{
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['size'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['height'];?>px;
}
#wsmd_downloader_form_input:focus{
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['size'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['field']['mobile']['height'];?>px;
}	

#wsmd_downloader_form_button{
    font-size : <?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['fsize'];?>px;
    width : <?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['width'];?>%;	
    height : <?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['height'];?>px;
	padding : <?php echo $wsmds_admin_options['shortcode']['form']['button']['mobile']['fsize'];?>px; 
}

img#wsmd_preview_img {
    width : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['width'];?>px;	
    height : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['height'];?>px;	
}

b.wsmd_title_preview {
    font-size : <?php echo $wsmds_admin_options['shortcode']['result']['title']['mobile']['size'];?>px;	
}

table.wsmd_result_table th {
	font-size : <?php echo $wsmds_admin_options['shortcode']['table']['header']['mobile']['fsize'];?>px;
}

table.wsmd_result_table td {
	font-size : <?php echo $wsmds_admin_options['shortcode']['table']['body']['mobile']['fsize'];?>px;
}

button.wsmd_download_button {
    font-size : <?php echo $wsmds_admin_options['shortcode']['table']['button']['mobile']['fsize'];?>px;
}

.wsmd_preview_holder {
    min-width : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['width'] + 20;?>px;	
    min-height : <?php echo $wsmds_admin_options['shortcode']['result']['thumnail']['mobile']['height'] + 20;?>px;		
}

button.wsmd_tablinks {
    font-size: <?php echo $wsmds_admin_options['shortcode']['table']['header']['mobile']['fsize'];?>px;
	    line-height: 20px;
}

.wsmd_downloader_modal_content {
  width: 95%;
  margin: 30% auto;
}



}	
</style>

	
