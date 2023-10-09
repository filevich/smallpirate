<?php
function template_manual_above(){}
function template_manual_below(){}
function template_manual_intro()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
echo'<script language="JavaScript" type="text/javascript">
function showrequerido(comentario, email)
	{	
			if(comentario == \'\')
			{
				alert(\'Es necesario que agreges una aclaraci\xf3n o comentario sobre tu denuncia.\');
				return false;
			}				if(email == \'\')
			{
				alert(\'Tu no has seleccionado ningun post para denunciar.\');
				return false;
			}		
					
			}
	</script>';
	
$context['ID_DEL_POST'] = $_GET['id'];

if ($context['user']['is_guest'])
echo'	<div>
<table align="center" width="392px" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Denunciar Post</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table align="center" class="windowbg" width="392px">
		<tr class="windowbg">
		<td align="center">
		<br>
   Disculpe, para denunciar un post debe autentificarte.
		<br>
		<br>
	    <input class="login" style="font-size: 11px;" type="submit" title="Ir a la P&aacute;gina principal" value="Ir a la P&aacute;gina principal" onclick="location.href=\'/\'" />
        <br>
        <br>
		</td>
		</tr>
    	</table>
        </div>
        <br><br>'; 

$request = db_query("
SELECT *
FROM (smf_messages AS m, smf_members AS user)
WHERE m.ID_TOPIC = {$context['ID_DEL_POST']} AND m.ID_MEMBER = user.ID_MEMBER", __FILE__, __LINE__);
	while ($row = mysql_fetch_assoc($request)){
			$titulo = $row['subject'];
			$id = $row['ID_TOPIC'];
			$usuario = $row['memberName'];		
			}
	mysql_free_result($request);

if ($context['user']['is_logged'])
echo'	<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Denunciar Post</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
	<table border="0px" class="windowbg" align="center" width="100%">
	<tr class="windowbg" align="center" ><td class="windowbg" align="center" >
    <form action="/?action=rz;m=endenuncias" method="post">
			<p align="center" class="size11"><b>Denunciar el post:</b> <br>
', $id , ' / ', $titulo, '
			<p align="center" class="size11"><b>Creado por:</b> <br>
', $usuario, '
<br><br><font class="size11"><b>Raz&oacute;n de la denuncia:</b></font><br>
			<select name="razon" style="color: black; background-color: rgb(250, 250, 250); font-size: 12px;">
			<option value="0">Re-post</option>
			<option value="1">Se hace Spam</option>
			<option value="2">Tiene enlaces muertos</option>
			<option value="3">Es Racista o irrespetuoso</option>
			<option value="4">Contiene informaci&oacute;n personal</option>
			<option value="5">El Titulo esta en may&uacute;scula</option>
			<option value="6">Contiene Pornografia</option>
			<option value="7">Es Gore o asqueroso</option>
			<option value="8">Est&aacute; mal la fuente</option>
			<option value="9">Post demasiado pobre</option>
			<option value="10">No se encuentra el Pass</option>
			<option value="11">No cumple con el protocolo</option>
			<option value="12">Otra raz&oacute;n (especificar)</option>
			</select><br><br>
			<font class="size11"><b>Aclaraci&oacute;n y comentarios:</b></font><br>
			<textarea name="comentario" cols="40" rows="5" wrap="hard" tabindex="6"></textarea><br><font size="1">En el caso de ser Re-post se debe indicar el enlace del 
post original.</font>
<br><br><input onclick="return showrequerido(this.form.comentario.value, this.form.email.value);" class="login" type=submit value="Denunciar Post"><br><input value="', $context['user']['id'] , '" type="hidden" name="ID_MEMBER"><input type="hidden" name="ID_TOPIC" size="25" value="', $id , '">
	</form>
	</td></tr></table>'; 
}
function template_manual_login()
{
echo'
<div>
<table align="center" width="392px" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Denuncia enviada</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table align="center" class="windowbg" width="392px">
		<tr class="windowbg">
		<td align="center">
		<br>
   Tu denuncia ah sido enviada correctamente.
		<br>
		<br>
	    <input class="login" style="font-size: 11px;" type="submit" title="Ir a la P&aacute;gina principal" value="Ir a la P&aacute;gina principal" onclick="location.href=\'/\'" />
        <br>
        <br>
		</td>
		</tr>
    	</table>
        </div>';}
?>