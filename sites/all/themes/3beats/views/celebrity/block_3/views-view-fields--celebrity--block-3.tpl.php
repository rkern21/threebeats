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

?>

<div class="celeb_cat_<?php print $cat ?> celeb_cat_<?php print $cat ?>_border celeb_stream_single" id="celeb_stream_single_<?php echo $fields['nid']->raw; ?>_<?php echo $fields['uid']->raw; ?>">
	<div class="celeb_stream_img_wrapper">
		<?php 				if($fields['field_twitter_profile_image_url_value']->raw)	{										$CelebImageUrl = three_beats_get_image($fields['field_twitter_profile_image_url_value']->raw, '/twitter_cached_images');					$CelebImageCachedUrl = imagecache_create_url('48x48', $CelebImageUrl);					$CelebImageUrl = $CelebImageCachedUrl;					print "<img src='$CelebImageUrl' title='".$fields['field_twitter_author_value']->content."' class='celeb_cat_stream_img' />";
				}else{					print l(theme('imagecache', 'user_cached_images_small', $fields['uid']->raw . '.jpg', '', $fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content, array('class'=>'celeb_cat_stream_img')), 'user/' . $fields['uid']->raw, array('html' => TRUE));	}		?>
	</div>
  <div class="celeb_stream_text" id="celeb_stream_text_<?php echo $fields['nid']->raw; ?>_<?php echo $fields['uid']->raw; ?>">
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
                        print ('style="left:70px;"');} ?> alt="" src="<?php print base_path().'sites/all/themes/3beats/images/twitter-feed.png'; ?>" class="sprites">
		<?php else: ?>
			<img <?php $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        if ( stristr($user_agent, 'MSIE 6.0') ){
                         print '';
                        }
                        if ( stristr($user_agent, 'MSIE 7.0') ){
                          print '';
                        }
                        else{
                        print ('style="left:70px;"');} ?> alt="" src="<?php print base_path().'sites/all/themes/3beats/images/sprite_user.png'; ?>" class="sprites <?php print $thumb ?> ">
		<?php endif; ?>
     </div>
    <span class="celeb_stream_name">
    <?php if(!empty($fields['field_twitter_author_value']->content)){
            print $fields['field_twitter_author_value']->content;
          }
          else {
            if ($fields['field_first_name_value']->content || $fields['field_last_name_value']->content) {
              print $fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content;
            }
            else {
              print $fields['name']->content;
            }
          } ?>:</span>
    <span class="celeb_stream_comment">
    <?php if (strlen($fields['field_vote_comment_value']->content)>144){
            print strip_tags(three_beats_site_word_wrap_wbr((substr(html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ,0,144).'...'), 18),'<p/> <br/> <wbr/>'); }
          else {
          	print strip_tags(three_beats_site_word_wrap_wbr(html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'), 18),'<p/> <br/> <wbr/>');
          } ?>
    <?php if (strlen($fields['field_vote_comment_value']->content)>144) : ?>
      <a href="#TB_inline?height=200&width=600&inlineId=hiddenComment_<?php echo $fields['nid']->raw; ?>" class="thickbox" title="<?php print $fields['field_first_name_value']->content.' '.$fields['field_last_name_value']->content; ?>"><?php print t('more') ?></a>
    <?php endif; ?>
    </span>
    <div id="hiddenComment_<?php echo $fields['nid']->raw; ?>" style="display: none">
    <p><?php print html_entity_decode(html_entity_decode($fields['field_vote_comment_value']->content, ENT_NOQUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
    <?php if (!empty($fields['field_article']->content)): ?>
    <?php else: ?>
    <br>
    <?php
     $dom=parse_url($fields['field_url_url_1']->content);
     $url_dom=$dom['host'];
		if(!empty($fields['field_twitter_author_value']->content))
		{
			print '<span class="celeb_stream_source"> from twitter.com </span>';
		}
		elseif (!empty($fields['field_url_url_1']->content))
		{
			print '<span class="celeb_stream_source"> '.t('From "').$fields['title']->content.'" / '.$url_dom.'</span>';
		}
		else {
			print '<span class="celeb_stream_source"> from 3beats.com </span>';
		} ?>
    <?php endif; ?>
  </div>
</div>