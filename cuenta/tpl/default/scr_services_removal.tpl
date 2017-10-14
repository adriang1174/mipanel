
<script type="text/javascript">
function show_hide(theDiv){
	if(!document.getElementById(theDiv)){
		return;
	}
	mostrar = false;
	if(document.getElementById(theDiv).style.display == 'none'){
		mostrar = true;
	}

	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++){
		if(divs[i].id.substring(0, 6) == "action"){
		   document.getElementById(divs[i].id).style.display = 'none';
		 }
	}
	if(mostrar){
		document.getElementById(theDiv).style.display = 'block';
	}
}

</script>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td class="scr_header"><font class="scr_header"><!--{$strPath}--></font></td></tr>
<!--{if $email_not_verif}-->
</table><br />
            <table border="0" cellspacing="0" cellpadding="0" class="info_table">
                <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{lang k=ERR_EMAIL_NOT_VERIFIED}--></b></td></tr>
                <tr><td align="center" style="padding: 5px;"><a href="email.ca" target="_self"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" border="0" /></a>&nbsp;<a href="index.ca" target="_self"><img src="<!--{ipath name="bt-cancelar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=CANCEL}-->" border="0" /></a></td></tr>
            </table>
<!--{else}-->
    <tr><td style="padding-top: 10px;">

   
   
   <!--{if $show == "select"}-->

   <!--{lang k=MSG_DEL_SERVICE}--><br /><br />

   <form name="frmLine" id="frmLine" method="post" action="">
   <table>
   <tr>
	<!--{if $lines|@count > 0}-->
   <td>
	<!--{lang k=MSG_SELECT_LINE}-->&nbsp; 
	</td>
	<td>
		<select name="line">
			<!--{foreach name="lines" from=$lines item="line"}-->
			<option value="<!--{$line[2]}-->"><!--{$line[2]}--> - <!--{$line[1]}--></option>
			<!--{/foreach}-->
		</select>
		</td>
		<td>
	<input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" />
	<input type="hidden" name="step" value="1" maxlength="128" size="64" />
	</td>
	<!--{else}-->
	<td><b><!--{lang k=NO_CONF_LINES}--></b>
    </td>
	<!--{/if}-->
	</tr></table>
	</form>
	<!--{/if}-->
	
	
	
	
	<!--{if $show == "confirma"}-->
	
	Est&#225; por dar de baja el servicio 
	<b><!--{lang k=LINE}-->:</b>&nbsp; <!--{$line}--> -
	<b><!--{lang k=SERVICE}-->:</b>&nbsp; <!--{$service}--> 
	¿Est&#225; seguro?
	<br /><br />
	
	<form action="<!--{phpself}-->?post=1" method="POST" style="margin: 0px;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	
	<tr>
	<td colspan="2" style="padding-top: 20px;" align="center">
	&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
	&nbsp;
	
	<input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" name="cancel" value="1" onclick="location.href='services_removal.ca'; return false;" />
	
	<input type="hidden" name="line" value="<!--{$line}-->" maxlength="128" size="64" />
	<input type="hidden" name="service" value="<!--{$service}-->" maxlength="128" size="64" />
	<input type="hidden" name="step" value="2" maxlength="128" size="64" />
	</td>
	</tr>
	
	</table>
	</form>

	
	<table width="100%">
	<!--{foreach name="actions" from=$actions item="action"}-->
		<!--{include file="$action[2]"}-->
	<!--{/foreach}-->		
	</table>	
	<!--{/if}-->
	
	<!--{if $show == "formulario"}-->
	
	
	
	<form action="<!--{phpself}-->?post=1" method="POST" style="margin: 0px;">
	
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	
	<!--{if $contact_msg}-->
	<tr><td style="padding-top: 15px;"><!--{$contact_msg_txt}--></td></tr>
	<!--{/if}-->
	
	
	<!--{if $msg_error}-->
		<tr>
		<td colspan="2" style="padding: 20px;" align="center">
		<table border="0" cellspacing="0" cellpadding="0" class="info_table">
		<tr><td style="padding: 10px;" class="error"><b><!--{$msg_errorEmail}--></b></td></tr>
		</table>
		</td>
		</tr>
	<!--{elseif $msg_info}-->
		<tr>
		<td colspan="2" style="padding: 10px;" align="center">
		<table border="0" cellspacing="0" cellpadding="0" class="info_table">
		<tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{$msg_infoEmail}--></b></td></tr>
		</table>
		</td>
		</tr>
	<!--{/if}-->
	
	<tr><td colspan="2">1)
	<!--{lang k=BAJA_PREG1}-->
	<br />
	</td></tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_NECESIDADES}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_NECESIDADES" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_PROMETIDO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_PROMETIDO" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_NECESITO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_NECESITO" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_INCONVENIENTES}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_INCONVENIENTES" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_FUNCIONAMIENTO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_FUNCIONAMIENTO" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_EMPRESA}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_EMPRESA" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_CIERRE}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_CIERRE" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_FALLECIMIENTO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_FALLECIMIENTO" value="1"  />
	</td>
	</tr>
		<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=BAJA_OTRA}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="BAJA_OTRA" value="" maxlength="128" size="64" />
</tr>
	<tr><td colspan="2">
	-----
	<br />
	</td></tr>
	
	<tr><td colspan="2">2)
	<!--{lang k=BAJA_PREG2}-->
	<br />
	</td></tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_RUIDO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_RUIDO" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_ECO}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_ECO" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_CORTA}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_CORTA" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_OCUPADA}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_OCUPADA" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
	<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
	<b><!--{lang k=BAJA_PROBLEMAS}--></b>:</td>
	<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
	<input type="checkbox" name="BAJA_PROBLEMAS" value="1"  />
	</td>
	</tr>
	
	<tr valign="top">
<td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #eee; border-bottom: 0px;">
<b><!--{lang k=BAJA_OTROS}--></b>:</td>
<td style="padding-left: 5px; padding: 5px; border: 1px solid #eee; border-left: 0px;">
<input type="text" name="BAJA_OTROS" value="" maxlength="128" size="64" />
</tr>
	
	<tr>
	<td colspan="2" style="padding-top: 20px;" align="center">
	&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" />
	&nbsp;
	<a href="services_removal.ca">
	<input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" onclick="location.href = 'services_removal.ca'" name="cancel" value="1" />
	</a>
	<input type="hidden" name="line" value="<!--{$line}-->" maxlength="128" size="64" />
	<input type="hidden" name="service" value="<!--{$service}-->" maxlength="128" size="64" />
	<input type="hidden" name="step" value="3" maxlength="128" size="64" />
	</td>
	</tr>
	
	</table>
	</form>
	
	<!--{/if}-->
	
	
	<!--{if $show == "cierreProceso"}-->
	
	<!--{lang k=BAJA_SENT}-->
	
	<!--{/if}-->
	
    </td></tr>
</table>
 <!--{if $show_id}-->
<script type="text/javascript">
	show_hide('action<!--{$show_id}-->');
</script>
 <!--{/if}-->
 <!--{/if}-->