<?php
// Version 1.2.0;

function template_Begin() {}

function template_Boards() {
	global $context, $scripturl, $txt, $modSettings, $settings, $url;

	if(isset($context['sitemap']['board']))
		$switch = false;
		
		
		echo'<table align="center"><tr align="center"><td align="center"><div class="box_300" style="float: left; margin-right: 8px;" align="left">

<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['general'], '</div>
<div class="box_rss"><img alt="" src="/Themes/default/images/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="windowbg" style="padding:4px;width:290px;"><span class="size11"><a href="', $scripturl ,'?action=search" title="', $txt['searcher'],'">', $txt['searcher'], '</a><br />
<a href="', $scripturl ,'?action=rz;m=4674868" title="', $txt['chat'],'">', $txt['chat'],'</a><br /><a href="', $scripturl ,'?action=contactenos" title="',$txt['contact'],'">',$txt['contact'],'</a><br /><a href="', $scripturl ,'?action=enlazanos" title="', $txt['share_us'], '">', $txt['share_us'], '</a><br />
<a href="', $scripturl ,'?action=protocolo" title="', $txt['protocol'], '">', $txt['protocol'], '</a><br /><a href="', $scripturl ,'?action=widget" title="', $txt['widget'], '">', $txt['widget'], '</a><br />
<a href="', $scripturl ,'?action=terminos-y-condiciones" title="', $txt['TOS'], '">', $txt['TOS'], '</a><br /><a href="', $scripturl ,'?action=TOPs" title="', $txt['top'], '">', $txt['top'], '</a><br />
<a href="', $scripturl ,'?action=sitemap;xml" title="XML">XML</a>
</span><br /></div></div>

<div class="box_300" style="float: left; margin-right: 8px;" align="left">

<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['categories'], '</div>
<div class="box_rss"><img src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" style="padding: 4px; width: 290px;"><span class="size11">';
		foreach($context['sitemap']['board'] as $board) {
			if ($board['level'] == 0 && $switch) {
				$switch = false;
			}
echo '<a href="', $scripturl ,'?id=',$board['id'],'" title="',$board['name'],' | ', $txt['topic'], ': ', $board['numt'], '">',$board['name'],'</a><br />';}
echo'</span></div></div>
<div class="box_300" style="float: left;" align="left">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['rss'], '</div>
<div class="box_rss"><img alt="" src="/Themes/default/images/blank.gif" style="width: 16px;height:16px;" border="0" /></div></div><div class="windowbg" style="padding: 4px; width: 290px;"><span class="size11">
<a href="',$url,'/web/rss/rss-ultimos-post.php" title="', $txt['lasts_topics'], '">', $txt['lasts_topics'], '</a><br />
<a href="',$url,'/web/rss/rss-comment.php" title="', $txt['lasts_posts'], '">', $txt['lasts_posts'], '</a>

</span><br /></div></div></td></tr></td></tr></table>';

}

function template_Topics() {}
function template_End() {}
function template_XMLDisplay() {
	global $context, $scripturl, $modSettings;

	// Test to see if Joomla!/Mambo is here...
	if (defined('_VALID_MOS' )) {
		global $mosConfig_live_site, $Itemid, $mosConfig_sef;
		$myurl = ($mosConfig_sef=='1' ? '' : $mosConfig_live_site. '/') . 'index.php?option=com_smf&amp;Itemid=' . $Itemid;
		$mark = '&amp;';
	}
	// And if its not here, create our own function...
	else {
		$myurl = $scripturl;
		$mark = '?';
		function sefReltoAbs($string) {
			global $modSettings, $scripturl;
			if (!empty($modSettings['pretty_enable_filters']) ||
				empty($modSettings['queryless_urls']) || 
				$string == $scripturl)
				return $string;
			$string = str_replace('?board=', '/board,', $string);
			$string = str_replace('?topic=', '/topic,', $string);
			$string = $string . '.html';
			return $string;
		}
	}


	echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';

	echo '
	<url>
		<loc>', sefReltoAbs($myurl), '</loc>
		<lastmod>', $context['sitemap']['main']['time'], '</lastmod>
		<changefreq>always</changefreq>
		<priority>1.0</priority>
	</url>';

	if (isset($context['sitemap']['board']))
	foreach ($context['sitemap']['board'] as $board)
		echo '
	<url>
		<loc>', sefReltoAbs($myurl . $mark . 'board=' . $board['id']), '</loc>
		<lastmod>', $board['time'], '</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>';

	if (isset($context['sitemap']['topic']))
	foreach ($context['sitemap']['topic'] as $topic)
		echo '
	<url>
		<loc>', sefReltoAbs($myurl . $mark . 'topic=' . $topic['id']), '</loc>
		<lastmod>', $topic['time'], '</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
	</url>';


	echo '
</urlset>';

}
?>