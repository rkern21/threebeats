<div class="top-10 top-10-losers">
    <div class="top-10-text top-10-text-losers">
        <span><?php echo t('Top 10 Losers'); ?></span>
    </div>
    <div class="top-10-items top-10-items-losers">
        <?php foreach ($rows as $id => $row): ?>
        <?php print $row; ?>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
</div>