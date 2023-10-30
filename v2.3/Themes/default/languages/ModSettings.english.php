<?php
// Version: 1.1.5; ModSettings

$txt['smf3'] = 'This page allows you to change the configuration of features, mods, and basic choices of your forum. Please check the<a href="' . $scripturl . '?action=theme;sa=settings;th=' . $settings['theme_id'] . ';sesc=' . $context['session_id'] . '">Theme Settings</a> For more Options.<i>click</i> in the help images to get more information.';

$txt['mods_cat_features'] = 'Basic Settings';
$txt['pollMode'] = 'Poll Mode';
$txt['smf34'] = 'Disable Polls';
$txt['smf32'] = 'Enable Polls';
$txt['smf33'] = 'Show Polls With Topics';
$txt['allow_guestAccess'] = 'Allow Guest To View The Webpage';
$txt['userLanguage'] = 'Activate Languages Selected By The User';
$txt['allow_editDisplayName'] = 'Allow Users To Select/Change Their Names?';
$txt['allow_hideOnline'] = 'Allow Users To Be Hidden?';
$txt['allow_hideEmail'] = 'Allow Users To Hide Their E-Mail';
$txt['guest_hideContacts'] = 'Hide Contact Things To Guests';
$txt['titlesEnable'] = 'Enable Personalized Title';
$txt['enable_buddylist'] = 'Enable Buddy List';
$txt['default_personalText'] = 'Default Personal Text';
$txt['max_signatureLength'] = 'Max Signature Length<div class="smalltext">(0 Is No Max)</div>';
$txt['number_format'] = 'Number Format';
$txt['time_format'] = 'Time Format';
$txt['time_offset'] = 'Global Time Offset';
$txt['failed_login_threshold'] = 'Time To Wait After The Login Failed';
$txt['lastActive'] = 'Time After The Last Action, That The User Will Be Shown In The Who';
$txt['trackStats'] = 'Track Stats';
$txt['hitStats'] = 'Track Hits(The Track Stats May Be Enabled';
$txt['enableCompressedOutput'] = 'Enable Compressed Output';
$txt['databaseSession_enable'] = 'Enable Sessions From De Database';
$txt['databaseSession_loose'] = 'Allow browsers to return to the pages in the cache';
$txt['databaseSession_lifetime'] = 'Seconds for a unused session to expire ';
$txt['enableErrorLogging'] = 'Enable The Error Log';
$txt['cookieTime'] = 'Cookie Time (in minutes)';
$txt['localCookies'] = 'Enable local storage of cookies<div class="smalltext">(the SSI won´t work properly.)</div>';
$txt['globalCookies'] = 'Use subdomain independent cookies?<div class="smalltext">Warning: You must disable local cookies first!</div>';
$txt['securityDisable'] = 'Disable The Admin Security?';
$txt['send_validation_onChange'] = 'Send by Email New Password If, The User Changes His Email';
$txt['approveAccountDeletion'] = 'Require The Approvement Of The admin,to delete own accounts?';
$txt['autoOptDatabase'] = 'Optimize Tables Each How Many Days?<div class="smalltext">(0 Means Disabled)</div>';
$txt['autoOptMaxOnline'] = 'Maximum online users while optimizing<div class="smalltext">(0 Means No Max)</div>';
$txt['autoFixDatabase'] = 'Autofix Tables With Problems';
$txt['allow_disableAnnounce'] = "Allow users to disable the notifications of \'Forum Classifieds \'";
$txt['disallow_sendBody'] = 'Do not allow sending the text message notifications?';
$txt['modlog_enabled'] = 'Save The Moderation Log';
$txt['queryless_urls'] = 'Show URLs Without ?s<div class="smalltext"><b>Only Apache!</b></div>';
$txt['max_image_width'] = 'Maximum width of the images in posts (0 = disabled)';
$txt['max_image_height'] = 'Maximum height of images in the posts (0 = disabled)';
$txt['mail_type'] = 'Mail Type';
$txt['mail_type_default'] = '(PHP Default)';
$txt['smtp_host'] = 'SMTP Server';
$txt['smtp_port'] = 'SMTP Port';
$txt['smtp_username'] = 'SMTP User';
$txt['smtp_password'] = 'SMTP Password';
$txt['enableReportPM'] = 'Enable private messaging alert';

$txt['max_pm_recipients'] = 'Maximum number of recipients allowed in a private message.<div class="smalltext">(0 Means unlimited)</div>';
$txt['pm_posts_verification'] = 'Users with a number of messages below the established, must enter a code when they send a personal message.<div class="smalltext">(0 Means Unlimited)</div>';
$txt['pm_posts_per_hour'] = 'Number of personal messages that can be sent by a user in an hour.<div class="smalltext">(0 Means Unlimited)</div>';

$txt['mods_cat_layout'] = 'Design (Themes)';
$txt['compactTopicPagesEnable'] = 'Compact Theme Mod Enable ';
$txt['smf235'] = 'Number Of Pages To Show:';
$txt['smf236'] = 'To Show';
$txt['todayMod'] = "Activate Today´s Mod ";
$txt['smf290'] = 'Unabled';
$txt['smf291'] = 'Only Today';
$txt['smf292'] = 'Today And Yesterday';
$txt['topbottomEnable'] = "Activate Buttons,Go Up, Go Down";
$txt['onlineEnable'] = 'Show Online/offline Users In Pm And Posts';
$txt['enableVBStyleLogin'] = 'Activate Login As  VB';
$txt['defaultMaxMembers'] = 'Maximum Number Of Users In The Complete List';
$txt['timeLoadPageEnable'] = 'Show time taken to create each page';
$txt['disableHostnameLookup'] = '&iquest;Desactivar la b&uacute;squeda de los nombres de los servidores?';
$txt['who_enabled'] = 'Enable The Who Is Online';

$txt['smf293'] = 'Karma';
$txt['karmaMode'] = 'Karma Mode';
$txt['smf64'] = 'Disable Karma|Enable Karma Total|Activate Karma Positive/Negative';
$txt['karmaMinPosts'] = 'Specify the minimum number of messages required to change the karma';
$txt['karmaWaitTime'] = 'Specify the wait time in hours';
$txt['karmaTimeRestrictAdmins'] = 'Restrict admins to wait';
$txt['karmaLabel'] = 'Karma Label';
$txt['karmaApplaudLabel'] = 'Applaud Karma Label';
$txt['karmaSmiteLabel'] = 'Smite Karma Label';

$txt['caching_information'] = '<div align="center"><b><u>&iexcl;Important! Read This Before Enabling This Options.</b></u></div><br />
	SPirate! supports caching through the use of accelerators. Accelerators that are currently supported:<br />
	<ul>
		<li>APC</li>
		<li>eAccelerator</li>
		<li>Turck MMCache</li>
		<li>Memcached</li>
		<li>Zend Platform/Performance Suite (It is Not A Zend Optimizer)</li>
	</ul>
	Make cache only work on your server if you have PHP compiled with one of the above optimizers, or if you have memcache
available. <br /><br />
	Spirate performs the cache at several levels. A higher level of cache, CPU will be used more
when you read the information in the cache. If you have this functionality we recommend you first try to level 1 of cache.
	<br /><br />
	Note that if you use memcached you must provide the server details in the configuration below. This should be entered as a comma separated list
as shown in the example below:<br />
	&quot;server1,server2,server3:port,server4&quot;<br /><br />
	Note that if the port is not specified Spirate will use the port 11211. Spirate will attempt a random load balancing between servers.
	<br /><br />
	%s
	<hr />';

$txt['detected_no_caching'] = '<b style="color: red;">Spirate has not found any compatible accelerator installed on your server.</b>';
$txt['detected_APC'] = '<b style="color: green">Spirate Detected that you have installed APC.';
$txt['detected_eAccelerator'] = '<b style="color: green">Spirate Detected that you have installed  eAccelerator.';
$txt['detected_MMCache'] = '<b style="color: green">Spirate Detected that you have installed  MMCache.';

$txt['detected_Zend'] = '<b style="color: green">Spirate Detected that you have installed  Zend installed.';
$txt['detected_Memcached'] = '<b style="color: green">Spirate  Detected that you have installed  Memcached installed.';

$txt['cache_enable'] = 'Caching Level';
$txt['cache_off'] = 'Cache Off';
$txt['cache_level1'] = 'Cache Level 1 ;';
$txt['cache_level2'] = 'Cache Level 2 (Not Recommended)';
$txt['cache_level3'] = 'Cache Level 3 (Not Recommended)';
$txt['cache_memcached'] = 'Memcache Settings';



$txt['thankyouposttitle'] = 'Thank In Message';
$txt['thankYouPostColors'] = 'Allow colors to be shown  (members) in the Acknowledgements list.';
$txt['thankYouPostOnePerPost'] = 'Users Can Thank In Posts<br />
<span class="smalltext">If Disabled,Users Will Only Can Thank In Topics</span>';
$txt['thankYouPostPreview'] = 'Allow A Preview.';
$txt['thankYouPostPreviewHM'] = 'Names In The Preview?<br /><span class="smalltext"><strong>(0 = all)</strong></span></';
$txt['thankYouPostPreviewOrder'] = 'Preview Order';
$txt['thankYouPostPreviewOrderSelect'] = 'Acknowledgements early first | Latest first Acknowledgements';
$txt['thankYouPostFullOrder'] = 'The Complete List Order';
$txt['thankYouPostFullOrderSelect'] = 'cknowledgements early first | Latest first Acknowledgements | Member Names';
$txt['thankYouPostHideExtraInfo'] = 'Requires The Hidde Link Mod';
$txt['thankYouPostUnhidePost'] = 'Discover the contents of the post after Thanksgiving there.
<br /><span class="smalltext">This only reveals the post in which it was made Thank you, but if the user is normal post is found it will show all!</span>'.$txt['thankYouPostHideExtraInfo'];
$txt['thankYouPostThxUnhideAll'] = 'When Thanksgiving will discover all hidden files!
<br /><span class="smalltext">Discover all content after giving thanks single post in any Topic (Disable Option 1)</span>'.$txt['thankYouPostHideExtraInfo'];
$txt['thankYouPostDisableUnhide'] = 'isable the option to discover content, after posting, just may find out Thanks!
<br /><span class="smalltext">You have to thank to discover the content it depends on the options 1 / 2 as many may find</span>'.$txt['thankYouPostHideExtraInfo'];
$txt['thankYouPostDisplayPage'] = 'Post thankful for given and received in Topic';

$txt['mods_cat_meta'] = 'Meta';
$txt['meta_mod'] = 'Easy Edit Meta Data';
$txt['meta_description'] = 'Meta Description';
$txt['meta_keywords'] = 'Meta Keywords';
$txt['meta_author'] = 'Meta Author';
$txt['meta_copyright'] = 'Meta Copyright';
?>