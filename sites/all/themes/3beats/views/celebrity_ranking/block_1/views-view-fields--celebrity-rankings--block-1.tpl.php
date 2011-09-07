<?php
  $count        = $fields['counter']->content;
  $sum          = $view->result[$count]->sss_sum;
  $rate         = $view->result[$count]->sss_sum_dev_count;
  $user_pulse   = $view->result[$count]->sss_sort_vote;
  $count_vote   =  ($rate == 0)?0:$sum/$rate;
  $name         = $fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content;
  $plus      	  = round(((143 * $rate / 100) / 14.3), 0);
  $plus_first   = round ($view->result[0]->sss_sort_vote,0) ;
  $plus_last    = round ($view->result[sizeof($view->result)]->sss_sort_vote,0) ;
  $del          = ($plus_first-$plus_last)/8;
  $plus         = round ($view->result[$count]->sss_sort_vote,0);
  $kub          = round($plus/$del+2,0);
  $height_div   = ($kub*14.3);
  $user_info  	= user_load(arg(1));

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


 $query2 = db_query("SELECT sss.sort_vote AS sss_sort_vote
					FROM node node
					LEFT JOIN content_type_celebrity node_data_field_firstname ON node.vid = node_data_field_firstname.vid
					LEFT JOIN (SELECT content_field_celebrity.field_celebrity_nid as seleb,
					SUM(content_type_vote.field_vote_rate_rating) as sum,
					COUNT(*)as count,
				  SUM(content_type_vote.field_vote_rate_rating)/COUNT(*)+1 as sum_dev_count,  ((SUM(content_type_vote.field_vote_rate_rating)/25)-(COUNT(*)*2)) as sort_vote
					FROM content_type_vote
					INNER JOIN content_field_celebrity ON content_type_vote.nid = content_field_celebrity.nid
					GROUP BY content_field_celebrity.field_celebrity_nid) sss ON node_data_field_firstname.nid = sss.seleb
					WHERE (node.type in ('celebrity')) AND (node.nid =".$fields['nid']->raw.")
					ORDER BY sss_sort_vote DESC");
 $full_vote = db_fetch_object($query2);  $node = node_load($fields['nid']->raw);
  $CelebImageUrl = three_beats_celebrity_imagecache('48x48', $node);;
?>

<td width="33%">
	<table class="userceleb user-celeb-top"><tbody>
		<tr><th colspan="3"><?php print $name; ?></th></tr>
		<tr>
			<td rowspan="3">
				<div class="pic48">					<?php print l("<img src='".$CelebImageUrl."' title='".$fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content."' class='celeb_img' />", 'node/' . $fields['nid']->raw, array('html' => TRUE)) ; ?>
				</div>
			</td>
			<td width="100"><?php print t('!user_name\'s Pulse:',array('!user_name'=>$user_info->name)); ?></td>
			<td> <?php print round($user_pulse,0); ?> </td>
		</tr>
		<tr>
			<td> <?php print t('Crowd Pulse:'); ?> </td>
			<td> <?php print round($full_vote->sss_sort_vote,0); ?> </td>
		</tr>
		<tr><td colspan="2"><?php print t('Favorite of !user_count_res users',array('!user_count_res'=>$user_count_res) );  ?></td></tr>
	</tbody></table>
</td>