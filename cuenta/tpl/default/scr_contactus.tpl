<!--{if $contact_form}-->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header">FAQ</font>
        </td></tr>
        <tr><td style="padding-top: 15px;"><!--{lang k=FAQ_Q_1}--></td></tr>
		<tr><td style="padding-top: 10px;"><!--{lang k=FAQ_R_1}--></td></tr>
		<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_Q_2}--></td></tr>
		<tr><td style="padding-top: 10px;"><!--{lang k=FAQ_R_1}--></td></tr>
		<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_Q_3}--></td></tr>
		<tr><td style="padding-top: 10px;"><!--{lang k=FAQ_R_3}--></td></tr>
		
		<!--{if $vea_ademas_red}-->
			<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_LINKS}--></td></tr>
			<tr><td style="padding-top: 10px;"><a target="_blank" href="http://www.alternativa.com.ar/Seccion/422/Preguntas-frecuentes.html"><!--{lang k=FAQ_SERVICE_FAQ}--></a></td></tr>
		<!--{/if}-->
		
		<!--{if $vea_ademas_hola}-->
			<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_LINKS}--></td></tr>
			<tr><td style="padding-top: 10px;"><a target="_blank" href="http://www.holatel.com/Seccion/311/PreguntasFrecuentes.html"><!--{lang k=FAQ_SERVICE_FAQ}--></a></td></tr>
		<!--{/if}-->
		
		<!--{if $vea_ademas_holatel}-->
			<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_LINKS}--></td></tr>
			<tr><td style="padding-top: 10px;"><a target="_blank" href="http://www.holatel.com/content.aspx?Id=569"><!--{lang k=FAQ_SERVICE_FAQ}--></a></td></tr>
		<!--{/if}-->
		
			<!--{if $vea_ademas_telephone2}-->
			<tr><td style="padding-top: 25px;"><!--{lang k=FAQ_LINKS}--></td></tr>
			<tr><td style="padding-top: 10px;"><a target="_blank" href="http://www.telephone2.com/seccion/486/preguntas-frecuentes.html"><!--{lang k=FAQ_SERVICE_FAQ}--></a></td></tr>
		<!--{/if}-->
</table>
<br /><br />
<!--{/if}-->

<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td class="scr_header"><font class="scr_header"><!--{$strPath}--></font></td></tr>
        <!--{if $contact_msg}-->
		<tr><td style="padding-top: 15px;">
		<!--{if $contact_msg_txt}-->
			<!--{lang k="CONTACTUS_MSG_OK" owner="1"}-->
		<!--{else}-->
			<span style='color: red; font-weight: bold'><!--{lang k="CONTACTUS_MSG_KO" owner="1"}--></span>
		<!--{/if}-->
		
		</td></tr>
		<!--{/if}-->
		<!--{if $contact_form}-->
		<tr><td style="padding-top: 15px;"><!--{lang k=CONTACTUS_TITLE}--></td></tr>
		<tr><td style="padding-top: 25px;">
			<form name="ftmContactus" action="" method="post">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td><!--{lang k=CONTACTUS_NAME_LASTNAME}--></td>
					<td width="30">&nbsp;</td>
					<td><input type="text" name="name" id="name" style="width: 185px"/></td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td>Tipo de reclamo</td>
					<td width="30">&nbsp;</td>
					<td>
						<select name="tipo_reclamo" style="font-size: 11px; width: 190px; float:left;">
							<!--{foreach from=$reclamos item=reclamo}-->
								<option value="<!--{$reclamo}-->">- <!--{$reclamo}--></option>
							<!--{/foreach}-->
						</select>
					
					</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td valign="top"><!--{lang k=CONTACTUS_COMMENTS}--></td>
					<td width="30">&nbsp;</td>
					<td><textarea name="comments" id="comments" style="width: 186px"></textarea></td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3" align="right"><input type="image" src="<!--{ipath name="bt-enviar.gif" owner="1" lang="1"}-->" name="cancel" value="1" /></td></tr>
			</table>
			</form>
		</td></tr>
		<!--{/if}-->
		
</table>
