<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<p class="Estilo1">Como agregar un nuevo template:</p>
<p><b>1)</b> Agregar el archivo de preview en la carpeta vistasPrevias (ej: homeDosPaneles.php)</p>
<ul>
  <li> el archivo incluye en la cabecera el codigo php:<br /> <pre>&lt;?php<br />
  session_start();<br />
  $listaElemAdministrables = $_SESSION[&quot;listaElemAdministrables&quot;];<br />
?&gt;</pre></li>
<li>y luego permite acceder a los valores en donde se precisen de la siguiente
  forma:<br />
<pre>&lt;?php echo $listaConv[&quot;HTMLId&quot;][&quot;valor&quot;];
?&gt; /* HTMLId es el identificador del elemnto */</pre></li>
</ul>
<p><b>2) </b>Definir nombres y relaciones en las tablas de la base de datos</p>
<p>a) tabla <b><i>admin_templates</i></b>:</p>
<ul>
  <li> denom: denominación descriptiva para lectura del operador (hasta 50 caracteres)</li>
  <li> fileName: el nombre base del archivo del template (sin prefijos ni sufijos,
    hasta 100 caracteres; ej: homeDosPaneles)</li>
</ul>
<p>b) tabla <b><i>admin_elementos</i></b>: </p>
<ul>
  <li>idTemplate: id del template del cual se definiran los elemntos</li>
  <li>denom: denominacón descriptiva del elemnto (hasta 100 caracteres)</li>
</ul>
<p>.HTMLId: id HTML del elemnto</p>
<p>c)tabla <b><i>admin_valores</i></b>:</p>
<ul>
  <li>idOwner: id del owner (tabla: owner) especifico al que correspondera el
    valor del elemento</li>
  <li>idElemento: id del elemento (tabla: admin_elementos) especifico al que
    correspondera el valor del elemento</li>
</ul>
<p><b>3)</b> hubicar los archivos de template de smarty (beta-cuenta/tpl/default/scr_{admin_templates.fileName}.tpl)<br />
  ej scr_homeDosPaneles.tpl</p>
<p><b>4)</b>definir en el archivo de logica de la pagina correspondiente (seccion assign)
  las variables smarty que seran reemplezadas en 3) </p>
<p>ej: extender el archivo beta-cuenta/inc/scr/home/scr.php -&gt; function assing
  para ver como agregar un nuevo template de home</p>
<p>&nbsp;</p>
</body>
</html>
