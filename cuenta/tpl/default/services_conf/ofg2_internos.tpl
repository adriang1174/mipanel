<tr style="height: 30px;"><td class="scr_resalt2">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;" title="<!--{$action[1]}-->"><!--{$action[0]}--></a></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<script type="text/javascript">
		var internos = Array();
		
		function nuevoINT(){
			var w = window.screen.width;
			var h = window.screen.height;
			var popW = 350, popH = 280;
			var leftPos = (w-popW)/2, topPos = (h-popH)/2;
			window.open('conf_services_popup.ca?popup=1&accion=ofg2_internos_nuevoint','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
		}
		
		function nuevoINT_procesar(interno, destino, referencia){
			for(i=0; i<internos.length; i++){
				if(internos[i] == interno){
					return false;
				}
			}
			document.getElementById('form_nuevo_interno_interno').value=interno;
			document.getElementById('form_nuevo_interno_destino').value=destino;
			document.getElementById('form_nuevo_interno_referencia').value=referencia;
			document.getElementById('form_nuevo_interno').submit();
			return true;
		}
		
		function delINT(formulario){
			var si = confirm('<!--{lang k=INT_MSG_CONFIRM}-->');
	        if (si){
			   document.getElementById(formulario+'actioncode').value = "B";
        	   document.getElementById(formulario).submit();
	         return (true);
    	    }
			return false;
		}
		

		function showFollowme(ani, interno){
			var w = window.screen.width;
			var h = window.screen.height;
			var popW = 900, popH = 700;
			var leftPos = (w-popW)/2, topPos = (h-popH)/2;
			window.open('fh_callback.ca?popup=1&followme=1&ani='+ani+'&interno='+interno+'&id_accion=<!--{$action[3]}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos+',scrollbars=yes, resizable=yes');
		}

		</script>
	<form name="form_nuevo_interno" id="form_nuevo_interno" action="" method="post">
		<input type="hidden" name="process" value="1" />
		<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
		<input type="hidden" name="actioncode" id="form_nuevo_interno_actioncode" value="A" />
		<input type="hidden" name="line" value="<!--{$line}-->" />
		<input type="hidden" name="destino" id="form_nuevo_interno_destino" value="" />
		<input type="hidden" name="interno" id="form_nuevo_interno_interno" value="" />
		<input type="hidden" name="referencia" id="form_nuevo_interno_referencia" value="" />
	</form>
			<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
						<!--{lang k=DESCRIPCION_INTERNOS}--><br /><br />
					</td>
				</tr>
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
					<script type="text/javascript">
                    <!--{assign var="total_loops" value=0}-->
                    <!--{foreach name="internos" from=$internos item="int"}-->
						internos.push( <!--{$int.interno}--> );
						<!--{if $int.interno > $total_loops}-->					
							<!--{assign var="total_loops" value=$int.interno}-->
						<!--{/if}-->
                        			
                    <!--{/foreach}-->
                    </script>
                  	<form name="int_<!--{$nuevo_interno}-->" id="int_<!--{$nuevo_interno}-->" action="" method="post">
						<input type="hidden" name="process" value="1" />
						<input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
						<input type="hidden" name="actioncode" id="int_<!--{$nuevo_interno}-->actioncode" value="A" />
						<input type="hidden" name="line" value="<!--{$line}-->" />
						<input type="hidden" name="destino" id="int_<!--{$nuevo_interno}-->destino" value=""/>
						<input type="hidden" name="interno" value="<!--{$nuevo_interno}-->" />
                        <!--{if $nuevo_interno < 8}-->	
                        	<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="nuevoINT('int_<!--{$nuevo_interno}-->'); return false;" />
                       <!--{else}-->     
                       		<input type="image" src="<!--{ipath name="bt-agregar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ADD}-->" onclick="alert('<!--{lang k=MAX_INT_LIMITE}-->'); return false;"/>
                       <!--{/if}-->	 
                       
                      </form>
					</td>
				</tr>
			</table>
			<br />
			<table cellspacing="2" cellpadding="0" border="0">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="center" class="scr_resalt" width="100"><a href="#" class="popup_link" title="<!--{lang k=INTERNO_TITLE}-->"><!--{lang k=INTERNO}--></a></td>
					<!-- <td align="center" class="scr_resalt" width="100"><a href="#" class="popup_link" title="<!--{lang k=NUMERO_TITLE}-->"><!--{lang k=NUMERO}--></td> -->
					<td align="center" class="scr_resalt" width="160"><a href="#" class="popup_link" title="<!--{lang k=REFERENCIA_TITLE}-->"><!--{lang k=REFERENCIA}--></a></td>
					<td align="center" class="scr_resalt" width="260"></td>
					<td align="center" class="scr_resalt" width="140"><!--{lang k=EDITAR}--></td>
                    <td class="scr_resalt" align="center">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			
		
				<!--{section name="loopInternos" start=0 loop=$total_loops}-->
					<!--{assign var="indice" value="`$smarty.section.loopInternos.index+1`"}-->
					
					<!--{foreach name="internos" from=$internos item="int"}-->
						<!--{if $int.interno == $indice}-->					
							<!--{assign var="interno_loop" value="$int"}-->
						<!--{/if}-->
					<!--{/foreach}-->
					
                    <!--{if $interno_loop.interno == $indice}-->
					
                        <!--{if $indice != 8 && $indice != 9}-->
                        <form name="int_<!--{$indice}-->" id="int_<!--{$indice}-->" action="" method="post">
                            <input type="hidden" name="process" value="1" />
                            <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
                            <input type="hidden" name="actioncode" id="int_<!--{$indice}-->actioncode" value="F" />
                            <input type="hidden" name="line" value="<!--{$line}-->" />
                            <input type="hidden" name="destino" id="int_<!--{$indice}-->destino" value=""/>
                            <input type="hidden" name="interno" value="<!--{$indice}-->" />
                        <tr>
                            <td width="20">&nbsp;</td>	
                            <td align="left" style="padding-left: 10px;"><!--{$indice}--></td>
                           <!-- <td align="center"><!--{$int.numero}--> -->
                            <td align="center"><input type="text" name="referencia" value="<!--{$interno_loop.referencia}-->"/></td>
                            <td align="left"></td>
                            <td align="center">	
                                <!--{if $indice == 1}-->
                                <a href="#" title="<!--{lang k=INTERNOS_LAPIZ_TITLE}-->" onclick="showFollowme('<!--{$line}-->_<!--{$interno_loop.interno}-->', '<!--{$interno_loop.interno}-->'); return false;"><img src="<!--{ipath name="icono-lapiz.gif"}-->" border="0" /></a>
                                <!--{else}-->
                                <a href="#" title="<!--{lang k=INTERNOS_LAPIZ_TITLE}-->" onclick="showFollowme('<!--{$line}-->_<!--{$interno_loop.interno}-->', '<!--{$interno_loop.interno}-->'); return false;"><img src="<!--{ipath name="icono-lapiz.gif"}-->" border="0" /></a>
                                / 
                                <a href="#" onclick="return delINT('int_<!--{$interno_loop.interno}-->');"><img src="<!--{ipath name="icono-goma.gif"}-->" border="0" /></a>
                                <!--{/if}-->
                            </td>
                           <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </tr>
                        </form>
                    <!--{elseif $indice == 8}-->
                    <tr>
                    	<!--{foreach name="email_asoc" from=$email_asoc item="email"}-->
                              <!--{if $email.hm_subcasilla == 0}-->
                                  <!--{assign var="email_values" value="$email"}-->
                              <!--{/if}-->
                        <!--{/foreach}-->
                    	<form name="frm" method="post" action="">
                        <input type="hidden" name="process" value="1" />
                        <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
                        <input type="hidden" name="actioncode" value="X" />
                        <input type="hidden" name="line" value="<!--{$line}-->" />
                        <input type=hidden name="hm_casilla"    value="<!--{$email_values.hm_casilla|trim}-->">
                        <input type=hidden name="hm_atsubcas"   value="<!--{$email_values.hm_atsubcas|trim}-->">
                        <input type=hidden name="hm_subcasilla" value="0">
                        <td width="20">&nbsp;</td>	
                        <td align="left" style="padding-left: 10px;">8</td>
                        <!-- <td align="center">Voicemail</td> -->
                        <td align="center">Voicemail</td>
                        <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="link_tooltip">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig}-->"/>
                    </td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </form>
                    </tr>
                    <!--{elseif $indice == 9}-->
                    <tr>
                    	<!--{foreach name="email_asoc" from=$email_asoc item="email"}-->
                              <!--{if $email.hm_subcasilla == 1}-->
                                  <!--{assign var="email_values" value="$email"}-->
                              <!--{/if}-->
                        <!--{/foreach}-->
                    	<form name="frm" method="post" action="">
                        <input type="hidden" name="process" value="1" />
                        <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
                        <input type="hidden" name="actioncode" value="X" />
                        <input type="hidden" name="line" value="<!--{$line}-->" />
                        <input type=hidden name="hm_casilla"    value="<!--{$email_values.hm_casilla|trim}-->">
                        <input type=hidden name="hm_atsubcas"   value="<!--{$email_values.hm_atsubcas|trim}-->">
                        <input type=hidden name="hm_subcasilla" value="1">
                            <td width="20">&nbsp;</td>	
                            <td align="left" style="padding-left: 10px;">9</td>
                            <!-- <td align="center">Fax</td> -->
                            <td align="center">Fax</td>
                           <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="popup_link">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig}-->"/></td>
                            <td align="center">&nbsp;</td>
                            <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </form>
                    </tr>
                    <!--{/if}-->
				<!--{/if}-->
				
				<!--{/section}-->
				<!--{if $total_loops < 10}-->
               <tr>
                    	<!--{foreach name="email_asoc" from=$email_asoc item="email"}-->
                              <!--{if $email.hm_subcasilla == 0}-->
                                  <!--{assign var="email_values" value="$email"}-->
                              <!--{/if}-->
                        <!--{/foreach}-->
                    	<form name="frm" method="post" action="">
                        <input type="hidden" name="process" value="1" />
                        <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
                        <input type="hidden" name="actioncode" value="X" />
                        <input type="hidden" name="line" value="<!--{$line}-->" />
                        <input type=hidden name="hm_casilla"    value="<!--{$email_values.hm_casilla|trim}-->">
                        <input type=hidden name="hm_atsubcas"   value="<!--{$email_values.hm_atsubcas|trim}-->">
                        <input type=hidden name="hm_subcasilla" value="0">
                        <td width="20">&nbsp;</td>	
                        <td align="left" style="padding-left: 10px;">8</td>
                        <!-- <td align="center">Voicemail</td> -->
                        <td align="center">Voicemail</td>
                        <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="popup_link">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig}-->"/>
                    </td>
                        <td align="center">&nbsp;</td>
                        <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </form>
                    </tr>
				<tr>
                    	<!--{foreach name="email_asoc" from=$email_asoc item="email"}-->
                              <!--{if $email.hm_subcasilla == 1}-->
                                  <!--{assign var="email_values" value="$email"}-->
                              <!--{/if}-->
                        <!--{/foreach}-->
                    	<form name="frm" method="post" action="">
                        <input type="hidden" name="process" value="1" />
                        <input type="hidden" name="actionid" value="<!--{$action[3]}-->" />
                        <input type="hidden" name="actioncode" value="X" />
                        <input type="hidden" name="line" value="<!--{$line}-->" />
                        <input type=hidden name="hm_casilla"    value="<!--{$email_values.hm_casilla|trim}-->">
                        <input type=hidden name="hm_atsubcas"   value="<!--{$email_values.hm_atsubcas|trim}-->">
                        <input type=hidden name="hm_subcasilla" value="1">
                            <td width="20">&nbsp;</td>	
                            <td align="left" style="padding-left: 10px;">9</td>
                            <!-- <td align="center">Fax</td> -->
                            <td align="center">Fax</td>
                           <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="popup_link">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig}-->"/></td>
                            <td align="center">&nbsp;</td>
                            <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </form>
                    </tr>
                <!--{/if}-->
				<tr><td colspan="6">&nbsp;</td></tr>
			</table>
		</div>
</tr>
<tr><td>&nbsp;</td></tr>