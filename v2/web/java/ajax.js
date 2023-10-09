function objetoAjax(){
 var xmlhttp=false;
  try{
   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  }catch(e){
   try {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
   }catch(E){
    xmlhttp = false;
   }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
   xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function Paginas(nropagina){
 //donde se mostrará los registros
 divContenido = document.getElementById('contenido');
 
 ajax=objetoAjax();
 //uso del medoto GET
 //indicamos el archivo que realizará el proceso de paginar
 //junto con un valor que representa el nro de pagina
 ajax.open("GET", "pag/pag1.php?pag="+nropagina);
 divContenido.innerHTML= '<div class="box_posts" width="100%"><p valign="top" align="right"><img src="http://www.morphcreations.es/yelid/Themes/default/images/cargando-ajax.gif"> <b class="size11">Cargando...</b></p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><p valign="buttom" align="right"><img src="http://www.morphcreations.es/yelid/Themes/default/images/cargando-ajax.gif"> <b class="size11">Cargando... </b></p></div>';
 ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
   //mostrar resultados en esta capa
   divContenido.innerHTML = ajax.responseText
  }
 }
 //como hacemos uso del metodo GET
 //colocamos null ya que enviamos 
 //el valor por la url ?pag=nropagina
 ajax.send(null)
}

function Pagina(nropagina,id){
 //donde se mostrará los registros
 divContenido = document.getElementById('contenido');
 
 ajax=objetoAjax();
 //uso del medoto GET
 //indicamos el archivo que realizará el proceso de paginar
 //junto con un valor que representa el nro de pagina
 ajax.open("GET", "http://www.morphcreations.es/yelid/web/java/pag/pag1.php?pag="+nropagina+"&id="+id);
 divContenido.innerHTML= '<div class="box_posts" width="100%"><p valign="top" align="right"><img src="http://www.morphcreations.es/yelid/Themes/default/images/cargando-ajax.gif"> <b class="size11">Cargando...</b></p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><p valign="buttom" align="right"><img src="http://www.morphcreations.es/yelid/Themes/default/images/cargando-ajax.gif"> <b class="size11">Cargando... </b></p></div>';
 ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
   //mostrar resultados en esta capa
   divContenido.innerHTML = ajax.responseText
  }
 }
 //como hacemos uso del metodo GET
 //colocamos null ya que enviamos 
 //el valor por la url ?pag=nropagina
 ajax.send(null)
}
