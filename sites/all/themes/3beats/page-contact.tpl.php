<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>"  xmlns:fb="http://www.facebook.com/2008/fbml">
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
</head>
<!-- Contact Theme -->
<body>
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
            <?php print $primary_links_tree; /* UNCOMMENT FOR DROPDOWN MENU */?>
        <?php endif; ?>
        <div id="searchbox_bg_corner" >
        <?php print '<div id="cont">'.$celebrity_search.'</div>'; ?>
        </div>
        </div>
      </div>
			<div id="contentbg">
				<div id="contentbox">
				<div style="clear:both"></div>
					<div class="node-page">
						<h2 class="subheading"><?php print t('About Us')?></h2>					
						<div><?php print $contact_bar;?></div>
						<div class="newline"></div>
						<div style="display:inline; padding-left:15px;">
						</div>
					</div>
					<div class="contact-us-form">
						<h2 class="subheading"><?php print $title;?></h2>
							<span style="color:#fff; font-size:12px">
							<?php print $messages;?>
							<?php print $content;?><!--;-->
							<br />
							</span>
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
                <?php //print $service_link ?>
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