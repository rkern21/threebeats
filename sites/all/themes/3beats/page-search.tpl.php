<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>"  xmlns:fb="http://www.facebook.com/2008/fbml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php print $head ?><title><?php print $head_title ?></title><?php print $styles ?><?php print $scripts ?><!--[if lt IE 7]><?php print phptemplate_get_ie_styles(); ?><![endif]--></head><!-- Search Theme --><body><script> /*function testfunc(){setTimeout("window.location.href = window.location.href;",5000); }*/</script>
<?php  $base_url = url(NULL, array('absolute' => TRUE)); ?>	<div id="wrapper">    	<div id="top_tabs">			<?php print $header; ?>			<div style="float:right; margin-right:20px; width:180px;">				<ul><li><?php print $facebook; ?></li></ul>			</div>        </div>
	<div id="container">		<div id="header_bar">			<div class="topnavigation" >			<?php if (isset($primary_links)) : ?>					  <?php print $primary_links_tree; /* UNCOMMENT FOR DROPDOWN MENU */?>				<?php endif; ?>			</div>		</div>		<div id="contentbg">			<div id="content">				<div id="header_search">					<div id="header_inner">						<h2>Make Your Celebrity Voice Heard<br /></h2>						<div id="searchbox_bg">						  <?php print $celebrity_search;?>						</div>					</div>				</div>				<?php print $content;?>			     <div style="clear:both"></div>			</div>        </div>        <div id="divider_bar"></div>		<div id="contentbg">			<div id="footerbox">				<div id="footer">					<div id="footer_inner">						<ul>							<div id="foot"><?php print $footer;?><div id="cop" style="margin-left:800px; position:absolute;margin-top:5px;"></div></div>							<?php // print $service_link ?>						</ul>					</div>				</div>			</div>		</div>        <div id="footer_bar"></div>   </div></div><?php print $closure ?></body></html><?php print $content_bottom; ?>