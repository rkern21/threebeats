<?php
// $Id: search-result.tpl.php,v 1.1.2.1 2008/08/28 08:21:44 dries Exp $

/**
 * @file search-result.tpl.php
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $type: The type of search, e.g., "node" or "user".
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type.
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 * - $info_split['upload']: Number of attachments output as "% attachments", %
 *   being the count. Depends on upload.module.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for their existance before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 *
 *   <?php if (isset($info_split['comment'])) : ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 *
 * To check for all available data within $info_split, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_result()
 */
?>

<?php if ( $result['attributes']=='celeb'): ?>

<?php
if ($result['tid']==21)
{
  $cat=t('fiveminfame');
  $catImage = "5 min. Fame";
}
else if($result['tid']==1)
{
  $cat=t('sports');
  $catImage = "Sports";
}
else if($result['tid']==20)
{
  $cat=t('business');
  $catImage = "Business";
}
else if ($result['tid']==2)
{
  $cat=t('entertainment');
  $catImage = "Entertainment";
}
else if ($result['tid']==3)
{
  $cat=t('politics');
  $catImage = "Politics";
}
else {
	$cat=t('business');
	$catImage = "Business";
}
$celebrity_node = node_load($result['nid']);
$CelebImageUrl = three_beats_celebrity_imagecache('48x48', $celebrity_node);
?>

 <div id="celeb_stream_items" class="celeb_cat_<?php print $cat ?> celeb_cat_<?php print $cat ?>_border">
	<div id="celeb_cat_bg" class="celeb_cat_img_bg celeb_cat_img_bg_<?php print $cat ?>" style="display:table-cell;">
		<a href="<?php print $result ["link"] ?>">
		<img src='<?php print $CelebImageUrl; ?>' title='<?php print $result["title"]; ?>' class='celeb_cat_img' />
		</a>
	</div>
	<div id="celeb_stream_single_search">
		<div id="celeb_stream_text" style="display:table-cell;padding-left:15px;">
			<span class="celeb_stream_name"><?php print $result["title"] ?><?php print $result["vote_rate"] ?></span><br />
			<span class="celeb_stream_comment"><?php print $result["descriptions"] ?></span>
			<br />
		</div>
	</div>
</div>
<?php endif;?>
<?php if ( $result['attributes']=='user'): ?>
<div id="celeb_stream_items" class="celeb_cat_entertainment celeb_cat_entertainment_border">
	<div id="celeb_cat_bg" style="display:table-cell;">
		<a href="<?php print $result ["link"] ?>">
		<img src='<?php print $CelebImageUrl; ?>' title='<?php print $result["title"]; ?>' class='celeb_cat_img' />
		</a>
	</div>
	<div id="celeb_stream_single_search">
		<div id="celeb_stream_text" style="display:table-cell;padding-left:15px;">
			<span class="celeb_stream_name"><?php print $result["title"] ?><?php print $result["vote_rate"] ?></span><br />
			<span class="celeb_stream_comment"><?php print $result["descriptions"] ?></span>
			<br />
		</div>
	</div>
</div>
<?php endif;?>