jQuery(document).ready(function($){
document.getElementById("wsmds_tab_default").click();	


$('body').on('click', '.wpwrap', function (event) {
	if(event.target != $('.wsmd_help')[0]){
	$('.wsmd_help-text').hide();	
	}
});

////////////////////used for modal ads
if ($('input#wsmd_show_results_in_modal').is(':checked')) {
$('.wsmd_modal_mode').show();
}	

$("#wsmd_show_results_in_modal").change(function() {
    if(this.checked) {
      $('.wsmd_modal_mode').show();
    }else{
	$('.wsmd_modal_mode').hide();	
	}
});	


$('.wsmd-color-field').wpColorPicker({});


$(".wsmds_spinner-width").spinner({
    min: 0
    });




if ($('input#wsmds_allow_share_results').is(':checked')) {
$('#wsmds_choose_share_buttons').show();
}	

$("#wsmds_allow_share_results").change(function() {
    if(this.checked) {
      $('#wsmds_choose_share_buttons').show();
    }else{
	$('#wsmds_choose_share_buttons').hide();	
	}
});	
	

	
if ($('#wsmds_template_chooser').val() == 'custom') {
$('#wsmds_custom_template_styles').show();
$('#wsmds_template_custom_color').hide();
}else{
$('#wsmds_custom_template_styles').hide();
$('#wsmds_template_custom_color').hide();	
}

	  if($('#wsmds_template_chooser').val() == 'darkcustom' || $('#wsmds_template_chooser').val() == 'lightcustom'){
		$('#wsmds_template_custom_color').show(); 
        $('#wsmds_template_demo').hide();		
	  }	

$('#wsmds_template_chooser').change(function() {
	var valu = $('#wsmds_template_chooser').val();
    if($('#wsmds_template_chooser').val() == 'custom') {
      $('#wsmds_custom_template_styles').show();
	  $('#wsmds_template_custom_color').hide(); 
	  $('#wsmds_template_demo').hide();
    }else{
	  $('#wsmds_custom_template_styles').hide();
	  
	  if($('#wsmds_template_chooser').val() == 'darkcustom' || $('#wsmds_template_chooser').val() == 'lightcustom'){
		$('#wsmds_template_custom_color').show();
        $('#wsmds_template_demo').hide();		
	  }else{
		$('#wsmds_template_custom_color').hide();  
	  $('#wsmds_template_demo').show();	
      $('#wsmds_template_demo').attr("src" , wsmd_admin_setting.assets + valu + '.png');
	  }	  
	}
});	


$('body').on('change', '#use_mlpip' ,function(){
if(this.checked) {
	$('#use_proxy').prop('checked', false);
}	
});


$('body').on('change', '#use_proxy' ,function(){
if(this.checked) {
	$('#use_mlpip').prop('checked', false);
}	
});


});





(function (document, window, undefined) {
  'use strict';
  
  // Find each tooltip
  var tooltip = document.querySelectorAll('.wsmd_help');

  [].forEach.call(tooltip, function(el) {
    // Create tooltip element
    var tooltipText = document.createElement('div');
    
    // Set tooltip text
    tooltipText.textContent = el.getAttribute('data-tooltip-text');
    tooltipText.classList.add('wsmd_help-text');
  
    // Add tooltip to body on mouse over
    el.addEventListener('mouseover', function() {
      document.body.appendChild(tooltipText);
    }, false);
  
    // Remove tooltip on mouseout
    el.addEventListener('mouseout', function() {
      document.body.removeChild(tooltipText);
    }, false);
  
    // Attach the tooltip to the mouse cursor
    el.addEventListener('mousemove', function(e) {
      tooltipText.style.top = (e.pageY + 20) + 'px';
      tooltipText.style.left = (e.pageX + 20) + 'px';
    }, false);
  
  });
  
})(document, window);




	//////codeeditor
	  var editor = CodeMirror.fromTextArea(wsmd_custom_styles, {
    lineNumbers: true,
	mode: "css",
  autoRefresh:true,
  viewportMargin : Infinity 
  });


function openTab(evt, mytabname) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("wsmds_tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("wsmds_tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(mytabname).style.display = "block";
  evt.currentTarget.className += " active";
}




		function wsmds_open_media_uploader_image_plus(){
			media_uploader = wp.media({
				multiple: false,
                title: wsmd_admin_setting.title,
                button: {
                        text: wsmd_admin_setting.button
                },				
			});
			media_uploader.on("select", function(){

				var length = media_uploader.state().get("selection").length;
				var images = media_uploader.state().get("selection").models

				for(var iii = 0; iii < length; iii++){
					var image_url = images[iii].changed.url;
                    jQuery("#wsmds_loader_img_holder").attr("src" , image_url);
                    jQuery("#wsmd_show_preloader_input").val(image_url);			
				}
			});
			media_uploader.open();
		}