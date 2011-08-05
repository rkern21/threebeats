<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>">
<!--html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>"  xmlns:fb="http://www.facebook.com/2008/fbml"-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php print $head ?>
<title><?php print $head_title ?></title>
<?php print $styles ?>
<?php print $scripts ?>
<!--[if lt IE 7]>
    <?php print phptemplate_get_ie_styles(); ?>  
	<script defer type="text/javascript" src="<?php print base_path(); ?>sites/all/themes/3beats/pngfix.js"></script>
<![endif]-->
 <meta property="og:title" content="3beats : Artist Statistics"/>
 <meta property="og:type" content="3beats"/>
 <meta property="og:site_name" content="3beats.com"/>
 <meta property="og:url" content="http://www.3beats.com/"/>
 <meta property="og:image" content="http://dev.3beats.com/sites/default/files/garland_logo.png"/>
 <!--meta name="fb:app_id" content="128490007174811"/-->
 <!--meta name="fb:app_id" content="141116715954130"/-->
 <meta name="fb:app_id" content="207618829249751"/>
 <meta property="og:description"
          content="3Beats Artist Statistics Description Text."/>
</head>
<!-- Default Theme -->
<body>
<script> /*function testfunc(){setTimeout("window.location.href = window.location.href;",5000); }*/</script>
<?php  $base_url = url(NULL, array('absolute' => TRUE)); ?>
	<div id="wrapper">
    	<div id="top_tabs">
			<?php print $header; ?>
			<div style="float:right; margin-right:20px; width:180px;">
				<ul><li><?php print $facebook; ?></li></ul>
			</div>
        </div>
		<div id="container">
			<div id="header_bar">
				<div class="topnavigation" >
				<?php if (isset($primary_links)) : ?>
					  <div id="primary-menu">
    					 <?php print $primary_links_tree; /* UNCOMMENT FOR DROPDOWN MENU */?>
				    </div>
				<?php endif; ?>
				</div>
           <div id="searchbox_bg_corner"  <?php $primary_links_tree ? '' : print ('style="margin-top:15px;"'); ?>>
         <?php print $celebrity_search; ?>
				</div>
			</div>
			<div id="contentbg">
				<div id="contentbox">
					<div class="newline"></div>
					<div id="tit" style="clear:both"><h1><?php print three_beats_substr_name ('', $title, 40);?></h1></div>
						<div style="margin-left:15px">
							<?php if ($tabs): ?>
								<div class="tabs"><?php print $tabs; ?></div>
							<?php endif; ?>
						<?php print $content ?>
						<?php if ($contact_bar): ?>
    						<div class="contact-us-form">
                                <span style="color:#fff; font-size:12px">
                                <?php print $messages;?>
                                <?php print $contact_bar;?>
                                <br />
                                </span>
                            </div>
						<?php endif; ?>
						</div>
					<div style="clear:both"></div>
				</div>
			</div>
			<div id="divider_bar"></div>
			<div id="contentbg"><div id="footerbox">
				<div id="footer">
					<div id="footer_inner">
						<ul>
						    <div id="foot"><?php print $footer;?><div id="cop" style="margin-left:800px; position:absolute;margin-top:5px;"></div></div>
						    <?php // print $service_link ?>
						</ul>
					</div>
        </div></div>
			</div>
			<div id="footer_bar"></div>
		</div>
	</div>
<?php print $closure ?>
</body>
</html>
<?php print $content_bottom; ?>