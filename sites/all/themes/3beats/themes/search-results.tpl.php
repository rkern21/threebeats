<?php
// $Id: search-results.tpl.php,v 1.1 2007/10/31 18:06:38 dries Exp $

/**
 * @file search-results.tpl.php
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependant to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $type: The type of search, e.g., "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 */
?>

<div id="right-container" >
	<h2 class="subhead">Resent News</h2>
	<div class="celeb_list_articles view-content-rigt">
		<?php global $nid_separated; print views_embed_view('Articles', 'block_1', $nid_separated); ?>
	</div>
</div>
<div id="left-container" >
      <?php if ($search_results_celeb): ?>
    <div><?php print '<h2>'.t('Celebrities:').'</h2>'?> <?php print $search_results_celeb; ?></div>
  <?php endif;?>
  <?php if ($search_results_user): ?>
    <div> <?php print '<h2>'.t('Users:').'</h2>'?> <?php print $search_results_user; ?></div>
  <?php endif;?>
  <?php  print $pager_custom?>
</div>

<div class="clear"></div>