<?php
  $count        = $fields['counter']->content;
  $rate         = $view->result[$count]->sss_sum_dev_count;
  $name         = $fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content;
  $minus_first  =-1* round ($view->result[0]->sss_sort_vote,0) ;
  $minus_last   =-1* round ($view->result[sizeof($view->result)]->sss_sort_vote,0) ;
  $del          =($minus_first-$minus_last)/8;
  $minus        = -1*($view->result[$count]->sss_sort_vote);
  $kub          = $minus/$del+2;
  $height_div   = ($kub*14.7);  $node = node_load($fields['nid']->raw);
  $CelebImageUrl = three_beats_celebrity_imagecache('celebrity_80x80', $node);;
?>
<div class="top-10-item">
    <div class="top-10-thumb top-10-thumbdown"><span><?php //print'-'. round($minus,0); ?></span></div>
    <div class="top-10-item-content losers">
        <div class="top-10-rating">
            <div class="top-10-rating-value top-10-rating-losers" id="<?php print $fields['field_lastname_value']->content?>_rate" style="height:<?php if ($minus){ print ($height_div);} else {print '5';}?>px!important">&nbsp;</div>
        </div>
        <div class="top-10-avatar">         <?php print l("<img src='".$CelebImageUrl."' title='".$fields['field_firstname_value']->content . ' ' . $fields['field_lastname_value']->content."' class='celeb_img' />", 'node/' . $fields['nid']->raw, array('html' => TRUE)) ; ?>        </div>
    </div>
</div>