<?php
// $Id: gigya.pages.inc,v 1.1.2.18.2.4 2010/05/17 22:45:46 azinck Exp $

/**
 * @file
 * Page display functions for for gigya module.
 */

/**
 * 
 * 
 */
function gigya_connect($account, $name = NULL) {
	drupal_set_title('Edit your Social Network connections');
	return theme('gigya_connect_display');
}



function gigya_logout_ajax() {
  global $user, $base_path;
  module_load_include('.inc', 'user', 'user.pages');
  module_load_include('inc', 'gigya');

  $dest = $_REQUEST['destination'];
  if(empty($dest)) $dest = $base_path;
  $logout_behavior = array("logout_location" => $dest);
  
  drupal_add_js(array('gigya' => $logout_behavior), 'setting');

  $behavior_js = 'Drupal.behaviors.gigya_logout = function(){ gigya.services.socialize.logout(Drupal.settings.gigya.conf, {callback:Drupal.gigya.logoutResponse});};';
  drupal_add_js($behavior_js, 'inline');
  return '<div id="logoutMessage">'. t("Logging out...") .'</div>';
}


function gigya_login_ajax() {

  global $user, $base_path;
  
  drupal_set_message('gigya_login_ajax u:' . $user->uid > 0);
  module_load_include('inc', 'gigya'); 
  
	if (!($user->uid)) { //not yet logged in to Drupal
  
    if($_gigya_user = GigyaUser::UserFromUrl()){
      
      $dest = $base_path . variable_get('gigya_login_uiconfig_urlredirect', 'user');
    
      $bio = $_gigya_user->GetUserInfo();
         
      //check to see if the gigya_user is a drupal user
      if ($account = user_load($_gigya_user->uid)) {    
        if (!variable_get('user_email_verification', true) || $account->login) {
          //we can suppress the notifylogin js because the user is clearly already logged into gigya
          $_SESSION['gigya_suppress_notifylogin_js'] = true;
          
          //log the user in
          user_external_login($account);
          
        }
        else {
          drupal_set_message(t('You must validate your email address for this account before logging in via Gigya.'));
        }
        drupal_goto();
      }
      elseif(variable_get('user_register', 1)){ //try to register them if we're allowed to
        $form_state['redirect'] = $_REQUEST['destination'];
        $form_state['values'] = array();
        drupal_execute('user_register',$form_state);//default values get populated here by hook_form_alter
        
        if (form_get_errors()) {
            
            $messages = drupal_get_messages('error');
              
            $xxx = gigya_printObject('',$messages);
            // We were unable to register a valid new user
            watchdog('gigya', 'error:' . $xxx);
            
            $dest = $_REQUEST['destination'];
            unset($_REQUEST['destination']);
            drupal_goto('socialize-register',array('signature'=>$_GET['signature'],'UID'=>$_GET['UID'],'timestamp'=>$_GET['timestamp'],'destination'=>$dest));
        }

        drupal_redirect_form($form, $form_state['redirect']);
        
      }
      else {
        drupal_set_message(t('Only site administrators can create new user accounts.'), 'error');
      }
  	}    
	}	
  drupal_goto();
	
}

/**
 * AJAX function to handle various requests to gigya
 * for now it's just used to set session variables for the javascript
 */
function gigya_ajax($op){
  switch($op){
    case 'notify-login':
      $_SESSION['gigya_suppress_notifylogin_js'] = true;
    break;
    case 'link-accounts-complete':
      $_SESSION['link_accounts'] = false;
    break;
    case 'logout':
      
    break;
  }
  exit();
}


/**
 */
function gigya_get_friends($account, $name = NULL) {
  $title = isset($account->title) ? $account->title : $account->name;
  drupal_set_title(check_plain($title));

  module_load_include('inc', 'gigya');
  $site_friends = array();
  $this_gigya_user = new GigyaUser($account->uid);
  if ($friends = $this_gigya_user->GetFriends()) {
    foreach ($friends['friends']->friend as $friend) {
      $friend_arr = get_object_vars($friend);
      if ($friend_arr['isSiteUser'] === 'true')
        $site_friends[] = $friend_arr;
    }
  }

  return theme('gigya_friends', $site_friends);
}

/**
 * Wrapper for the gigya javascript userInfo function.
 * injects the gigya getUserInfo javascript function.
 */
function gigya_get_user($object, $name = NULL) {
  $title = isset($object->title) ? $object->title : $object->name;
  drupal_set_title(check_plain($title));

  //add the onload functions  
  $behavior_js = 'Drupal.behaviors.gigya_getUserInfo = function(context){ gigya.services.socialize.getUserInfo(Drupal.settings.gigya.conf, {callback:Drupal.gigya.getUserInfo_callback}); }';
  drupal_add_js($behavior_js, 'inline');

  $userinfo = '<div id="userinfo"></div>';
  return $userinfo;
}


function gigya_register(){
 
  global $user;

  // If we are already logged on, go to the user page instead.
  if ($user->uid) {
    drupal_goto('user/'. $user->uid);
  }
  
  if (!($_gigya_user = GigyaUser::UserFromUrl())) {
    drupal_goto();
  }
  $bio = $_gigya_user->GetUserInfo(TRUE);
      
  $registration_form = drupal_get_form('user_register');
  $link_accounts_form = drupal_get_form('gigya_link_accounts');
  return theme('gigya_register',$bio,$registration_form,$link_accounts_form);
}