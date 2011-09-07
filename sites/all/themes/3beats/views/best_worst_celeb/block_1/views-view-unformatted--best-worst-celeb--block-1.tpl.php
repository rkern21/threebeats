<div class="top-10 top-10-gainers">
    <div class="top-10-items top-10-items-gainers">
        <?php foreach ($rows as $id => $row): ?>
        <?php print $row; ?>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
    <div class="top-10-text top-10-text-gainers">
        <span><?php echo t('Top 10 Gainers'); ?></span>
    </div>
</div>