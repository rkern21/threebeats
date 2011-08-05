<?php

class three_beats_handler_argument_article_url extends views_handler_argument {
  function query() {
    $base_table = 'node';

    $join = new views_join();
    $join->construct('content_type_article', $base_table, 'vid', 'vid');
    $url_table = $this->query->add_relationship('content_type_article', $join, $base_table);
    $this->query->add_where(0, "($url_table.field_url_url = '$this->argument')");
  }
}