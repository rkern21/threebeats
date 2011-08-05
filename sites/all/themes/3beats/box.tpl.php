<?php
// $Id: box.tpl.php,v 1.3 2007/12/16 21:01:45 goba Exp $

/**
 * @file box.tpl.php
 *
 * Theme implementation to display a box.
 *
 * Available variables:
 * - $title: Box title.
 * - $content: Box content.
 *
 * @see template_preprocess()
 */
 ?>

<div class="box">

<?php if ($title): ?>
  <h1><?php print $title ?>: <?php print arg(2)?></h1>
<?php endif; ?>

<?php print $content ?>
</div>