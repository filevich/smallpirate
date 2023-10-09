<?php
if (!defined('SMF'))
	die('Hacking attempt...');
	
function template_pm_above()
{
	global $context, $settings, $options, $txt;
	
	echo '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>
			<td width="160px" style="padding: 0px 8px 0px 0px;" valign="top">
			<table border="0" width="100%"><form action="/?action=pm;sa=manlabels;sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '">';
	foreach ($context['pm_areas'] as $section)
	{
	
					echo '<div style="background: url(\'/Themes/default/images/title_2.png\') no-repeat;"><center><font style="color: #FFFFFF;">', $section['title'], '</font></center></div>
	<div style="background-color: #FFFFFF; border: 1px solid #E0E0B3; padding: 4px 4px 4px 4px;">';
	
				foreach ($section['areas'] as $i => $area)
		{	if ($i == $context['pm_area'])
			echo '<b>', $area['link'], (empty($area['unread_messages']) ? '' : ' (<b>' . $area['unread_messages'] . '</b>)'), '</b><br />';
			else
			echo '', $area['link'], (empty($area['unread_messages']) ? '' : ' (<b>' . $area['unread_messages'] . '</b>)'), '<br />';	
		}
		
		echo '</div><br>';
	}
	if($context['pm_areas']['labels'])
		echo'
		

		<span class="size10">Carpeta/s Seleccionada/s <input class="login" type="submit" name="delete" value="Eliminar" style="font-weight: normal;" onclick="return confirm(\'\xbfEst&aacute;s seguro que deseas borrar las carpetas seleccionadas?\');" />
		</span><br><br>'; else echo'';
	echo '</form><script language="JavaScript" type="text/javascript">
	function hidediv(id) {
	if (document.getElementById) {
		document.getElementById(id).style.display = \'none\';
	}
	else {
		if (document.layers) {
			document.id.display = \'none\';
		}
		else {
			document.all.id.style.display = \'none\';
		}
	}
}

	function esconder(id, linkid) {
if (document.getElementById(id).style.display ==  \'block\') {
document.getElementById(id).style.display = \'block\';
document.getElementById(linkid).innerHTML = \'<img border="0" alt="Carpetas" src="/Themes/default/images/icons/icono-agregar-carpeta.gif"> Crear Carpeta\'} else {
document.getElementById(id).style.display =  \'block\';
document.getElementById(linkid).innerHTML = \'<img border="0" alt="Carpetas" src="/Themes/default/images/icons/icono-agregar-carpeta.gif"> Crear Carpeta\'
}}</script>
<form action="/?action=pm;sa=manlabels;sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '">
<div style="overflow-y: auto; overflow-x: hidden;"><a href="javascript:void(0)" onClick="esconder(\'below\', \'linkid\');" id="linkid"><img border="0" alt="Carpetas" src="/Themes/default/images/icons/icono-agregar-carpeta.gif"> Crear Carpeta</a></div>
	
<div id="below" style="overflow-y: auto; overflow-x: hidden; display:none;">
		<input type="text" name="label" value="" size="26" maxlength="20" />
		<input class="login" type="submit" name="add" value="Crear Carpeta" title="Crear Carpeta" style="font-weight: normal;" /> <input class="login" style="font-weight: normal;" type="button" title="Cancelar" value="Cancelar" onclick=" hidediv(\'below\')" />
		<input type="hidden" name="sc" value="', $context['session_id'], '" />
		
		</div></form>
					</table>
					<br />
				</td>
				<td valign="top">';
}

function template_pm_below()
{
	global $context, $settings, $options;

	echo '
				</td>
			</tr></table>';
}

function template_folder()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
<form action="/?action=pm;sa=pmactions;f=', $context['folder'], ';start=', $context['start'], $context['current_label_id'] != -1 ? ';l=' . $context['current_label_id'] : '', '" method="post" accept-charset="', $context['character_set'], '" name="pmFolder">';



echo'<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Mensajes Privados</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>';
	

if(!isset($context['sl-singlepm']))
	{	
if ($context['show_delete'])
{	echo '
	<table border="0" width="100%" cellpadding="2" cellspacing="1" class="bordercolor">
		<tr style="background-color: #BBC4AF;">
			<td style="color: #FFF;" width="46%"><input type="checkbox" onclick="invertAll(this, this.form);" class="check" /> Asunto:</td>
			<td style="color: #FFF;">Por:</td>
			<td style="color: #FFF;">Fecha:</td>
		</tr>';

	$next_alternate = false;
	while ($message = $context['get_pmessage']())
	{
		echo '
		<tr class="windowbg">
		<td><input type="checkbox" name="pms[]" id="deletelisting', $message['id'], '" value="', $message['id'], '"', $message['is_selected'] ? ' checked="checked"' : '', ' onclick="document.getElementById(\'deletedisplay', $message['id'], '\').checked = this.checked;" class="check" /> <b class="size11"><a href="', $message['p'], '" title="', $message['subject'], '">', $message['subject'], '</a><b></td>
		<td><b class="size11">', ($context['from_or_to'] == 'from' ? $message['member']['link'] : (empty($message['recipients']['to']) ? '' : implode(', ', $message['recipients']['to']))), '<b></td>
		<td><span class="size11">', tiempo2($message['time']), '</span></td>		
		</tr>';
		$next_alternate = $message['alternate'];
	}

	echo '
	</table>
	<div class="bordercolor" style="padding: 1px; ', $context['browser']['needs_size_fix'] && !$context['browser']['is_ie6'] ? 'width: 100%;' : '', '">
		<table width="100%" cellpadding="2" cellspacing="0" border="0"><tr style="background-color: #BBC4AF;" valign="middle">
			<td style="color: #FFF;">';
			if ($context['page_index'])
				echo'', $context['page_index'], '';
				echo'
				<div style="float: right;">&nbsp;';

	if ($context['show_delete'])
	{
		if (!empty($context['currently_using_labels']) && $context['folder'] != 'outbox')
		{
			echo '
				<select name="pm_action" onchange="if (this.options[this.selectedIndex].value) this.form.submit();" onfocus="loadLabelChoices();">
			<option value="">Mover a la carpeta:</option>';
			foreach ($context['labels'] as $label)
			echo '<option value="rem_', $label['id'], '">&nbsp;', $label['name'], '</option>';
			echo '</select>
';
		}

		echo '
				<input class="login" type="submit" name="del_selected" value="', $txt['quickmod_delete_selected'], '" style="font-weight: normal;" onclick="if (!confirm(\'', $txt['smf249'], '\')) return false;" />';
	}

	echo '<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
					var allLabels = {};
					function loadLabelChoices()
					{
						var listing = document.forms.pmFolder.elements;
						var theSelect = document.forms.pmFolder.pm_action;
						var add, remove, toAdd = {length: 0}, toRemove = {length: 0};

						if (theSelect.childNodes.length == 0)
							return;';

	echo '
						if (typeof(allLabels[-1]) == "undefined")
						{
							for (var o = 0; o < theSelect.options.length; o++)
								if (theSelect.options[o].value.substr(0, 4) == "rem_")
									allLabels[theSelect.options[o].value.substr(4)] = theSelect.options[o].text;
						}

						for (var i = 0; i < listing.length; i++)
						{
							if (listing[i].name != "pms[]" || !listing[i].checked)
								continue;

							var alreadyThere = [], x;
							for (x in currentLabels[listing[i].value])
							{
								if (typeof(toRemove[x]) == "undefined")
								{
									toRemove[x] = allLabels[x];
									toRemove.length++;
								}
								alreadyThere[x] = allLabels[x];
							}

							for (x in allLabels)
							{
								if (typeof(alreadyThere[x]) == "undefined")
								{
									toAdd[x] = allLabels[x];
									toAdd.length++;
								}
							}
						}

						while (theSelect.options.length > 2)
							theSelect.options[2] = null;

						if (toAdd.length != 0)
						{
									theSelect.options[theSelect.options.length - 1].disabled = true;

							for (i in toAdd)
							{
								if (i != "length")
									theSelect.options[theSelect.options.length] = new Option(toAdd[i], "" + i);
							}
						}

						if (toRemove.length != 0)
						{
												theSelect.options[theSelect.options.length - 1].disabled = true;

							for (i in toRemove)
							{
								if (i != "length")
									theSelect.options[theSelect.options.length] = new Option(toRemove[i], "rem_" + i);
							}
						}
					}
				// ]]></script>';

		echo '
				</div>
			</td>
		</tr></table>
	</div>';
	}
	else
	echo'	<table width="100%">	<tr>
			<td class="windowbg" colspan="5"><center><br>', $txt[151], '</center><br></td>
		</tr></table>';
	}
	echo '
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		var currentLabels = {};
	// ]]></script>';

	if ((isset($context['sl-singlepm']) || (isset($modSettings['enableSinglePM']) && $modSettings['enableSinglePM'] ==0) || !isset($modSettings['enableSinglePM'])))
	{
		echo '
		<table cellpadding="0" cellspacing="0" border="0" width="100%" class="bordercolor">';

		while ($message = $context['get_pmessage']())
		{
			$windowcss = $message['alternate'] == 0 ? 'windowbg' : 'windowbg2';

			echo '
		<tr><td style="padding: 1px 1px 0 1px;">
			<a name="msg', $message['id'], '"></a>
			<table width="100%" cellpadding="3" cellspacing="0" border="0">
				<tr><td colspan="2" class="', $windowcss, '">
					<table width="100%" cellpadding="4" cellspacing="1" style="table-layout: fixed;">
								';
			echo '<td class="', $windowcss, '" valign="top" width="100%" height="100%">
				  <table cellpadding="3" cellspacing="0" border="0" width="100%">
				  <tr>
				  <td align="right"><b>Por:</b></td>
				  <td><a href="/?action=profile;user=', $message['member']['username'], '">', $message['member']['name'], '</a></td>
					</tr>
										<tr>
						<td align="right"><b>Enviado:</b></td>
						<td>', tiempo2($message['time']), '</td>
					</tr>					<tr>
						<td align="right"><b>Asunto:</b></td>
						<td>', $message['subject'], '</td>
					</tr>				<tr>
						<td align="right" valign="top"><b>Mensaje:</b></td>
						<td><div style="background: #FFFFFF;" class="personalmessage">', $message['body'], '</div></td>
					</tr></table>';
		echo '<p align="center"><input class="login" style="font-size: 11px;" value="Eliminar MP" title="Eliminar MP" onclick="if (!confirm(\'\xbfEstas seguro que desea eliminar este mensaje?\')) return false; location.href=\'/?action=pm;sa=pmactions;pm_actions[', $message['id'], ']=delete;f=', $context['folder'], ';start=', $context['start'], ';', $context['current_label_id'] != -1 ? ';l=' . $context['current_label_id'] : '', ';sesc=', $context['session_id'], '\'" type="button">&nbsp;<input class="login" style="font-size: 11px;" value="Responder MP" title="Responder MP" onclick="location.href=\'/?action=pm;sa=send;f=', $context['folder'], $context['current_label_id'] != -1 ? ';l=' . $context['current_label_id'] : '', ';pmsg=', $message['id'], ';u=', $message['member']['id'], '\'" type="button"></p>
					</table>
					<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
						currentLabels[', $message['id'], '] = {';

		if (!empty($message['labels']))
		{
			$first = true;
			foreach ($message['labels'] as $label)
			{
				echo $first ? '' : ',', '
								"', $label['id'], '": "', $label['name'], '"';
				$first = false;
			}
		}

		echo '
						};
					// ]]></script>
				</td></tr>
			</table>
		</td></tr>';
		}

		echo '
			<tr><td style="padding: 0 0 1px 0;"></td></tr>
	</table>
	</div>';
	}

	echo '
	<input type="hidden" name="sc" value="', $context['session_id'], '" />
</form>';
}

function template_search(){}
function template_search_results(){}	

function template_send()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	if (!empty($context['send_log']))
	{
		echo '
		<br />
		<table border="0" width="80%" cellspacing="1" cellpadding="3" class="bordercolor" align="center">
			<tr class="titlebg">
				<td>', $txt['pm_send_report'], '</td>
			</tr>
			<tr>
				<td class="windowbg">';
		foreach ($context['send_log']['sent'] as $log_entry)
			echo '<span style="color: green">', $log_entry, '</span><br />';
		foreach ($context['send_log']['failed'] as $log_entry)
			echo '<span style="color: red">', $log_entry, '</span><br />';
		echo '
				</td>
			</tr>
		</table><br />';
	}
	echo '
		
		<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Enviar mensaje</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
			<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" ><tr>
				<td class="windowbg">
					<form action="/?action=pm;sa=send2" method="post" accept-charset="', $context['character_set'], '" name="postmodify" id="postmodify" onsubmit="submitonce(this);saveEntities();">
						<table border="0" cellpadding="3" width="100%">';

	echo '<tr><td><font class="size11"><b>De:</b>&nbsp;</font></td>
	
	<td align="left">'.$context['user']['name'].'</td></tr>
	<tr><td><font class="size11"><b>', $txt[150], ':</b>&nbsp;</font></td>
	
	<td align="left"><input type="text" name="to" id="to" value="', $context['to'], '" tabindex="1" size="40" /></td></tr>';

	echo '
							<tr>
								<td><font class="size11"><b>Asunto:</b>&nbsp;</font></td><td align="left"><input type="text" name="subject" value="', $context['subject'], '" tabindex="2" size="40" maxlength="50" /></td>
							</tr>';
	echo '
							<tr>
								<td colspan="2">';

	theme_quickreply_box();

	echo '<font class="size11"><b>Opciones:</b></font> 
								<br /><label for="outbox"><input type="checkbox" name="outbox" id="outbox" value="1" tabindex="3"', $context['copy_to_outbox'] ? ' checked="checked"' : '', ' class="check" /> ', $txt['pm_save_outbox'], '</label>';
								
if ($context['allow_admin']){
echo'<br><a href="javascript:void(0);" onclick="replaceText(\'Hola!\n\nLe informamos que usted esta corrumpiendo el protocolo escribiendo un texto entero en MAYUSCULA\n\nPara acceder al protocolo, presiona [url=/?action=protocolo]este enlace[/url].\n\nMuchas gracias por entender!\', document.forms.postmodify.message); return false;"><img src="/Themes/default/images/icons/icono-razon-edicion.gif" align="bottom" alt="Mayusculas" title="Mayusculas" /></a> | <a href="javascript:void(0);" onclick="replaceText(\'Hola!\n\nLamento contarte que tu post titulado [b]Titulo Del Post[/b] fue eliminado\n\nPor la Causa de: [b]Causa de eliminaci&oacute;n[/b]\n\nPara acceder al protocolo, presiona [url=/?action=protocolo]este enlace[/url].\n\nMuchas gracias por entender!\', document.forms.postmodify.message); return false;"><img src="/Themes/default/images/icons/icono-eliminar.png" align="bottom" alt="Post eliminado" title="Post eliminado" /></a>';}
								
						echo'<center><input class="login" type="submit" value="', $txt[148], '" tabindex="4" onclick="return obligatorio(this.form.to.value, this.form.subject.value, this.form.message.value); return submitThisOnce(this);" accesskey="s" /></center>
								</td>
							</tr>
							<tr>
								<td></td>
								<td align="right"></td>
							</tr>
						</table>
						<input type="hidden" name="sc" value="', $context['session_id'], '" />
						<input type="hidden" name="usuarien" value="',$context['user']['id'], '" />
						<input type="hidden" name="seqnum" value="', $context['form_sequence_number'], '" />
						<input type="hidden" name="f" value="', isset($context['folder']) ? $context['folder'] : '', '" />
						<input type="hidden" name="l" value="', isset($context['current_label_id']) ? $context['current_label_id'] : -1, '" />
					</form>
				</td>
			</tr>
		</table>';


	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		
		function obligatorio(to, subject, message)
	{	
			if(to == \'\')
			{
				alert(\'No has ingresado el destinario del MP.\');
				return false;
			}
			if(subject == \'\')
			{
				alert(\'No has escrito el asunto del MP.\');
				return false;
			}
			if(message == \'\')
			{
				alert(\'No has escrito nada en el mensaje del MP.\');
				return false;
			}}
			
			function autocompleter(element)
			{
				if (typeof(element) != "object")
					element = document.getElementById(element);

				this.element = element;
				this.key = null;
				this.request = null;
				this.source = null;
				this.lastSearch = "";
				this.oldValue = "";
				this.cache = [];

				this.change = function (ev, force)
				{
					if (window.event)
						this.key = window.event.keyCode + 0;
					else
						this.key = ev.keyCode + 0;
					if (this.key == 27)
						return true;
					if (this.key == 34 || this.key == 8 || this.key == 13 || (this.key >= 37 && this.key <= 40))
						force = false;

					if (isEmptyText(this.element))
						return true;

					if (this.request != null && typeof(this.request) == "object")
						this.request.abort();

					var element = this.element, search = this.element.value.replace(/^("[^"]+",[ ]*)+/, "").replace(/^([^,]+,[ ]*)+/, "");
					this.oldValue = this.element.value.substr(0, this.element.value.length - search.length);
					if (search.substr(0, 1) == \'"\')
						search = search.substr(1);

					if (search == "" || search.substr(search.length - 1) == \'"\')
						return true;

					if (this.lastSearch == search)
					{
						if (force)
							this.select(this.cache[0]);

						return true;
					}
					else if (search.substr(0, this.lastSearch.length) == this.lastSearch && this.cache.length != 100)
					{
						// Instead of hitting the server again, just narrow down the results...
						var newcache = [], j = 0;
						for (var k = 0; k < this.cache.length; k++)
						{
							if (this.cache[k].substr(0, search.length) == search)
								newcache[j++] = this.cache[k];
						}

						if (newcache.length != 0)
						{
							this.lastSearch = search;
							this.cache = newcache;

							if (force)
								this.select(newcache[0]);

							return true;
						}
					}

					this.request = new XMLHttpRequest();
					this.request.onreadystatechange = function ()
					{
						element.autocompleter.handler(force);
					}

					this.request.open("GET", this.source + escape(textToEntities(search).replace(/&#(\d+);/g, "%#$1%")).replace(/%26/g, "%25%23038%25") + ";" + (new Date().getTime()), true);
					this.request.send(null);

					return true;
				}
				this.keyup = function (ev)
				{
					this.change(ev, true);

					return true;
				}
				this.keydown = function ()
				{
					if (this.request != null && typeof(this.request) == "object")
						this.request.abort();
				}
				this.handler = function (force)
				{
					if (this.request.readyState != 4)
						return true;

					var response = this.request.responseText.split("\n");
					this.lastSearch = this.element.value;
					this.cache = response;

					if (response.length < 2)
						return true;

					if (force)
						this.select(response[0]);

					return true;
				}
				this.select = function (value)
				{
					if (value == "")
						return;

					var i = this.element.value.length + (this.element.value.substr(this.oldValue.length, 1) == \'"\' ? 0 : 1);
					this.element.value = this.oldValue + \'"\' + value + \'"\';

					if (typeof(this.element.createTextRange) != "undefined")
					{
						var d = this.element.createTextRange();
						d.moveStart("character", i);
						d.select();
					}
					else if (this.element.setSelectionRange)
					{
						this.element.focus();
						this.element.setSelectionRange(i, this.element.value.length);
					}
				}

				this.element.autocompleter = this;
				this.element.setAttribute("autocomplete", "off");

				this.element.onchange = function (ev)
				{
					this.autocompleter.change(ev);
				}
				this.element.onkeyup = function (ev)
				{
					this.autocompleter.keyup(ev);
				}
				this.element.onkeydown = function (ev)
				{
					this.autocompleter.keydown(ev);
				}
			}

			if (window.XMLHttpRequest)
			{
				var toComplete = new autocompleter("to"), bccComplete = new autocompleter("bcc");
				toComplete.source = "', $scripturl, '?action=requestmembers;sesc=', $context['session_id'], ';search=";
				bccComplete.source = "', $scripturl, '?action=requestmembers;sesc=', $context['session_id'], ';search=";
			}

			function saveEntities()
			{
				var textFields = ["subject", "message"];
				for (i in textFields)
					if (document.forms.postmodify.elements[textFields[i]])
						document.forms.postmodify[textFields[i]].value = document.forms.postmodify[textFields[i]].value.replace(/&#/g, "&#38;#");
			}
		// ]]></script>';
}

function template_ask_delete()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<table border="0" width="80%" cellpadding="4" cellspacing="1" class="bordercolor" align="center">
			<tr class="titlebg">
				<td>', ($context['delete_all'] ? $txt[411] : $txt[412]), '</td>
			</tr>
			<tr>
				<td class="windowbg">
					', $txt[413], '<br />
					<br />
					<b><a href="', $scripturl, '?action=pm;sa=removeall2;f=', $context['folder'], ';', $context['current_label_id'] != -1 ? ';l=' . $context['current_label_id'] : '', ';sesc=', $context['session_id'], '">', $txt[163], '</a> - <a href="javascript:history.go(-1);">', $txt[164], '</a></b>
				</td>
			</tr>
		</table>';
}
function template_labels()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
<form action="/?action=pm;sa=manlabels;sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '">
		<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>', $txt['pm_label_add_new'], '</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>	
		<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="windowbg2">
			<tr class="windowbg2">
				<td align="right" width="40%">
					<b class="size11">', $txt['pm_label_name'], ':</b>
				</td>
				<td align="left">
					<input type="text" name="label" value="" size="30" maxlength="20" />
				</td>
			</tr>
			<tr class="windowbg2">
				<td colspan="2" align="center">
					<input class="login" type="submit" name="add" value="', $txt['pm_label_add_new'], '" style="font-weight: normal;" />
				</td>
			</tr>
		</table>
	</form>
<form action="/?action=pm;sa=manlabels;sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '" style="margin-top: 8px;">
	<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>', $txt['pm_manage_labels'], '</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>	
		<table width="100%" class="windowbg">
			<tr class="windowbg2">
				<td colspan="2" style="padding: 1ex;"><center><span class="smalltext">', $txt['pm_labels_desc'], '</span></center></td>
			</tr>
			<tr >
				<td colspan="2" style="background-color: #BBC4AF; color: #FFFFFF;">
					<div style="float: right; width: 4%; text-align: center;"><input type="checkbox" class="check" onclick="invertAll(this, this.form);" /></div>
					', $txt['pm_label_name'], ':
				</td>
			</tr>';

		$alternate = true;
		foreach ($context['labels'] as $label)
		{
			if ($label['id'] != -1)
			{
				echo '
				<tr class="', $alternate ? 'windowbg2' : 'windowbg', '">
					<td>
						<input type="text" name="label_name[', $label['id'], ']" value="', $label['name'], '" size="30" maxlength="30" />
					</td>
					<td width="4%" align="center"><input type="checkbox" class="check" name="delete_label[', $label['id'], ']" /></td>
				</tr>';
				$alternate = !$alternate;
			}
		}

		echo '
			<tr>
				<td align="center" colspan="2">
				<br>	<input class="login" type="submit" name="save" value="Guardar Cambio" style="font-weight: normal;" />
					<input class="login" type="submit" name="delete" value="', $txt['quickmod_delete_selected'], '" style="font-weight: normal;" onclick="return confirm(\'', $txt['pm_labels_delete'], '\');" />
				</td>
			</tr>';
	
	echo '
		</table>
		<input type="hidden" name="sc" value="', $context['session_id'], '" />
	</form>';
}
function template_prune(){}
function template_report_message(){}
function template_report_message_complete(){}
function template_quickreply_box()
{
	global $context, $settings, $options, $txt, $modSettings;
	if (!empty($_REQUEST['pmsg']))
	{
$request = db_query("
SELECT *
FROM (smf_personal_messages) 
WHERE ID_PM = ".$_REQUEST['pmsg']."
", __FILE__, __LINE__);
while ($row = mysql_fetch_assoc($request))
	{
		censorText($row['body']);
		$row['body'] = trim(un_htmlspecialchars(strip_tags(strtr(parse_bbc($row['body'], false, $ID_MSG), array('<br />' => "\n", '</div>' => "\n", '</li>' => "\n", '&#91;' => '[', '&#93;' => ']')))));
		$comentario = $row['body'];
		$fecha = $row['msgtime'];
		$nombre = $row['fromName'];
 	 
	}
	mysql_free_result($request);}
	
	echo'<b class="size11">Mensaje:</b><br>';
		if ($context['show_bbc'])
	{
		echo '<tr><td></td><td>';
		$context['bbc_tags'][] = array(
			'bold' => array('code' => 'b', 'before' => '[b]', 'after' => '[/b]', 'description' => $txt[253]),
			'italic' => array('code' => 'i', 'before' => '[i]', 'after' => '[/i]', 'description' => $txt[254]),
					'aleft' => array('code' => 'aleft', 'before' => '[left]', 'after' => '[/left]', 'description' => 'Todo hacia la Derecha'),
			'center' => array('code' => 'center', 'before' => '[center]', 'after' => '[/center]', 'description' => 'Todo centrado'),
			'aright' => array('code' => 'aright', 'before' => '[right]', 'after' => '[/right]', 'description' => 'Todo hacia la Izquierda'),
			'code' => array('code' => 'code', 'before' => '[code]', 'after' => '[/code]', 'description' => 'Insertar codigo'),
			'quote' => array('code' => 'quote', 'before' => '[quote]', 'after' => '[/quote]', 'description' => 'Insertar Cita'),
		);

		$found_button = false;
			foreach ($context['bbc_tags'][0] as $image => $tag)
		{
						if (isset($tag['before']))
			{
		
				if (!empty($context['disabled_tags'][$tag['code']]))
					continue;

				$found_button = true;

				if (!isset($tag['after']))
					echo '<a href="javascript:void(0);" onclick="replaceText(\'', $tag['before'], '\', document.forms.postmodify.message); return false;">';
				else
					echo '<a href="javascript:void(0);" onclick="surroundText(\'', $tag['before'], '\', \'', $tag['after'], '\', document.forms.postmodify.message); return false;">';

				echo '<img src="', $settings['images_url'], '/bbc/', $image, '.gif" align="bottom" alt="', $tag['description'], '" title="', $tag['description'], '" border="0" hspace="2"/></a>&nbsp;';
			}
			elseif ($found_button)
			{
				echo '';
				$found_button = false;
			}
		}
if (!isset($context['disabled_tags']['color']))
			echo ' <select align="bottom" onchange="surroundText(\'[color=\' + this.options[this.selectedIndex].value.toLowerCase() + \']\', \'[/color]\', document.forms.postmodify.message); postmodify.message.focus(document.forms.postmodify.message.caretPos);" style="margin-bottom: 1ex;">
							<option style="color: Black;" value="" selected="selected">Predeterminado</option>
						<option style="color: Red;" value="Red">', $txt[263], '</option>
							<option style="color: Yellow;" value="Yellow">', $txt[264], '</option>
							<option style="color: Pink;" value="Pink">', $txt[265], '</option>
							<option style="color: Green;" value="Green">', $txt[266], '</option>
							<option style="color: Orange;" value="Orange">', $txt[267], '</option>
							<option style="color: Purple;" value="Purple">', $txt[268], '</option>
							<option style="color: Blue;" value="Blue">', $txt[269], '</option>
							<option style="color: Beige;" value="Beige">', $txt[270], '</option>
							<option style="color: Brown;" value="Brown">', $txt[271], '</option>
							<option style="color: Teal;" value="Teal">', $txt[272], '</option>
							<option style="color: Nevy;" value="Navy">', $txt[273], '</option>
							<option style="color: Maroon;" value="Maroon">', $txt[274], '</option>
							<option style="color: LimeGreen;" value="LimeGreen">', $txt[275], '</option>
						</select>';

	if (!isset($context['disabled_tags']['size']))
echo ' <select align="bottom" onchange="surroundText(\'[size=\' + this.options[this.selectedIndex].value.toLowerCase() + \']\', \'[/size]\', document.forms.postmodify.message); postmodify.message.focus(document.forms.postmodify.message.caretPos);" style="margin-bottom: 1ex;">
	<option value="7pt">Miniatura</option>
	<option value="9pt">Peque&ntilde;a</option>
	<option name="normal" id="normal" selected="selected" value="12pt">Normal</option>
	<option value="18pt">Grande</option>
	<option value="24pt">Enorme</option>
	</select>';

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
$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
$diames2 = date(j,$fecha); $mesano2 = date(n,$fecha) - 1 ; $ano2 = date(Y,$fecha);
$seg2=date(s,$fecha); $hora2=date(H,$fecha); $min2=date(i,$fecha);
$fecha2="$diames2.$mesesano2[$mesano2].$ano2 a las $hora2:$min2:$seg2";

echo '<textarea cols="75" rows="7" style="width: 95%; height: 160px;" name="message" tabindex="1" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" onchange="storeCaret(this);">';
if (!empty($_REQUEST['pmsg']))
{echo'


El '.$fecha2.', '.$nombre.' Escribi&oacute;:
> '.str_replace("\n", "\n> ", $comentario) .'';}
echo'</textarea><br>';

if (!empty($context['smileys']['postform']))
{
foreach ($context['smileys']['postform'] as $smiley_row)
{
foreach ($smiley_row['smileys'] as $smiley)
echo'<a href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.postmodify.message); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a> ';
			if (empty($smiley_row['last']))
				echo '<br />';
		}
	// If the smileys popup is to be shown... show it!
		if (!empty($context['smileys']['popup']))
		echo '
		<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script>
		<a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a><br>';
	}


}
?>