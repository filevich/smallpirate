<?php

// Version: 1.1.9; index


global $forum_copyright, $forum_version, $webmaster_email, $slogan;

$txt['lang_locale'] = 'english';
$txt['lang_dictionary'] = 'en';
$txt['lang_spelling'] = '';

$txt['lang_character_set'] = 'UTF-8';
$txt['lang_rtl'] = false;

$txt['days'] = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$txt['days_short'] = array('Sun', 'Mon', 'Tue', 'Wed;', 'Thu', 'Fri', 'Sat');
$txt['months'] = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$txt['months_titles'] = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$txt['months_short'] = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

$txt['newmessages0'] = 'is new';
$txt['newmessages1'] = 'are new';
$txt['newmessages3'] = 'New(s)';
$txt['newmessages4'] = ',';

$txt[2] = 'Administration';

$txt[10] = 'Edit post';

$txt[17] = 'Modify';
$txt[18] = $slogan;
$txt[19] = 'Users';
$txt[20] = 'Category name';
$txt['topicsmb'] = 'Posts';
$txt[21] = 'Messages';
$txt[22] = 'Last message';

$txt[24] = '(No title)';
$txt[26] = 'Messages';
$txt[27] = 'View profile';
$txt[28] = 'Anon';
$txt[29] = 'Author';
$txt[30] = '';
$txt[31] = 'Delete';
$txt[33] = 'Create new post';

$txt[34] = 'Login';
$txt[35] = 'User';
$txt[36] = 'Password';

$txt[40] = 'User name not found.';

$txt[62] = 'Category mod';
$txt[63] = 'Delete post';
$txt[64] = 'posts';
$txt[66] = 'Modify message';
$txt[68] = 'Name';
$txt[69] = 'Email';
$txt[70] = 'Title';
$txt[72] = 'Message';

$txt[79] = 'Edit Profile';

$txt[81] = 'Choise a password';
$txt[82] = 'Verify password';
$txt[87] = 'Group';

$txt[92] = 'View profile to';
$txt[94] = 'Total';
$txt[95] = 'Messages';
$txt[96] = 'Website';
$txt[97] = 'Register';

$txt[101] = 'Home Messages';
$txt[102] = 'News';
$txt[103] = 'Home';

$txt[104] = 'Lock/Unlock post';
$txt[105] = 'Publish';
$txt[106] = 'Atention!';
$txt[107] = 'at';
$txt[108] = 'Exit';
$txt[109] = 'Started by';
$txt[110] = 'Replies';
$txt[111] = 'Last message';
$txt[114] = 'Enter to admin panel';
$txt[118] = 'post';
$txt[119] = 'Help';
$txt[121] = 'Delete message';
$txt[125] = 'Notify';
$txt[126] = 'Want to be notified by email when someone replies to this post?';
$txt[130] = "Regards,\nThe Team " . $context['forum_name'] . '.';
$txt[131] = 'Notify Replies';
$txt[132] = 'Move post';
$txt[133] = 'Move to';
$txt[139] = 'pages';
$txt[140] = 'Users active in past ' . $modSettings['lastActive'] . ' minutes';
$txt[144] = 'Private Messages';
$txt[145] = 'Reply with quote';
$txt[146] = 'Reply';

$txt[151] = 'No have messages...';
$txt[152] = 'you have';
$txt[153] = 'messages';
$txt[154] = 'Delete this message';

$txt[158] = 'Online Users';
$txt[159] = 'Private Message';
$txt[160] = 'Go to';
$txt[161] = 'go';
$txt[162] = 'Are you sure to delete this post?';
$txt[163] = 'Yes';
$txt[164] = 'No';

$txt[166] = 'Search results';
$txt[167] = 'End results';
$txt[170] = 'Sorry, no posts found';
$txt[176] = 'in';

$txt[182] = 'Search';
$txt[190] = 'All';

$txt[193] = 'Back';
$txt[194] = 'Password reminder';
$txt[195] = 'Topic started by';
$txt[196] = 'Title';
$txt[197] = 'Posted by';
$txt[200] = 'List (search option) of all registered users.';
$txt[201] = 'Please, welcome to';
$txt[208] = 'Admin Center';
$txt[211] = 'Last modified';
$txt[212] = 'Would you turn off the notification in this post?';

$txt[214] = $txt[18];

$txt[227] = 'City';
$txt[231] = 'Sex';
$txt[233] = 'Register Date';

$txt[234] = 'View the most recent messages in the category.';
$txt[235] = 'is the most recently updated post';

$txt[238] = 'Male';
$txt[239] = 'Female';

$txt[240] = 'Invalid character in the user name.';

$txt['welcome_guest'] = 'Welcome, <b>' . $txt[28] . '</b>. Please, <a href="?action=login">login</a> or <a href="?action=registrarse">register</a>.';
$txt['welcome_guest_activate'] = '<br />Forgot your  <a href="?action=activate">activation mail?</a>';
$txt['hello_member'] = 'Hi,';
$txt['hello_guest'] = 'Welcome,';
$txt[247] = 'Hi,';
$txt[248] = 'Welcome,';
$txt[249] = 'Please';
$txt[250] = 'Back';
$txt[251] = 'Please select a destination';

// Escape any single quotes in here twice.. 'it\'s' -> 'it\\\'s'.
$txt[279] = 'Publicado por';

$txt[287] = 'Smile';
$txt[288] = 'Angry';
$txt[289] = 'Laugh';
$txt[290] = 'Laughter';
$txt[291] = 'Sad';
$txt[292] = 'Wink';
$txt[293] = 'Grin';
$txt[294] = 'Impressed';
$txt[295] = 'Super';
$txt[296] = 'Huh';
$txt[450] = 'Roll Eyes';
$txt[451] = 'Tongue';
$txt[526] = 'Embarrassed';
$txt[527] = 'Lips Sealed';
$txt[528] = 'Undecided';
$txt[529] = 'Kiss';
$txt[530] = 'Cry';

$txt[298] = 'Moderator';
$txt[299] = 'Moderators';


$txt[301] = 'Viewa';
$txt[302] = 'New';

$txt[303] = 'View all users';
$txt[305] = 'View';
$txt[307] = 'Email';

$txt[308] = 'Viewing users';
$txt[309] = 'of';
$txt[310] = 'total users';
$txt[311] = 'to';
$txt[315] = 'Forgot your password?';

$txt[317] = 'Date';
// Use numeric entities in the below string.
$txt[318] = 'To';
$txt[319] = 'Title';
$txt[322] = 'Get New Posts';
$txt[324] = 'For';

$txt[330] = 'posts';
$txt[331] = 'users';
$txt[332] = 'Users list';
$txt[333] = 'New messages';
$txt[334] = 'No messages';

$txt['sendtopic_send'] = 'Send';

$txt[371] = 'Time Difference';
$txt[377] = 'or';

$txt[398] = 'Sorry, no posts found';

$txt[418] = 'Notification';

$txt[430] = 'Sorry %s, You have denied access to this site!';


$txt[454] = 'hot post (More ' . $modSettings['hotTopicPosts'] . ' replies)';
$txt[455] = 'very hot post (More ' . $modSettings['hotTopicVeryPosts'] . ' replies)';
$txt[456] = 'lock post';
$txt[457] = 'normal post';
$txt['participation_caption'] = 'posts in which you have posted';

$txt[462] = 'GO';

$txt[465] = 'Print';
$txt[467] = 'Profile';
$txt[468] = 'Posts sumary';
$txt[470] = 'N/D';
$txt[471] = 'message';
$txt[473] = 'This name is in use by another user.';

$txt[488] = 'Total Users';
$txt[489] = 'Total Messages';
$txt[490] = 'Total Posts';

$txt[507] = 'Preview';
$txt[508] = 'Remember Account';

$txt[511] = 'Online';

$txt[512] = 'IP';

$txt[515] = 'WWW';

$txt[525] = 'by';

$txt[578] = 'hours';
$txt[579] = 'days';

$txt[581] = ', our newest user.';

$txt[582] = 'Search by';

$txt[616] = 'Remember, this site is under \'Maintenance Mode\'.';

$txt[641] = 'Read';
$txt[642] = 'times';

$txt[645] = 'Statistics';
$txt[656] = 'Latest Member';
$txt[658] = 'Total Categories';
$txt[659] = 'Last message';

$txt[660] = 'You have';
$txt[661] = 'Click';
$txt[662] = 'here';
$txt[663] = 'to view.';

$txt[665] = 'Total Categories';

$txt[668] = 'Print page';

$txt[679] = 'Must be a valid email address.';

$txt[683] = 'a lot';
$txt[685] = $context['forum_name'] . ' - Information Center';

$txt[707] = 'Send post';

$txt['sendtopic_title'] = 'Send post &#171; %s &#187; to a friend.';
// Use numeric entities in the below three strings.
$txt['sendtopic_dear'] = 'Dear %s,';
$txt['sendtopic_this_topic'] = 'I want you to check the following post: %s, in ' . $context['forum_name'] . '. To view, click on the link below';
$txt['sendtopic_thanks'] = 'Thanks';
$txt['sendtopic_sender_name'] = 'Your name';
$txt['sendtopic_sender_email'] = 'Your email adress';
$txt['sendtopic_receiver_name'] = 'Recipient name';
$txt['sendtopic_receiver_email'] = 'Recipient email address';
$txt['sendtopic_comment'] = 'Add a comment';
// Use numeric entities in the below string.
$txt['sendtopic2'] = 'A comment about this post have been added';

$txt[721] = 'Hide email to public';

$txt[737] = 'Select all';

// Use numeric entities in the below string.
$txt[1001] = 'Data base error';
$txt[1002] = 'Please try again. If this message appears again, notifying the error to an administrator.';
$txt[1003] = 'File';
$txt[1004] = 'Line';
// Use numeric entities in the below string.
$txt[1005] = 'The system has detected errors in the database, and has tried to automatically correct.  f problems persist, or keep getting these emails, please contact your hosting provider.';
$txt['database_error_versions'] = '<b>Note:</b> Parece que tu base de datos puede necesitar una actualizaci&oacute;n. La versi&oacute;n de los archivos de tu web est&aacute;n en la versi&oacute;n ' . $forum_version . ', mientras que tu base de datos est&aacute; en la versi&oacute;n de ' . $forum_version . '. Te recomendamos que ejecutes la &uacute;ltima versi&oacuten de upgrade.php.';
$txt['template_parse_error'] = 'Template Error parsing!';
$txt['template_parse_error_message'] = 'Looks like something crashed into the net with the system posts.  This problem may only be temporary, please return in a few moments and try again. If you see this message, please contact the administrator.<br /><br />refreshing <a href="javascript:location.reload();">this page</a>.';
$txt['template_parse_error_details'] = 'There was a problem loading the language file or post <tt><b>%1$s</b></tt>.  Please check the syntax and try again - remember, apostrophes (<tt>\'</tt>) generally must have an escape sequence with the backslash (<tt>\\</tt>).  To view specific information of the error you can visite the PHP site <a href="' . $boardurl . '%1$s">access the file directly</a>.<br /><br />You can try <a href="javascript:location.reload();">update this page</a> or <a href="' . $scripturl . '?theme=1">use the default theme</a>.';

$txt['smf10'] = '<b>Today at</b> ';
$txt['smf10b'] = '<b>Yesterday</b> at ';
$txt['smf20'] = 'New Poll';
$txt['smf21'] = 'Question';
$txt['smf23'] = 'Submit vote';
$txt['smf24'] = 'Total votes';
$txt['smf25'] = 'shortcut: hit alt + s to post or alt + p to preview';
$txt['smf29'] = 'View results';
$txt['smf30'] = 'Lock Poll';
$txt['smf30b'] = 'Unlock Poll';
$txt['smf39'] = 'Edit Poll';
$txt['smf43'] = 'Poll';
$txt['smf47'] = '1 Day';
$txt['smf48'] = '1 Week';
$txt['smf49'] = '1 Month';
$txt['smf50'] = 'Forever';
$txt['smf52'] = 'Login with username, password and session length';
$txt['smf53'] = '1 Hour';
$txt['smf56'] = 'MOVED';
$txt['smf57'] = 'Please enter a brief description of<br />why this post is moving.';
$txt['smf60'] = 'Sorry, you do not have enough posts to change the karma - you need at least ';
$txt['smf62'] = 'Sorry, can not repeat a karma action without waiting for ';
$txt['smf82'] = 'category';
$txt['smf88'] = 'in';
$txt['smf96'] = 'sticky post';

$txt['smf138'] = 'Delete';

$txt['smf199'] = 'Your Private Messages';

$txt['smf211'] = 'KB';

$txt['smf223'] = '[More Stats]';

// Use numeric entities in the below three strings.
$txt['smf238'] = 'Code';
$txt['smf239'] = 'Quote to';
$txt['smf240'] = 'Quote';

$txt['smf251'] = 'Split post';
$txt['smf252'] = 'Combine posts';
$txt['smf254'] = 'Title for the new post';
$txt['smf255'] = 'Just divide this message.';
$txt['smf256'] = 'Split post from this message (by including).';
$txt['smf257'] = 'Select the message to divide.';
$txt['smf258'] = 'New Message';
$txt['smf259'] = 'The post has been divided into two posts.';
$txt['smf260'] = 'Origin post';
$txt['smf261'] = 'Please select which messages you want to split.';
$txt['smf264'] = 'The posts have been successfully combined.';
$txt['smf265'] = 'New post combined';
$txt['smf266'] = 'post to be combined';
$txt['smf267'] = 'target category';
$txt['smf269'] = 'destination post';
$txt['smf274'] = 'Are you sure you want to combine?';
$txt['smf275'] = 'with';
$txt['smf276'] = 'This function will combine the two posts messages in a post. Messages will be sorted according to the date they were posted. Therefore, the most recent Post will be the first message of the combined post.';

$txt['smf277'] = 'Sticky Post';
$txt['smf278'] = 'Unset Sticky post';
$txt['smf279'] = 'Lock post';
$txt['smf280'] = 'Unlock post';

$txt['smf298'] = 'Advanced Search';

$txt['smf299'] = 'GREATER SECURITY RISK:';
$txt['smf300'] = 'You havent deleted ';

$txt['smf301'] = 'Page created in ';
$txt['smf302'] = ' seconds ';
$txt['smf302b'] = ' queries.';

$txt['smf315'] = 'Use this function to inform the moderators and administrators of an abusive message, or incorrectly published.<br /><i>It is important to note that your email address will be revealed to the moderator if you use this feature.</i>';

$txt['online2'] = 'Online';
$txt['online3'] = 'Offline';
$txt['online4'] = 'Message (Online)';
$txt['online5'] = 'Message (Offline)';
$txt['online8'] = 'Status';

$txt['topbottom4'] = 'Go to Top';
$txt['topbottom5'] = 'Go to Bottom';

$forum_copyright = '<a href="http://www.spirate.net/" title="Spirate" target="_blank" rel="nofollow">Powered by ' . $forum_version . '</a> & 
<a href="http://www.simplemachines.org/about/copyright.php" title="Free Forum Software" target="_blank" rel="nofollow">SMF</a>';

$txt['calendar3'] = 'Birthday:';
$txt['calendar4'] = 'Events:';
$txt['calendar3b'] = 'Upcoming birthdays:';
$txt['calendar4b'] = 'Upcoming Events:';
$txt['calendar5'] = '';
// Prompt for holidays in the calendar, leave blank to just display the holiday's name.
$txt['calendar9'] = 'Month:';
$txt['calendar10'] = 'Year:';
$txt['calendar11'] = 'Day:';
$txt['calendar12'] = 'Event Title:';
$txt['calendar13'] = 'Publish in:';
$txt['calendar20'] = 'Edit Event';
$txt['calendar21'] = 'Erase this event?';
$txt['calendar22'] = 'Delete Event';
$txt['calendar23'] = 'Post Event';
$txt['calendar24'] = 'Calendar';
$txt['calendar37'] = 'Link to calendar';
$txt['calendar43'] = 'Event Link';
$txt['calendar47'] = 'Calendar of upcoming events';
$txt['calendar47b'] = 'Todays Calendar';
$txt['calendar51'] = 'Week';
$txt['calendar54'] = 'Number of Days:';
$txt['calendar_how_edit'] = 'How do you edit these events?';
$txt['calendar_link_event'] = 'Link Event to the message:';
$txt['calendar_confirm_delete'] = 'Are you sure you want to delete this event?';
$txt['calendar_linked_events'] = 'Linked Events';

$txt['moveTopic1'] = 'Post a redirect post';
$txt['moveTopic2'] = 'Change the title post';
$txt['moveTopic3'] = 'New title';
$txt['moveTopic4'] = 'Change de title of each message';

$txt['theme_template_error'] = 'Couldnt load the template \'%s\'.';
$txt['theme_language_error'] = 'Couldnt load language file \'%s\'.';

$txt['parent_boards'] = 'Subcategory';

$txt['smtp_no_connect'] = 'It wasnt possible to connect to the SMTP server';
$txt['smtp_port_ssl'] = 'Puerto SMTP configured incorrectly, it should be 465 in SSL Servers.';
$txt['smtp_bad_response'] = 'Couldnt obtain response codes mail server';
$txt['smtp_error'] = 'There were problems sending mail. Error: ';
$txt['mail_send_unable'] = 'You will not be able to send the email to the address \'%s\'';

$txt['mlist_search'] = 'Search by users';
$txt['mlist_search2'] = 'Search again';
$txt['mlist_search_email'] = 'Search by email adress';
$txt['mlist_search_messenger'] = 'Search by messenger nick';
$txt['mlist_search_group'] = 'Search by group';
$txt['mlist_search_name'] = 'Search by name';
$txt['mlist_search_website'] = 'Search by website';
$txt['mlist_search_results'] = 'Search results by';

$txt['attach_downloaded'] = 'downloaded';
$txt['attach_viewed'] = 'view';
$txt['attach_times'] = 'times';

$txt['MSN'] = 'Messenger';

$txt['settings'] = 'Configuration';
$txt['never'] = 'Never';
$txt['more'] = 'more';

$txt['hostname'] = 'Server Name';
$txt['you_are_post_banned'] = 'Sorry %s, you cant post messages or send private messages on the web.';
$txt['ban_reason'] = 'Reason';

$txt['tables_optimized'] = 'Tables of the database optimized';

$txt['add_poll'] = 'Add poll';
$txt['poll_options6'] = 'You may select up %s options.';
$txt['poll_remove'] = 'Delete poll';
$txt['poll_remove_warn'] = 'Are you sure you want to remove this post survey?';
$txt['poll_results_expire'] = 'The results will be displayed once the survey is closed';
$txt['poll_expires_on'] = 'The vote closes';
$txt['poll_expired_on'] = 'Voting closed';
$txt['poll_change_vote'] = 'Delete Vote';
$txt['poll_return_vote'] = 'Voting Options';

$txt['quick_mod_remove'] = 'Delete selected(s)';
$txt['quick_mod_lock'] = 'Lock selected(s)';
$txt['quick_mod_sticky'] = 'Sticky selected(s)';
$txt['quick_mod_move'] = 'Move selected(s) to';
$txt['quick_mod_merge'] = 'Split selected(s)';
$txt['quick_mod_markread'] = 'Mark selected as read';
$txt['quick_mod_go'] = 'Go!';
$txt['quickmod_confirm'] = 'Are you sure you want to do this?';

$txt['spell_check'] = 'Check Spelling';

$txt['quick_reply_1'] = 'Quick Reply';
$txt['quick_reply_2'] = 'In the <i>quick reply</i> you can use the BBC and smileys as you would in a normal message, but in a more convenient way.';
$txt['quick_reply_warning'] = 'Warning: The post is locked!<br />Only admins and moderators can reply.';

$txt['notification_enable_board'] = 'Are you sure you want to enable notification of new posts for this category?';
$txt['notification_disable_board'] = 'Are you sure you want to disable notification of new posts for this category?';
$txt['notification_enable_topic'] = 'Are you sure you want to activate the notification of new replies to this post?';
$txt['notification_disable_topic'] = 'Are you sure you want to disable the notification of new replies to this post?';

$txt['rtm1'] = 'Report to moderator';

$txt['unread_topics_visit'] = 'New unread posts';
$txt['unread_topics_visit_none'] = 'Didnt match any unread posts since last visit.  <a href="' . $scripturl . '?action=unread;all">You can <i>clic</i> here to try all unread posts</a>.';
$txt['unread_topics_all'] = 'All unread posts';
$txt['unread_replies'] = 'updated posts';

$txt['who_title'] = 'Online users';
$txt['who_and'] = ' and ';
$txt['who_viewing_topic'] = ' are viewing this post.';
$txt['who_viewing_board'] = ' are seeing this category.';
$txt['who_member'] = 'User';

$txt['valid_html'] = 'HTML 4.01 valid';
$txt['valid_xhtml'] = 'XHTML 1.0 valid!';
$txt['valid_css'] = 'CSS valid!';

$txt['guest'] = 'Anonymous';
$txt['guests'] = 'Anonymous';
$txt['user'] = 'User';
$txt['users'] = 'Users';
$txt['hidden'] = 'Hidden';
$txt['buddy'] = 'Friend';
$txt['buddies'] = 'Friends';
$txt['most_online_ever'] = 'Most Online Ever';
$txt['most_online_today'] = 'Most Online Today';

$txt['merge_select_target_board'] = 'Select a category fate of combined post';
$txt['merge_select_poll'] = 'Select which survey has the combined post';
$txt['merge_topic_list'] = 'Select posts to combine';
$txt['merge_select_subject'] = 'Select the title of the post combined';
$txt['merge_custom_subject'] = 'Custom title';
$txt['merge_enforce_subject'] = 'Change the title of all posts';
$txt['merge_include_notifications'] = 'Does notifications?';
$txt['merge_check'] = 'Merge?';
$txt['merge_no_poll'] = 'No Poll';

$txt['response_prefix'] = 'Re: ';
$txt['current_icon'] = 'Current icon';

$txt['smileys_current'] = 'Current set of Smileys';
$txt['smileys_none'] = 'No Smileys';
$txt['smileys_forum_board_default'] = 'Those that are using the default web';

$txt['search_results'] = 'Search results';
$txt['search_no_results'] = 'Results not found';

$txt['totalTimeLogged1'] = 'Total time spent online: ';
$txt['totalTimeLogged2'] = ' days, ';
$txt['totalTimeLogged3'] = ' hours and ';
$txt['totalTimeLogged4'] = ' minutes.';
$txt['totalTimeLogged5'] = 'd ';
$txt['totalTimeLogged6'] = 'h ';
$txt['totalTimeLogged7'] = 'm';

$txt['approve_thereis'] = 'There';
$txt['approve_thereare'] = 'There';
$txt['approve_member'] = 'one user';
$txt['approve_members'] = 'users';
$txt['approve_members_waiting'] = 'awaiting approval.';

$txt['notifyboard_turnon'] = 'Want an email alert when someone publishes a new post in this category?';
$txt['notifyboard_turnoff'] = 'Do you really NOT want to receive notifications of new posts in this category?';

$txt['activate_code'] = 'Your activation code is';

$txt['find_members'] = 'Search users';
$txt['find_username'] = 'Name, user name or email address';
$txt['find_buddies'] = 'Show friends only?';
$txt['find_wildcards'] = 'Wildcards allowed: *, ?';
$txt['find_no_results'] = 'Not found results';
$txt['find_results'] = 'Results';
$txt['find_close'] = 'Close';

$txt['unread_since_visit'] = 'Show unread posts since last visit.';
$txt['show_unread_replies'] = 'Show new replies to your messages.';

$txt['change_color'] = 'Change color';

$txt['quickmod_delete_selected'] = 'Delete selected';

// In this string, don't use entities. (&amp;, etc.)
$txt['show_personal_messages'] = 'You received one or more private messages.\\nWould you like to see them now (in a new window)?';

$txt['previous_next_back'] = '&laquo; previous';
$txt['previous_next_forward'] = 'nexto &raquo;';

$txt['movetopic_auto_board'] = '[CATEGORY]';
$txt['movetopic_auto_topic'] = '[URL POST]';
$txt['movetopic_default'] = 'The topic has been moved to ' . $txt['movetopic_auto_board'] . ".\n\n" . $txt['movetopic_auto_topic'];

$txt['upshrink_description'] = 'Shrink or expand header.';

$txt['mark_unread'] = 'Mark as unread';

$txt['ssi_not_direct'] = 'Please log in to SSI.php directly using the URL, better use the path (%s) or add ?ssi_function=some_value.';
$txt['ssi_session_broken'] = 'SSI.php couldnt load a session!  This can cause problems with some functions, such as entering or leaving - Please make sure SSI.php is always included at the beginning * before * any code in all your scripts!';

// Escape any single quotes in here twice.. 'it\'s' -> 'it\\\'s'.
$txt['preview_title'] = 'Preview...';
$txt['preview_fetch'] = 'Preview...';
$txt['preview_new'] = 'New Message';
$txt['error_while_submitting'] = 'There was an error posting this message:.';

$txt['split_selected_posts'] = 'Selected posts';
$txt['split_selected_posts_desc'] = 'The messages shown below will form a new post once divided.';
$txt['split_reset_selection'] = 'reset selections';

$txt['modify_cancel'] = 'Cancel';
$txt['mark_read_short'] = 'Mark as read';

$txt['pm_short'] = 'My Messages';
$txt['hello_member_ndt'] = 'Hi';

$txt['ajax_in_progress'] = '<img alt="" border="0" src="Themes/default/images/icons/icono-cargando.gif">  Loading...';


$txt['hide_hiddentext'] = 'Here is a little secret ... Or not?';
$txt['hide_unhiddentext'] = 'My little secret is now displayed ... Or not?';


$txt['thank_you_link_beforecounter'] = 'For this post,';
$txt['thank_you_link_members'] = 'members';
$txt['thank_you_link_member'] = 'member';
$txt['thank_you_link_aftercounter'] = 'thanked!';
$txt['thank_you_is_locked'] = 'Thanks is closed';
$txt['thank_you_post_post_b'] = 'Thanks';
$txt['thank_you_post_delete_b'] = 'Delete Thanks';
$txt['thank_you_post_lock_b'] = 'Close Thanks';
$txt['thank_you_post_open_b'] = 'Open Thanks';
$txt['thank_you_post_lock_all_b'] = 'Remove all Thanks';
$txt['thank_you_post_open_all_b'] = 'Open all Thanks';
$txt['remove_thank_you_post'] = 'Delete this Thanks';
$txt['followgiveathank'] = 'The following members were thanked for your post:';
$txt['thank_you_post_unlock_all'] = 'Open all Thanks';
$txt['thankyoupostlist'] = 'Thanks list for post (Complete)';
$txt['thankyouposterrorinscript'] = 'Script error... Oops';
$txt['thank_you_post_thx_display'] = 'Thanks';
$txt['thank_you_post_made_display'] = 'Give';
$txt['thank_you_post_became_display'] = 'Received';

$txt['last_posts'] = 'Latest posts';
$txt['last_comments'] = 'Latest comments';
$txt['last_comments'] = 'Latest comments';
$txt['protocol'] = 'Rules';
$txt['link_us'] = 'Link us';
$txt['widget'] = 'Widget';
$txt['contact'] = 'Contact';
$txt['recomend'] = 'Recommend';
$txt['sitemap'] = 'Sitemap';
$txt['termns'] = 'TOS';
$txt['copyright'] = 'Powered by <a href="http://www.spirate.net">Spirate</a> & <a href="http://www.simplemachines.org">SMF</a>';
$txt['start'] = 'Home';
$txt['help'] = 'Help';
$txt['search'] = 'Search';
$txt['chat'] = 'Chat';
$txt['register'] = 'Register!';
$txt['user_name'] = 'Username:';
$txt['password'] = 'Password:';
$txt['start_ses'] = 'Login';
$txt['question_register'] = 'Not register?';
$txt['register_now'] = 'Register Now!';
$txt['tops'] = 'TOPs';
$txt['publish'] = 'Publish';
$txt['pm'] = 'Private Messages';
$txt['monitor'] = 'User Monitor';
$txt['my_gallery'] = 'My Gallery';
$txt['my_favourites'] = 'My Favorites';
$txt['my_account'] = 'My Account';
$txt['my_profile'] = 'My Profile';
$txt['exit'] = 'Logout';
$txt['hist_mod'] = 'History moderation';
$txt['search_empty'] = 'You must type a search term.';
$txt['my_friends'] = 'My Friends';
$txt['new_pm'] = 'New PM';
?>