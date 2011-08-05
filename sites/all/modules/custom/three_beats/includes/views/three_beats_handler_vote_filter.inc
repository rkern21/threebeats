<?php

class three_beats_handler_vote_filter extends views_handler_sort {
  /**
   * Called to add the sort to a query.
   */
  function query() {




    $base_table = 'node_data_field_firstname';
    $join = new views_join_complex();
    $our='(SELECT content_field_celebrity.field_celebrity_nid as seleb,
           COALESCE(SUM(content_type_vote.field_vote_rate_rating), 0) as sum,
           COUNT(*)as count,
           COALESCE(SUM(content_type_vote.field_vote_rate_rating)/COUNT(*),0) as sum_dev_count,  
		    (COALESCE((SUM(content_type_vote.field_vote_rate_rating)/25),0)-(COUNT(*)*2)) as sort_vote
           FROM content_type_vote
           INNER JOIN content_field_celebrity ON content_type_vote.nid = content_field_celebrity.nid
		    	 INNER JOIN node ON content_type_vote.nid = node.nid
			     WHERE node.uid ='.$this->view->args[0].'
           GROUP BY content_field_celebrity.field_celebrity_nid)';
    $join->construct($our, $base_table, 'node_data_field_firstname.nid', 'sss.seleb');
    $voite2=$this->query->add_relationship('sss',$join,$base_table);
    $this->query->add_field('',"sss.sum", 'sss_sum');

    if ($this->options['order']=='ASC'){
      $this->query->add_where('',"sum_dev_count <'%d'",50);
   }
    else if ($this->options['order']=='DESC'){
      $this->query->add_where('',"sum_dev_count >'%d'",50);
   }
    $this->query->add_orderby($voite2, 'sort_vote', $this->options['order']);
  }
}