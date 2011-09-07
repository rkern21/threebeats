<?php
  $count        = $fields['counter']->content;
  $sum          = $view->result[$count]->sss_sum;
  $rate         = $view->result[$count]->sss_sum_dev_count;
  $user_pulse   = $view->result[$count]->sss_sort_vote;
  $count_vote   =  ($rate == 0)?0:$sum/$rate;
  $name         = $fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content;
  $plus       	= round(((143 * $rate / 100) / 14.3), 0);
  $plus_first   = round ($view->result[0]->sss_sort_vote,0) ;
  $plus_last    = round ($view->result[sizeof($view->result)]->sss_sort_vote,0) ;
  $del          = ($plus_first-$plus_last)/8;
  $plus         = round ($view->result[$count]->sss_sort_vote,0);
  $kub          = round($plus/$del+2,0);
  $height_div   = ($kub*14.3);
  $user_info 	  = user_load(arg(1));

  $account_profile = content_profile_load('personal',$user_info->uid);
  if (isset($account_profile->field_first_name[0]['value']) && isset($account_profile->field_last_name[0]['value'])) { $user_info->name = $account_profile->field_first_name[0]['value'].' '.$account_profile->field_last_name[0]['value']; }

 // favorite of users
 $query1 = db_query("SELECT count( node.nid ) AS user_count, node.uid
					FROM node
					INNER JOIN content_field_celebrity AS cfc ON cfc.nid = node.nid
					WHERE cfc.field_celebrity_nid =".$fields['nid']->raw." GROUP BY node.uid");
 $users_favorite = array();

 while( $row = db_fetch_object($query1) ){
	$users_favorite[]=$row->uid;
 }

 $user_count_res = count($users_favorite);

 $user_ranking_time_days = variable_get('user_ranking_time',7);
 $user_ranking_time = time()-$user_ranking_time_days*60*60*24;

 $query2 = db_query("SELECT SUM(ctv.field_vote_rate_rating) AS sum_vote, count(*) AS count_vote FROM `content_field_celebrity` AS cfc
					INNER JOIN content_type_vote AS ctv ON cfc.nid = ctv.nid
					INNER JOIN node ON ctv.nid=node.nid
					WHERE cfc.field_celebrity_nid = ".$fields['nid']->raw." AND node.uid=".$user_info->uid." AND node.created > ".$user_ranking_time);

 $user_vote = db_fetch_object($query2);
 $res_user_vote = $user_vote->sum_vote/25 - $user_vote->count_vote*2;
  $node = node_load($fields['nid']->raw);  $CelebImageUrl = three_beats_celebrity_imagecache('48x48', $node);;
?>

<td width="33%">
	<table class="userceleb user-celeb-top"><tbody>
		<tr><th colspan="3"><?php print $name; ?></th></tr>
		<tr>
			<td rowspan="3">
				<div class="pic48">
					<?php print l("<img src='".$CelebImageUrl."' title='".$fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content."' class='celeb_img' />", 'node/' . $fields['nid']->raw, array('html' => TRUE)) ; ?>
				</div>
			</td>
			<td width="100"><?php print t('!user_name\'s Pulse:',array('!user_name'=>$user_info->name)); ?></td>
			<td> <?php print round($res_user_vote,0); ?> </td>
		</tr>
		<tr>
			<td><?php print t('Crowd Pulse:'); ?></td>
			<td> <?php print $plus; ?> </td>
		</tr>
		<tr><td colspan="2"><?php print t('Favorite of !user_count_res users',array('!user_count_res'=>$user_count_res) );  ?></td></tr>
	</tbody></table>
</td>