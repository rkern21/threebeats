<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div onclick="location.href='<?php print url('user/'.$fields["uid"]->raw); ?>';" style="cursor:pointer;" id="celeb_stream_items" class="celeb_cat_entertainment celeb_cat_entertainment_border">
	<div id="celeb_cat_bg" style="display:table-cell;">
		<a href="<?php print url('user/'.$fields["uid"]->raw); ?>">
			<?php print theme('imagecache', '48x48', $fields["picture"]->raw, $fields["field_first_name_value"]->raw." ".$fields["field_last_name_value"]->raw, $fields["field_first_name_value"]->raw." ".$fields["field_last_name_value"]->raw, array('class' => 'celeb_cat_img')) ?>
		</a>
	</div>
	<div id="celeb_stream_single_search">
		<div id="celeb_stream_text" style="display:table-cell;padding-left:15px;">
			<a href="<?php print url('user/'.$fields["uid"]->raw); ?>">
				<span class="celeb_stream_name_search"><?php print $fields["field_first_name_value"]->raw." ".$fields["field_last_name_value"]->raw; ?></span><br />
			</a>
			<span class="celeb_stream_comment"><?php print $fields["field_descriptions_value"]->raw; ?></span>
			<br />
		</div>
	</div>
</div>