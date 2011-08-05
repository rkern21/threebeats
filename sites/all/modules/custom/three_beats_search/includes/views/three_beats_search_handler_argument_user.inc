<?php

class three_beats_search_handler_argument_user extends views_handler_argument {
  function query() {
    $base_table = 'node';
    
    if($this->argument){
      $keys_array = explode(' ', $this->argument);
      
      $join = new views_join();
      $join->construct('content_type_personal', $base_table, 'vid', 'vid');
      $search_table = $this->query->add_relationship('content_type_personal', $join, $base_table);
      
      foreach($keys_array as $id => $key){
        if(count($keys_array) == ($id + 1)){
          $this->query->add_where(0, "($search_table.field_first_name_value LIKE '%%%s%%' || $search_table.field_last_name_value LIKE '%%%s%%')", $key, $key);
        }else{
          $this->query->add_where(0, "($search_table.field_first_name_value = '%s' || $search_table.field_last_name_value = '%s')", $key, $key);
        }
      }  
    }
  }
}