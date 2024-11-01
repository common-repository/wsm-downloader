

//////////////////////////////////////////////////////////////////////////////////////add new tab to wpmedia class
var l10n = wp.media.view.l10n;
wp.media.view.MediaFrame.Select.prototype.browseRouter = function( routerView ) {
    routerView.set({
        upload: {
            text:     l10n.uploadFilesTitle,
            priority: 20
        },
        browse: {
            text:     l10n.mediaLibraryTitle,
            priority: 40
        },
        wsmd: {
            text:     wsmd_admin.tabname,
            priority: 60
        }
    });
};


jQuery(document).ready(function($){
    if ( wp.media ) {

        wp.media.view.Modal.prototype.on( "open", function() {
            if($('body').find('.media-modal-content .media-router .media-menu-item.active')[0].innerText === wsmd_admin.tabname){
                wsmb_content();
				$('.media-frame-menu .media-menu').append('<div class="wsmb_menu_disable"></div>');
			}else{
				$('.wsmb_menu_disable').remove();
			}
        });	
	
        $(wp.media).on('click', '.media-router .media-menu-item', function(e){
		
            if(e.target.innerText === wsmd_admin.tabname){
				      wsmb_content();
				$('.media-frame-menu .media-menu').append('<div class="wsmb_menu_disable"></div>');
			}else{
				      $('.wsmb_menu_disable').remove();
			}
        });
    }
});


function wsmb_content() {
	
	var preloader = '<div class="wsmd_preloader"><div class="wsmd-sk-circle"><div class="wsmd-sk-circle1 wsmd-sk-child"></div><div class="wsmd-sk-circle2 wsmd-sk-child"></div><div class="wsmd-sk-circle3 wsmd-sk-child"></div><div class="wsmd-sk-circle4 wsmd-sk-child"></div><div class="wsmd-sk-circle5 wsmd-sk-child"></div><div class="wsmd-sk-circle6 wsmd-sk-child"></div><div class="wsmd-sk-circle7 wsmd-sk-child"></div><div class="wsmd-sk-circle8 wsmd-sk-child"></div><div class="wsmd-sk-circle9 wsmd-sk-child"></div><div class="wsmd-sk-circle10 wsmd-sk-child"></div><div class="wsmd-sk-circle11 wsmd-sk-child"></div><div class="wsmd-sk-circle12 wsmd-sk-child"></div></div></div>';
	
    var html = '<div class="wsmd_wpmedia_downloader_containar">';
	
      	//input part
        html += '<div class="wsmd_wpmedia_input_holder">';
	    html += '<div class="wsmd_wpmedia_input_containar"><div class="wsmd_wpmedia_input_field"><input type="text" placeholder="'+wsmd_admin.linkplch+'" id="wsmd_wpmedia_link_input" value=""><button id="wsmd_wpmedia_downloadbuttom">&nbsp;<span class="dashicons dashicons-download"></span>&nbsp;'+wsmd_admin.dlbuttontxt+'</button></div><br>';
	    html += '<div class="wsmd_wpmedia_options_holder" style="display: inline-flex;"><div style="border:1px solid  #bbbbbb; margin:5px; padding:5px;"><input disabled type="checkbox" name="wsmd_use_proxy" id="wsmd_use_proxy" value="proxy">'+wsmd_admin.proxy_option+' &nbsp; </div><div style="border:1px solid  #bbbbbb; margin:5px; padding:5px;"><input disabled type="checkbox" name="wsmd_use_mlpip" id="wsmd_use_mlpip" value="mlpip"> '+wsmd_admin.mlip_option+'</div></div><br>'+preloader+'<br>';	
	    html += '<div class="wsmd_wpmedia_results_holder"></div><br>';		
        html += '</div></div>';
	
	html += '</div>';
    jQuery('body .media-modal-content .media-frame-content').html(html);
}









///////////////////////////////////////////////////////////////////////////Downloader functions
jQuery(document).ready(function($){


$('body').on('click', '#wsmd_use_proxy', function (event) {
$('#wsmd_use_mlpip').prop('checked', false);
});

$('body').on('click', '#wsmd_use_mlpip', function (event) {
$('#wsmd_use_proxy').prop('checked', false);
});




$('body').on('click', '#wsmd_wpmedia_downloadbuttom', function (event) {
    wsmb_request_for_decode('click');
});


$('body').bind("paste", '#wsmd_wpmedia_link_input',function(e){
    wsmb_request_for_decode('paste');
});


$('body').on('click', '.wsmd_download_button', function (event) {
    wsmb_request_for_download($(this));
});


});	



function wsmb_request_for_decode(type){
	
clearInterval(window.wsmdcountdown);	
var preloader =  jQuery(".wsmd_preloader");
var link = jQuery('#wsmd_wpmedia_link_input').val();
if(link.length == 0 && type == 'click'){
	alert(wsmd_admin.alert);
	return;
}


var option = '';
if (jQuery('input#wsmd_use_proxy').is(':checked')) {
	option = 'proxy';
}
if (jQuery('input#wsmd_use_mlpip').is(':checked')) {
	option = 'mlpip';
}
preloader.show();
jQuery("#wsmd_wpmedia_downloadbuttom").attr("disabled", true);
          setTimeout(function(e) {
            var link = jQuery('#wsmd_wpmedia_link_input').val();
			  
                         jQuery.ajax({
                                type: "POST"
                                , url: wsmd_admin.wpajax
                                , data: { 'action': 'wsmd_download_controler_admin', 'link': link , 'option' : option}
                                , success: function(textStatus) {
								jQuery("#wsmd_wpmedia_downloadbuttom").attr("disabled", false);	
                                preloader.hide();
						
                                jQuery('.wsmd_wpmedia_results_holder').html(textStatus);
								jQuery('body .wsmd_tablinks:first-child').attr("id" , "wsmd_defaultopen");
								if(jQuery("body #wsmd_defaultopen").length){
								document.getElementById("wsmd_defaultopen").click();
								}
                                }
                                , error: function(MLHttpRequest, textStatus, errorThrown) {
									jQuery("#wsmd_wpmedia_downloadbuttom").attr("disabled", false);	
									preloader.hide();
                                    jQuery('.wsmd_wpmedia_results_holder').html(errorThrown);
                                }
                        });	
           }, 200);	

} 



function wsmb_request_for_download(evnt){

var progressbar =  '<div class="wsmd-light-grey"><b id="wsmd_counter_progress">0%</b><div id="wsmd_download_progressbar" class="wsmd-container wsmd-green wsmd-center" style="width:0px">&nbsp;</div></div>';
jQuery(evnt).replaceWith(progressbar);
	
var option = '';
if (jQuery('input#wsmd_use_proxy').is(':checked')) {
	option = 'proxy';
}
if (jQuery('input#wsmd_use_mlpip').is(':checked')) {
	option = 'mlpip';
}
var classn = jQuery(evnt).attr("data-class");
var link = jQuery(evnt).attr("data-dl");
var format = jQuery(evnt).attr("data-type");
var title = jQuery('.wsmd_title_preview').html();
var ml_ip = jQuery(evnt).attr("data-ml");
var randomid = wsmd_makeid(10);
jQuery(".wsmd_download_button").attr("disabled", true);

window.wsmdcountdown = setInterval(function(){
wsmd_progressbar_reader(randomid);
} , 500 );

                         jQuery.ajax({
                                type: "POST"
                                , url: wsmd_admin.wpajax
                                , data: { 'action': 'wsmd_download_media_and_addtowp', 'link': link , 'option' : option , 'class' : classn , 'mlip' : ml_ip , 'title' : title , 'format' : format , 'progressid' : randomid}
                                , success: function(textStatus) {
								jQuery('.wsmd-light-grey').replaceWith('<span class="dashicons dashicons-yes"></span>');	
                                jQuery(".wsmd_download_button").attr("disabled", false);
								clearInterval(window.wsmdcountdown);
                                var wp = parent.wp;
                                wp.media.frame.setState('insert');
                                if( wp.media.frame.content.get() !== null) {
                                    wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
                                    wp.media.frame.content.get().options.selection.reset();
                                  } else {
                                    wp.media.frame.library.props.set ({ignore: (+ new Date())});
                                }								
							
                                }
                                , error: function(xhr, textStatus, errorThrown) {
									jQuery("body #wsmd_wpmedia_downloadbuttom").attr("disabled", false);	
									jQuery("body .wsmd_download_button").attr("disabled", false);
									jQuery('body .wsmd-light-grey').replaceWith('<span class="dashicons dashicons-no" style="color:red;"></span>');
									
									clearInterval(window.wsmdcountdown);
                                    wsmd_error_cacther();
                                }
                        });
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


function wsmd_progressbar_reader(fileid){
                        var ms = new Date().getTime();
                        jQuery.get(wsmd_admin.jsonfile + "?dummy=" + ms, function(data) {
							var property = fileid;
							if(data.hasOwnProperty(property)){
								var parsed = data;
								var width = parsed[property];
                               jQuery('body #wsmd_counter_progress').html(width);								
                               jQuery('body #wsmd_download_progressbar').css({'width' : width});	
							}
                        }, 'json');	
	
}



function wsmd_makeid(length) {
	var ms = new Date().getTime();
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result + ms;
}


function wsmd_error_cacther(){
                        var ms = new Date().getTime();
                        jQuery.get(wsmd_admin.errorfile + "?dummy=" + ms, function(data) {
							var error = 'error';
							if(data.hasOwnProperty(error)){
								var parsed = data;
								var msg = parsed[error];
                               jQuery('body .wsmd_wpmedia_results_holder').prepend('<p class="wsmd_error_handler" >' + msg + '</p>');									
							}
                        }, 'json');
}