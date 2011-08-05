<?php
// $Id: gigya.inc,v 1.1.2.23.2.4 2010/05/20 02:16:20 azinck Exp $

/**
 * @file
 * This module provides a link to Gigya profiles from a users' drupal account.
 *
 * Development of this module is sponsered by gigya, Inc
 */

function gigya_execute_replacement(&$value,$key,$params){
	$replacements = $params['replacements'];
	$token_types = $params['token_types'];
	
	if(is_string($value)){
		if(module_exists('token')){
			foreach($token_types as $token_type){
				if($context['hook'] == 'comment' && $type == 'node'){
				  $the_object = node_load($object->nid);
				}
				else{
				  $the_object = $object;
				}
				$value = token_replace($value,$token_type,$the_object);
			}      
		}
		$value = strtr($value,$replacements);  
	}
}
 
function gigya_delete_profile($uid) {
  gigya_unlinkAccounts($uid,$uid);
  return TRUE;
}

function gigya_get_loginprovider($uid) {
  return false;
}


function gigya_avatar_check($uid) {
  $bio = gigya_getUserInfo($uid);
  if ($bio['thumbnailURL'])
    return $bio['thumbnailURL'];
  else if ($bio['photoURL'])
    return $bio['photoURL'];
  else { 
    return FALSE;
  }
}
  

function gigya_save_userpic($uid) {
  // Get facebook user picture's url.

  if($avatar = gigya_avatar_check($uid)) {
    $result = drupal_http_request($avatar);
    
    if ($result->code != 200) {
      watchdog('gigya', 'Failed importing user avatar for @uid, code : @code', 
      array('@uid' => $uid, '@code' => $result->code));
      return FALSE;
    }  
    
    $filename = 'picture-gigya_'. $uid .'.jpg';
    $dest = file_directory_path();  
    if (variable_get('user_picture_path', '')) {
      $dest .= '/'. variable_get('user_picture_path', '');
    }
    $dest .= '/'. $filename;
    
    $file = file_save_data($result->data, $dest, FILE_EXISTS_REPLACE);
    // Resizing
    list($width, $height) = sscanf(variable_get('user_picture_dimensions', '85x85'), '%dx%d');
    image_scale_and_crop($file, $dest, $width, $height);
    drupal_set_message("user pic saved successfully!");

    return $file;
  } else {
    drupal_set_message("Your social network does not have a profile picture");
    return FALSE;
  }
}

/**
 *  Gigya parameter functions below
 */

function gigya_get_capabilities() {
  //this function retrieves services available on this account
  $services = array(
    'login' => 'login',
    'friends' => 'friends'
  );
  return $services;
}

function gigya_status_form($account = NULL) {
  global $user;
  drupal_add_js(drupal_get_path('module', 'gigya') .'/gigya_updatestatus.js', 'module');
 
  if (empty($account)) {
    global $user;
    $account = $user;
  }

  if ($capabilities = $user->gigya->GetCapabilities()) {
    if (array_search('Status', $capabilities)) {
      $form = array();
      $form['status'] = array(
        '#type' => 'textfield',
        '#id' => 'gigya-textfield',
      );
      return $form;
    }
  }
}

function gigya_get_networks() {
  //this function gets the list of services that can be connected to
  $services = array(
    'facebook' => 'Facebook',
    'myspace' => 'MySpace',
    'twitter' => 'Twitter',
    'google' => 'Google',
    'yahoo' => 'Yahoo',
    'aol' => 'AOL',  
    'blogger' => 'blogger',
    'wordpress' => 'WordPress',
    'typepad' => 'typepad',
    'liveJournal' => 'liveJournal', 
    'hyves' =>  'hyves' ,
    'veriSign' =>'veriSign',
  	'linkedin' =>  'LinkedIn',
    'liveid' => 'Windows Live ID',
    'openid' => 'OpenID'
  
  );
  return $services;
}


function gigya_get_network_displayName($networkName) {	
	$networks = gigya_get_networks();
	if ( array_key_exists($networkName,$networks)) {		
		return $networks[$networkName];	
	}	
	return $networkName;
}

function _gigya_get_profile_fields() {
  //todo add the ability to specify the field type
  return array(
    "nickname" => "nickname",
    "firstName" => "firstName",
    "lastName" => "lastName",
    "gender" => "gender",
    "age" => "age",
    "birthDay" => "birthDay",
    "birthMonth" => "birthMonth",
    "birthYear" => "birthYear",
    "email" => "email",
    "country" => "country",
    "state" => "state",
    "city" => "city",
    "zip" => "zip",
  );
}


function _gigya_getUserCapabilities($uid) {
		
  if (empty($uid)) {
    return;
  }
  if ($bio = gigya_getUserInfo($uid)) {
    $capabilities = split(', ', $bio['capabilities']);
    array_walk($capabilities, '_gigya_trim_value');
    return $capabilities;
  }
  else {
    return FALSE;
  }
}



function _gigya_trim_value(&$value) {
    $value = trim($value);
}

/**
 *  Internal gigya signature verification functions
 */

/**
 * Wrapper around the hmacsha1 signature function
 * @param string $timestamp The current timestamp for the request being made or received
 * @param string $uid The gigya GID being passed to/from gigya
 * @param string $privatekey The private key set in the admin settings. Fetch the key from the gigya socialize site
 */

function gigya_verify_signature($timestamp,$uid,$signature){
	$secret = variable_get('gigya_SecretKey', FALSE);
	$localkey = _gigya_verify_signature($timestamp, $uid, $secret);
	if($localkey == $signature){
		return $uid;
	}
	else{
		return false;
	}
}

function _gigya_verify_signature($timestamp, $uid, $privatekey) {

  $ch1data = $timestamp .'_'. $uid;
  $keydata = base64_decode($privatekey);
  return _gigya_encodedata($keydata, $ch1data);
}

/**
 * Wrapper for the base64 encoding of the hmacsha1 function
 * @param string $key The base64 decoded version of the private key set in the gigya settings
 * @param string $data The timestamp+uid being passed for comparison
 * @return The signature created by the hmacsha1 function. Should be the same as the signature retrieved from gigya socialize
 */
function _gigya_encodedata($key, $data) {
    return base64_encode(_gigya_hmacsha1($key, $data));
}

/**
 *  Internal gigya signature verification function
 */
function _gigya_hmacsha1($key, $data) {
    $blocksize=64;
    $hashfunc='sha1';
    if (drupal_strlen($key)>$blocksize)
        $key=pack('H*', $hashfunc($key));
    $key = str_pad($key, $blocksize, chr(0x00));
    $ipad = str_repeat(chr(0x36), $blocksize);
    $opad = str_repeat(chr(0x5c), $blocksize);
    $hmac = pack(
                'H*', $hashfunc(
                    ($key^$opad) . pack(
                        'H*', $hashfunc(
                            ($key^$ipad) . $data
                        )
                    )
                )
            );
    return $hmac;
}

/**
 * Very lightweight helper function to generate a TinyURL for a given post.
 */
function gigya_shorten_url($url) {
  $response = drupal_http_request("http://tinyurl.com/api-create.php?url=". $url);
  if ($response->code == 200) {
    return $response->data;
  }
  else {
    return $url;
  }
}

/**
 * Used to validate the gigya session keys. We use the site 'admin' username to find out the status. 
 * If it shows the user logged out, thats good, if it returns an error then our keys are most likely bad
 */ 
function gigya_validate($update = FALSE) {
  	
  $origValidateState = variable_get("gigya_validate", FALSE);	
	
  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = 'admin';
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'getUserInfo', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.getUserInfo".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']); //for some reason drupal_urlencode doesn't take out slashes
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');
  //print_r($results);
  if ($error = _gigya_request_failure($results,true)) {
    variable_set("gigya_validate", FALSE);
    if($error == 403003) {
      if(!$update) 
        drupal_set_message("Your request signature is invalid. This is most likely caused by invalid site and/or private keys. Gigya is disabled until this error message is cleared",'error');
    } else {
      if(!$update) 
        drupal_set_message("Gigya encountered an error while validating itself. Please check watchdog and try later. If this message keeps appearing please contact gigya or file a bug in the gigya project issue queue",'error');
    }
    return FALSE;
  }
  
  
  
  if ( !$origValidateState || variable_get("need_validation_msg", FALSE)) {  	   
  	drupal_set_message($eee . " Gigya validated properly. This site is authorized to use Gigya services");
  	variable_set("need_validation_msg", TRUE);  	  
  }
  
  variable_set($eee . "gigya_validate", TRUE);
    
  return TRUE;
}
  
/**
 *  GIGYA REST API functions
 */

 /**
 * Fetch information about users following a given socialize account.
 */
function gigya_getUserInfo($gigya_uid) {			    

  if (empty($gigya_uid)) {
    return FALSE;
  }
  
  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = $gigya_uid;  	

  
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'getUserInfo', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.getUserInfo".
            "?timestamp=". drupal_urlencode($gigya_params['timestamp']) .  
            "&apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .  
            "&uid=". urlencode($gigya_params['uid']); //for some reason drupal_urlencode doesn't take out slashes
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
    
   
  $results = drupal_http_request($url, $headers, 'GET');
  

  if (_gigya_request_failure($results)) {
  	watchdog('gigya', 'gigya_getUserInfo failure'); 
    return FALSE;
  }
  return _gigya_convert_xml_to_array($results->data);
}

function gigya_getFriendsInfo($gigya_uid) {
	
  if (!$gigya_uid) {
    return FALSE;
  }

  $gigya_params = gigya_load_params();
	$gigya_params['uid'] = $gigya_uid;  	
  
  
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'getFriendsInfo', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.getFriendsInfo".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']);
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');
  
  if (_gigya_request_failure($results)) {
    return FALSE;
  }
  return _gigya_convert_xml_to_array($results->data);
}

function gigya_setStatus($gigya_uid, $status) {
  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = $gigya_uid;
  $gigya_params['status'] = $status;

  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'setStatus', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.setStatus".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']) .
            "&status=". rawurlencode($gigya_params['status']);
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');

  if (_gigya_request_failure($results)) {
    return FALSE;
  }

  return _gigya_convert_xml_to_array($results->data);
}

function gigya_publish_user_action($gigya_uid, $content) {
  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = $gigya_uid;
  $gigya_params['userAction'] = _gigya_get_useraction_xml($content);
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'publishUserAction', $gigya_params);

  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.publishUserAction".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']) .
            "&userAction=". rawurlencode($gigya_params['userAction']);

  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');


  if (_gigya_request_failure($results)) {
    return FALSE;
  }
  return _gigya_convert_xml_to_array($results->data);
}


/**
 * Create a linkage in Gigya Socialize between the current Drupal user and gigya user (Drupal uid<->Gigya uid)
 */
function gigya_linkAccountsRest($gigya_uid,$drupalUid) {
  if (empty($gigya_uid) || empty($drupalUid))
    return FALSE;

  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = $gigya_uid;
  $gigya_params['siteUID'] = $drupalUid;
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'linkAccounts', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.linkAccounts".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']). //for some reason drupal_urlencode doesn't take out slashes
            "&siteUID=". urlencode($gigya_params['siteUID']); //for some reason drupal_urlencode doesn't take out slashes
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');
  //print_r($results);
  if (_gigya_request_failure($results)) {  	
    return FALSE;
  }
  return _gigya_convert_xml_to_array($results->data);
}

/**
 * Break the linkage in Gigya Socialize between the current Drupal user and gigya user (Drupal uid != Gigya uid)
 */
function gigya_unlinkAccounts($gigya_uid,$drupalUid) {	 
  if (empty($gigya_uid))
    return FALSE;

    	      
  $gigya_params = gigya_load_params();
  $gigya_params['uid'] = $gigya_uid;
  $gigya_params['siteUID'] = $drupalUid;
  $signature = _gigya_calc_signature(variable_get('gigya_SecretKey', FALSE), 'GET', 'unlinkAccounts', $gigya_params);
  $url = "http://". variable_get('gigya_api_url', 'socialize.api.gigya.com') ."/socialize.unlinkAccounts".
            "?apiKey=". drupal_urlencode($gigya_params['apiKey']) .
            "&timestamp=". drupal_urlencode($gigya_params['timestamp']) .
            "&nonce=". drupal_urlencode($gigya_params['nonce']) .
            "&sig=". drupal_urlencode($signature) .
            "&uid=". urlencode($gigya_params['uid']). //for some reason drupal_urlencode doesn't take out slashes
            "&siteUID=". urlencode($gigya_params['siteUID']); //for some reason drupal_urlencode doesn't take out slashes
  $headers = array('Content-type' => 'application/x-www-form-urlencoded');
  $results = drupal_http_request($url, $headers, 'GET');

  if (_gigya_request_failure($results)) {
    return FALSE;
  }
  
  $currUser = (object)array('uid' => $drupalUid);    
  user_set_authmaps($currUser,array('auth_gigya' =>NULL));    
  return _gigya_convert_xml_to_array($results->data);
}


function _gigya_get_useraction_xml($content) {
  $template = $content['template'];
  $action = $content['action'];
  $title = htmlspecialchars($content['title']);
  $path = htmlspecialchars(url($content['path'], array('absolute' => TRUE)));
  $xml = "<userAction><template>$template</template><actionName>$action</actionName><templateFields><templateField><name>thing</name><text>$title</text><href>$path</href></templateField></templateFields></userAction>";
  return $xml;
}

function _gigya_calc_signature($secretkey, $httpmethod, $apimethod, $parameters) {
  require_once("OAuth.inc");
  $req = OAuthRequest::from_request($httpmethod, 'http://socialize.api.gigya.com/socialize.'. $apimethod, $parameters);
  return base64_encode(hash_hmac('sha1', $req->get_signature_base_string(), base64_decode($secretkey), TRUE));
}

/**
  * Internal helper function to deal cleanly with various HTTP response codes.
  */
function _gigya_request_failure($results, $return_error = FALSE) {

  $code = $results->code;
  $errormsg = '';
  if($code == 200) {
    $result = _gigya_convert_xml_to_array($results->data);
    $code = intval($result['statusCode']);
    $errormsg = $result['errorMessage'];
    $errorcode = $result['errorCode'];
    if(!$errorcode) 
      $errorcode = $code;
  }
  
	if ($code != 200 ) {
		$xxx = gigya_printObject('results ', $results);
  		watchdog('gigya', '_gigya_request_failure ' . $xxx);
	}  
  
  
  switch ($code) { //see if there is a issue with the request on the http level
    case 302:
      watchdog('gigya', $errorcode . ' Missing Schema. ' . $errormsg);
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 304:
      // 304 Not Modified: there was no new data to return.
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 400:
      // 400 Bad Request: your request is invalid, and we'll return an error message that tells you why. This is the status code returned if you've exceeded the rate limit
      watchdog('gigya', $errorcode . ' Bad Request. ' . $errormsg);      
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 401:
      // 401 Not Authorized: either you need to provide authentication credentials, or the credentials provided aren't valid.
      watchdog('gigya', $errorcode . ' Not Authorized. ' . $errormsg);      
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 403:
      // 403 Forbidden: we understand your request, but are refusing to fulfill it.  An accompanying error message should explain why.
      watchdog('gigya', $errorcode . ' Forbidden. ' . $errormsg);      
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 404:
      // 404 Not Found: either you're requesting an invalid URI or the resource in question doesn't exist (ex: no such user)
      watchdog('gigya', $errorcode . ' Not Found. ' . $errormsg);
      drupal_set_message('Gigya Socialize Error: code(' . $errorcode . ') Not Found. ' . $errormsg,'error');
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 500:
      // 500 Internal Server Error: we did something wrong.  Please post to the group about it and the Gigya team will investigate.
      watchdog('gigya', $errorcode . ' Internal Server Error. ' . $errormsg);  	  
  	  if ( !(strpos($errormsg,'Data Pending'))) {
      	drupal_set_message('Gigya Socialize Error: code(' . $errorcode . ') Internal Server Error. ' . $errormsg,'error');
      }
       
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 502:
      // 502 Bad Gateway: returned if Gigya is down or being upgraded.
      watchdog('gigya', $errorcode . ' Bad Gateway. ' . $errormsg);                
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
    case 503:
      // 503 Service Unavailable: the Gigya servers are up, but are overloaded with requests.  Try again later.
      watchdog('gigya', $errorcode . ' Service Unavailable. ' . $errormsg);
      drupal_set_message('Gigya Socialize Error: code(' . $errorcode . ') Service Unavailable. ' . $errormsg,'error');
      if ($return_error)
        return $errorcode;
      else
        return TRUE;
  }
  // 200 OK: everything went awesome.
  return FALSE;
}

/**
 * Internal XML munging code
 */

function _gigya_convert_xml_to_array($data) {
  $xml = new SimpleXMLElement($data);
  return get_object_vars($xml);
}



