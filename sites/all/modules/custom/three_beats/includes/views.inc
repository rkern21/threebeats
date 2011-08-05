<?php
/**
 * Implementation of hook_views_api().
 */
function three_beats_views_api() {
  return array(
    'api'   => 2,
    'path'  => drupal_get_path('module', 'three_beats') .'/includes/views'
  );
}


/**
 * Implementation of hook_views_data().
 */
function three_beats_views_data() {
  $data = array();

  $data['three_beats']['table']['group'] = t('Beats Site');
  $data['three_beats']['table']['join'] = array(
    '#global' => array()
  );

  $data['three_beats']['article_url'] = array(
    'title' => t('Article URL'),
    'help' => t('Article URL'),
    'argument' => array(
      'handler' => 'three_beats_handler_argument_article_url',
      'parent' => 'views_handler_argument'
    ),
  );
  $data['three_beats']['name'] = array(
    'title' => t('SortCeleb'),
    'help' => t('SortCeleb'),
    'sort' => array(
      'handler' => 'three_beats_handler_sort_sortcel'
      )
  );
  
    $data['three_beats']['vote_filter'] = array(
    'title' => t('Vote filter'),
    'help' => t('Vote filter'),
    'sort' => array(
      'handler' => 'three_beats_handler_vote_filter'
      )
  );
	
	 $data['three_beats']['name2'] = array(
    'title' => t('SortCelebUser'),
    'help' => t('SortCelebUser'),
    'sort' => array(
      'handler' => 'three_beats_handler_sort_sortcel_user'
      )
  );
	
	
  return $data;
}

/**
 * Implementation of hook_views_handlers().
 */
function three_beats_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'three_beats') .'/includes/views',
    ),
    'handlers' => array(
      'three_beats_handler_argument_article_url' => array(
        'parent' => 'views_handler_argument'
      ),
       'three_beats_handler_sort_sortcel' => array(
        'parent' => 'views_handler_sort'
      ),
	    'three_beats_handler_vote_filter' => array(
        'parent' => 'views_handler_sort'
      ),
		'three_beats_handler_sort_sortcel_user' => array(
        'parent' => 'views_handler_sort'
      )	   
    )
  );
}