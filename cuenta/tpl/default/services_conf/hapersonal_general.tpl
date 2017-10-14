<tr style="height: 30px;"><td class="scr_resalt">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;<img src="<!--{ipath name="bt-ampliar.gif" owner="1"}-->" border="0">&nbsp;</span><!--{$action[0]}--></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<form name="frm" action="" method="post">
			<input type="hidden" name="process" value="1" />
			<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
			<input type="hidden" name="actioncode" value="M" />
			<input type="hidden" name="line" value="<!--{$line}-->" />
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="20">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="150"><!--{lang k=NOMBRE}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;" width="270"><input type="text" name="Usuario" size="40" value="<!--{$datos[0].Usuario|trim}-->"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><!--{lang k=CLAVE_ACCESO}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><input type="password" size="4" maxlength="4" name="clave_acc" value="<!--{$datos[0].clave_acc|trim}-->"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><!--{lang k=CLAVE_PUBLICA}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><input type="password" size="4" maxlength="4" name="clave_pub" value="<!--{$datos[0].clave_pub|trim}-->"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
			</tr>						
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><!--{lang k=TELEFONO_ESPECIAL}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><input type="text" name="Tel_Esp" value="<!--{$datos[0].Tel_Esp|trim}-->"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
			</tr>
			<tr style="height: 25px">
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;"><!--{lang k=TRATAMIENTO_OTROS}--></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">
					<select id="default_otros" name="default_otros">
						<option  <!--{if $datos[0].default_otros == 0}--> selected <!--{/if}--> value="0">Follow Me</option>
						<option <!--{if $datos[0].default_otros == 1}--> selected <!--{/if}--> value="1">Bloqueado</option>
						<option <!--{if $datos[0].default_otros == 2}--> selected <!--{/if}--> value="2">Pedido de Clave - Follow Me (Deshabilitado)</option>
						<option <!--{if $datos[0].default_otros == 3}--> selected <!--{/if}--> value="3">Hola Mail</option>
						<option <!--{if $datos[0].default_otros == 4}--> selected <!--{/if}--> value="4">Nro.Especial</option>
					</select>
				</td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204); padding-left: 5px;">&nbsp;</td>
			</tr>	
			<tr style="height: 25px">
				<td colspan="3" align="right"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" /></td>
				<td>&nbsp;</td>
			</tr>									
			</form>
		</table>
	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>