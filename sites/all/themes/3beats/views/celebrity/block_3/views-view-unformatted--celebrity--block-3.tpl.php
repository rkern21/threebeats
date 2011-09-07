<div class="i-slider-block">
  <div class="in-block clear-block">
    <?php foreach ($rows as $id => $row): ?>
      <div class="same-block<?php print !$id ? ' same-block-act' : ''; ?>" id="a<?php print $id+1; ?>">
        <?php print $row; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>