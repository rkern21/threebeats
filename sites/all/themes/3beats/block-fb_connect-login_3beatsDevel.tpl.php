<?php
// $Id$

global $user;

$account_profile = content_profile_load('personal',$user->uid);
if (!empty($account_profile)) {
        $name = $account_profile->field_first_name[0]['value'];
}
else {
        $tmp = explode(' ', $user->name, 1);
        $name = $tmp[0];
}

?>

<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">

  <div class="content">
                <?php
                if ($user->uid) {
                        echo '<div class="facebook_logged">';
                        
                        echo '<a href="#" class="facebook_logged">Hi ' . $name . '</a>';
                        echo '</div>';
                }
                else {
                        print $block->content;
                }
                ?>
  </div>

</div>