jQuery(document).ready(function(){
	window.options_skpd = {};
	var loading = ''
		+'<div id="wrap-loading">'
	        +'<div class="lds-hourglass"></div>'
	        +'<div id="persen-loading"></div>'
	    +'</div>';
	if(jQuery('#wrap-loading').length == 0){
		jQuery('body').prepend(loading);
	}
});

function sql_migrate_siks(){
	jQuery('#wrap-loading').show();
	jQuery.ajax({
		url: ajaxurl,
      	type: "post",
      	data: {
      		"action": "sql_migrate_siks"
      	},
      	dataType: "json",
      	success: function(data){
			jQuery('#wrap-loading').hide();
			return alert(data.message);
		},
		error: function(e) {
			console.log(e);
			return alert(data.message);
		}
	});
}