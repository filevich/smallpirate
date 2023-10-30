<?php
function template_manual_above(){}
function template_manual_below(){}
function template_manual_intro()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings, $boardurl, $db_prefix;

echo'	
	<script type="text/javascript">
  var ancho=new Array();
  var alto=new Array();
  ancho[\'0\']=350;
  alto[\'0\']=100;
  ancho[\'1\']=200;
  alto[\'1\']=200;
  ancho[\'2\']=200;
  alto[\'2\']=250; 
  ancho[\'3\']=285;
  alto[\'3\']=134;
  ancho[\'4\']=200;
  alto[\'4\']=300;
  ancho[\'5\']=320;
  alto[\'5\']=100;
  ancho[\'6\']=320;
  alto[\'6\']=200;
  ancho[\'7\']=320;
  alto[\'7\']=300;
  
  var color = new Array();
  color[\'0\'] = "rojo";
  color[\'1\'] = "amarillo";
  color[\'2\'] = "gris";
  color[\'3\'] = "rosa";
  color[\'5\'] = "violeta";
  color[\'6\'] = "verde";
  color[\'7\'] = "turquesa";
  

  function actualizar_preview(noselect){
    document.getElementById("cantidad").value = parseInt(document.getElementById("cantidad").value);
  	if (isNaN(document.getElementById("cantidad").value)) {
		  document.getElementById("cantidad").value="";
      alert("', $txt['should_be_integer'], '");
		  return;
	  }
    if (!document.getElementById("cantidad").value){
      alert("', $txt['should_input_something'], '");
      document.getElementById("cantidad").focus();
      return;
    }
    if (document.getElementById("cantidad").value > 50){
      alert("', $txt['maximun_listed_topics'], ' 50");
      document.getElementById("cantidad").focus();
      return;
    }
    code=\'<div style="border: 1px solid rgb(213, 213, 213); padding: 2px 5px 5px; background: #D7D7D7 url('.$boardurl.'/Themes/default/images/widget/fondo2-widget-\'+ color[document.getElementById("color").value] + \'.gif) repeat-x scroll center top; width: \'+ ancho[document.getElementById("tamano").value] + \'px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; text-align: left;">';
    echo '<a href="'.$boardurl.'/"><img src="'.$boardurl.'/Themes/default/images/widget/widget-logo.png" alt="'.$boardurl.'" style="border: 0pt none; margin: 0px 0px 5px 5px;" /></a><br>';
    echo '<iframe src="'.$boardurl.'/sp-widget.php?cat=\' + document.getElementById("categ").value + \'&cant=\'+ document.getElementById("cantidad").value + \'&an=\'+ ancho[document.getElementById("tamano").value] + \'&color=\'+ color[document.getElementById("color").value] + \'" style="border: 1px solid rgb(213, 213, 213); margin: 0pt; padding: 0pt; width: \'+ ancho[document.getElementById("tamano").value] + \'px; height: \'+ alto[document.getElementById("tamano").value] + \'px;" frameborder="0"></iframe></div>\';

    document.getElementById("widget-preview").innerHTML=code;
    document.getElementById("codigo").value=code;
    focus_code(noselect);
    return;
  }

  function focus_code(noselect){
    if(!noselect)
      document.getElementById("codigo").focus();
    document.getElementById("codigo").select();
    return;
  }

</script>';

	echo '
<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>', $txt['title'], '</center></div>
</div>
	<table width="100%" class="windowbg"><tr><td>', $txt['how_to_implement'], '</td></tr></table>
<table class="windowbg" width="100%" height="1">
  <tr>
    <td width="192" height="1" bgcolor="#AFAF7B">
    <p align="center"><b><font color="#FFFFFF">', $txt['customization'], '</font></b></td>
    <td width="335" height="1" bgcolor="#AFAF7B">
    <p align="center"><b><font color="#FFFFFF">', $txt['code'], '</font></b></td>
  <td width="397" height="1" bgcolor="#AFAF7B">
  <p align="center"><b><font color="#FFFFFF">', $txt['example'], '</font></b></td>
  </tr>
  <tr><td width="192" height="1" bgcolor="#BBC4AF">
    <p align="center"><b>', $txt['category'], ':</b> <select id="categ" onchange="actualizar_preview();">';
    $request = db_query("
		SELECT ID_BOARD, name
		FROM {$db_prefix}boards", __FILE__, __LINE__);
		echo '<option selected="selected" value="0">', $txt['all'], '</option>';
		while($categoria = mysql_fetch_assoc($request))
		{
		echo'<option value="'.$categoria['ID_BOARD'].'">'.$categoria['name'].'</option>';
		}
		echo '</select></p>
             <p align="center"><b>', $txt['how_much'], ':</b> <input size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" type="text"> <span class="smalltext">(max 50)</span></p>
             <p align="center"><b>', $txt['size'], ':</b> <select id="tamano" onchange="actualizar_preview();">
              <option value="0">350 x 100</option>
              <option value="1">200 x 200</option>
              <option value="2">200 x 250</option>
              <option value="3">285 x 134</option>
              <option value="4">200 x 300</option>
              <option value="5">320 x 100</option>
              <option value="6">320 x 200</option>
              <option value="7">320 x 300</option>
			</select></p>
			<p align="center"><b>', $txt['color'], ':</b> <select id="color" onchange="actualizar_preview();">
			  <option value="0">', $txt['red'], '</option>
			  <option value="1">', $txt['yellow'], '</option>
			  <option value="2">', $txt['grey'], '</option>
			  <option value="3">', $txt['pink'], '</option>
			  <option value="5">', $txt['violet'], '</option>
			  <option value="6">', $txt['green'], '</option>
			  <option value="7">', $txt['lightblue'], '</option>
			  </select></p>
			</td><td width="335" align="center" height="1" bgcolor="#BBC4AF">
      <p align="center">
      <textarea id="codigo" cols="47" rows="6" onClick="focus_code();"></textarea></td>
  <td align="center" width="397" height="1" bgcolor="#BBC4AF">
  <input type="hidden" size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" />
   <p align="center"><div id="widget-preview">
		</div><script type="text/javascript">
  actualizar_preview(1);
        </script><br></p></td>
  </table>';}
?>