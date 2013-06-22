/**
 * 
 * @author alexhermann
 *
 */
var AWD_facebook_app_requests = function(AWD_facebook) {
	return {
		request : function(message, button, callback){
			//call the FB.ui
			FB.ui({method: 'apprequests',
				message: message,
			},
			//call the user defined callback
			function(response){
				if(callback){
					var AWD_actions_callback = window[callback];
					if(jQuery.isFunction(AWD_actions_callback)){
						AWD_actions_callback(response, message);
					}
				}
			});
		}
	};
}(AWD_facebook);

jQuery(document).ready(function($){
	//create eventlistener on the element
	$('.AWD_facebook_app_requests_button').live('click',function(e){
		e.preventDefault();
		$(this);
		var $this = $(this);
		var data = $this.data();
		AWD_facebook_app_requests.request(data.message, this, data.callbackjs);
	});
});