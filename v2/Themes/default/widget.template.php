<?php
function template_manual_above(){}
function template_manual_below(){}
function template_manual_intro()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;

// Elimino de la variable scripturl (ruta de la web) en index.php para forma abajo la url, por muertet
$ruta = str_replace("index.php", "", $scripturl);

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
  ancho[\'4\']=150;
  alto[\'4\']=200;

  function actualizar_preview(noselect){
    document.getElementById("cantidad").value = parseInt(document.getElementById("cantidad").value);
  	if (isNaN(document.getElementById("cantidad").value)) {
		  document.getElementById("cantidad").value="";
      alert("Debe ingresar un valor numerico en el campo cantidad de posts listados");
		  return;
	  }
    if (!document.getElementById("cantidad").value){
      alert("Debe ingresar un valor en el campo cantidad de posts listados");
      document.getElementById("cantidad").focus();
      return;
    }
    if (document.getElementById("cantidad").value > 35){
      alert("La cantidad maxima de posts listados es 35	");
      document.getElementById("cantidad").focus();
      return;
    }
    code=\'<embed src="', $ruta ,'web/widget/\' + ancho[document.getElementById("tamano").value] + \'x\' + alto[document.getElementById("tamano").value] + \'-\' + document.getElementById("categ").value + \'.swf?can=\' + document.getElementById("cantidad").value + \'" quality="high" width="\' + ancho[document.getElementById("tamano").value] + \'" height="\' + alto[document.getElementById("tamano").value] + \'" type="application/x-shockwave-flash" AllowScriptAccess="always" wmode="transparent"></embed><noscript><a href="', $ruta ,'" alt="', $context['forum_name'], '" title="', $context['forum_name'], '">', $context['forum_name'], '</a></noscript>\';

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
	<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Widget</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
	<table width="100%" class="windowbg"><tr><td>
      Integra los &uacute;ltimos posts en tu Web y estate siempre actualizado.<br />

      En s&oacute;lo un segundos podr&aacute;s tener un listado que estar&aacute; siempre 
      actualizado con los &uacute;ltimos posts publicados.<br />
      Puedes personalizar el listado para que se adapte al estilo de tu sitio, cambiando su tama&ntilde;o, color, cantidad de posts a listar y hasta filtrado por categor&iacute;as.<br /><br />

      <b>Como implementarlo:</b><br />
      <b>1.</b> Personal&iacute;zalo a tu gusto. C&aacute;mbiale color y elige el tama&ntilde;o.<br />

      <b>2.</b> Copia el c&oacute;digo generado y p&eacute;galo en tu p&aacute;gina.<br />
      <b>3.</b> Listo. Ya puedes disfrutar de este Widget<br />


</td></tr></table>
<table class="windowbg" width="100%" height="1">
  <tr>
    <td width="192" height="1" bgcolor="#AFAF7B">
    <p align="center"><b><font color="#FFFFFF">Personalizaci&oacute;n</font></b></td>
    <td width="335" height="1" bgcolor="#AFAF7B">
    <p align="center"><b><font color="#FFFFFF">C&oacute;digo</font></b></td>
  <td width="397" height="1" bgcolor="#AFAF7B">
  <p align="center"><b><font color="#FFFFFF">Ejemplo</font></b></td>
  </tr>
  <tr><td width="192" height="1" bgcolor="#BBC4AF">
    <p align="center"><b>Color:</b> <select id="categ" onchange="actualizar_preview();">
              <option selected="selected" value="amarillo">Amarillo</option>
              <option value="azul">Azul</option>
               <option value="negro">Negro</option>
              <option value="rojo">Rojo</option>
              <option value="marron">Marron</option>
              <option value="combinado">Combinado</option>
              <option value="opaco">Opaco</option>
              <option value="verde">Verde</option></select></p>
             <p align="center"><b>Cantidad:</b> <input size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" type="text"> <span class="smalltext">(max 35)</span></p>
    <p align="center"><b>Tama&ntilde;o:</b> <select id="tamano" onchange="actualizar_preview();">
              <option value="0">350 x 100</option>
              <option value="2">200 x 250</option>
          
            </select></td><td width="335" align="center" height="1" bgcolor="#BBC4AF">
      <p align="center">
      <textarea id="codigo" cols="47" rows="6" onClick="focus_code();"></textarea></td>
  <td align="center" width="397" height="1" bgcolor="#BBC4AF">
  <input type="hidden" size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" />
   <p align="center"><div id="widget-preview">
		</div><script type="text/javascript">
  actualizar_preview(1);
        </script></p></td>
  </table>';}
?>