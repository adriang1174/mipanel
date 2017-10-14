<tr style="height: 30px;"><td class="scr_resalt2">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;<!--{$action[0]}--></td></tr>
		<tr><td>   
        <script type="text/javascript">
		function deleteInt(int){
			if(confirm("¿Desea eliminar el interno " + int + "?")){
				document.getElementById('interno').value = int;
				document.getElementById('frmdelete').submit();
			}
		}
		
		function resetInt(int, mail){
			if(confirm("¿Desea resetear la password del interno " + int + "?")){
				document.getElementById('interno_reset').value = int;
				document.getElementById('email_com').value = mail;
				document.getElementById('frmreset').submit();
			}
		}
		
		function modifInt(int){
			document.getElementById('interno_edit').value = int;
			document.getElementById('voicemail_edit').value = document.getElementById('voicemail_'+int).value;
			document.getElementById('mail_comunic_edit').value = document.getElementById('mail_comunic_'+int).value;
			document.getElementById('frmedit').submit();
			
		}
		
		function addInt(){
			var w = window.screen.width;	
			var h = window.screen.height;
			var popW = 350, popH = 250;
			var leftPos = (w-popW)/2, topPos = (h-popH)/2;
			window.open('conf_services_popup.ca?popup=1&accion=netfono_nuevoint&line=<!--{$line}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
		}
		
		function nuevoINT_procesar(nuevo_interno, nuevo_voicemail, nuevo_mail_comunic){
			document.getElementById('interno_add').value = nuevo_interno;
			document.getElementById('voicemail_add').value = nuevo_voicemail;
			document.getElementById('mail_comunic_add').value = nuevo_mail_comunic;
			document.getElementById('frmAdd').submit();
		}
		
		function activarInt(int){
			if(confirm("¿Quiere activar nuevamente este interno?")){
				nuevoINT_procesar(int, document.getElementById('voicemail_'+int).value, document.getElementById('mail_comunic_'+int).value);
			}else{
				return false;
			}
		}
		
	
		var internos_en_uso = new Array();
		<!--{foreach name="internos" from=$internos item="int"}-->
			<!--{if $int.Estado == "HABILITADO"}-->
				internos_en_uso.push('<!--{$int.Interno}-->');
			<!--{/if}-->
		<!--{/foreach}-->
		
		</script>
        <form name="frmAdd" id="frmAdd" action="" method="post">	
            <input type="hidden" name="process" value="1" />
            <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
            <input type="hidden" name="actioncode" value="A" />
            <input type="hidden" name="line" value="<!--{$line}-->" />
            <input type="hidden" name="contexto" value="<!--{$contexto[0].Contexto}-->" />
            <input type="hidden" name="interno" id="interno_add" value="" />
            <input type="hidden" name="voicemail" id="voicemail_add" value="" />
            <input type="hidden" name="mail_comunic" id="mail_comunic_add" value="" />
        </form> 


        <form name="frmedit" id="frmedit" action="" method="post">	
            <input type="hidden" name="process" value="1" />
            <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
            <input type="hidden" name="actioncode" value="M" />
            <input type="hidden" name="line" value="<!--{$line}-->" />
            <input type="hidden" name="interno" id="interno_edit" value="" />
            <input type="hidden" name="voicemail" id="voicemail_edit" value="" />
            <input type="hidden" name="mail_comunic" id="mail_comunic_edit" value="" />
            <input type="hidden" name="audio" id="audio_edit" value="" />
        </form> 
        <form name="frmdelete" id="frmdelete" action="" method="post">	
            <input type="hidden" name="process" value="1" />
            <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
            <input type="hidden" name="actioncode" value="B" />
            <input type="hidden" name="line" value="<!--{$line}-->" />
            <input type="hidden" name="interno" id="interno" value="" />
        </form> 
        <form name="frmreset" id="frmreset" action="" method="post">	
            <input type="hidden" name="process" value="1" />
            <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
            <input type="hidden" name="actioncode" value="R" />
            <input type="hidden" name="password_reset" value="1" />
            <input type="hidden" name="line" value="<!--{$line}-->" />
            <input type="hidden" name="interno" id="interno_reset" value="" />
			<input type="hidden" name="email_comunicaciones" id="email_com" value="" />
        </form>
        <!--{if $process == 1 && $actioncode == 'R'}-->
        <script type="text/javascript">
		alert("El requerimiento ha sido procesado. En breve recibirá en su casilla de correo la información de su cuenta");
		</script>
        <!--{/if}-->
		<div>
    		<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
						<!--{lang k=NETFONO_CONFIGURACION}--><br /><br />
					</td>
				</tr>
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
                  	<form name="int_<!--{$nuevo_interno}-->" id="int_<!--{$nuevo_interno}-->" action="" method="post">
						<input type="hidden" name="process" value="1" />
						<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
						<input type="hidden" name="actioncode" id="int_<!--{$nuevo_interno}-->actioncode" value="A" />
						<input type="hidden" name="line" value="<!--{$line}-->" />
						<input type="hidden" name="destino" id="int_<!--{$nuevo_interno}-->destino" value=""/>
						<input type="hidden" name="interno" value="<!--{$nuevo_interno}-->" />
                  <!--{*
                       <input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="addInt(); return false;"/>
                  *}-->
                      </form>
					</td>
				</tr>
			</table>
			<br />
            
                
	<table cellspacing="2" cellpadding="0" border="0">
		<tr style="height: 20px">
			<td width="20">&nbsp;</td>	
			<td align="center" class="scr_resalt" width="100"><a href="#" class="popup_link" title="N&uacute;mero de interno habilitado.<br> Para modificar su configuraci&oacute;n haga clic en (icono lapicito),<br> para borrarlo haga clic en (icono goma)">Interno nº</a></td>
			<td align="center" class="scr_resalt" width="160"><a href="#" class="popup_link" title="Es la direccion de email adonde llegan los mensajes en mp3">Voicemail</a></td>

			<td align="center" class="scr_resalt" width="160"><a href="#" class="popup_link" title="Es la direccion de email para las comunicaciones">Mail comunicaciones</a></td>
			<td align="center" class="scr_resalt" width="140">Estado</td>
			<td align="center" class="scr_resalt" width="80">Audio</td>
            <td class="scr_resalt" align="center">&nbsp;</td>
            <td class="scr_resalt" align="center">&nbsp;</td>
            <td class="scr_resalt" align="center">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <!--{foreach name="internos" from=$internos item="int"}-->
	<tr>
		<td width="20">&nbsp;</td>	
		<td align="left" style="padding-left: 10px;"><!--{$int.Interno}--></td>
		<td align="center"><input type="text" name="voicemail" id="voicemail_<!--{$int.Interno}-->" value="<!--{$int.mailbox}-->"/></td>
	
		<td align="center"><input type="text" name="mail_comunic" id="mail_comunic_<!--{$int.Interno}-->"  value="<!--{$int.mailcomunicacion}-->"/></td>
		<td align="center">	<!--{$int.Estado}-->
		</td>
        <td align="center"><input name="audio" id="audio_<!--{$int.Interno}-->" type="checkbox" <!--{if ($int.CanReinvite == 'yes') }--> checked="checked" <!--{/if}--> /></td>
		<td align="center">
        <!--{if $int.Interno != $line|cat:"00"}-->	
        	<!--{if $int.Estado == 'HABILITADO'}-->
        	<a href="#" onclick="deleteInt(<!--{$int.Interno}-->); return false;">
            	<img src="<!--{ipath name="bt-borrar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=DELETE}-->" border="0" />
            </a>
            <!--{else}-->
  <a href="#" onclick="activarInt(<!--{$int.Interno}-->); return false;">
            	<img src="<!--{ipath name="bt-activar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACTIVATE}-->" border="0" />
            </a>
            <!--{/if}-->
        <!--{else}-->
        &nbsp;    
        <!--{/if}-->
        </td>
        <td align="center">
        	<!--{if $int.Estado == 'HABILITADO'}-->
        	<a href="#" onclick="resetInt(<!--{$int.Interno}-->, '<!--{$int.mailcomunicacion}-->'); return false;">
            	<img src="<!--{ipath name="bt-reset.gif" lang="1" owner="1"}-->" alt="<!--{lang k=RESET}-->" border="0" />
            </a>
            <!--{else}-->
            	<img src="<!--{ipath name="bt-reset-dis.gif" lang="0" owner="0"}-->" alt="<!--{lang k=RESET}-->" border="0" />
            <!--{/if}-->
      
        </td>
        <td align="center">
        	<!--{if $int.Estado == 'HABILITADO'}-->
        	<a href="#" onclick="modifInt(<!--{$int.Interno}-->); return false;">
	            <img src="<!--{ipath name="bt-editar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=EDIT}-->" border="0" />
            </a>
            <!--{else}-->
            	<img src="<!--{ipath name="bt-edit-dis.gif" lang="0" owner="0"}-->" alt="<!--{lang k=EDIT}-->" border="0" />
            <!--{/if}-->
        </td>
	</tr>
    <!--{/foreach}-->
	<tr><td colspan="6">&nbsp;</td></tr>
</table>      
        
	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>
