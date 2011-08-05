<?php
// $Id: user-profile.tpl.php,v 1.2.2.2 2009/10/06 11:50:06 goba Exp $

/**
 * @file user-profile.tpl.php
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * By default, all user profile data is printed out with the $user_profile
 * variable. If there is a need to break it up you can use $profile instead.
 * It is keyed to the name of each category or other data attached to the
 * account. If it is a category it will contain all the profile items. By
 * default $profile['summary'] is provided which contains data on the user's
 * history. Other data can be included by modules. $profile['user_picture'] is
 * available by default showing the account picture.
 *
 * Also keep in mind that profile items and their categories can be defined by
 * site administrators. They are also available within $profile. For example,
 * if a site is configured with a category of "contact" with
 * fields for of addresses, phone numbers and other related info, then doing a
 * straight print of $profile['contact'] will output everything in the
 * category. This is useful for altering source order and adding custom
 * markup for the group.
 *
 * To check for all available data within $profile, use the code below.
 * @code
 *   print '<pre>'. check_plain(print_r($profile, 1)) .'</pre>';
 * @endcode
 *
 * Available variables:
 *   - $user_profile: All user profile data. Ready for print.
 *   - $profile: Keyed array of profile categories and their items or other data
 *     provided by modules.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 */
?>

<?php
	$account_profile = content_profile_load('personal',$account->uid);
	drupal_set_title($account_profile->field_first_name[0]['value'].'_'.$account_profile->field_last_name[0]['value'] )
  ?>

    <div id="contentbox">
        <div id="user-left-container" >
            <h1 class="user-page-name" style="font-size:20px;padding:23px 0 0 15px;"><?php if(isset($account_profile->field_first_name[0]['value']) || isset($account_profile->field_last_name[0]['value'])) { $printed_username = three_beats_substr_name ($account_profile->field_first_name[0]['value'], $account_profile->field_last_name[0]['value'], 18 ) ; } else { $printed_username =  $account->name; }
			print $printed_username;
			?>
			</h1>
            <div class="user-border">
                <div id="user-picture">
					<?php	print theme('imagecache', 'user_avatar', $account->picture ,'user avatar'); ?>
                </div>
                <div>
                    <span class="user-joined"><?php print t('Joined 3beats:') ?><?php print date('M Y',$account->created) ?></span>
                </div>
                <div id="shure_fb" style="color:black; display: none;"><?php print '<p style="text-align: center;">'.t('Are you sure you want to unlink your FB account?').'<p>'?>
                <p style="text-align: left; position:absolute; top:85px;left:80px;"><input type="submit" onclick="tb_remove()" value="&nbsp;&nbsp;YES&nbsp;&nbsp;" id="yes_fb"></p>
                <p style="text-align: right; position:absolute; top:85px;left:200px;"><input type="submit" onclick="tb_remove()" value="&nbsp;&nbsp;NO&nbsp;&nbsp;" id="no_fb"></p>
                </div>
                 <div id="shure_tw" style="color:black; display: none;"><?php print '<p style="text-align: center;">'.t('Are you sure you want to unlink your Twitter account?').'<p>'?>
                <p style="text-align: left; position:absolute; top:85px;left:80px;"><input type="submit" onclick="tb_remove()" value="&nbsp;&nbsp;YES&nbsp;&nbsp;" id="yes_fb"></p>
                <p style="text-align: right; position:absolute; top:85px;left:200px;"><input type="submit" onclick="tb_remove()" value="&nbsp;&nbsp;NO&nbsp;&nbsp;" id="no_fb"></p>
                </div>
                <?php
				if(strstr($account->name,'@facebook')){ $facebook_login=TRUE; } else {$facebook_login=FALSE;}
				if(strstr($account->name,'@twitter')){ $twitter_login=TRUE; } else {$twitter_login=FALSE;}
				?>
                <?php global $user; ?> <!-- need change after twitter integration! -->
                <?php if (($user->uid==arg(1))&&($user->uid!=1)){
                	    if ($facebook_login)  {
                	        $fb_tw='<div id="user-fb-settings" class="user-settings">'.
                                   '<h4>'. t('Facebook:').'</h4>'.
                                   '<p>'.$account_profile->field_facebook_email[0]['value'] .'</p>'.
                                   '<input type=checkbox '.$chk.'disable  name="facebook-posts" id="facebook-posts" style="margin-top:10px;vertical-align:top;">'.
                                   '<p style="padding:0;display:inline-block;width:100px;">'.
                                   t('Publish posts to Facebook wall').'</p>'.
                                   '<a href="#TB_inline?height=150&width=300&inlineId=shure_fb&modal=true" class="thickbox">'.t('unlink account').'</a>'.
                                   '</div>';
                	    }
                	    elseif($twitter_login)
						{
							$fb_tw='<div id="user-twitter-settings" class="user-settings">'.
                                   '<h4>'.t('Twitter:').'</h4>'.
                                   '<p>'.$printed_username.'</p>'.
                                   '<input type=checkbox id="facebook-posts" name="facebook-posts" style="margin-top:10px;vertical-align:top;">'.
                                   '<p style="padding:0;display:inline-block;width:100px;">'.t('Publish posts to
                                   Twitter').'</p>'.
                                   '<a href="#TB_inline?height=150&width=300&inlineId=shure_tw&modal=true" class="thickbox">'.t('unlink account').'</a>'.
                        	         '</div>';
                	    }
                	        $face_tw='<div style="margin-top:20px">'.
                                   '<h3>'.t('User Settings').'</h3>'.$fb_tw.'</div>';
                        print $face_tw;
                    }
                ?>
            </div>
        </div>
        <div id="user-right-container">
            <?php
            $block_1=views_embed_view('celebrity_rankings','block_1',$account->uid);
            $block_2=views_embed_view('celebrity_rankings','block_2',$account->uid);
            $block_3=views_embed_view('celebrity_rankings','block_3',$account->uid);
            $block_4=views_embed_view('celebrity_rankings','block_4',$account->uid);
            $block_5=views_get_view_result('celebrity_rankings','block_3',$account->uid);
            $block_6=views_get_view_result('celebrity_rankings','block_4',$account->uid);
            $validate_vote = views_get_view_result('validate_vote','block_1',$account->uid);
            if (count($validate_vote)<1):
            print t('<h1 style="font-size:25px;padding:21px 0 0 15px;">This user has revealed no Pulse</h1>');
            else :
            ?>
            <h1 style="font-size:25px;padding:21px 0 0 15px;"><?php if(isset($account_profile->field_first_name[0]['value']) || isset($account_profile->field_last_name[0]['value'])) { print $account_profile->field_first_name[0]['value'].' '.$account_profile->field_last_name[0]['value']; } else { print $account->name; } ?><?php print t('\'s Celebrity Rankings')?></h1>
            <h3><?php print t('Most Liked / Least Liked')?></h3>
            <div id="user-top-liked-container1" class="user-ranking-container">
           	    <div class="user-top-list">
                    <table style="table-layout: fixed;" width="100%">
						<tr>
							<?php print $block_1 ?>
						</tr>
						<tr>
							<?php print $block_2 ?>
						</tr>
                    </table>
                </div>
            </div>

            <h3><?php if (empty($block_5) && empty($block_6)){
                        print t('This user has revealed no Pulse');
                      }else {
                        print t('Gainers / Losers');}?>
            </h3>
            <div id="user-top-liked-container2" class="user-ranking-container">
                <div class="user-top-list">
                    <table style="table-layout:fixed;" width="100%">
						<tr>
							<?php print $block_3 ?>
						</tr>
						<tr>
							<?php print $block_4 ?>
						</tr>
				  	</table>
                </div>
            </div>
            <h3> <?php if(isset($account_profile->field_first_name[0]['value']) || isset($account_profile->field_last_name[0]['value'])) { print $account_profile->field_first_name[0]['value'].' '.$account_profile->field_last_name[0]['value']; } else { print $account->name; } ?><?php print t('\'s Pulse')?></h3>
            <div id="user_celeb_bottom_container" >
                <?php print views_embed_view('user_vote' , 'block_1',$account->uid) ?>
            </div>
            <?php endif;?>
        </div>
    </div>