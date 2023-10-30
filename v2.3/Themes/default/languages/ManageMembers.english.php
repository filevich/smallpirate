<?php
// Version: 1.1; ManageMembers

$txt['membergroups_title'] = 'Manage Membergroups';
$txt['membergroups_description'] = 'membergroups are used to group users that have the same permission settings, appearance, or access rights. Some groups are based on the number of messages posted. You can assign someone to a group by selecting his profile and changing the settings on his account.';
$txt['membergroups_modify'] = 'Modify';

$txt['membergroups_add_group'] = 'Add Membergroup';
$txt['membergroups_regular'] = 'Regular Membergroups';
$txt['membergroups_post'] = "Membergroups based on the count of messages";

$txt['membergroups_new_group'] = 'Add Membergroup';
$txt['membergroups_group_name'] = 'Membergroup Name';
$txt['membergroups_new_board'] = 'Visible Boards';
$txt['membergroups_new_board_desc'] = 'Boards That This Users Can See.';
$txt['membergroups_new_board_post_groups'] = '<em>Note: Normally, the groups based on message count does not need access because the group in which they are gives them access.</em>';
$txt['membergroups_new_as_type'] = 'As Type';
$txt['membergroups_new_as_copy'] = 'As Copy Of';
$txt['membergroups_new_copy_none'] = '(None)';
$txt['membergroups_can_edit_later'] = 'You Can Edit This Later.';

$txt['membergroups_edit_group'] = 'Edit membergroup';
$txt['membergroups_edit_name'] = 'membergroup name';
$txt['membergroups_edit_post_group'] = 'this group is based on message count';
$txt['membergroups_min_posts'] = 'required messages';
$txt['membergroups_online_color'] = 'Color in the online users list';
$txt['membergroups_star_count'] = 'Number of star images';
$txt['membergroups_star_image'] = 'Star images file';
$txt['membergroups_star_image_note'] = 'you can use $language to use the user language.';
$txt['membergroups_max_messages'] = 'Max. private messages';
$txt['membergroups_max_messages_note'] = '0 = No Limit';
$txt['membergroups_edit_save'] = 'Save';
$txt['membergroups_delete'] = 'Delete';
$txt['membergroups_confirm_delete'] = 'Do You Really Want To Delete This Membergroup?!';

$txt['membergroups_members_title'] = 'Showing All The Users Of That Group';
$txt['membergroups_members_no_members'] = 'there are no members in this group';
$txt['membergroups_members_add_title'] = 'Add user To this group';
$txt['membergroups_members_add_desc'] = 'List of users to add';
$txt['membergroups_members_add'] = 'Add users';
$txt['membergroups_members_remove'] = 'remove from de membergroup';

$txt['membergroups_postgroups'] = 'Groups based on the number of messages';

$txt['membergroups_edit_groups'] = 'Edit Membergroups';
$txt['membergroups_settings'] = 'Membergroups Settings';
$txt['groups_manage_membergroups'] = 'Membergroups Allowed To Manage Membergroups';
$txt['membergroups_settings_submit'] = 'Save';
$txt['membergroups_select_permission_type'] = 'Select Permission Type';
$txt['membergroups_images_url'] = '{theme URL}/images/';
$txt['membergroups_select_visible_boards'] = 'Select Visible Boards';

$txt['admin_browse_approve'] = 'Users who are waiting for the approval of their accounts';
$txt['admin_browse_approve_desc'] = 'From here you can manage all users who are waiting for the approval of their accounts.';
$txt['admin_browse_activate'] = 'Users Waiting For The Approval of their accounts';
$txt['admin_browse_activate_desc'] = 'This screen lists all users who have not yet activated their accounts.';
$txt['admin_browse_awaiting_approval'] = 'Waiting Approval <span style="font-weight: normal">(%d)</span>';
$txt['admin_browse_awaiting_activate'] = 'Waiting Activation <span style="font-weight: normal">(%d)</span>';

$txt['admin_browse_username'] = 'Username';
$txt['admin_browse_email'] = 'Email';
$txt['admin_browse_ip'] = 'IP';
$txt['admin_browse_registered'] = 'Registered';
$txt['admin_browse_id'] = 'ID';
$txt['admin_browse_with_selected'] = 'Selected With';
$txt['admin_browse_no_members_approval'] = 'No Members Need To Be Approved.';
$txt['admin_browse_no_members_activate'] = 'No Members Are Waiting To Activate Their Accounts.';
// Don't use entities in the below strings, except the main ones. (lt, gt, quot.)
$txt['admin_browse_warn'] = '&#191;All The Selected Users?';
$txt['admin_browse_outstanding_warn'] = '&#191;All Afected Users?';
$txt['admin_browse_w_approve'] = 'Approve';
$txt['admin_browse_w_activate'] = 'Activate';
$txt['admin_browse_w_delete'] = 'Delete';
$txt['admin_browse_w_reject'] = 'Reject';
$txt['admin_browse_w_remind'] = 'Remind';
$txt['admin_browse_w_approve_deletion'] = 'Approve (Delete Accounts)';
$txt['admin_browse_w_email'] = 'Also Send An Email';
$txt['admin_browse_w_approve_require_activate'] = 'Waiting Approval Or Activation';

$txt['admin_browse_filter_by'] = 'Filer By';
$txt['admin_browse_filter_show'] = 'Showing';
$txt['admin_browse_filter_type_0'] = 'New Accounts Not Activated';
$txt['admin_browse_filter_type_2'] = 'Email Changes Not Accepted';
$txt['admin_browse_filter_type_3'] = 'New Accounts Not Approved';
$txt['admin_browse_filter_type_4'] = 'Delete Not Approved Accounts';
$txt['admin_browse_filter_type_5'] = 'Accounts Below The Age To Approve';

$txt['admin_browse_outstanding'] = 'Outstanding Users';
$txt['admin_browse_outstanding_days_1'] = 'With all the users who registered more than';
$txt['admin_browse_outstanding_days_2'] = 'days';
$txt['admin_browse_outstanding_perform'] = 'Perform';
$txt['admin_browse_outstanding_go'] = 'Do Action';

// Use numeric entities in the below nine strings.
$txt['admin_approve_reject'] = 'Register Rejected';
$txt['admin_approve_reject_desc'] = 'I regret to inform you that your application for a membership to the forum' . $context['forum_name'] . ' Was rejected.';
$txt['admin_approve_delete'] = 'Account Deleted';
$txt['admin_approve_delete_desc'] = 'Your account in ' . $context['forum_name'] . ' has been deleted. It was probably because you never activated your account, in that case you can register again.';
$txt['admin_approve_remind'] = 'Register Reminder';
$txt['admin_approve_remind_desc'] = 'You Have Not Activated Your Account In';
$txt['admin_approve_remind_desc2'] = 'Click In The Next Link To Activate It:';
$txt['admin_approve_accept_desc'] = 'Your Account Was Activated By The Admin, Now You Can Enter.';
$txt['admin_approve_require_activation'] = 'Your Account In ' . $context['forum_name'] . ' has been approved by the board administrator, and now must be activated before you can post.';

?>