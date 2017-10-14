<?php
session_start();
$listaElemAdministrables = $_SESSION["listaElemAdministrables"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Mi Panel: Home</title>
<meta http-equiv="pragma" content="no-cache"/>
<meta name="mssmarttagspreventparsing" content="true"/>

<link rel="stylesheet" type="text/css" href="../../owner/<?php echo $_SESSION["currentOwnerFolder"]; ?>/stylesheet.v2.css" />
</head>

<body>
<div id="container">

<div id="header" style="background:url(../../owner/<?php echo $_SESSION["currentOwnerFolder"]; ?>/img/es/header.jpg) no-repeat;">

	<h1>Alternativa Comunica</h1>
    <a href="#" class="home-link">Home</a>

	<div id="login" class="right" style="position:relative; height:115px;">
    	<p style="width: 205px;"><b>¡Bienvenido,  {usuario}!</b></p>
        <p>Número de Cliente: {0000000}</p>

        <p>Usted tiene contratado/s {N} servicio/s</p>

        <p class="bot" style="position:absolute; width: 200px; bottom:10px; right:0px;">
        <a href="http://www.red-alternativa.com/contacto.html">Atención al Cliente</a>
        <a href="logout.ca" title=""><img src="../../owner/<?php echo $_SESSION["currentOwnerFolder"]; ?>/img/es/btn-logout.gif" style="border:0" alt="Logout" /></a>
        </p>
    </div>
</div>

<div id="bg-mid">



<div id="contenido-top"></div>
<div id="contenido">


<div id="layout">
    <div id="columna-1" class="left">
        <p><?php echo $listaElemAdministrables["cajas"]["valor"]; ?></p>
    </div>
    
    <div id="columna-2" class="left">
        <p><?php echo $listaElemAdministrables["cajaLateralIzqPrincipal"]["valor"]; ?></p>
        <p><?php echo $listaElemAdministrables["cajaTextoSecundaria"]["valor"]; ?></p>
        <p><?php echo $listaElemAdministrables["cajaTextoSecundaria2"]["valor"]; ?></p>
    </div>
</div>


</div>
<!-- fin Contenido -->


</div>
<div id="bg-bot"></div>


</div>
</body>
</html>