<?php
if (!defined('SMF'))
	die('Hacking attempt...');

function template_main()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
$request = mysql_query("
SELECT *
FROM smf_members AS m
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
				alert(\'El post es demasiado largo. No debe exceder los 65000 caracteres.\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'Falta la categoria\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'El post esta VACIO.\');
				return false;
			}

			if(subject == \'\'){
				alert(\'El post NO TIENE TITULO.\');
				return false;
			}

			if(tags == \'\'){
				alert(\'Ingresar TAGS!\');
				return false;
			}
 var separar_tags = tags.split(",");
 if(separar_tags.length -1 < 2){
  alert("Tienes que ingresar por lo menos 3 tags separados por coma.\nLos tags son una lista de palabras separada por comas, que describen el contenido.\nEjemplo: Calamaro, Disco, Musica;");
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
				alert(\'El post es demasiado largo. No debe exceder los 65000 caracteres.\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'Falta la categoria\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'El post esta VACIO.\');
				return false;
			}

			if(subject == \'\'){
				alert(\'El post NO TIENE TITULO.\');
				return false;
			}
		data_ = {message:$(\'textarea\').val()} //"message="+ $(\'#message\').val();
         $.ajax({
            type: "POST",
            url: \'/vprevia.php\',
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
				alert(\'El post es demasiado largo. No debe exceder los 65000 caracteres.\');
				return false;
			}
			if(f.categorias.options.selectedIndex==-1 || f.categorias.options[f.categorias.options.selectedIndex].value==-1){
				alert(\'Falta la categoria\');
				return false;
			}
			
			if(message == \'\'){
				alert(\'El post esta VACIO.\');
				return false;
			}

			if(subject == \'\'){
				alert(\'El post NO TIENE TITULO.\');
				return false;
			}

			if(tags == \'\'){
				alert(\'Ingresar TAGS!\');
				return false;
			}
 var separar_tags = tags.split(",");
 if(separar_tags.length -1 < 2){
  alert("Tienes que ingresar por lo menos 3 tags separados por coma.\nLos tags son una lista de palabras separada por comas, que describen el contenido.\nEjemplo: Calamaro, Disco, Musica;");
        return;
      }
		data_ = {message:$(\'textarea\').val()} //"message="+ $(\'#message\').val();
         $.ajax({
            type: "POST",
            url: \'/vprevia.php\',
			data: data_,
            
            success: function(h){
    			scrollUp();
          $(\'#preview\').html(h);
          $(\'#preview\').css(\'display\',\'inline\');

             }
        });        
    }</script>';
	
echo'<form action="/?action=' . $context['destination'] . ';board=4" method="post" accept-charset="', $context['character_set'], '" name="postmodify" id="postmodify" enctype="multipart/form-data">';
echo '<div id="preview" style="display:none;"></div>
<div>
<div style="margin-bottom: 8px;">
<div class="box_235" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 235px;"><div class="box_txt box_235-34"><center>&#161;Aclaraci&oacute;n!</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" border="0" style="width: 225px; padding: 4px;"><center class="size12"><i>En esta seccion puedes agregar una
publicacion
para compartirla con nuestra comunidad.<hr>
Para que esta publicacion no sea borrada por:
moderadores/administradores.
Debe estar de acuerdo con las normas
establecidas en la web</i><br><br>
<a href="?action=protocolo" target="_blank"><b>Leer el Protocolo</b></a></center></div></div>


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
	global $context, $settings, $options, $txt, $modSettings;

if($_GET['topic'])
{$inputs = mysql_query("
SELECT *
FROM (smf_messages AS men, smf_topics AS t)
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
	{echo '<b class="size11">Mensaje del post:</b><br>
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
					<a href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.', $context['post_form'], '.', $context['post_box_name'], '); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a>';}}
if (!empty($context['smileys']['popup']))
echo '<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script> <a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a>';


if(!isset($context['num_replies'])){
echo'<br><b class="size11">Tags:</b><br><input type="text" name="tags"', ' tabindex="3" size="60" maxlength="200" /><br><font class="size9">Una lista separada por comas, que describa el contenido. Ejemplo: Calamaro, Disco, M&uacute;sica.</font>';}

echo'<br><font class="size11"><b>Categor&iacute;a:</b></font><br><select tabindex="4" id="categorias" name="categorias">
<option value="-1" selected="selected">Elejir categor&iacute;a</option>';
foreach ($context['boards'] as $board)
{echo '<option value="', $board['id'], '" '; if($context['ID_BOARD']==$board['id'])echo'selected="true"'; echo' >', $board['name'], '</option>';}
echo'</select>';
echo'<br><font class="size11"><b>Opciones:</b></font>';

if($context['can_sticky']){
if($context['sticky']){
	echo '<br><label for="check_sticky"><input type="checkbox" tabindex="6" name="sticky" id="check_sticky" value="0" class="check" /> Quitarle sticky</label>';}
 else echo'<br><label for="check_sticky"><input type="checkbox" tabindex="6" name="sticky" id="check_sticky" value="1" class="check" /> Agregarle Sticky</label>';
 }

 if($context['can_lock']){
 	if($context['locked']){
 echo'<br><label for="check_lock"><input type="checkbox" name="lock" tabindex="8" id="check_lock" value="0" class="check" /> Si permitir comentarios.</label>';}  else echo'<br><label for="check_lock"><input tabindex="8" type="checkbox" name="lock" id="check_lock" value="1" class="check" /> No permitir comentarios.</label>';}

if ($context['buenus']){ 
echo'<br><label for="hiddenOption"><input class="check" type="checkbox" tabindex="9" name="hiddenOption" id="hiddenOption" value="1"> Solo usuarios registrados.</label>';}


if ((!$context['is_new_post'])){
echo'<center><input onclick="vprevia(this.form.subject.value, this.form.message.value, this.form);" class="button" style="font-size: 15px;" value="Previsualizar" title="Previsualizar" type="button">
<input onclick="return oblig(this.form.subject.value, this.form.message.value, this.form.tags.value, this.form);" class="button" style="font-size: 15px;" value="Postear" title="Postear" type="submit">
</center>';
}else
echo'<center><input onclick="vprevia(this.form.subject.value, this.form.message.value, this.form.tags.value, this.form);" class="button" style="font-size: 15px;" value="Previsualizar" title="Previsualizar" type="button">
<input onclick="return oblig(this.form.subject.value, this.form.message.value, this.form.tags.value, this.form);" class="button" style="font-size: 15px;" value="Postear" title="Postear" type="submit"></center>';

echo'<br>';
}

function template_spellcheck(){}
function template_quotefast(){}
function template_announce(){}
function template_announcement_send(){}
function template_quickreply_box(){}
?>