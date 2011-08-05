<?php

/**
 * @file
 * delete all Drush command
 */

/**
 * Implementation of hook_drush_command().
 */
function delete_all_drush_command() {
  $items = array();
  $items['delete-all'] = array(
    'callback' => 'delete_all_drush_delete',
    'description' => "Delete all nodes of a specific content type",
  );
  return $items;
}

/**
 * Implementation of hook_drush_help().
 */
function delete_all_drush_help($section) {
  switch ($section) {
    case 'drush:delete-all':
	return dt("Delete all nodes of a specific content type.");
  }
}

/**
 * Drush callback to delete content
 */
function delete_all_drush_delete() {
  $types = func_get_args();
  if ($types) {
      print "Deleted " . _delete_all_normal(FALSE, $types) . " nodes\n";
  } else {
      print "Content types and number of nodes:\n";
      // This should be refactored back into delete_all_content
      $result = db_query("SELECT type, COUNT(*) AS num FROM {node} GROUP BY type");
      $count = array();
      while ($data = db_fetch_object($result)) {
	  $count[$data->type] = $data->num;
      }
      foreach (node_get_types() as $type => $info) {
	  print $info->type .' '. ($count[$type] + 0) . "\n";
      }
  }
}
