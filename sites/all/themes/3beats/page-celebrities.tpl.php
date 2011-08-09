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
	<![endif]-->
</head>
<!-- Celebrity Theme -->
<body>
	<?php  $base_url = url(NULL, array('absolute' => TRUE)); ?>

	<!-- Section for Facebook Connect -->
	<div style="width: 100%; background-color: #736d2c; line-height: 1.5em; opacity:0.8; filter:alpha(opacity=80);">
	<?php global $user; if (!$user->uid): ?>	
		<span style="text-align: center; color: rgb(255, 235, 9); opacity: 1; padding-left: 420px; margin-left: 650px;">
				<fb:login-button size="small" onlogin="facebook_onlogin_ready();" background="dark" v="2" perms="user_about_me, email, publish_stream, offline_access">Connect</fb:login-button>
		</span>
	<?php else: ?>
		<span style="opacity: 1; color: rgb(255, 235, 9); text-align: right; padding-left: 370px; margin-left: 650px; font-size: 11px; vertical-align: middle; font-weight: bold;">
			<!--<img style="float:right; margin-right:20px;" src="http://graph.facebook.com/<?php /*print $user->fbuid; */?>/picture?type=small" alt="" height="50">-->
			Welcome <a href="/user/<?php print $user->uid; ?>" style="font-weight: bold; font-size: 12px; color: rgb(255, 235, 9);"><?php print $user->name; ?></a>&nbsp;|&nbsp;<a href="/logout" style="font-weight: bold; font-size: 12px; color: rgb(255, 235, 9);"><strong>Logout</strong></a>
		</span>
	<?php endif; ?>
	</div>
	<!-- End section for Facebook Connect -->
	
	<div id="wrapper">
    	<div id="top_tabs">
			<?php print $header; ?>
        </div>

		<div id="container">
			<div id="header_bar">
				<div class="topnavigation" >
					<?php if (isset($primary_links)) : ?>
						  <?php print $primary_links_tree; /* UNCOMMENT FOR DROPDOWN MENU */?>
					<?php endif; ?>
					<div id="searchbox_bg_corner" >
						<form action="/beta/"  accept-charset="UTF-8" method="post" id="test-page">
							<input type="text" maxlength="255" name="name" id="edit-name" size="100" value="Type a Celebrity Name" onclick="this.value=&quot;&quot;" class="form-text" />
							<input type="image" name="op" id="edit-submit-1" value="" class="form-submit" />
							<input type="hidden" name="form_build_id" id="form-41e18512d2327efc32335135d058cedf" value="form-41e18512d2327efc32335135d058cedf"  />
							<input type="hidden" name="form_token" id="edit-test-page-form-token" value="5ff69ab800cda8bf1a9ca71055bba807"  />
							<input type="hidden" name="form_id" id="edit-test-page" value="test_page"  />
						</form>
					</div>
				</div>
			</div>

			<div id="contentbg">
				<div id="contentbox">
					<div class="newline"></div>
						<h1><?php $arg=arg(1); $sql_title=db_fetch_object(db_query("select title from node where nid='$arg'")); print $sql_title->title;?></h1>
						<?php if ($tabs): ?>
							<div class="tabs"><?php print $tabs; ?></div>
						<?php endif; ?>
						<?php print $content ?>
					<div style="clear:both"></div>
				</div>
			</div>

			<div id="divider_bar"></div>

			<div id="contentbg">
				<div id="footer">
					<div id="footer_inner">
                        <ul>
                            <div id="foot"><?php print $footer;?><div id="cop" style="margin-left:800px; position:absolute;margin-top:5px;"></div></div>
                            <?php //print $service_link ?>
                        </ul>
					</div>
                </div>
			</div>

			<div id="footer_bar"></div>

		</div>
	</div>
<?php print $closure ?>
</body>
</html>
