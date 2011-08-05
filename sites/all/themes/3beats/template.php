<?php
// $Id: template.php,v 1.16.2.1 2009/02/25 11:47:37 goba Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
  if ($left != '' && $right != '') {
    $class = 'sidebars';
  }
  else {
    if ($left != '') {
      $class = 'sidebar-left';
    }
    if ($right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
  $vars['celebrity_search'] = drupal_get_form('search_celebrity');




  // Generate menu tree from source of primary links
  $vars['primary_links_tree'] = menu_tree(variable_get('menu_primary_links_source', 'primary-links'));
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if ($language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}

function user_picture_custum($uid)
{
    $sql_result = db_fetch_object(db_query("SELECT picture FROM users WHERE uid='$uid'"));
    if(!empty($sql_result->picture))
    {
    	$user_picture = $sql_result->picture;
    }
    else
    {

      $user_picture = 'sites/all/themes/mapendo/images/underTestimonial_img.jpg';
    }

    return  $user_picture;
}

function get_user_name($uid)
{
   $sql = db_fetch_object(db_query("SELECT name FROM users WHERE uid='$uid'"));
   $userName = $sql->name;
   return $userName;
}

function datetime_format($date)
{
	global $arr_month_short;
	if (strlen($date) >= 10) {
		if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		}
		$mktime	= mktime(substr($date, 11, 2), substr($date, 14, 2), substr($date, 17, 2),substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		return date("M j, Y h:i A ", $mktime);
	} else {
		return $s;
	}
}

function mission_data()
{
 $mission = db_fetch_object(db_query("SELECT *  FROM variable WHERE name='site_mission'"));
 $data= unserialize($mission->value);
 return $data;
}

function home_page_slogan()
{
  $node_id =  db_fetch_object(db_query("SELECT nid FROM node WHERE nid='69'"));

  $htitle = node_load($node_id->nid);
    return $htitle->body;
}

function _contact_mail_page() {echo "kkkkkkkkkkkkkkkkkkkkkkk";die;
  global $user;

  $form = $categories = array();

  $result = db_query('SELECT cid, category, selected FROM {contact} ORDER BY weight, category');
  while ($category = db_fetch_object($result)) {
    $categories[$category->cid] = $category->category;
    if ($category->selected) {
      $default_category = $category->cid;
    }
  }

  if (count($categories) > 0) {
    $form['#token'] = $user->uid ? $user->name . $user->mail : '';
    $form['contact_information'] = array('#value' => filter_xss_admin(variable_get('contact_form_information', t('You can leave a message using the contact form below.'))));
    $form['name'] = array('#type' => 'textfield',
      '#title' => t('Your name'),
      '#maxlength' => 255,
      '#default_value' => $user->uid ? $user->name : '',
      '#required' => TRUE,
    );
    $form['mail'] = array('#type' => 'textfield',
      '#title' => t('Your e-mail address'),
      '#maxlength' => 255,
      '#default_value' => $user->uid ? $user->mail : '',
      '#required' => TRUE,
    );
    $form['subject'] = array('#type' => 'textfield',
      '#title' => t('Subject'),
      '#maxlength' => 255,
      '#required' => TRUE,
    );
    if (count($categories) > 1) {
      // If there is more than one category available and no default category has been selected,
      // prepend a default placeholder value.
      if (!isset($default_category)) {
        $default_category = t('- Please choose -');
        $categories = array($default_category) + $categories;
      }
      $form['cid'] = array('#type' => 'select',
        '#title' => t('Category'),
        '#default_value' => $default_category,
        '#options' => $categories,
        '#required' => TRUE,
      );
    }
    else {
      // If there is only one category, store its cid.
      $category_keys = array_keys($categories);
      $form['cid'] = array('#type' => 'value',
        '#value' => array_shift($category_keys),
      );
    }
    $form['message'] = array('#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    );
    // We do not allow anonymous users to send themselves a copy
    // because it can be abused to spam people.
    if ($user->uid) {
      $form['copy'] = array('#type' => 'checkbox',
        '#title' => t('Send yourself a copy.'),
      );
    }
    else {
      $form['copy'] = array('#type' => 'value', '#value' => FALSE);
    }
    $form['submit'] = array('#type' => 'submit',
      '#value' => t('Send e-mail'),
    );
  }
  else {
    drupal_set_message(t('The contact form has not been configured. <a href="@add">Add one or more categories</a> to the form.', array('@add' => url('admin/build/contact/add'))), 'error');
  }
  return $form;
}

/**
 * Process variables for node.tpl.php
 *
 * The $vars array contains the following arguments:
 * - $node
 * - $teaser
 * - $page
 *
 * @see node.tpl.php
 */
function beats_preprocess_node(&$vars, $hook) {
  $node = $vars['node'];

  if ($node->build_mode === NODE_BUILD_NORMAL || $node->build_mode === NODE_BUILD_PREVIEW) {
    $build_mode = $vars['teaser'] ? 'teaser' : 'full';
  }
  elseif ($node->build_mode === NODE_BUILD_RSS) {
    $build_mode = 'rss';
  }
  else {
    $build_mode = $node->build_mode;
  }
  $vars['template_files'][] = 'node--'. $build_mode;
  $vars['template_files'][] = 'node-'. $node->type .'-' . $build_mode;
  $vars['template_files'][] = 'node-'. $node->type .'-' . $build_mode .'-'. $node->nid;
  $preprocess = array(
    'beats_preprocess_node_'. $node->type,
    'beats_preprocess_node__'. $build_mode,
    'beats_preprocess_node_'. $node->type .'_'. $build_mode,
    'beats_preprocess_node_'. $node->type .'_'. $build_mode .'_'. $node->nid
  );
  foreach (array_reverse($preprocess) as $function) {
    if (function_exists($function)) {
      $function($vars);
      break;
    }
  }
}

function beats_theme() {
  return array(
      'beats_rating_theme' => array(
      'arguments'          => array('params' => NULL),
      'template'           => 'beats-rating-theme',
      'path'               => drupal_get_path('themes', '3beats') . '/themes'
    ),
      'beats_chart_theme'  => array(
      'arguments'          => array('params' => NULL),
      'template'           => 'beats-chart-theme',
      'path'               => drupal_get_path('themes', '3beats') . '/themes'
    ),
      'box' => array(
      'arguments' => array('title' => NULL, 'content' => NULL, 'region' => 'main'),
      'template' => 'box',
      'path' => drupal_get_path('themes', '3beats')
    ),

  );
}

function beats_preprocess_node_celebrity(&$vars) {
  global $user;

  $node = node_load(arg(1));

  /*
   * Clelebrity Image
   */
	if(is_array($node->taxonomy)) {
  		foreach($node->taxonomy as $termID => $termData) {
  			if($termData->vid == 1) {
  				$category = $termData->name;
  			}		
  		}
  	}
  
  
  $CelebImageUrl = three_beats_celebrity_imagecache('189x245', $node);
  $vars['celebrity_image'] = "<img src='$CelebImageUrl' class='celeb_img' />";


  /**
   * Chart
   */
  $rating_data  = _beats_get_rating_data($node, '2d');
  $rating_chart = _beats_get_rating_chart($rating_data);

  $vars['chart'] = theme('beats_chart_theme', array(
    'celebrity_node'  => $node,
    'rating_data'     => $rating_data,
    'rating_chart'    => $rating_chart,
  ));

  /**
   * RSS Feed
   */
  $url = $node->field_rss[0]['url'];
  $feeds = array();
  if(!empty($url)) {
	  $rss = simplexml_load_file($url);
	  if ($rss->channel->item) {
	    foreach ($rss->channel->item as $item) {
	      $feeds[] = array(
	        'title'       => $item->title,
	        'link'        => $item->link,
	        'description' => strip_tags($item->description),
	      );
	      break;
	    }
	    !empty($feeds[0]) ? $vars['feed'] = $feeds[0] : $vars['feed'] = NULL;
	  }
  }
  /**
   * View Celebrity
   * @todo if anonymous user voting is allowed, than how do we achive it. IP Address?
   */
  $view = views_get_view_result('celebrity', 'block_2', $user->id, arg(1));
  if ($user->uid > 0 && is_array($view) && !count($view) > 0) {
    $vars['form_rating'] = theme('beats_rating_theme', array(
      'form' => drupal_get_form('beats_form_rating'),
    ));
  }

  /**
   * Last User Comments
   */
  if ($user->uid > 0 && is_array($view) && count($view) > 0) {
    $node = array_shift($view);
    $node = node_load($node->nid);
    $vars['form_vote_comment'] = $node->field_vote_comment[0]['value'];
  }

  /**
   * Celebrity User Comments
   */
  $vars['celebrity_comments'] = views_embed_view('celebrity', 'block_3', arg(1));

  /**
   * Celebrity Articles
   */
  $vars['celebrity_articles'] = views_embed_view('article', 'block_2', arg(1));

/**
   * Similar Celebrities
   */
  $similar_celebrities = array();
  $celebrities_node = node_load(arg(1));
  if (!empty($celebrities_node->field_related_celebrities) && is_array($celebrities_node->field_related_celebrities)) {
    foreach ($celebrities_node->field_related_celebrities as $value) {
      if (!array_key_exists($value['nid'], $similar_celebrities)) {
        $similar_celebrities[$value['nid']] = node_load($value['nid']);
      }
    }
  }
  $tmp = similarterms_list(2, arg(1));
  if (!empty($tmp) && is_array($tmp)) {
    foreach ($tmp as $value) {
      if (!array_key_exists($value->nid, $similar_celebrities)) {
        $similar_celebrities[$value->nid] = $value;
      }
    }
  }
  $vars['similar_celebrities'] = $similar_celebrities;
}

/**
 * Creating rating and comment form
 * @param $form_state mixed
 * @return drupal form
 */
function beats_form_rating(&$form_state) {
  global $user;

  $form = array();

  $form['rank1'] = array(
    '#id'         => 'beats_button_m2',
    '#name'       => 'beats_button_m2',
    '#type'       => 'button',
    '#attributes' => array(
      'onblur'    => 'return false;',
      'class'     => 'beats_button_m2 buttun',
    ),
  );

  $form['rank2'] = array(
    '#id'         => 'beats_button_m1',
    '#name'       => 'beats_button_m1',
    '#type'       => 'button',
    '#attributes' => array(
      'onblur'    => 'return false;',
      'class'     => 'beats_button_m1 buttun',
    ),
  );

  $form['rank3'] = array(
    '#id'         => 'beats_button_p1',
    '#name'       => 'beats_button_p1',
    '#type'       => 'button',
    '#attributes' => array(
      'onblur'    => 'return false;',
      'class'     => 'beats_button_p1 buttun',
    ),
  );

  $form['rank4'] = array(
    '#id'         => 'beats_button_p2',
    '#name'       => 'beats_button_p2',
    '#type'       => 'button',
    '#attributes' => array(
      'onblur'    => 'return false;',
      'class'     => 'beats_button_p2 buttun',
    ),
  );

  $form['comment'] = array(
    '#id'         => 'beats_comment_textbox',
    '#name'       => 'beats_comment_textbox',
    '#type'       => 'textarea',
    '#required'   => TRUE,
    '#maxlength'  => 200,
    '' => '',
    '#value'      => t('Leave your Comment here...'),
    '#prefix'     => '<div id="beats_comment_state">',
    '#suffix'     => '</div>',
    '#attributes' => array(
    ),
  );

  $form['rating_value'] = array(
    '#id'     => 'rating_value',
    '#name'   => 'rating_value',
    '#type'   => 'hidden',
    '#value'  => '0',
  );

  /**
   * Validate handler
   */
  $form['#validate'] = array(
    'beats_form_rating_validator',
  );

  /**
   * Submit handler
   * @var unknown_type
   */
  $form['#submit'] = array(
    'beats_form_rating_submitted',
  );

  $form['submit'] = array(
    '#id'         => 'submit1',
    '#name'       => 'submit1',
    '#type'       => 'submit',
    '#prefix'     => '<div id="beats_submit_buttons">',
    '#suffix'     => '</div>',
    '#attributes' => array(
      'class'     => 'beats_submitbtn',
    ),
  );

  return $form;
}

/**
 * @param $form drupal form
 * @param $form_state mixed
 */
function beats_form_rating_validator($form, &$form_state) {}

/**
 *
 * @param $form drupal form
 * @param $form_state mixed
 */
function beats_form_rating_submitted($form, &$form_state) {
  global $user;
  three_beats_rest_create_vote($user, '', $form_state['clicked_button']['#post']['beats_comment_textbox'], (($form_state['clicked_button']['#post']['rating_value']) + 2) * 25, arg(1), $arcicleid = NULL, '3beats');
}

function beats_preprocess_search_results(&$variables) {
  $variables['pager_custom'] = $variables['results']['pager'];
  $variables['search_results_celeb'] = '';
  $variables['search_results_user'] = '';

  foreach ($variables['results'] as $result) {
  	if ($result['attributes']=='celeb'){
      $variables['search_results_celeb'] .='<div class="res_celeb">'.theme('search_result', $result, $variables['type']).'</div>';
  	}
  	else if ($result['attributes']=='user'){
      $variables['search_results_user'] .='<div class="res_user">'.theme('search_result', $result, $variables['type']).'</div>';
  	}
  }

  $variables['pager'] = theme('pager', NULL, 5, 0);
  // Provide alternate search results template.
  $variables['template_files'][] = 'search_results_'.$variables['type'];

}


 /**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function beats_preprocess_page(&$vars, $hook) {
  $vars['service_link'] = views_embed_view('service_link' , 'block_1');
}

function beats_imagecache($presetname, $path, $alt = '', $title = '', $attributes = NULL, $getsize = TRUE) {


  if((in_array($presetname, array('user_avatar','48x48','189x245' , 'celebrity_80x80'
  )) || !$presetname) && (!file_exists($path) || !$path)){


    $path = drupal_get_path('theme','3beats').'/images/defaults_img.png';
  }
  // Check is_null() so people can intentionally pass an empty array of
  // to override the defaults completely.
  if (is_null($attributes)) {
    $attributes = array('class' => 'imagecache imagecache-'. $presetname);
  }
  if ($getsize && ($image = image_get_info(imagecache_create_path($presetname, $path)))) {
    $attributes['width'] = $image['width'];
    $attributes['height'] = $image['height'];
  }

  $attributes = drupal_attributes($attributes);

  $imagecache_url = $presetname ? imagecache_create_url($presetname, $path) : $path;
  return '<img src="'. $imagecache_url .'" alt="'. check_plain($alt) .'" title="'. check_plain($title) .'" '. $attributes .' />';
}

