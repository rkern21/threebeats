<?php 


// $Id: page.tpl.php,v 1.18.2.1 2009/04/30 00:13:31 goba Exp $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
   <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
   <META HTTP-EQUIV="expires" CONTENT="0">
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>

<body>

<?php  $base_url = url(NULL, array('absolute' => TRUE)); ?>

	<div class="mainbox">
<div class="mainContainer">
		<div class="mainContentBox">
			<div class="headerContainer">
				<div class="logoContainer">
				<?php
          // Prepare header
          $site_fields = array();
          if ($site_name) {
            $site_fields[] = check_plain($site_name);
          }
          if ($site_slogan) {
            $site_fields[] = check_plain($site_slogan);
          }
          $site_title = implode(' ', $site_fields);
          if ($site_fields) {
            $site_fields[0] = '<span>'. $site_fields[0] .'</span>';
          }
          $site_html = implode(' ', $site_fields);

          if ($logo || $site_title) {
            print '<a href="'. check_url($front_page) .'" title="'. $site_title .'">';
            if ($logo) {
              print '<img src="'. check_url($logo) .'" alt="'. $site_title .'" id="logo" />';
            }
            print $site_html .'</a>';
          }
        ?>
				</div>
				<div class="topright">
					<div style="height:80px; border:0px solid #ff0000;width:475px;">
						<div class="inner01"><?php print mission_data();?></div>

						<div class="inner02">
							<a href="<?php print base_path()?>blog/feed"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/top_icon01.gif" border="0" /></a><a href="http://twitter.com/home?status=Currently" target="blank"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/twitter.gif" border="0" /></a><a href="http://www.youtube.com/user/MapendoInternational" target="blank"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/youtube.gif"  border="0" /></a></a><a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/top_icon08.gif" border="0" /></a>  </div>
						
					</div>
				</div>
			
				<div class="topright_main" >
									<div class="topnavigation" > 
						<?php if (isset($primary_links)) : ?>
						  <?php print $primary_links_tree; /* UNCOMMENT FOR DROPDOWN MENU */?>
						  	<?php endif; ?>
                    </div>
                
                </div>
			
			
			</div>
			
		</div>
		<div class="newline"></div>
		<div style="margin-top:-30px;">
		<div class="left">
			<div class="lefttabs">
				<ul>
					<li><a href="<?php echo url('contribute');?>"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/makeaDonation_btn.gif" border="0" /></a></li>
				  <li><a href="<?php echo url('jointhecause');?>"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/jointheCause_btn.gif" border="0" /></a></li>
				  <li><a href="<?php echo url('epostcard');?>"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/tellaFriend.gif" border="0" /></a></li>
			  </ul>
				
			</div>
			<?php  if ($left_sidebar):?>
				<div class="eventsbox">
					 <?php echo  $left_sidebar; ?>
				 </div>
			 <?php endif; ?>
		</div>
        
        
        
        <!---->
		<div class="right">
         <!--<img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/about_banner.jpg" />-->
         
         <!--Internal page Content Starts -->
        <div class="interpage">
                   <?php //print $breadcrumb; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $help; ?>
          <div class="clear-block">
            <?php print $content ?>
            <?php print $feed_icons; ?>
          </div>
          </div>
          <!--Internal page Content Ends -->
		</div> <!-- Right Content Ends -->
	
	</div>
    <div class="newline01"></div>
     <div><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/draperRichards_logo.gif" /><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/globalLeadership.gif" /><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/echoingGreen.gif" /></div>
    
    	
	</div>
    <div class="newline"></div>
    <div class="footer">
	<?php print $newsletterblock;?>
	<!--<table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tr>
          <td colspan="4" style="height:4px;"></td>
        </tr>
        <tr>
          <td width="22%"><strong>Sign up for email address</strong></td>
          <td width="25%"><input name="textfield" type="text" id="textfield" value="Email Address" size="30" /></td>
          <td width="20%"><input name="textfield2" type="text" id="textfield2" value="Zip Code" /></td>
          <td width="32%"><a href="#"><img src="<?php echo $base_url ?>sites/all/themes/mapendo/images/go_btn.gif" width="33" height="15" border="0" /></a></td>
          <td width="1%">&nbsp;</td>
        </tr>
      </table>-->
    </div>
</div>
<div class="copyright">&copy;2010 Mapendo International. All Rights Reserved</div>

 <?php print $closure ?>
  </body>
</html>
