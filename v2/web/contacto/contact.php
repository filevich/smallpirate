<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="/Themes/default/estilo-ez-1.0.css" />
<title>Formulario de contacto</title>
<style>
body{background-color: transparent;}
</style>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('Han ocurrido los siguientes errores:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
</head>

<body>
<center>
 
<form action="/web/contacto/mailer.php" method="post" name="form1" id="form1" style="margin:0px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px; width:300px;" onsubmit="MM_validateForm('from','','RisEmail','asunto','','R','verif_box','','R','mensaje','','R');return document.MM_returnValue">

<b>E-mail:</b><br />
<input name="from" type="text" id="from" style="width: 184px;" value="<?php echo $_GET['from'];?>"/>
<br />
<br />

<b>Asunto:</b><br />
<input name="asunto" type="text" id="asunto" style="width: 184px;" value="<?php echo $_GET['asunto'];?>"/>
<br />
<br />

<b>Comentarios:</b><br />
<textarea name="mensaje" cols="6" rows="5" id="mensaje" style="padding:2px; border:1px solid #CCCCCC; width:300px; height:100px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;"><?php echo $_GET['mensaje'];?></textarea>
<br />

<b>Código de la imagen:</b><br />
<img src="/web/contacto/verificationimage.php?<?php echo rand(0,9999);?>" alt="Imágen de Verificación" width="50" height="24" align="absbottom" /><br />
<input name="verif_box" type="text" id="verif_box" style="width: 184px;"/>
<br />
<!-- if the variable "wrong_code" is sent from previous page then display the error field -->
<?php if(isset($_GET['wrong_code'])){?>
<div style="border:1px solid #990000; background-color:#D70000; color:#FFFFFF; padding:4px; padding-left:6px;width:295px;">Código Erroneo</div><br /> 
<?php ;}?>
<br>
<input class="login" name="Submit" type="submit" style="font-size: 10px;" size="50" value="Enviar" title="Enviar"/>
</form>
<br>
<span class="size9">
<?
$ip = $_SERVER['REMOTE_ADDR'];
echo "- Su IP ($ip) Será almacenada en nuestra base de datos por razones de seguridad.";
?>
</span>
</center>
</body>
</html>
