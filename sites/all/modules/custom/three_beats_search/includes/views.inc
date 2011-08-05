<?php
/**
 * Implementation of hook_views_api().
 */
function three_beats_search_views_api() {
  return array(
    'api'   => 2,
    'path'  => drupal_get_path('module', 'three_beats_search') .'/includes/views'
  );
}


/**
 * Implementation of hook_views_data().
 */
function three_beats_search_views_data() {
  $data = array();

  $data['three_beats_search']['table']['group'] = t('Beats search');
  $data['three_beats_search']['table']['join'] = array(
    '#global' => array()
  );

  $data['three_beats_search']['celebrity_search'] = array(
    'title' => t('Celebrity'),
    'help' => t('Celebrity'),
    'argument' => array(
      'handler' => 'three_beats_search_handler_argument_celebrity',
      'parent' => 'views_handler_argument'
    ),
  );
  $data['three_beats_search']['users_search'] = array(
    'title' => t('User'),
    'help' => t('User'),
    'argument' => array(
      'handler' => 'three_beats_search_handler_argument_user',
      'parent' => 'views_handler_argument'
    ),
  );
 
	
  return $data;
}

/**
 * Implementation of hook_views_handlers().
 */
function three_beats_search_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'three_beats_search') .'/includes/views',
    ),
    'handlers' => array(
      'three_beats_search_handler_argument_celebrity' => array(
        'parent' => 'views_handler_argument'
      ),
      'three_beats_search_handler_argument_user' => array(
        'parent' => 'views_handler_argument'
      ),
    )
  );
}