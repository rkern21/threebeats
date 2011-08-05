<div id="celeb_top_container">
    <div id="celeb_top_img">
    	<div>
    		<?php print $celebrity_image; ?>
    	</div>
    </div>
    <div id="celeb_top_bio">
    <p>
    <?php if (strlen($node->field_descriptions[0]['view'])>640) {
      print substr($node->field_descriptions[0]['view'],0,640).'.'.'.'.'.'; }
    else {
      print $node->field_descriptions[0]['view']; }
    ?>
    <?php if (!empty($node->field_celebrity_url[0]['value'])) : ?>
      <a href="<?php print $node->field_celebrity_url[0]['value'] ?>" target="_blank"><?php print t('more at Wikipedia') ?></a>
        <?php elseif (strlen($node->field_descriptions[0]['view'])>640) : ?>
        <a href="#TB_inline?height=395&width=600&inlineId=hiddenContent" class="thickbox" title="<?php $arg=arg(1); $sql_title=db_fetch_object(db_query("select title from node where nid='$arg'")); print $sql_title->title;?>"><?php print t('more') ?></a>
    <?php endif; ?>
    </p>
    </div>
    <div id="celeb_top_graph_wrapper">
        <?php print $chart; ?>
    </div>
</div>
<div id="vertical_divider"></div>
<div id="celeb_bottom_container">
    <div id="celeb_stream_wrapper">
        <h2 class="subheading"><?php echo t('Crowd Pulse'); ?></h2>
        <?php print $celebrity_comments; ?>
    </div>
    <div id="celeb_extras_wrapper">

        <h2 class="subheading"><?php echo t('The Latest'); ?></h2>
        <div id="celeb_pulse">
            <div id="beats_tagline">
             <?php if (!empty($form_rating)): ?>
            <?php print t('Now I think !celebrity_name is...',
                    array('!celebrity_name' => three_beats_substr_name ($node->field_firstname[0]['value'], $node->field_lastname[0]['value'], 19 )
                )); ?>
            </div>

            <div><?php print $form_rating; ?></div>
            <?php elseif (!empty($form_vote_comment)): ?>
            <div><p><?php// print $form_vote_comment; ?></p></div>
            <?php endif; ?>
        </div>

        <?php if (!empty($feed) && is_array($feed)): ?>
        <div id="celeb_extras">
            <h3 class="subheading"><?php echo t('From Website'); ?></h3>
            <p><?php print $feed['title']; ?></p>
            <p><?php print $feed['description']; ?></p>
        </div>
        <?php endif; ?>

        <?php if (!empty($celebrity_articles)): ?>
        <div id="celeb_extras">
            <h3 class="subheading">
                <?php print t('Latest news on !celebrity_name',
                    array('!celebrity_name' => three_beats_substr_name ($node->field_firstname[0]['value'], $node->field_lastname[0]['value'], 19 )
                )); ?>
            </h3>
            <div class="celeb_list_articles">
            <?php print $celebrity_articles; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($similar_celebrities) && is_array($similar_celebrities)): ?>
        <div id="celeb_extras">
            <h3 class="subheading"><?php print t('Similar Celebrities'); ?></h3>
            <div class="celeb_similar">
            <ul>
            <?php foreach ($similar_celebrities as $value): ?>
            <li><?php print l($value->field_firstname[0]['value'] . ' ' . $value->field_lastname[0]['value'], 'node/' . $value->nid, array('' => '')); ?></li>
            <?php endforeach; ?>
            </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<div id="hiddenContent" style="display: none">
      <div style="float:left;padding-top:23px;padding-bottom:10px;">
        <?php print $celebrity_image; ?>
      </div>
    <p><?php print $node->field_descriptions[0]['view']; ?></p>
</div>
<div style="clear: both;"></div>