/**
 * Binds the object to the specified function (and optional parameters).  This
 * bind variant ignores all parameters passed into the function by the caller
 * and only uses those parameters used to create the bind.
 *
 * @param object the object to use as the 'this' reference
 * @param func the function to bind object to
 * @param ... an option set of parameters that will be passed to the
 *        specified function when it is called
 */
bindIgnoreCallerArgs =
function(object, func) {
  var __method = func;
  var __args = [];
  for (var i = 2; i < arguments.length; i++) {
    __args.push(arguments[i]);
  }
  delete i;
  return function() {
    var args = [];
    args = args.concat(__args);
    return __method.apply(object, args);
  };
};

$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});

Drupal.gigya = {};

/**
 * Debug code for the login block, should be removed after further testing
 */
Drupal.gigya.printResponse = function(response) {
     if ( response['status'] == 'OK' ) {               
         var availableProviders= response['availableProviders'];   
         var msg = response['context']['myAppTitle'] + '\n\n';  
         if ( null!=availableProviders ) {  
             for (var providerName in availableProviders) {  
                 msg += providerName + ':\n' ;  
                 var provider = availableProviders[providerName];  
                 for (var properties in provider) {  
                     msg+= ' ' +properties+ '  :  ' + provider[properties] + '\n';  
                 }
                 msg+='\n';  
             }
             alert(msg);
         }
         else {
             alert('Error : NO available providers were returned');  
         }
     }
     else {   
         alert('Error :' + response['statusMessage']);  
     }
};

Drupal.gigya.logoutResponse = function (response) {      
    if ( response['status'] == 'OK' ) {
      document.getElementById('logoutMessage').innerHTML = "Successfully logged out, redirecting";
      window.location = Drupal.settings.gigya.logout_location;
    }
    else {    
     alert('Error :' + response['statusMessage']);    
    }    
}; 

Drupal.gigya.login_callback = function (response) {
  url_obj = {'signature':response['signature'],'timestamp':response['timestamp'],'UID':response['UID']};
  new_url = response['context'].destination + '&' + $.param(url_obj);
  window.location = new_url;
}

/**
 * Callback for the getUserInfo function
 * takes getUserInfo object and renders the HTML to display an array of the user object
 * note: probably should be removed in production, since its just for dumping user output.
 */
Drupal.gigya.getUserInfo_callback = function(response)
{
  if (response.status == 'OK')
  {
    var user = response['user'];  

    var str="<pre>"; //variable which will hold property values
    for(prop in user)
    {
      if (prop == 'birthYear' && user[prop] == 2009) {
        user[prop] = '';
      }
      if (prop == 'identities') {
            for(ident in user[prop])
            {
               for(provide in user[prop][ident])
               {
                 str+=provide + " SUBvalue :"+ user[prop][ident][provide]+"\n";
               }
            }
      }
      str+=prop + " value :"+ user[prop]+"\n";//Concate prop and its value from object
    }
    str+="</pre>";
    
    document.getElementById('userinfo').innerHTML = str;
  }
  else {  
     alert('Error :' + response['statusMessage']);  
  }      
};

/**
 * Callback for the gigya.login function
 * checks to make sure a user is logged in or out, and displays the loginUI page accordingly
 * has an additional check for a drupal user, and if logged out, performs the gigya logout function
 */
Drupal.gigya.login = function() {
  var conf = Drupal.settings.gigya.conf;
  var params = Drupal.settings.gigya.params;
  params += {callback:Drupal.gigya.printResponse};
  var login_params = Drupal.settings.gigya.login_params;
  login_params.width = parseInt(login_params.width);
  login_params.height = parseInt(login_params.height);
  gigya.services.socialize.showLoginUI(conf,login_params);
};

Drupal.gigya.printResponse = function(res) {
	var spaces=' ';
	var str='';
	for ( ppp in res ) {
	 var obj = res[ppp];
	 if ( typeof res[ppp] != 'object' ) { 
		str += spaces + ppp + ' :  ' + res[ppp] + '\n';  
	 }
	 else {
	  str += spaces+ppp+'\n';
	  spaces = '   ';
	  for ( kk in obj ) {
		var obj2 = obj[kk];
	    if ( typeof obj[kk] != 'object' ) {     
			str += spaces + kk + ' :  ' + obj[kk] + '\n';  
		
		}
		else {
			spaces = '     ';
			for ( zz in obj2 ) {
				str += spaces + zz + ' :  ' + obj2[zz] + '\n';  
			}
		}
			
	  }  
	  spaces=' ';
	 } 
	}
	return str;
}

Drupal.gigya.linkAccounts_callback = function(response) {

 if ( response['status'] == 'OK' ) {
	 $.get(Drupal.settings.basePath + 'socialize-ajax/link-accounts-complete');
 } 
 else {
   alert(response['statusMessage']);
 }
};


Drupal.gigya.notifyLogin_callback = function(response) {
  if ( response['status'] == 'OK' ) {
	setTimeout("$.get(Drupal.settings.basePath + 'socialize-ajax/notify-login')",1000);
  } 
  else {
    alert(response['statusMessage']);
  }
};

Drupal.gigya.notifyFriends_callback = function(res){
	
	
  if(res.user!=null && res.user.isConnected)   {	 
      user = res.user ;    
      // Show friend-selector component
      document.getElementById("friends").style.display = "block";
      
      var friendsUI_params = Drupal.settings.gigya.friendsUI_params;
      friendsUI_params.width = parseInt(friendsUI_params.width);
      friendsUI_params.height = parseInt(friendsUI_params.height);
      friendsUI_params.onSelectionDone = Drupal.gigya.notifyFriends_onSelectionDone;
      friendsUI_params.onClose = Drupal.gigya.notifyFriends_onClose;
      friendsUI_params.showEditLink = 'false';
      var origUrl = (document.referrer!="")?document.referrer:document.location;
      friendsUI_params.context = { url:origUrl};    	
      

      Drupal.settings.gigya.conf.disabledProviders = 'myspace, google, yahoo, aol';
      
      gigya.services.socialize.showFriendSelectorUI(Drupal.settings.gigya.conf, friendsUI_params);
          
  } 
  else {
      document.getElementById("friends").style.display = "none";
  }
};

// If the user clicked "OK" in the friend-selector component
// Send a notification to the selected friends.
Drupal.gigya.notifyFriends_onSelectionDone = function(response)
{
  var subject = "Notifiation message"; //gigya needs a subject, although its never displayed in fb or twitter.  
  var notification = document.getElementById('socialize_notification');
  var body = notification.body.value;
  var url = notification.url.value;  
  var urlTitle = notification.urltitle.value;
    
  
  if (!body) {
    alert("Please write a message first!");
    return;
  }
  
  if (response.friends.getSize() > 0)   {	
	  document.getElementById('notify_MsgLabel').style.display = 'none';
	  document.getElementById('notify_message').style.display = 'none';
	  document.getElementById('notify_WaitLabel').style.display = '';
	  	  	
	  body = body + ' ' + urlTitle + ': '  + url; 	 	 
      var params =    {         
          callback:sendNotification_callback,
          subject:subject,
          body:body,
          recipients:response.friends
      };
    gigya.services.socialize.sendNotification(Drupal.settings.gigya.conf, params)
    }
};

Drupal.gigya.notifyFriends_onClose = function(response) {	
	Popups.close();
	if ( null!=response.context && null!=response.context.url) { 
		window.location = response.context.url;
	}
};

Drupal.gigya.getHTMLEncode  = function(t) {
	return t.toString().replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
}


// Display a status message according to the response from sendNotification
function sendNotification_callback(response) {
	
	
  document.getElementById('socialize_notification').innerHTML = '';
  var statusELem = document.getElementById('status');
  
  statusELem.style.fontSize = "16pt";
  statusELem.style.textAlign = "center";
	
  switch (response.status)  {
    case 'OK':
    	statusELem.style.color = "green";
    	statusELem.innerHTML = "Notification sent successfully.";   
    	break;
    default:
    	statusELem.style.color = "red";            
    	statusELem.innerHTML = "<p>Unable to send notification. <br /> status=" + response.status + "</p>";   
  }
  
  //debugger;
  setTimeout(bindIgnoreCallerArgs(this,Popups.close),Popups.originalSettings.popups.autoCloseFinalMessageDelay);  	  
};

// Toggle the gigya login/register block depending on which router you're taking.
Drupal.gigya.toggleScreens = function() {
  $("fieldset#user-login-description > legend > a").click(function(){
    if(!$("fieldset#user-register-description").hasClass("collapsed")) {
      Drupal.toggleFieldset($("fieldset#user-register-description"));
    }
  });
  $("fieldset#user-register-description > legend > a").click(function(){
    if (!$("fieldset#user-login-description").hasClass("collapsed")) {
      Drupal.toggleFieldset($("fieldset#user-login-description"));
    }
  });
};

Drupal.gigya.loadSetStatusPopup = function(url) {

  var popupElement = document.createElement('a');
  popupElement.id = 'gigya_setStatus';
  popupElement.href=url; 
  //popupElement.setAttribute('style','display:none;');
  //popupElement.setAttribute('destination','index.php');
  popupElement.setAttribute('class','popups-form popups-processed');
  popupElement.textContent="setStatus";
  parent.path=url;  
  Popups.openPath(popupElement,Popups.options,parent);  
  //Popups.message('Titles','here we go!');
};

Drupal.gigya.SetStatusPopup_onClose = function(response) {	
  Popups.close();
};

Drupal.gigya.init_response = function(response){
	if(null!=response.user) { 
		if(response.user.UID != Drupal.settings.gigya.notify_login_params.siteUID || !response.user.isLoggedIn){
			gigya.services.socialize.notifyLogin(Drupal.settings.gigya.conf, Drupal.settings.gigya.notify_login_params);
		}
		else{
			//alert(response['user']['UID']);
		}
	}
}

Drupal.gigya.showShareUI = function(userAction_params,shareUI_params){
	shareUI_params = $.extend(shareUI_params,{userAction: Drupal.gigya.buildUserAction(userAction_params)});
	gigya.services.socialize.showShareUI(Drupal.settings.gigya.conf, shareUI_params);
}

Drupal.gigya.buildUserAction = function(userAction_params){
	var act = new gigya.services.socialize.UserAction();
	$.each(userAction_params, function(index,value){
		switch(index){
		case 'user_message':
			act.setUserMessage(value);
			break;
		case 'title':
			act.setTitle(value);
			break;
		case 'description':
			act.setDescription(value);
			break;
		case 'link_back':
			act.setLinkBack(value);
			break;
		case 'template':
			act.setTemplate(value);
			break;
		case 'action_name':
			act.setActionName(value);
			break;
		case 'action_links':
			$.each(value, function(action_index,action_item){
				act.addActionLink(action_item.title,action_item.href);
			});
			break;
		case 'template_fields':
			$.each(value, function(template_field_index,template_field_item){
				act.setTemplateField(template_field_item.field_name,template_field_item.text,template_field_item.href);
			});
			break;
		case 'media_item':
			act.addMediaItem(value);
			break;
		}
		
	});
	return act;
}
