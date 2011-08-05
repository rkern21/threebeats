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
if ($fields['tid']->content==21){
  $cat=t('fiveminfame');
}
else if ($fields['tid']->content==1){
  $cat=t('sports');
}
else if ($fields['tid']->content==20){
  $cat=t('business');
}
else if ($fields['tid']->content==2){
  $cat=t('entertainment');
}
else if ($fields['tid']->content==3){
  $cat=t('politics');
}
else {
	$cat=t('business');;
}

?>

<?php

if ($fields['field_vote_rate_rating']->content==0){
  $thumb=t('thumb_m2');
}
else if ($fields['field_vote_rate_rating']->content==25){
  $thumb=t('thumb_m1');
}
else if ($fields['field_vote_rate_rating']->content==50){
  $thumb=t('thumb_none');
}
else if ($fields['field_vote_rate_rating']->content==75){
  $thumb=t('thumb_p1');
}
else if ($fields['field_vote_rate_rating']->content==100){
  $thumb=t('thumb_p2');
}

else {
  $thumb=t('thumb_none');
}

  $node = node_load($fields['nid']->raw);
  $CelebImageUrl = three_beats_celebrity_imagecache('48x48', $node);;

  

?>

<div id="celeb_cat_stream_items">
	<div class="celeb_title_cat celeb_title_cat_<?php print $cat ?>">
		<span class="celeb_title_name"><?php print $fields['field_firstname_value']->content.' '.$fields['field_lastname_value']->content?></span > <span>&nbsp;<!--(<?php /*print get_count_celebrities_by_vote_id($fields['nid']->raw)*/ ?> comments) --></span>
		<span class="celeb_title_comments"></span>
	</div>
	<div id="celeb_cat_comment">
    <div id="celeb_cat_bg" class="celeb_cat_img_bg celeb_cat_img_bg_<?php print $cat ?>">
			<span><?php print l("<img src='".$CelebImageUrl."' title='".$fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content."' class='celeb_cat_stream_img' />", 'node/' . $fields['nid']->raw, array('html' => TRUE)) ; ?> </span>
		</div>
		<div id="celeb_cat_stream_single" class="celeb_cat_<?php print $cat ?>">
<?php
	if($fields['field_twitter_profile_image_url_value']->raw) {
		$twitterCelebImageUrl = three_beats_get_image($fields['field_twitter_profile_image_url_value']->raw, '/twitter_cached_images');	
		$twitterCelebImageCachedUrl = imagecache_create_url('48x48', $CelebImageUrl);
		$CelebImageUrl = $CelebImageCachedUrl;
		print "<img src='".$twitterCelebImageUrl."' title='".$fields['field_twitter_author_value']->content."' class='celeb_cat_stream_img' />";
	}else {
		print l(theme('imagecache', '48x48', $fields['picture']->raw, '', $fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content, array('class'=>'celeb_cat_stream_img')), 'user/' . $fields['uid']->raw, array('html' => TRUE));
	}
?>
		<div id="celeb_stream_text">
        <div class="sprite">
          <?php if($fields['field_twitter_author_value']->content): ?>
            <img <?php $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        if ( stristr($user_agent, 'MSIE 6.0') ){
                         print '';
                        }
                        if ( stristr($user_agent, 'MSIE 7.0') ){
                          print '';
                        }
                        else{
                        print ('style="left:175px;"');} ?> alt="" src="<?php print base_path().'sites/all/themes/3beats/images/twitter-feed.png'; ?>" class="sprites">
          <?php else: ?>
            <img <?php $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        if ( stristr($user_agent, 'MSIE 6.0') ){
                         print '';
                        }
                        if ( stristr($user_agent, 'MSIE 7.0') ){
                          print '';
                        }
                        else{
                        print ('style="left:175px;"');} ?> alt="" src="<?php print base_path().'sites/all/themes/3beats/images/sprite_user.png'; ?>" class="sprites <?php print $thumb ?>">
          <?php endif; ?>
         </div>
				<span class="celeb_stream_name">
<?php 
	if (!empty($fields['field_twitter_author_value']->content)) {
		print $fields['field_twitter_author_value']->content;
	} else {
		if ($fields['field_first_name_value']->content || $fields['field_last_name_value']->content) {
			print l($fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content, 'user/' . $fields['uid']->raw, array('html' => TRUE));
		} else {
			/* typically goes here on the homepage 
			 * problem is that it displays the name twice
			 */
			print l($fields['name']->content, 'user/' . $fields['uid']->raw, array('html' => TRUE));
		}
	} 
?>
				</span>
				<span class="celeb_stream_comment">
        <?php if (strlen($fields['field_vote_comment_value']->content)>270){
                print three_beats_site_word_wrap_wbr((substr(html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ,0,270).'...'), 18 ); }
              else {
          	    print three_beats_site_word_wrap_wbr( html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') , 18 );
              }
        ?>
        <?php if (strlen($fields['field_vote_comment_value']->content)>270) : ?>
         <a href="#TB_inline?height=200&width=600&inlineId=hiddenComment_<?php echo $fields['nid']->raw; ?>" class="thickbox" title="<?php print $fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content; ?>"><?php print t('more') ?></a>
        <?php endif; ?>
        </span>
        <div id="hiddenComment_<?php echo $fields['nid']->raw; ?>" style="display: none">
        <p><?php print html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
				<br />
				<?php $dom=parse_url($fields['field_url_url']->content);
              $url_dom=$dom['host'];
               if(!empty($fields['field_twitter_author_value']->content)) {
                 print '<span class="celeb_stream_source"> from twitter.com </span>';
               }elseif (!empty($fields['field_url_url']->content)) {
                 print '<span class="celeb_stream_source"> '.t('From "').$fields['title_1']->content.'" / '.$url_dom.'</span>';
               }else {
                 print '<span class="celeb_stream_source"> from 3beats.com </span>';
               } ?>
      </div>
		</div>
	</div>
</div>