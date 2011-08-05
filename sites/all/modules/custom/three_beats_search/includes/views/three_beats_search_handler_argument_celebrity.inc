<?php

class three_beats_search_handler_argument_celebrity extends views_handler_argument {
  function query() {
    $base_table = 'node';
    
    if($this->argument){
      $keys_array = explode(' ', $this->argument);
      
      $join = new views_join();
      $join->construct('content_type_celebrity', $base_table, 'vid', 'vid');
      $search_table = $this->query->add_relationship('content_type_celebrity', $join, $base_table);
      
      foreach($keys_array as $id => $key){
        if(count($keys_array) == ($id + 1)){
          $this->query->add_where(0, "($search_table.field_firstname_value LIKE '%%%s%%' || $search_table.field_lastname_value LIKE '%%%s%%')", $key, $key);
        }else{
          $this->query->add_where(0, "($search_table.field_firstname_value = '%s' || $search_table.field_lastname_value = '%s')", $key, $key);
        }
      }
    }
  }
}