<?php  $count        = $fields['counter']->content;
  $sum          = $view->result[$count]->sss_sum;
  $rate         = $view->result[$count]->sss_sum_dev_count;
  $name         = $fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content;
  $plus_first   = round ($view->result[0]->sss_sort_vote,0) ;
  $plus_last    = round ($view->result[sizeof($view->result)]->sss_sort_vote,0) ;
  $del          = ($plus_first-$plus_last)/8;
  $plus         = $view->result[$count]->sss_sort_vote;
  $kub          = $plus/$del+2;
  $height_div   = ($kub*14.3);
  $node = node_load($fields['nid']->raw);  $CelebImageUrl = three_beats_celebrity_imagecache('celebrity_80x80', $node);;  
?>
<div class="top-10-item">
    <div class="top-10-thumb top-10-thumbup"><span><?php //print '+'.round($plus,0); ?></span></div>
    <div class="top-10-item-content gainers">
        <div class="top-10-avatar">		  <?php print l("<img src='".$CelebImageUrl."' title='".$fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content."' class='celeb_img' />", 'node/' . $fields['nid']->raw, array('html' => TRUE)) ; ?>        </div>
        <div class="top-10-rating align-bottom">
            <div class="top-10-rating-value top-10-rating-gainers" id="<?php print $fields['field_lastname_value']->content?>_rate" style="height:<?php if ($plus){ print $height_div;} else {print '5';}?>px!important">&nbsp;</div>
        </div>
    </div>
</div>
