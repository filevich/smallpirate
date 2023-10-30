<?php

//Spirate v2.3

function template_main()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
$request = mysql_query("
SELECT *
FROM {$db_prefix}members AS m
WHERE ".$context['user']['id']." = m.ID_MEMBER");
while ($grup = mysql_fetch_assoc($request))
{	
$context['idgrup'] = $grup['ID_POST_GROUP'];
$context['leecher'] = $grup['ID_POST_GROUP'] == '4';
$context['novato'] = $grup['ID_POST_GROUP'] == '5';
$context['buenus'] = $grup['ID_POST_GROUP'] == '6';
}
echo '<script language="JavaScript" type="text/javascript">
			function oblig(subject,message,tags,f){
			if(message.length>63206){
				alert(\'', $txt['post_way_too_large'],'\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'', $txt['category_missing'],'\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'', $txt['empty_post'],'\');
				return false;
			}

			if(subject == \'\'){
				alert(\'', $txt['empty_title'],'\');
				return false;
			}

			if(tags == \'\'){
				alert(\'', $txt['insert_tags'],'\');
				return false;
			}
var x,y;
var separar_tags = new Array();

separar_tags = tags.split(",");
if(separar_tags.length -1 >= 2)
{
for (x in separar_tags)
{
   if (separar_tags[x].length <3)
   {
       alert("', $txt['short_tag'],'");
       return;
   }
   else
   {
   for (y in separar_tags)
   {
    if (separar_tags[x]==separar_tags[y] & x != y)
    {
        alert("', $txt['repetided_tags'],'");
        return;
    }
   }
   }
}
}
else 
{
   alert("', $txt['how_to_tag_a_post'],'");
   return;
}
}
	    function cerrar_vprevia(){
	$(\'#preview\').fadeOut("slow");;
	}
	function scrollUp(){
			var cs = (document.documentElement && document.documentElement.scrollTop)? document.documentElement : document.body;
			var step = Math.ceil(cs.scrollTop / 10);
			scrollBy(0, (step-(step*2)));
			if(cs.scrollTop>0)
        setTimeout(\'scrollUp()\', 40);
		}
	';
	echo '</script>';
if ((!$context['is_new_post'])){
	echo'<script>function vprevia(subject,message,f) {
		if(message.length>63206){
				alert(\'', $txt['post_way_too_large'],'\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'', $txt['category_missing'],'\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'', $txt['empty_post'],'\');
				return false;
			}

			if(subject == \'\'){
				alert(\'', $txt['empty_title'],'\');
				return false;
			}
		data_ = {message:$(\'textarea\').val()} //"message="+ $(\'#message\').val();
         $.ajax({
            type: "POST",
            url: \'vprevia.php\',
			data: data_,
            
            success: function(h){
    			scrollUp();
          $(\'#preview\').html(h);
          $(\'#preview\').css(\'display\',\'inline\');

             }
        });        
    }</script>';}
    else
	echo'<script>function vprevia(subject,message,tags,f) {
		if(message.length>63206){
				alert(\'', $txt['post_way_too_large'],'\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'', $txt['category_missing'],'\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'', $txt['empty_post'],'\');
				return false;
			}

			if(subject == \'\'){
				alert(\'', $txt['empty_title'],'\');
				return false;
			}

			if(tags == \'\'){
				alert(\'', $txt['insert_tags'],'\');
				return false;
			}
var x,y;
var separar_tags = new Array();

separar_tags = tags.split(",");
if(separar_tags.length -1 >= 2)
{
for (x in separar_tags)
{
   if (separar_tags[x].length <3)
   {
       alert("', $txt['short_tag'],'");
       return;
   }
   else
   {
   for (y in separar_tags)
   {
    if (separar_tags[x]==separar_tags[y] & x != y)
    {
        alert("', $txt['repetided_tags'],'");
        return;
    }
   }
   }
}
}
else 
{
   alert("', $txt['how_to_tag_a_post'],'");
   return;
}
		data_ = {message:$(\'textarea\').val()} //"message="+ $(\'#message\').val();
         $.ajax({
            type: "POST",
            url: \'vprevia.php\',
			data: data_,
            
            success: function(h){
    			scrollUp();
          $(\'#preview\').html(h);
          $(\'#preview\').css(\'display\',\'inline\');

             }
        });        
    }</script>';
	
echo'<form action="',$scripturl,'?action=' . $context['destination'] . ';board=4" method="post" accept-charset="', $context['character_set'], '" name="postmodify" id="postmodify" enctype="multipart/form-data">';
echo '<div id="preview" style="display:none;"></div>
<div>
<div style="margin-bottom: 8px;">
<div class="box_235" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 235px;"><div class="box_txt box_235-34"><center>', $txt['warning_post'],'</center></div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" border="2" style="width: 225px; padding: 4px;"><tt><font face="Arial, Helvetica, sans-serif">', $txt['before_posting'],'</font></tt><br>
</b>

<br /><b class="size12">', $txt['post_title'],'</b>

<br /><br /><b class="size10"><img src="',$settings['images_url'],'/icon-good.png" align="absmiddle" vspace="2">', $txt['descriptive'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['mayus_letter'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['exagerated'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['partially_mayus'],'</li>
	

<br /><br /><b class="size12"><b>', $txt['post_content'],'</b>

<br /><br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['others_info'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['gore'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['racist'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['poor_content'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['this_is_not_a_forum'],'</li>
<br /><b class="size10"><img src="',$settings['images_url'],'/icon-bad.png" align="absmiddle" vspace="2">', $txt['insulting'],'</li>
						
						
<br /><br /><b class="size12">	<b>', $txt['second_warning'],'</b>

<br /><br /><b class="size10">', $txt['follow_the_rules_or'],'</b><hr>
<b class="size10">', $txt['no_porn_in_here'],'</a></b>

<br /><br /><b class="size12"><a href="',$boardurl,'?action=protocolo" target="_blank"><b>', $txt['read_the_protocol'],'</b></a></div></div>
<div class="ed-ag-post" style="float:left;">
<div class="box_title" style="width: 686px;"><div class="box_txt ed-ag-posts"><center>';
if ((!$context['is_new_post'])){echo $context['submit_label'].'';}else echo'Agregar nuevo post'; echo'</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>';
echo'<div class="windowbg" border="0" style="width: 676px; padding: 4px;">
<input type="hidden" name="topic" value="' . $context['current_topic'] . '" />';
echo'<b class="size11">', $txt[70], ':</b><br>
<input type="text" name="subject"', $context['subject'] == '' ? '' : ' value="' . $context['subject'] . '"', ' tabindex="1" size="60" maxlength="54" /><br>';
theme_postbox($context['message']);
echo'</div></div>';
echo'<input type="hidden" name="additional_options" value="', $context['show_additional_options'] ? 1 : 0, '" />
	 <input type="hidden" name="sc" value="', $context['session_id'], '" />
	 <input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
	</div></div></form>';
}

function template_postbox(&$message)
{
	global $context, $settings, $options, $txt, $modSettings, $db_prefix;

if($_GET['topic'])
{$inputs = mysql_query("
SELECT *
FROM ({$db_prefix}messages AS men, {$db_prefix}topics AS t)
WHERE ".$_GET['topic']." = men.ID_TOPIC 
      AND men.ID_TOPIC = t.ID_TOPIC");
while ($grup = mysql_fetch_assoc($inputs))
{	
$context['ID_BOARD'] = $grup['ID_BOARD'];
$context['hiddenOption'] = $grup['hiddenOption'];
$context['isSticky'] = $grup['isSticky'];
$context['locked'] = $grup['locked'];
}	
mysql_free_result($inputs);
}
else
echo'';
	if ($context['show_bbc'])
	{echo '<b class="size11">', $txt['post_message'],'</b><br>
		';

		$found_button = false;
			foreach ($context['bbc_tags'][0] as $image => $tag)
		{
						if (isset($tag['before']))
			{
		
				if (!empty($context['disabled_tags'][$tag['code']]))
					continue;

				$found_button = true;

				if (!isset($tag['after']))
					echo '<a href="javascript:void(0);" onclick="replaceText(\'', $tag['before'], '\', document.forms.', $context['post_form'], '.', $context['post_box_name'], '); return false;">';
				else
					echo '<a href="javascript:void(0);" onclick="surroundText(\'', $tag['before'], '\', \'', $tag['after'], '\', document.forms.', $context['post_form'], '.', $context['post_box_name'], '); return false;">';

				echo '<img src="', $settings['images_url'], '/bbc/', $image, '.gif" align="bottom" alt="', $tag['description'], '" title="', $tag['description'], '" border="0" hspace="2"/></a>&nbsp;';
			}
			elseif ($found_button)
			{
				echo '';
				$found_button = false;
			}
		}

		$found_button = false;
		foreach ($context['bbc_tags'][1] as $image => $tag)
		{
			if (isset($tag['before']))
			{
				if (!empty($context['disabled_tags'][$tag['code']]))
					continue;

				$found_button = true;
			}
					elseif ($found_button)
			{
				echo '';
				$found_button = false;
			}
		}


	}

	echo '<textarea style="height:300px;width:615px;" id="markItUp" name="', $context['post_box_name'], '" class="markItUpEditor" tabindex="3">', $message, '</textarea><br>';
if (!empty($context['smileys']['postform']))
	{
		echo '';
foreach ($context['smileys']['postform'] as $smiley_row)
		{
			foreach ($smiley_row['smileys'] as $smiley)
				echo '
					<a  style="padding-right:4px;" href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.', $context['post_form'], '.', $context['post_box_name'], '); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a>';}}
if (!empty($context['smileys']['popup']))
echo '<script type="text/javascript">function openpopup(){var winpops=window.open("',$boardurl,'emoticones.php","","width=255px,height=500px,scrollbars");}</script> <a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a>';


if(!isset($context['num_replies'])){
echo'<br><b class="size11">Tags:</b><br><input type="text" name="tags"', ' tabindex="3" size="60" maxlength="200" /><br><font class="size9">Una lista separada por comas, que describa el contenido. Ejemplo: Calamaro, Disco, M&uacute;sica.</font>';}

echo'<br><font class="size11"><b>',$txt['post_category'],':</b></font><br><select tabindex="5" id="categorias" name="categorias" size="23" style="width: 230px;">
<option value="-1" selected="selected">', $txt['choose_category'],'</option>';
foreach ($context['boards'] as $board)
{echo '<option value="', $board['id'], '" '; if($context['ID_BOARD']==$board['id'])echo'selected="true"'; echo' >', $board['name'], '</option>';}
echo'</select>';
echo'<br><font class="size11"><b>', $txt['options'],'</b></font>';

if($context['can_sticky']){
if($context['sticky']){
	echo '<br><label for="check_sticky"><input type="checkbox" tabindex="6" name="sticky" id="check_sticky" value="0" class="check" />', $txt['delete_sticky'],'</label>';}
 else echo'<br><label for="check_sticky"><input type="checkbox" tabindex="6" name="sticky" id="check_sticky" value="1" class="check" />', $txt['add_sticky'],'</label>';
 }

 if($context['can_lock']){
 	if($context['locked']){
 echo'<br><label for="check_lock"><input type="checkbox" name="lock" tabindex="8" id="check_lock" value="0" class="check" />', $txt['allow_comments'],'</label>';}  else echo'<br><label for="check_lock"><input tabindex="8" type="checkbox" name="lock" id="check_lock" value="1" class="check" />', $txt['not_allow_comments'],'</label>';}

if ($context['hiddenOption']){
echo'<br><label for="hiddenOption"><input class="check" type="checkbox" tabindex="9" name="hiddenOption" id="hiddenOption" value="0">', $txt['quit_only_users'],'</label>';}
else {echo'<br><label for="hiddenOption"><input class="check" type="checkbox" tabindex="9" name="hiddenOption" id="hiddenOption" value="1">', $txt['only_users'],'</label>';}


if ((!$context['is_new_post'])){
echo'<center><input onclick="vprevia(this.form.subject.value, this.form.message.value, this.form);" class="button" style="font-size: 15px;" value="Previsualizar" title="', $txt['preview'],'" type="button">
</center>';
}else
echo'<center><input onclick="vprevia(this.form.subject.value, this.form.message.value, this.form.tags.value, this.form);" class="button" style="font-size: 15px;" value="Previsualizar" title="', $txt['preview'],'" type="button">';

echo'<br>';
}

function template_spellcheck(){}
function template_quotefast(){}
function template_announce(){}
function template_announcement_send(){}
function template_quickreply_box(){}
?>