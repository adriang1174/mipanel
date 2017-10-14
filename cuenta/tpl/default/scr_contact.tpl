<table border="0" cellspacing="0" cellpadding="0" width="100%">
                
        <!--{if $show_select}-->
		<tr><td>
			<form name="frmLine" id="frmLine" method="post" action="">
			<table>
			<tr>
				<td>Selecciona una l&iacute;nea &nbsp;&nbsp;</td>
				<td>
				<select name="line">
					<!--{foreach name="lines" from=$lines item="line"}-->
					<option value="<!--{$line[0]}-->"><!--{$line[0]}--></option>
					<!--{/foreach}-->
				</select>
				</td>
				<td>
				<input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" />
				</td>
			</tr>
			</table>
			</form>
		</td></tr>
		<!--{/if}-->
		
		<!--{if $show_thanks}-->
		<tr><td>
			<p align="center" style="padding:100px 0"><b>El mensaje fue enviado con &eacute;xito. <br /><br />Si quieres enviar tu n&uacute;mero de HolaTel a m&aacute;s personas, haz <a href="contact.ca">clic aqu&iacute;</a>.</b></p>
		</td></tr>
		<!--{/if}-->
		
		<!--{if $show_form}-->
		<tr><td style="padding-left: 13px;">
			<form name="frmLine" id="frmLine" method="post" action="">
			<input type="hidden" name="line" value="<!--{$selected_line}-->" />
			<input type="hidden" name="send" value="true" />
            <img src="<!--{ipath name="comunicales_top.jpg" lang="1" owner="1"}-->" alt="Contales a tus familiares y amigos sobre tu HolaTel." width="720" height="64" />
			<p align="center" style="padding-top:10px">Ingresa los datos de tus contactos a continuaci&oacute;n:</p>
			<p style="color: red" align="center"><!--{$str_error}--></p>
			<br />
            <br />
			<table style="margin:0 auto">
  <tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Nombre del contacto 1:</td>
			<td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="nombre_1" size="40" value="<!--{$nombre_1}-->" style="border:1px solid #ccc; width:170px; padding:3px" /></td>
				</tr>
				<tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Mail del contacto 1:</td>
				  <td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="email_1" size="40" value="<!--{$email_1}-->" style="border:1px solid #ccc; width:170px; padding:3px" /></td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Nombre del contacto 2:</td>
				  <td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="nombre_2" size="40" value="<!--{$nombre_2}-->" style="border:1px solid #ccc; width:170px; padding:3px" /> </td>
				</tr>
				<tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Mail del contacto 2:</td>
				  <td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="email_2" size="40" value="<!--{$email_2}-->" style="border:1px solid #ccc; width:170px; padding:3px" /> </td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Nombre del contacto 3:</td>
				  <td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="nombre_3" size="40" value="<!--{$nombre_3}-->" style="border:1px solid #ccc; width:170px; padding:3px" /> </td>
				</tr>
				<tr>
					<td align="right" valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#0971af; font-weight:bold; padding-bottom:10px">Mail del contacto 3:</td>
				  <td>&nbsp;</td>
					<td style="padding-bottom:10px"><input type="text" name="email_3" size="40"  value="<!--{$email_3}-->" style="border:1px solid #ccc; width:170px; padding:3px" /> </td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3" align="center" style="padding-left:30px">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" style="padding-right:50px"><input type="image" src="<!--{ipath name="aceptar_bt.jpg" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
    <td align="left"><input name="" type="reset" value="" style="background:url(<!--{ipath name="borrar_bt.jpg" lang="1" owner="1"}-->); width:89px; height:33px; border:0; cursor:pointer" /></td>
  </tr>
</table>
				</td></tr>
			</table>
		  </form>
		</td></tr>
		<!--{/if}-->
		
</table>
