<?php
// Version 1.2.0; Por Phobos91

function template_Begin() {}

function template_Boards() {
	global $context, $scripturl, $txt, $modSettings, $settings;

	if(isset($context['sitemap']['board']))
		$switch = false;
		
		
		echo'
<table align="center" style="float: center;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><center><b>Mapa del sitio</b> ', getXMLLink(), '</center></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
          
          
          <div class="box_icono" style="width: 100%">';
		foreach($context['sitemap']['board'] as $board) {
			if ($board['level'] == 0 && $switch) {
				$switch = false;
			}
			
			echo '
			<table width="100%"><tr><td width="100%"><div><div style="float: left"><div class="box_icono4"><img src="/Themes/default/images/post/icono_',$board['id'],'.gif" border="0" title="',$board['name'],'" alt="',$board['name'],'"></div><a title="',$board['name'],'" href="/categoria/', $board['id'], '" title="',$board['name'],'"><span title="',$board['name'],'">',$board['name'],'</span></a></div><div class="opc_fav" align="right">Post: ', $board['numt'], '</div></div></td></tr></table>';}
        echo'
    
	      </div>'; 
		
		  if ($context['page_index'])
		  echo'      <div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';
   
   echo'<td></tr></table>';
}

function template_Topics() {
	global $context, $scripturl, $txt;
		echo'
<table align="center" style="float: center;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><center><b>Mapa del sitio</b> ', getXMLLink(), '</center></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
          
          
          <div class="box_icono" style="width: 100%">';
$i = 1;
	if (isset($context['sitemap']['topic']))
		foreach ($context['sitemap']['topic'] as $topic) {
			
			echo '	<table width="100%">
				<tr><td width="100%"><div><div style="float: left;"><div class="box_icono4"><img alt="', $topic['name'], '" title"', $topic['name'], '" src="/Themes/default/images/post/icono_', $topic['ID_BOARD'], '.gif"></div>';
if ($context['user']['is_guest']){
if ($topic['privado']){
{echo'<img title="Post privado" src="/Themes/default/images/icons/icono-post-privado.gif">';}}  else echo'';}
echo'<a title="', $topic['subject'], '" href="', $topic['href'] ,'">', $topic['subject'], '</a></div><div class="opc_fav" align="right">Creado: ', $topic['fecha'],' por: ', $topic['poster'],' | ', $topic['puntos'],' pts. |<a title="Enviar a amigo" href="/index.php?action=enviar-a-amigo;topic=', $topic['id'],'"><img src="/Themes/default/images/icons/icono-enviar-mensaje.gif"></a></div></div></td>
				</tr></table>';
			$i++;
		}
        echo'
    
	      </div>'; 
		
		  if ($context['page_index'])
		  echo'      <div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';
   
   echo'<td></tr></table>';

}
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
function getXMLLink() {
	if (defined( '_VALID_MOS' )) {
		global $mosConfig_live_site, $Itemid;
		$retVal = '<script language="JavaScript" type="text/javascript"><!--  // --><![CDATA[
';
		$retVal .= 'document.write("<a href=\'' . $mosConfig_live_site . '/index.php?option=com_smf&amp;Itemid=' . $Itemid . '&amp;action=mapadelsitio;xml\'>XML</a>")
';
		$retVal .= '// ]]></script>';

		return $retVal;
	}
	else {
		global $scripturl;
		return '<a href="/?action=mapadelsitio;xml"><img align="absmiddle" hspace="4" src="/Themes/default/images/xml.png" title="XML" alt="XML"></a>';
	}
}
?>