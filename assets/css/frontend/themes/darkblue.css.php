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
    width: 100%;
    max-width: 760px;
    text-align: center;
	margin: auto !important;
    display : inherit;
}

#wsmd_downloader_form_input{
    color: #ffffff;
    background : #272c33;
    font-size : 15px;
    width : 80%;	
    height : 60px;
    border : 1px solid #003f77; 
    border-radius : 5px;
}

#wsmd_downloader_form_input:focus{
    color: #ffffff;
    background : #272c33;
    font-size : 15px;
    width : 80%;	
    height : 60px;
    border : 1px solid #003f77; 
    border-radius : 5px;
	outline : unset;
}

#wsmd_downloader_form_input::placeholder { /* Firefox, Chrome, Opera */ 
    color: #747d8a; 
} 
  
#wsmd_downloader_form_input:-ms-input-placeholder { /* Internet Explorer 10-11 */ 
    color: #747d8a; 
} 
  
#wsmd_downloader_form_input::-ms-input-placeholder { /* Microsoft Edge */ 
    color: #747d8a;  
} 





#wsmd_downloader_form_button{
    color: #ffffff;
    background : #003f77;
    font-size : 15px;
    width : 20%;	
    height : 60px;
    border : 1px dotted #003f77; 
    border-radius : 5px;
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
    background-color: #272c33;
    color: #ffffff;
    border : 0px solid #0a0a0a; 
    border-radius : 4px;  
    margin: 70px auto;
    width: 60%;
    -webkit-animation-name: fadeInUp;
    -webkit-animation-duration: 0.6s;
    animation-name: fadeInUp;
    animation-duration: 0.6s;  	
}


/* Style the tab */
.wsmd_tab {
    display: flex;
    overflow: hidden;	
}

/* Style the buttons inside the tab */
.wsmd_tab button {
  color : #747d8a;	
  background : #272c33;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
  border-radius : unset;
}

/* Change background color of buttons on hover */
.wsmd_tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.wsmd_tab button.active {
    color : #dee2e6;	
    background : #003f77; 
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
    min-width : 380px;	
    min-height : 270px;		
}

img#wsmd_preview_img {
    border : 1px dotted #003f77; 
    border-radius : 5px;  
    width : 360px;	
    height : 250px;	
}

b.wsmd_title_preview {
    color: #ffffff;
    font-size : 15px;	
    display: block;
    margin-bottom: 20px;	
}

table.wsmd_result_table {
    margin: unset;
border-width: 0px 0 0 0px;
}


table.wsmd_result_table th {
    color : #dee2e6;	
    background : #003f77;
	font-size : 15px;
    border : 3px solid #003f77 !important; 
	border-top: unset;
}

table.wsmd_result_table td {
    color : #747d8a;	
    background : #272c33;
	font-size : 17px;
    border : 1px dotted #747d8a !important; 
	
}

button.wsmd_download_button {
    color: #ffffff;
    background : #272c33;
    font-size : 12px;
    border : 2px solid #003f77; 
    border-radius: 5px;
    outline: unset;
    padding: 6px;
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
    width: 100%;
}

#wsmd_downloader_form_input{
    font-size : 15px;
    width : 75%;	
    height : 50px;
}
#wsmd_downloader_form_input:focus{
    font-size : 15px;
    width : 75%;	
    height : 50px;
}	

#wsmd_downloader_form_button{
    font-size : 12px;
    width : 30%;	
    height : 50px;
	padding : 10px; 
}

img#wsmd_preview_img {
    width : 150px;	
    height : 150px;	
}

b.wsmd_title_preview {
    font-size : 10px;	
}

table.wsmd_result_table th {
	font-size : 11px;
}

table.wsmd_result_table td {
	font-size : 14px;
}

button.wsmd_download_button {
    font-size : 10px;
}

.wsmd_preview_holder {
    min-width : 170px;	
    min-height : 170px;		
}

.wsmd_downloader_modal_content {
  width: 95%;
  margin: 30% auto;
}

button.wsmd_tablinks {
    font-size: 10px;
	    line-height: 20px;
}

}	
</style>