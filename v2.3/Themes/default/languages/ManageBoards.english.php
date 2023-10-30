<?php
// version: 1.1; manageboards

$txt[41] = 'Manage boards and categories';
$txt[43] = 'Order';
$txt[44] = 'Complete name';
$txt[672] = 'This will be the name shown.';
$txt[677] = 'Edit your categories and boards here.<br />to create a new board, <i>click</i> in "new board". to create a subforum in that board "subforum of..." in the menu, while you are creating it.';
$txt['parent_members_only'] = 'Parent members only';
$txt['parent_guests_only'] = 'Guests';
$txt['catconfirm'] = "Do you really want to delete this ' . $txt[cat2] . '?";
$txt['boardconfirm'] = 'Do you really want to delete this forum?';

$txt['catEdit'] = "Edit ' . $txt[cat2] . '";
$txt['boardsedit'] = 'Modify boards';
$txt['collapse_enable'] = 'Colapsable';
$txt['collapse_desc'] = '&iquest;Allow users to collapse this ' . $txt[cat2] . '?';
$txt['catModify'] = '(Modify)';

$txt['mboards_order_after'] = 'After ';
$txt['mboards_order_inside'] = 'Inside ';
$txt['mboards_order_first'] = 'First';

$txt['mboards_new_cat'] = "Create a new ' . $txt[cat2] . '";
$txt['mboards_new_board'] = 'Add board';
$txt['mboards_new_cat_name'] = "New ' . $txt[cat2] . '";
$txt['mboards_add_cat_button'] = "Add ' . $txt[cat2] . '";
$txt['mboards_new_board_name'] = 'New board';

$txt['mboards_name'] = 'Name';
$txt['mboards_modify'] = 'Modify';
$txt['mboards_permissions'] = 'Permissions';
// don't use entities in the below string.
$txt['mboards_permissions_confirm'] = 'Are you sure that you want to change the permissions to the local ones?';

$txt['mboards_delete_cat'] = "Delete ' . $txt[cat2] . '";
$txt['mboards_delete_board'] = 'Delete board';

$txt['mboards_delete_cat_contains'] = 'If you delete a category every post, topic,comments and files will be deleted.';
$txt['mboards_delete_option1'] = 'Delete category.';
$txt['mboards_delete_option2'] = 'Delete category and move boards to';
$txt['mboards_delete_error'] = 'No category was selected!';
$txt['mboards_delete_board_contains'] = 'Deleting this will move all the boards';
$txt['mboards_delete_board_option1'] = 'Delete forum and move all to the top.';
$txt['mboards_delete_board_option2'] = 'Delete forum and move all to the category';
$txt['mboards_delete_board_error'] = 'No forum was selected!';
$txt['mboards_delete_what_do'] = 'Please, select what will be made with the forum';
$txt['mboards_delete_confirm'] = 'Confirm';
$txt['mboards_delete_cancel'] = 'Cancel';

$txt['mboards_category'] = $txt[cat2];
$txt['mboards_description'] = 'Description';
$txt['mboards_description_desc'] = 'A description of your forum.';
$txt['mboards_groups'] = 'Allowed membergroups';
$txt['mboards_groups_desc'] = 'Membergroups allowed to view.<br /><em>note: i the user is in that membergroup wil have access.</em>';
$txt['mboards_groups_post_group'] = 'This membergroup is based in the number of messages.';
$txt['mboards_permissions_title'] = 'Access to forums';
$txt['mboards_permissions_desc'] = 'Select the restrictions of this forum. these restrictions do not apply to moderators and administrators.';
$txt['mboards_moderators'] = 'Moderators';
$txt['mboards_moderators_desc'] = 'Users with special privileges in this forum. administrators are not listed here;';
$txt['mboards_count_posts'] = 'Count messages';
$txt['mboards_count_posts_desc'] = 'When you post a new topic or message, it increases the count of posts from users.';
$txt['mboards_unchanged'] = 'No changes';
$txt['mboards_theme'] = 'Theme';
$txt['mboards_theme_desc'] = 'This allows you to change the appearance,of this forum.';
$txt['mboards_theme_default'] = '(Use the global default theme.)';
$txt['mboards_override_theme'] = 'Ignore the topics of all the users';
$txt['mboards_override_theme_desc'] = 'Use this theme of the forum even if the user did not choose to use default values';

$txt['mboards_order_before'] = 'Before';
$txt['mboards_order_child_of'] = 'Subforum of';
$txt['mboards_order_in_category'] = "In ' . $txt[cat2] . '";
$txt['mboards_current_position'] = 'Current position';
$txt['no_valid_parent'] = "The forum %s does not have a valid parent. please use the function \'find and fix errors \' to solve this problem.";
$txt['cat2'] = " Category ";
$txt['mboards_settings_desc'] = 'Edit forums and general configuration categories.';
$txt['groups_manage_boards'] = 'Membergroups allowed to administer forums and categories';
$txt['mboards_settings_submit'] = 'Save';
$txt['recycle_enable'] = 'Enable the recycle bin';
$txt['recycle_board'] = 'Forum to save deleted topics';
$txt['countchildposts'] = 'Count messages of child categories in parent categories';

$txt['mboards_select_destination'] = 'Selecciona el foro destino \'<b>%1$s</b>\'';
$txt['mboards_cancel_moving'] = 'Cancel the movement';
$txt['mboards_move'] = 'Move';


$txt['mboards_thank_you_post_enable'] = 'Enable thanks in message';
$txt['mboards_thank_you_post_enable_desc'] = 'This option enables the "thank you" in the posts';
?>