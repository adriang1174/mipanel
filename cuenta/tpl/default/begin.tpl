<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--{capture assign="tit"}--><!--{section_title title=$full_scr.title truncate="1"}--><!--{/capture}-->
<title><!--{$panel_name}--><!--{if $tit}-->: <!--{$tit}--><!--{/if}--></title>
<meta http-equiv="pragma" content="no-cache"/>
<meta name="mssmarttagspreventparsing" content="true"/>

<style type="text/css">
#admin {background:black; color:#ddd; padding:9px 0; position:fixed; top:0; left:0; width:100%; float:left; z-index:99999;}
.contenedor {width:780px; margin:0 auto;}
.contenedor div.right {width:auto; float:right !important;}
.contenedor div.left {width:auto; float:left;}
.contenedor a {color:#F9DF04; text-decoration:none;}
.contenedor a:hover {color:#F9DF04; text-decoration:underline;}
.contenedor span a {color:#F89827; text-decoration:none;}
.contenedor span a:hover {color:#F89827; text-decoration:underline;}
</style>

<link rel="stylesheet" type="text/css" href="css/common.css" media="screen" />

  <!--{if !$print}-->
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="js/utiles.js"></script>
	
		<!-- Validate -->
		<script type="text/javascript" src="js/jquery.validate.js" charset="ISO-8859-1"></script>
		<script type="text/javascript" src="js/validate_es.js" charset="ISO-8859-1"></script>
		<script type="text/javascript" src="js/validator-additional-methods.js" charset="ISO-8859-1"></script>
		<!-- Validate -->
		<script type="text/javascript"><!-- <!--{include file="init_calendar.js.tpl"}--> //--></script>
		<script type="text/javascript" src="js/comm_calendar.js"></script>
		<script type="JavaScript" src="js/comm_qtip.js"></script>
		<script type="text/javascript">
		function open_popup(){
			var w = window.screen.width;
			var h = window.screen.height;
			var popW = 476, popH = 320;
			var leftPos = (w-popW)/2, topPos = (h-popH)/2;
			window.open('popup_info.ca?o=<!--{$owner}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos + ',scrollbars=no');
		}
		function do_menu(id,status) {
			//alert (id + status);
			if(status == null){
				status = 'none';
			}
			
			//var currentStyle = document.getElementById(id).style.display;
			
			var divs = document.getElementsByTagName('div');
			for (var i = 0; i < divs.length; i++){
				if(divs[i].id.substring(0, 10) == "principal_"){ 
						document.getElementById(divs[i].id).style.display = 'none';
				}
			}
			
			if(id == null){
				return;
			}
			
			document.getElementById(id).style.display = status;
			
			/*
			if (currentStyle == "block") {
				document.getElementById(id).style.display = "none";
			} else {
				document.getElementById(id).style.display = "block";
			} 
			*/
		}
		function do_submenu(id) {
			var currentStyle = document.getElementById(id).style.display;
			if (currentStyle == "block") {
				document.getElementById(id).style.display = "none";
			} else {
				document.getElementById(id).style.display = "block";
			} 
		}
	</script>
        <!--{/if}-->
	<!--{if $pagos_online_incAutoLoadMetaTag}-->
		<meta http-equiv="refresh" content="<!--{$pagos_online_autoLoadMetaTagVal}-->" >
		<!--{/if}-->
        <!--{include file="css_owner.tpl" print_switch="1"}-->
		<link rel="stylesheet" type="text/css" href="<!--{if $print || $printall}--><!--{ownerurl}--><!--{else}-->owner/<!--{/if}--><!--{$owner}-->/stylesheet.v2.css" />
<!--[if IE 6]>
	<script type="text/javascript" src="scripts/drop_down.js"></script>
<![endif]-->
</head>

<body >

<!--{if ($print or $popup)}-->
<div align="center" style="width:100%; float:left">
<!--{else}-->


<!--{if $admin_access}-->
<div id="admin">
	<div class="contenedor">
		<div class="left"><span><strong>Usuario:</strong> <!--{$admin_username}--> | <a href="admin_home.ca?logout=1">Cerrar sesión de administrador</a></span></div>
		<div class="right"><a href="admin_home.ca">&laquo; Volver al listado de clientes</a></div>
	</div>
</div><br /><br />
<!--{/if}-->


<div id="container">


<div id="header" onmouseover="do_menu();" style="background:url(<!--{ipath name="header.jpg" owner="1" lang="1"}-->) no-repeat;">

	<h1>Alternativa Comunica</h1>
    <a href="home.ca" class="home-link">Home</a>

	<div id="login" class="right" style="position:relative; width:240px; height:118px; margin-top:30px">
    	<p style="width: 205px; height:30px; margin-left:30px; display: block;"><b><!--{lang k=BEGIN_CUSTOMER_WELLCOME}--> <!--{$titular}-->!</b></p>
        <p><!--{lang k=BEGIN_CUSTOMER_NUMBER}--> <!--{$userid}--> <span style="font-size: 9px">(<!--{$ClientStatusForUserLoginPanel}-->)</span></p>
<!--
        <p><!--{lang k=BEGIN_CUSTOMER_LINE_COUNT_MSG}--> <!--{$CountLinesForUserLoginPanel}--> <!--{lang k=BEGIN_CUSTOMER_LINE_COUNT_MSG2}--></p>
-->
        <p class="bot botyatencion">
        <!--{* <a href="contactus.ca?fP=1" style="vertical-align: top; margin-left: 0; padding-top:5px"><!--{lang k=BEGIN_CUSTOMER_ATTENTION_LINK}--></a> *}-->
        <a href="contactus.ca?fP=1" id="contact-bt">Cont&aacute;ctenos</a>        
        
        <a href="logout.ca" title="" style="float: right; margin-left: 0;margin-top:3px"><img onclick="open_popup();" src="<!--{ipath name="btn-logout.gif" owner="1" lang="1"}-->" style="border:0" alt="Logout" /></a>
        </p>
    </div>
</div>

<!--{if $src_forzado|count_characters != 0}-->
<!--{assign var="scr" value=$src_forzado}-->
<!--{/if}-->

<div id="bg-mid" >
<!--{include file="botonera.tpl" botonera=$botonera scr=$scr owner=$owner}-->
<br class="block" />
<div id="contenido-top"></div>

<div id="contenido" onmouseover="do_menu();">
<!--{/if}-->

<!--{assign var="enfoque_id" value="0"}-->
<!--{assign var="enfoque_subId" value="0"}-->
<!--{assign var="id_titulo_anterior" value="0"}-->

<!--{assign var="strEnfoque" value=""}-->
<!--{assign var="strSubEnfoque" value=""}-->

<!--{foreach item=section from=$botonera name=titulos}-->
	<!--{ if ($section.titulo_principal == "")}-->
		<!--{ if ($section.id_titulo_principal != $id_titulo_anterior)}-->
			<!--{assign var="id_titulo_anterior" value=$section.id_titulo_principal}-->
		<!--{/if}-->
		<!--{if $section.titulo == "NOTITLE"}-->
			<!--{foreach name=mitems item=link from=$section.items}-->
                <!--{if $link.id == $scr}-->
					<!--{assign var="enfoque_id" value=$section.id_titulo_principal}-->
                    <!--{assign var="strEnfoque" value=$section.titulo}-->
                    
                    <!--{assign var="strEnfoque" value=""}-->
                    <!--{assign var="strSubEnfoque" value=$link.name}-->
				<!--{/if}-->
          	<!--{/foreach}-->
		<!--{else}-->
			<!--{foreach name=mitems item=link from=$section.items}-->
				
               
                <!--{if $link.id == $scr}-->
					<!--{assign var="enfoque_id" value=$section.id_titulo_principal}-->
					<!--{assign var="enfoque_subId" value=$section.id_sub}-->
                    
                    <!--{assign var="strEnfoque" value=$section.titulo}-->
                    <!--{assign var="strSubEnfoque" value=$link.name}-->
				<!--{/if}-->
			<!--{/foreach}-->
		<!--{/if}-->
		<!--{if $smarty.foreach.titulos.last}--><!--{/if}-->
	<!--{/if}-->
<!--{/foreach}-->

<!--{assign var="strPath" value=""}-->
<!--{ if ($enfoque_id != 0)}-->
	<!--{ if ($strEnfoque == "")}-->
        <!--{assign var="strPath" value=$strSubEnfoque}-->
    <!--{else}-->
        <!--{assign var="strPath" value=$strEnfoque|cat:" &gt; "|cat:$strSubEnfoque}-->
    <!--{/if}-->
<!--{/if}-->
