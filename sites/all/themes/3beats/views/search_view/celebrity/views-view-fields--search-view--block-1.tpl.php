<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php

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
 $full_vote = db_fetch_object($query2);

?>

<?php

$node = (object)array('vid' => $fields['vid']->raw, 'taxonomy' => array(), 'nid' => $fields['nid']->raw);
$term=array_shift(taxonomy_node_get_terms_by_vocabulary($node, 1));

if ($term->tid==21)
{
  $cat=t('fiveminfame');
}
else if($term->tid==1)
{
  $cat=t('sports');
}
else if($term->tid==20)
{
  $cat=t('business');
}
else if ($term->tid==2)
{
  $cat=t('entertainment');
}
else if ($term->tid==3)
{
  $cat=t('politics');
}
else {
	$cat=t('business');
}
  $node = node_load($fields['nid']->raw);
  $CelebImageUrl = three_beats_celebrity_imagecache('48x48', $node);;
?>
<?php
 global $nids;
 $nids[]=$fields['nid']->raw;
?>

 <div id="celeb_stream_items" class="celeb_cat_<?php print $cat ?> celeb_cat_<?php print $cat ?>_border">
	<div id="celeb_cat_bg" class="celeb_cat_img_bg celeb_cat_img_bg_<?php print $cat ?>" style="display:table-cell;">
		<a href="<?php print url('node/' . $fields['nid']->raw) ?>">
			<?php print "<img src='$CelebImageUrl' title='".$fields["field_firstname_value"]->raw." ".$fields["field_lastname_value"]->raw."' class='celeb_cat_img' />"; ?>
		</a>
	</div>
	<div id="celeb_stream_single_search">
		<div id="celeb_stream_text"  style="width:300px;float:right;color:#3A85AF;font-size:14px;margin-left:5px;line-height:20px;list-style-type:none;"><?php 
			print views_embed_view('Articles', 'block_1', $fields['nid']->raw); ?>
			</div>
		<div id="celeb_stream_text" style="width:500px;display:table-cell;padding-left:15px;padding-top:10px;">
			<span class="celeb_stream_name_search" onclick="location.href='<?php print url('node/' . $fields['nid']->raw) ?>';"><?php print $fields['title']->content ?><?php if ( round($full_vote->sss_sort_vote,0) < 0 ) { print '('.round($full_vote->sss_sort_vote,0).')'; } if ( round($full_vote->sss_sort_vote,0) > 0 ) { print '(+'.round($full_vote->sss_sort_vote,0).')'; } ?></span><br />
			<span class="celeb_stream_comment"><?php print $fields["field_descriptions_value"]->content!='none' ? $fields["field_descriptions_value"]->content : '' ; ?></span>
			<br />
		</div>
		
	</div>
</div>
