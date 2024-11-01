///////////////////////////////////////////////////////////////////////////Downloader functions
jQuery(document).ready(function($){

var is_modal = wsmd_user.modal;
var animate_ph = wsmd_user.animph;
var taskstart = 0;
var shortcode_link = window.location.href;
if(animate_ph == "true"){
	wsmd_play_placeholder_texts();
}

if(is_modal == "true"){
var modal = $('#wsmd_downloader_modal');

$('body').on('click', '#wsmd_downloader_form_button', function (event) {
	
	if($("#wsmd_downloader_form_input").val().length == 0 || !wsmd_isURL($("#wsmd_downloader_form_input").val())){
		var errorface = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>';
		$(".wsmd_error_holder").html(errorface+'<br>'+wsmd_user.urlvalid);
		$(".wsmd_error_holder").show();
		return;
	}
		$(".wsmd_error_holder").hide();
	modal.show();

    if(taskstart == 0){
	   $('#wsmd_loading').show();
       taskstart = 1;
	   var link = $("#wsmd_downloader_form_input").val();
	   $('.wsmd_downloader_result_holder').html('');
	   $(".wsmd_error_holder").html('');
                         jQuery.ajax({
                                type: "POST"
                                , url: wsmd_user.wpajax
                                , data: { 'action': 'wsmd_user_download_request', 'link': link , 'requestlink' : shortcode_link }
                                , success: function(textStatus) {
								modal.show();
								taskstart = 0;
								$('#wsmd_loading').hide();	
                                $('.wsmd_downloader_result_holder').html(textStatus);
								jQuery('body .wsmd_tablinks:first-child').attr("id" , "wsmd_defaultopen");
								if(jQuery("body #wsmd_defaultopen").length){
								document.getElementById("wsmd_defaultopen").click();
								}
                                }
                                , error: function(MLHttpRequest, textStatus, errorThrown) {
                                        alert(errorThrown);
                                }
                          });
	}	
});


$('body').on('click' , '.wsmd_close_modal', function (event) {
	modal.hide();	
});


$('body').on('click', '.wsmd_downloader_modal', function (event) {
	if(event.target == document.getElementById("wsmd_downloader_modal")){
	modal.hide();	
	}
});

}else{

$('body').on('click', '#wsmd_downloader_form_button', function (event) {
	
	if($("#wsmd_downloader_form_input").val().length == 0  || !wsmd_isURL($("#wsmd_downloader_form_input").val())){
		var errorface = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg>';
		$(".wsmd_error_holder").html(errorface+'<br>'+wsmd_user.urlvalid);
		$(".wsmd_error_holder").show();
		return;
	}

	$(".wsmd_error_holder").hide();

       $(".wsmd_downloader_no_modal_content").show();	
	   var link = $("#wsmd_downloader_form_input").val();
	   $('#wsmd_loading').show();
	   $('.wsmd_downloader_result_holder').html('');
	   $(".wsmd_error_holder").html('');
                         jQuery.ajax({
                                type: "POST"
                                , url: wsmd_user.wpajax
                                , data: { 'action': 'wsmd_user_download_request', 'link': link , 'requestlink' : shortcode_link}
                                , success: function(textStatus) {
								$('#wsmd_loading').hide();	
                                $('.wsmd_downloader_result_holder').html(textStatus);
								jQuery('body .wsmd_tablinks:first-child').attr("id" , "wsmd_defaultopen");
								if(jQuery("body #wsmd_defaultopen").length){
								document.getElementById("wsmd_defaultopen").click();
								}
                                }
                                , error: function(MLHttpRequest, textStatus, errorThrown) {
                                        alert(errorThrown);
                                }
                          });
	
	
});	
}



if(wsmd_user.onpaste == "true"){

$('body').bind("paste", '#wsmd_downloader_form_input',function(e){
	setTimeout(function(e) {
    $("#wsmd_downloader_form_button").click();
	}, 200);	
});

}

$('#wsmd_downloader_form_input').on("keypress",function(e){
	if(e.key == "Enter"){
	$("#wsmd_downloader_form_button").click();
	}
});



if(wsmd_user.sharable == "true"){
var path = window.location.href;
if(wsmd_getFragment(path) !== ''){
$("#wsmd_downloader_form_input").val(wsmd_getFragment(path).replace("#" , ""));
$("#wsmd_downloader_form_button").click();	
}
}


if($('.wsmd_downloader_no_modal_content').length !== 0){
if($('.wsmd_downloader_no_modal_content').width() < 782){
$('.wsmd_downloader_result_holder').css("display" , "inherit");	
}
}




$('body').on('click', '.wsmd_download_button', function (event) {
$(this).find("form").submit();
var loading = '<div style="display:block;" id="wsmd_Sk_downloading"><div class="wsmd_sk-chase"><div class="wsmd_sk-chase-dot"></div><div class="wsmd_sk-chase-dot"></div><div class="wsmd_sk-chase-dot"></div><div class="wsmd_sk-chase-dot"></div><div class="wsmd_sk-chase-dot"></div><div class="wsmd_sk-chase-dot"></div></div></div>';
$(this).parent().append(loading);
$(this).hide();
var $_this = $(this);

setTimeout(function(){ 
$('body #wsmd_Sk_downloading').remove();
$_this.show();	
 }, 2500);

});	


	
});







function wsmd_play_placeholder_texts(){
	var active_downloaders = JSON.parse(wsmd_user.availabe);
	var iii = 0;
    window.animatedplaceholder = setInterval(function(){
	
    if(active_downloaders.length > iii){
        jQuery("#wsmd_downloader_form_input").attr("placeholder" , active_downloaders[iii]);
	    iii++;	
	}else{
		iii = 0;
        jQuery("#wsmd_downloader_form_input").attr("placeholder" , active_downloaders[iii]);
	    iii++;		
	}
	
	} , 1000);

}


function wsmd_open_tab(evt, TabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("wsmd_tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("wsmd_tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(TabName).style.display = "block";
  if(evt !== undefined)
  {
  evt.currentTarget.className += " active";
  }
}

function wsmd_isURL(url) {
  var URL_REGEXP = /^(?:https?:)?\/\/\S+$/i;	
  return URL_REGEXP.test(url);
}

function wsmd_getFragment(url) {
  //var matches = /^\S+?(#[^\s\?]*)/.exec(url);
  if(url.indexOf('wsmd_share=') > 0){
	  console.log(url.indexOf('wsmd_share='));
  var matches = url.substring(url.indexOf('wsmd_share=') + 11);
  }
  if (matches) {
    return matches;
  }else{
	return '';  
  }
}