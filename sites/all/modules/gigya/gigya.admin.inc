<?php
// $Id: gigya.admin.inc,v 1.1.2.23.2.11 2010/05/20 02:16:20 azinck Exp $

/**
 * @file
 * This module provides a link to Gigya profiles from a users' drupal account.
 *
 * Development of this module is sponsered by gigya, Inc
 *
 * @package gigya
 */

/**
 * Constants defined for gigya system settings
 */
define('GIGYA_MODULE_VERSION', 'gigya-6.x-2.1');
define('GIGYA_ALREADY_DRUPAL_USER', 'already_drupal_user');
define('ONLY_SOCIALIZE_USER','only_socialize_user');
define('GIGYA_ENABLE_FACEBOOK_POPULATION','gigya_enable_facebook_population');
define('GIGYA_POPULATE_NON_REG_PROFILE_FIELDS','gigya_populate_non_reg_profile_fields');
define('GIGYA_DEFAULT_ICONSIZE', 30);
define('GIGYA_DEFAULT_LOGINUI_WIDTH', '120');
define('GIGYA_DEFAULT_LOGINUI_HEIGHT', '110');
define('GIGYA_DEFAULT_LOGINUI_COLOR_BACKGROUND', '#ffffff');
define('GIGYA_DEFAULT_LOGINUI_COLOR_FRAME', '#DFDFDF');
define('GIGYA_DEFAULT_LOGINUI_COLOR_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_LOGINUI_COLOR_LINK', '#0066CC');
define('GIGYA_DEFAULT_LOGINUI_COLOR_NAVIGATION_ARROW', '#79BCFD');
define('GIGYA_DEFAULT_LOGINUI_COLOR_CAPTION_BACKGROUND', '#4692DE');
define('GIGYA_DEFAULT_LOGINUI_COLOR_CAPTION_TEXT', '#FFFFFF');
define('GIGYA_DEFAULT_LOGINUI_COLOR_BUTTON_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_LOGINUI_COLOR_BACKGROUND_TRANSPARENT', TRUE);
define('GIGYA_DEFAULT_LOGINUI_CONTAINERID', 'divGigyaLogin');
define('GIGYA_DEFAULT_LOGINUI_USEHTML', TRUE);
define('GIGYA_DEFAULT_FRIENDSUI_WIDTH', '360');
define('GIGYA_DEFAULT_FRIENDSUI_HEIGHT', '400');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_BACKGROUND', '#ffffff');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_FRAME', '#DFDFDF');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_LINK', '#0066CC');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_NAVIGATION_ARROW', '#79BCFD');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_CAPTION_BACKGROUND', '#4692DE');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_CAPTION_TEXT', '#FFFFFF');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_BUTTON_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_FRIENDSUI_COLOR_BACKGROUND_TRANSPARENT', TRUE);
define('GIGYA_DEFAULT_FRIENDSUI_CONTAINERID', 'friends');
define('GIGYA_DEFAULT_FRIENDSUI_SHOWCAPTION', FALSE);
define('GIGYA_DEFAULT_FRIENDSUI_CAPTIONTEXT', 'Select Friends');
define('GIGYA_DEFAULT_FRIENDSUI_LINKTITLE', 'View Site');
define('GIGYA_DEFAULT_CONNECTUI_WIDTH', '175');
define('GIGYA_DEFAULT_CONNECTUI_HEIGHT', '85');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_BACKGROUND', '#ffffff');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_FRAME', '#FFFFFF');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_LINK', '#0066CC');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_NAVIGATION_ARROW', '#79BCFD');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_CAPTION_BACKGROUND', '#4692DE');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_CAPTION_TEXT', '#FFFFFF');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_BUTTON_TEXT', '#3A3A3A');
define('GIGYA_DEFAULT_CONNECTUI_COLOR_BACKGROUND_TRANSPARENT', TRUE);
define('GIGYA_DEFAULT_CONNECTUI_CONTAINERID', 'divConnect');
define('GIGYA_DEFAULT_CONNECTUI_SHOWCAPTION', FALSE);
define('GIGYA_DEFAULT_CONNECTUI_CAPTIONTEXT', 'Select social networks');
define('GIGYA_DEFAULT_CONNECTUI_USEHTML', TRUE);
define('GIGYA_DEFAULT_SHARE_SUBJECT', 'A site recommendation for you');
define('GIGYA_DEFAULT_SHARE_MESSAGE', 'I wanted to recommend this site <br/>to you. I enjoy it and think you will like it.');
define('GIGYA_DEFAULT_SHARE_LINK_TITLE', 'Share with friends');
define('GIGYA_DEFAULT_SHARE_UI_LINK_TITLE', 'Share UI title');
define('GIGYA_DEFAULT_SHARE_UI_SUBJECT', 'Share UI: A site recommendation for you');
define('GIGYA_DEFAULT_SHARE_UI_MESSAGE', 'Share UI: I wanted to recommend this site <br/>to you. I enjoy it and think you will like it.');
define('GIGYA_DEFAULT_SHARE_UI_SHOW_EMAIL_BUTTON',TRUE);
define('GIGYA_DEFAULT_SHARE_UI_SHOW_MORE_BUTTON',TRUE);
define('GIGYA_DEFAULT_LOGINUI_FBCONNECT', TRUE);
/**
 *
 */
function gigya_admin_form() {
  global $user,$base_path ;
  include_once 'modules/user/user.pages.inc';
  module_load_include('inc', 'gigya');
  $capabilities = gigya_get_capabilities();
  $form = array();
   
  gigya_validate();

  $form['keys'] = array(
    '#type' => 'fieldset',
    '#title' => t('Gigya Socialize keys'),
    '#description' => t('Keys needed for connecting to the Gigya Socialize service.'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => -400,
  );
  $form['keys']['gigya_APIKey'] = array(
    '#type' => 'textfield',
    '#title' => t('Gigya API Key'),
    '#description' => t('Specify the gigya API key for this domain'),
    '#default_value' => variable_get('gigya_APIKey', ''),
    '#required' => TRUE,
    '#weight' => -300,
  );
  $form['keys']['gigya_SecretKey'] = array(
    '#type' => 'textfield',
    '#title' => t('Gigya Secret Key'),
    '#description' => t('Specify the gigya Secret (Base64 encoded) key for this domain'),
    '#default_value' => variable_get('gigya_SecretKey', ''),
    '#required' => TRUE,
    '#weight' => -200,
  );
  
  $form['gigya_selected_networks'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Networks available to socialize'),
    '#default_value' => variable_get('gigya_selected_networks', array()),
    '#options' => gigya_get_networks(),
    '#required' => TRUE,
    '#description' => t('Select the networks this site should be allowed to connect to via socialize'),
    '#weight' => -100,
  );

   $form['gigya_requiredCapabilities'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Required services for socialize'),
    '#default_value' => variable_get('gigya_requiredCapabilities', array('login'=>'login')),
    '#options' => $capabilities,
    '#description' => t('Choose which capabilities you wish to enable when users connect to social networks.'),
    '#weight' => -8,
  );
  
  $form['login_uiconfig'] = array(
    '#type' => 'fieldset',
    '#title' => t('Parameters for Login UIConfig'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['login_uiconfig']['gigya_login_surpress_login'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display only Socialize component in the login block (suppress Drupal login)'),
    '#default_value' => variable_get('gigya_login_surpress_login', FALSE),
    '#description' => t('Checking this option will disable normal drupal login. Admins can login via /user'),
  );
  
	$form['login_uiconfig']['gigya_login_hide_title'] = array(
    '#type' => 'checkbox',
    '#title' => t('Hide title of Gigya login block'),
    '#default_value' => variable_get('gigya_login_hide_title', FALSE),
  );
	
	$form['login_uiconfig']['gigya_login_form_position'] = array(
    '#type' => 'radios',
    '#title' => t('Position of Gigya login UI within login form'),
    '#default_value' => variable_get('gigya_login_form_position', 0),
    '#options' => array(t('Top'), t('Bottom')),
  );
	
  $form['login_uiconfig']['gigya_enable_linking'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable linking of social networks accounts'),
    '#default_value' => variable_get('gigya_enable_linking', TRUE),
    '#description' => t('Checking this option will enable users to login with their Social Network credentials and map those to the same Drupal user.'),
  );  
  
  $form['login_uiconfig']['gigya_login_uiconfig_terms'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show terms link'),
    '#default_value' => variable_get('gigya_login_uiconfig_terms', false),
    '#description' => t('Display the Gigya terms of service link'),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Login UI Title'),
    '#default_value' => variable_get('gigya_login_uiconfig_title', ''),
    '#description' => t('Leave blank for no title. Note: An override for this is
                        also available in the block configuration screen.'),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_width'] = array(
    '#type' => 'textfield',
    '#title' => t('UI Box Width'),
    '#default_value' => variable_get('gigya_login_uiconfig_width', GIGYA_DEFAULT_LOGINUI_WIDTH),
    '#description' => t('Select width for Login Box'),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_height'] = array(
    '#type' => 'textfield',
    '#title' => t('UI Box Height'),
    '#default_value' => variable_get('gigya_login_uiconfig_height', GIGYA_DEFAULT_LOGINUI_HEIGHT),
    '#description' => t('Select height for Login Box'),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_iconsize'] = array(
    '#type' => 'textfield',
    '#title' => t('Icon Size'),
    '#default_value' => variable_get('gigya_login_uiconfig_iconsize', GIGYA_DEFAULT_ICONSIZE),
    '#description' => t('How big should the social network icons be'),
  );
  /**
   * Colors for the loginUI. If colorpicker module is enabled, we'll use that instead.
   */
  $color_field_type = (function_exists('colorpicker_2_or_later') ? 'colorpicker_' : '') .'textfield';
  $form['login_uiconfig']['gigya_login_uiconfig_color_background'] = array(
    '#type' => $color_field_type,
    '#title' => t('Background'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_background', GIGYA_DEFAULT_LOGINUI_COLOR_BACKGROUND),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_background_transparent'] = array(
    '#type' => 'checkbox',
    '#title' => t('Transparent Background'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_background_transparent', GIGYA_DEFAULT_LOGINUI_COLOR_BACKGROUND_TRANSPARENT),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_frame'] = array(
    '#type' => $color_field_type,
    '#title' => t('Frame'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_frame', GIGYA_DEFAULT_LOGINUI_COLOR_FRAME),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Text'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_text', GIGYA_DEFAULT_LOGINUI_COLOR_TEXT),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_link'] = array(
    '#type' => $color_field_type,
    '#title' => t('Link'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_link', GIGYA_DEFAULT_LOGINUI_COLOR_LINK),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_navigation_arrow'] = array(
    '#type' => $color_field_type,
    '#title' => t('Navigation Arrow'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_navigation_arrow', GIGYA_DEFAULT_LOGINUI_COLOR_NAVIGATION_ARROW),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_caption_background'] = array(
    '#type' => $color_field_type,
    '#title' => t('Caption Background'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_caption_background', GIGYA_DEFAULT_LOGINUI_COLOR_CAPTION_BACKGROUND),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_caption_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Caption Text'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_caption_text', GIGYA_DEFAULT_LOGINUI_COLOR_CAPTION_TEXT),
  );
  $form['login_uiconfig']['gigya_login_uiconfig_color_button_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Button Text'),
    '#default_value' => variable_get('gigya_login_uiconfig_color_button_text', GIGYA_DEFAULT_LOGINUI_COLOR_BUTTON_TEXT),
  );
  $form['login_uiconfig']['login_advanced'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced LoginUI Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 2,
  );
  $form['login_uiconfig']['login_advanced']['gigya_login_uiconfig_urlredirect'] = array(
    '#type' => 'textfield',
    '#title' => t('URL redirect after login'),
    '#default_value' => variable_get('gigya_login_uiconfig_urlredirect', 'user'),
    '#description' => t('Choose an alternate URL to direct users to after login. Defaults to user. Do not use a beginning or ending slash!'),
  );
  $form['login_uiconfig']['login_advanced']['gigya_login_advanced_custombuttons'] = array(
    '#type' => 'textfield',
    '#title' => t('Custom Login Icons URL'),
    '#default_value' => variable_get('gigya_login_advanced_custombuttons', ''),
    '#description' => t('Choose an alternate URL to pull in flash button data'),
  );
  $form['login_uiconfig']['login_advanced']['gigya_login_uiconfig_containerID'] = array(
    '#type' => 'textfield',
    '#title' => t('LoginUI container ID'),
    '#default_value' => variable_get('gigya_login_uiconfig_containerID', GIGYA_DEFAULT_LOGINUI_CONTAINERID),
    '#description' => t('div ID for loginUI'),
    '#required' => TRUE,    
  );
  
  $form['login_uiconfig']['login_advanced']['gigya_login_uiconfig_useHTML'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Flash widget instead of HTML widget'),
    '#default_value' => !variable_get('gigya_login_uiconfig_useHTML', GIGYA_DEFAULT_LOGINUI_USEHTML)   
  );
  

  $form['login_uiconfig']['login_advanced']['gigya_login_advanced_raw'] = array(
    '#type' => 'textarea',
    '#title' => t('Login UIConfig Advanced coding (Overwrites above settings)'),
    '#default_value' => variable_get('gigya_login_advanced_raw', ''),
    '#description' => t('Use this textbox to put in your own settings. If you are
                        not using this box, make sure it is empty!'),
  );
  
  
 
  //connect UI
  $form['connect_uiconfig'] = array(
    '#type' => 'fieldset',
    '#title' => t('Parameters for Connect UIConfig'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['connect_uiconfig']['gigya_connect_uiconfig_captionText'] = array(
    '#type' => 'textfield',
    '#title' => t('ConnectUI Caption'),
    '#default_value' => variable_get('gigya_connect_uiconfig_captionText', GIGYA_DEFAULT_CONNECTUI_CAPTIONTEXT),
    '#description' => t('Leave blank for no title.'),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_terms'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show terms link'),
    '#default_value' => variable_get('gigya_connect_uiconfig_terms', false),
    '#description' => t('Display the Gigya terms of service link'),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_width'] = array(
    '#type' => 'textfield',
    '#title' => t('UI Box Width'),
    '#default_value' => variable_get('gigya_connect_uiconfig_width', GIGYA_DEFAULT_CONNECTUI_WIDTH),
    '#description' => t('Select width for Login Box'),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_height'] = array(
    '#type' => 'textfield',                       
    '#title' => t('UI Box Height'),
    '#default_value' => variable_get('gigya_connect_uiconfig_height', GIGYA_DEFAULT_CONNECTUI_HEIGHT),
    '#description' => t('Select height for Login Box'),
  );

  /**
   * Colors for the lconnectUI. If colorpicker module is enabled, we'll use that instead.
   */
  $color_field_type = (function_exists('colorpicker_2_or_later') ? 'colorpicker_' : '') .'textfield';
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_background'] = array(
    '#type' => $color_field_type,
    '#title' => t('Background'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_background', GIGYA_DEFAULT_CONNECTUI_COLOR_BACKGROUND),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_background_transparent'] = array(
    '#type' => 'checkbox',
    '#title' => t('Transparent Background'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_background_transparent', GIGYA_DEFAULT_CONNECTUI_COLOR_BACKGROUND_TRANSPARENT),
  );
  if (variable_get('gigya_connect_uiconfig_color_background_transparent', GIGYA_DEFAULT_CONNECTUI_COLOR_BACKGROUND_TRANSPARENT)) {
    variable_set('gigya_connect_uiconfig_color_background', '');
  }
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_frame'] = array(
    '#type' => $color_field_type,
    '#title' => t('Frame'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_frame', GIGYA_DEFAULT_CONNECTUI_COLOR_FRAME),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Text'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_text', GIGYA_DEFAULT_CONNECTUI_COLOR_TEXT),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_link'] = array(
    '#type' => $color_field_type,
    '#title' => t('Link'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_link', GIGYA_DEFAULT_CONNECTUI_COLOR_LINK),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_navigation_arrow'] = array(
    '#type' => $color_field_type,
    '#title' => t('Navigation Arrow'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_navigation_arrow', GIGYA_DEFAULT_CONNECTUI_COLOR_NAVIGATION_ARROW),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_caption_background'] = array(
    '#type' => $color_field_type,
    '#title' => t('Caption Background'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_caption_background', GIGYA_DEFAULT_CONNECTUI_COLOR_CAPTION_BACKGROUND),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_caption_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Caption Text'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_caption_text', GIGYA_DEFAULT_CONNECTUI_COLOR_CAPTION_TEXT),
  );
  $form['connect_uiconfig']['gigya_connect_uiconfig_color_button_text'] = array(
    '#type' => $color_field_type,
    '#title' => t('Button Text'),
    '#default_value' => variable_get('gigya_connect_uiconfig_color_button_text', GIGYA_DEFAULT_CONNECTUI_COLOR_BUTTON_TEXT),
  );
  $form['connect_uiconfig']['connect_advanced'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced ConnectUI Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 2,
  );
  $form['connect_uiconfig']['connect_advanced']['gigya_connect_uiconfig_containerID'] = array(
    '#type' => 'textfield',
    '#title' => t('connectUI container ID:'),
    '#default_value' => variable_get('gigya_connect_uiconfig_containerID', GIGYA_DEFAULT_CONNECTUI_CONTAINERID),
    '#description' => t('div ID for connectUI'),
  );
  $form['connect_uiconfig']['connect_advanced']['gigya_connect_uiconfig_useHTML'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use Flash widget instead of HTML widget'),
    '#default_value' => !variable_get('gigya_connect_uiconfig_useHTML', GIGYA_DEFAULT_CONNECTUI_USEHTML)
  );
  
  $form['connect_uiconfig']['connect_advanced']['gigya_connect_uiconfig_raw'] = array(
    '#type' => 'textarea',
    '#title' => t('ConnectUI Advanced coding (Overwrites above settings)'),
    '#default_value' => variable_get('gigya_connect_uiconfig_raw', ''),
    '#description' => t('Use this textbox to put in your own settings. If you are not using this box, make sure it is empty!'),
  );
  //we need to disable email verification, so the user just logs in.
  //$form['user_email_verification'] = array('#type' => 'value', '#value' => FALSE);
  //$form['user_mail_register_no_approval_required_notify'] = array('#type' => 'value', '#value' => TRUE);

  /*if (variable_get('user_pictures',0)) {
    $form['picture'] = array(
      '#type' => 'fieldset',
      '#title' => t('Gigya user profile picture'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );      
    
    $form['picture']['gigya_user_picture'] = array ( 
      '#type' => 'checkbox',
      '#title' => t('Allow users to associate loginProvider to user picture'),
      '#default_value' => variable_get('gigya_user_picture', FALSE),
      '#description' => t('Checking this option allows users to connect their user picture to their drupal profile picture'),
    );
  }*/
  if(module_exists('profile') || (module_exists('content') && module_exists('content_profile'))){
    // Start filling the mapping part
    $fields = array('--Not mapped--', 'username');
  }
  
  if (module_exists('profile')) {
    $form['profile'][GIGYA_POPULATE_NON_REG_PROFILE_FIELDS] = array(
      '#type' => 'checkbox', 	 
      '#title' => t('Map non-registration profile fields.'),
      '#description' => t('(You will have to save the configuration to see the change). Normally you can only map fields that are visible on your registration form.  Enabling this will allow you to map any of your profile fields.  Please note that this can cause unexpected behavior with some configurations.  Disable it if you are having problems.'), 
      '#default_value' => variable_get(GIGYA_POPULATE_NON_REG_PROFILE_FIELDS,FALSE),      
      '#weight' => -20,
    );
    


    // Gather profile fields (profile module)
    if ($profile_categories = profile_categories()) {
      $profile_fields = array();
      $category_names = array();
      foreach ($profile_categories as $category) {
        $category_names[$category['name']] = $category['name'];
        $profiles = profile_form_profile(NULL, NULL, $category['name'], !variable_get(GIGYA_POPULATE_NON_REG_PROFILE_FIELDS,TRUE));
        if ($profiles && $profiles[$category['name']]) {
          foreach ($profiles[$category['name']] as $field_name => $profile) {
            if (is_array($profile)) {
              $fields[] = $field_name;
            }
          }
        }
      }
    }
    else {
      drupal_set_message(t("Although the profile module is enabled, You currently have no profile categories created"));
    }
  }

  // Gather content profile fields
  if (module_exists('content') && module_exists('content_profile')) {
    $profile_types = content_profile_get_types('names');
    if (!empty($profile_types)) {
      $profile_type = key($profile_types);
      $typeinfo = content_types($profile_type);
      $fields = array_merge($fields, array_keys($typeinfo['fields']));
    }
  }
    
  if (!empty($fields)){
    // Build the mapping list
    $form['bio_mapping'] = array(
      '#type' => 'fieldset',
      '#title' => t('Gigya <=> Drupal Profile Mappings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    foreach (_gigya_get_profile_fields() as $field_key => $field_name) {
      if ($field_name != 'email') {
        $form['bio_mapping']['gigya_bio_'. $field_name] = array(
          '#type' => 'select',
          '#title' => $field_name,
          '#options' => array_combine($fields, $fields),
          '#default_value' => variable_get('gigya_bio_'. $field_name, ''),
        );
      }
      if ($field_name == 'gender') {
        $form['bio_mapping']['gigya_bio_gender'] = array_merge($form['bio_mapping']['gigya_bio_gender'], 
        array('#description' => t('Gender CCK field must have keys "m" and "f". Labels can be whatever needed')));
      }
      if ($field_name == 'nickname') {
        $form['bio_mapping']['gigya_bio_nickname'] = array_merge($form['bio_mapping']['gigya_bio_nickname'], 
        array('#description' => t('You may want to map this to "username"')));
      }
      if (strpos($field_name, 'birth') !== false) {
        $form['bio_mapping']['gigya_bio_'. $field_name] = array_merge($form['bio_mapping']['gigya_bio_'. $field_name], 
        array('#description' => t('You may map month, day, year to the same date CCK field')));
      }
    }
  }
  else {
    $form['bio_mapping'] = array(
      '#type' => 'item',
      '#title' => t('Profile Modules Disabled'),
      '#value' => t('If you wish to map profile settings to gigya settings, please enable the Profile module and/or the Content Profile module'),
    );
  }
  
  $form['Facebook fields Population'] = array(
    '#type' => 'fieldset',
    '#title' => t('Facebook fields Population'),   	
    '#collapsible' => TRUE,
    '#collapsed' => FALSE    
  );  
  
       
  $form['Facebook fields Population'][GIGYA_ENABLE_FACEBOOK_POPULATION] = array(
  	'#type' => 'checkbox', 	 
   	'#title' => t('Enable Facebook fields population'),
    '#description' => t('To enable Facebook fields population, click on the checkboxe above.'), 
  	'#default_value' => variable_get(GIGYA_ENABLE_FACEBOOK_POPULATION,FALSE),      
    '#weight' => -20,
  );
    
  $form['versionInfo'] = array(
    '#type' => 'fieldset',
    '#title' => t('Module Version Info'),   	
    '#collapsible' => TRUE,
    '#collapsed' => TRUE    
  );
  
  $form[versionInfo]['gigya_socialize_module_version'] = array(
  	'#type' => 'item', 	  	
    '#value' => t('Current module version: ' . GIGYA_MODULE_VERSION),       
    '#weight' => -25,
  );
  
  
  $form['#submit'][0] = 'gigya_admin_settings_form_submit';
  return system_settings_form($form);
}

function gigya_admin_settings_form_submit($form, &$form_state) {
  $form_state['values']['gigya_login_uiconfig_useHTML'] = !$form_state['values']['gigya_login_uiconfig_useHTML'];
  $form_state['values']['gigya_connect_uiconfig_useHTML'] = !$form_state['values']['gigya_connect_uiconfig_useHTML'];
  variable_set(GIGYA_ENABLE_FACEBOOK_POPULATION,$form_state['values'][GIGYA_ENABLE_FACEBOOK_POPULATION]);           
  variable_set(GIGYA_POPULATE_NON_REG_PROFILE_FIELDS,$form_state['values'][GIGYA_POPULATE_NON_REG_PROFILE_FIELDS]);
}