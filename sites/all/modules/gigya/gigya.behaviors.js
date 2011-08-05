Drupal.behaviors.gigya_notifyFriends = function(context){
  $('.friends-ui:not(.gigya_notifyFriends-processed)', context).addClass('gigya_notifyFriends-processed').each(
    function () {
      gigya.services.socialize.getUserInfo(Drupal.settings.gigya.conf, {callback:Drupal.gigya.notifyFriends_callback});
      gigya.services.socialize.addEventHandlers(Drupal.settings.gigya.conf, { onConnect:Drupal.gigya.notifyFriends_callback, onDisconnect:Drupal.gigya.notifyFriends_callback });
   });
};

Drupal.behaviors.gigya_init = function(context){
	if(Drupal.settings.gigya.notify_login_params != undefined){
		Drupal.settings.gigya.notify_login_params.callback = Drupal.gigya.notifyLogin_callback;
		gigya.services.socialize.getUserInfo(Drupal.settings.gigya.conf,{callback: Drupal.gigya.init_response});
	}
}


