<div id="left-container" >
<?php global $base_url;?>
<div><h1>Search Results : <?php echo arg(2);?></h1></div>
    <?php if ($celebrityes): ?>
		<div><?php print '<h2>'.t('Celebrities:')?><a style="text-decoration:none;color:#FFEB09;padding-left:20px;font-size:12px;" href="<?php echo $base_url;?>/create_celebrity"><i>(Create Celebrity)</i></a> </h2><div style="float: right;margin-top:-57px;margin-left:600px;position:absolute;"><?php print '<h2>'.t('Recent News').'</h2>'?></div> <?php print $celebrityes; ?></div>
	<?php endif;?>

	<?php if ($users): ?>
		<div> <?php print '<h2>'.t('Users:').'</h2>'?> <?php print $users; ?></div>
	<?php endif;?>

	<?php if(!($users && $celebrityes)): ?>

		<div> <h2>No results</h2> </div>

	<?php endif; ?>

</div>

<div class="clear"></div>
