<!--{if !$print}-->
    <script type="text/javascript">
    <!--
        var _is_email = false;
    //-->
    </script>
<!--{/if}-->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if $pm_pago_facil}-->
        <!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}--><a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>&gt; Cup&oacute;n de pago</font>
            </td></tr>
            <tr>
            	<td style="padding-top: 5px">
            	<!--{lang k=TEXTO_CUPON_PAGO}-->
            	</td>
            </tr>
        <!--{/if}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr><td align="center">
                    <table border="0" cellspacing="0" cellpadding="1" style="border: 1px solid #7F7F7F;">
                        <tr><td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr><td style="height: 22px;" class="scr_resalt" align="center"><!--{lang k=CUPON_PAGO_FACIL}--></td></tr>
                                <tr><td style="padding: 10px;"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr><td colspan="4"><img src="<!--{ipath name="clogo.gif" owner="1" lang="1"}-->" /><img src="<!--{ipath name="logo-pagofacil.jpg" owner="0" lang="0"}-->" />
                                    <!--{if $owner == 'telephone2'}-->
                                    <img src="<!--{ipath name="logo-rapipago.jpg" owner="0" lang="0"}-->" />
                                    <!--{/if}-->
                                    </td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="right"><!--{lang k=RSOCIAL}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->titular}--></td><td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="right"><!--{lang k=CUIT}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->cuit}--></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="right"><!--{lang k=ADDRESS}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->address}--></td><td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="right"><!--{lang k=EXPIRE_DATE}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->expiration}--></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="right"><!--{lang k=CLIENT_CODE}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->clientid}--></td><td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="right"><!--{lang k=PAY_COND}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->payment_condition}--></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="right"><!--{lang k=IMPORT_TO_PAY}--></td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->total_simbol}-->&nbsp;<!--{$ticket->total_amount}--></td><td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="right"><!--{lang k=TICKET_N}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->ticketid}--></td></tr>
                                </table></td></tr>
                                <!--{if $print}-->
                                    <tr><td style="padding-top: 50px; border-bottom: 1px dotted #7f7f7f;"><br></td></tr>
                                    <tr style="valign: middle;"><td style="height: 100px;" align="center"><img src="<!--{if $print || $printall}--><!--{baseurl}--><!--{else}-->/<!--{/if}--><!--{barcode id=$ticket->barcodeid}-->" /></td></tr>
                                <!--{/if}-->
                            </table>
                        </td></tr>
                    </table>
                </td></tr>
                <!--{if !$print}-->
                    <tr><td align="center" style="padding-top: 10px;">
                        <form action="ticket.ca" method="GET" style="margin: 0px;" target="_blank" onsubmit="if ( _is_email) this.target='_top';">
                            <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                            <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                                <tr valign="middle">
                                    <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=IMPORT_TO_PAY}--></td>
                                    <td  style="padding: 5px; padding-right: 0px;"><!--{$ticket->total_simbol}--></td>
                                    <td style="padding: 5px; padding-left: 3px;"><input type="text" name="import" value="<!--{$ticket->total_amount}-->" /></td>
                                    <td style="padding: 5px; border-left: 1px solid #7F7F7F;"><input type="image" src="<!--{ipath name="bt-imprimir.gif" owner="1" lang="1"}-->" name="print" value="1" />&nbsp;<input type="image" src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" name="email" value="1" onclick="_is_email = true;" /></td>
                                </tr>
                            </table>
                        </form>
                    </td></tr>
                <!--{/if}-->
            </table>
        </td></tr>
	<!--{elseif $pm_pago_universal}-->
		<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : 
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pago Universal</font>
        </td></tr>
        <tr><td style="padding-top: 20px;"><!--{lang k=PAGO_UNIVERSAL_TIP}--></td></tr>
        <tr><td align="center" style="padding-top: 20px;">
            <form action="ticket.ca" method="POST" style="margin: 0px;" target="_top">
                <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=IMPORT_TO_PAY}--></td>
                        <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->total_simbol}--></td>
                        <td style="padding: 5px; padding-left: 3px;"><input type="text" name="import" value="<!--{$ticket->total_amount}-->" /></td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;"><input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" /></td>
                        
                    </tr>
                </table>
            </form>
        </td></tr>
        <tr><td style="padding-top: 20px;"><!--{lang k="PAGO_UNIVERSAL_ACLARATION"}--></td></tr>
		
		
	 <!--{elseif $pm_paypal}-->
		<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Paypal</font>
        </td></tr>
        
        
		<!--{if $checkoutpp}-->
        	<!--{if $cancelpay}-->
            	<tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                 <!--{lang k="PAYPAL_CANCEL_PAYMENT"}-->
                </td></tr>
                <tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                <a href="index.ca"/><!--{lang k="BACK"}-->
                </td></tr>
       		<!--{elseif $confirmpay}-->
                <tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                 <!--{lang k="PAYPAL_CONFIRM_PAYMENT"}--> <!--{$ticket->total_simbol}--> <!--{$confirmpayammount}--> <!--{lang k="PAYPAL_CONFIRM_PAYMENT2"}-->
                </td></tr>
                <tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                <input type="image" src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" onclick="location.href = location.href + '&cancelpayment=1';"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="image" src="<!--{ipath name="bt-confirmar.gif" owner="1" lang="1"}-->" onclick="location.href = location.href + '&finalizeco=1';"/>
                </td></tr>
            <!--{else}-->
                <tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                <!--{$msg_result}-->
                </td></tr>
                <tr><td style="padding-top: 20px;"></td></tr>
                <tr><td align="center" style="padding-top: 20px;">
                <a href="index.ca"/><!--{lang k="BACK"}-->
                </td></tr>
            <!--{/if}-->
		<!--{else}-->
		<tr><td style="padding-top: 20px;"><!--{lang k=PAYPAL_TIP}--></td></tr>
		<tr><td align="center" style="padding-top: 20px;">
            <form action="ticket.ca" method="POST" style="margin: 0px;" target="_top">
				<input type="hidden" name="checkoutpp" value="1" />
                <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=IMPORT_TO_PAY}--></td>
                        <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->total_simbol}--></td>
                        <td style="padding: 5px; padding-left: 3px;"><input type="text" name="import" value="<!--{$ticket->total_amount|replace:",":""}-->" /></td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;"><input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" /></td>
                    </tr>
                </table>
            </form>
		</td></tr>
        <tr><td style="padding-top: 20px;"><!--{lang k="PAYPAL_ACLARATION"}--></td></tr>	
		<!--{/if}-->
        
		
	 <!--{elseif $pm_dinero_mail_mx}-->
			<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : <!--{if (!$ticket->ticketid)}--><!--{lang k=DINERO_MAIL_MX_CUSTOM_PAY}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;<!--{lang k=DINERO_MAIL_MX_DENOM}--></font>
        </td></tr>
 		<tr><td style="padding-top: 20px;">
		
		<!--{if ($displayEditor)}--><!--{lang k=DINERO_MAIL_MX_TIP0}--><!--{/if}-->
		<!--{if ($displayPreviw)}--><!--{lang k=DINERO_MAIL_MX_TIP1}--><!--{/if}-->
		<!--{if ($displayProcess)}--><!--{lang k=DINERO_MAIL_MX_TIP2}--><!--{/if}-->
		
		</td></tr>
		<tr><td align="center" style="padding-top: 20px;">
 
		   <!--{if ($displayEditor || $displayPreviw || $displayProcess)}-->
		   <form id="frm_dmmx" name="frm_dmmx" action="<!--{$ticket->url_action}-->" method="POST" style="margin: 0px;" target="_top">
				
				<input type="hidden" name="NombreItem" value="<!--{$ticket->NombreItem}-->" />
				<input type="hidden" name="TipoMoneda" value="<!--{$ticket->TipoMoneda}-->" />
				<input type="hidden" name="E_Comercio" value="<!--{$ticket->E_Comercio}-->" />
				<input type="hidden" name="NroItem" value="<!--{$ticket->NroItem}-->" />
				<input type="hidden" name="DireccionExito" value="<!--{$ticket->DireccionExito}-->" />
				<input type="hidden" name="DireccionFracaso" value="<!--{$ticket->DireccionFracaso}-->" />
				<input type="hidden" name="DireccionEnvio" value="0"> 
				<input type="hidden" name="Mensaje" value="0" />
				<input type="hidden" name="process_dmmx" value="1" />
				<input type="hidden" name="usr_nombre" value="<!--{$ticket->usr_nombre}-->">
				<input type="hidden" name="usr_apellido" value="<!--{$ticket->usr_apellido}-->">
				<input type="hidden" name="usr_tel_numero" value="<!--{$ticket->usr_tel_numero}-->">
				<input type="hidden" name="usr_email" value="<!--{$ticket->usr_email}-->">
				<input type='hidden' name='MediosPago' value='13,14'>
                
				<input type="hidden" id="etapaProceso_dmmx" name="etapaProceso_dmmx" value="<!--{$etapaProceso_dmmx}-->">
				
				
				<!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                
				<table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=IMPORT_TO_PAY}--></td>
                        <td><table>
                        	<tr>
				                <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->moneda}--></td>
				                <td style="padding: 5px; padding-left: 3px;">
						
								<!--{if $displayEditor}-->
								<input type="text" name="PrecioItem_Dolares" value="<!--{$ticket->total}-->" />
								<!--{/if}-->
						
								<!--{if $displayPreviw || $displayProcess}-->
								<!--{$ticket->total}-->
								<input type="hidden" name="PrecioItem" value="<!--{$ticket->total_pesos}-->" />
								<input type="hidden" name="PrecioItem_Dolares" value="<!--{$ticket->total}-->" />
								<!--{/if}-->
								</td>
							</tr>
							<tr>
								<td style="padding: 5px; padding-left: 3px;" colspan="2">
								<!--{lang k=TOTAL_PESOS_MEX}-->: <!--{$ticket->total_pesos_string}-->
								</td>
							
						</table></td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;">
						
						<!--{if $displayEditor}-->
						<input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" name="cmdAceptar" value="1" />
						<!--{/if}-->
						
						<!--{if $displayPreviw}-->
						<input type="image" src="<!--{ipath name="bt-editar.gif" owner="1" lang="1"}-->" name="btnEditar" value="1" onclick="document.getElementById('etapaProceso_dmmx').value=0;document.frm_dmmx.action='<!--{$URLRetEditor}-->';document.frm_dmmx.submit();" />
						<input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" name="btnPagar" value="1" onclick="document.frm_dmmx.submit();" />
						<!--{/if}-->
						
						</td>
                    </tr>
                </table>
            </form>
			<!--{/if}-->
			
			<!--{if $displayProcess}-->
			<script type="text/javascript">
				setTimeout('document.frm_dmmx.submit();',1000);
			</script>
			<!--{/if}-->
			
			<!--{if ($displayResultadoExito)}-->
				<!--{lang k=DINERO_MAIL_MX_EXITO}-->
			<!--{/if}-->
			
			<!--{if ($displayResultadoFracaso)}-->
				<!--{lang k=DINERO_MAIL_MX_FRACASO}-->
			<!--{/if}-->
			
		</td></tr>	
        
	
	<!--{elseif $pm_dinero_mail_br}-->
		<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : <!--{if (!$ticket->ticketid)}--><!--{lang k=DINERO_MAIL_BR_CUSTOM_PAY}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;<!--{lang k=DINERO_MAIL_BR_DENOM}--></font>
        </td></tr>
 		<tr><td style="padding-top: 20px;">
		
		<!--{if ($displayEditor)}--><!--{lang k=DINERO_MAIL_BR_TIP0}--><!--{/if}-->
		<!--{if ($displayPreviw)}--><!--{lang k=DINERO_MAIL_BR_TIP1}--><!--{/if}-->
		<!--{if ($displayProcess)}--><!--{lang k=DINERO_MAIL_BR_TIP2}--><!--{/if}-->
		
		</td></tr>
		<tr><td align="center" style="padding-top: 20px;">
 
		   <!--{if ($displayEditor || $displayPreviw || $displayProcess)}-->
		   <form id="frm_dmmx" name="frm_dmmx" action="<!--{$ticket->url_action}-->" method="POST" style="margin: 0px;" target="_top">
				
				<input type="hidden" name="NombreItem" value="<!--{$ticket->NombreItem}-->" />
				<input type="hidden" name="TipoMoneda" value="<!--{$ticket->TipoMoneda}-->" />
				<input type="hidden" name="E_Comercio" value="<!--{$ticket->E_Comercio}-->" />
				<input type="hidden" name="NroItem" value="<!--{$ticket->NroItem}-->" />
				<input type="hidden" name="DireccionExito" value="<!--{$ticket->DireccionExito}-->" />
				<input type="hidden" name="DireccionFracaso" value="<!--{$ticket->DireccionFracaso}-->" />
				<input type="hidden" name="DireccionEnvio" value="0"> 
				<input type="hidden" name="Mensaje" value="0" />
				<input type="hidden" name="process_dmmx" value="1" />
				<input type="hidden" name="usr_nombre" value="<!--{$ticket->usr_nombre}-->">
				<input type="hidden" name="usr_apellido" value="<!--{$ticket->usr_apellido}-->">
				<input type="hidden" name="usr_tel_numero" value="<!--{$ticket->usr_tel_numero}-->">
				<input type="hidden" name="usr_email" value="<!--{$ticket->usr_email}-->">
				<input type='hidden' name='MediosPago' value='18,7'>
                
				<input type="hidden" id="etapaProceso_dmmx" name="etapaProceso_dmmx" value="<!--{$etapaProceso_dmmx}-->">
				
				
				<!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                
				<table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=IMPORT_TO_PAY}--></td>
                        <td><table>
                        	<tr>
				                <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->moneda}--></td>
				                <td style="padding: 5px; padding-left: 3px;">
						
								<!--{if $displayEditor}-->
								<input type="text" name="PrecioItem_Dolares" value="<!--{$ticket->total}-->" />
								<!--{/if}-->
						
								<!--{if $displayPreviw || $displayProcess}-->
								<!--{$ticket->total}-->
								<input type="hidden" name="PrecioItem" value="<!--{$ticket->total_reales}-->" />
								<input type="hidden" name="PrecioItem_Dolares" value="<!--{$ticket->total}-->" />
								<!--{/if}-->
								</td>
							</tr>
							<tr>
								<td style="padding: 5px; padding-left: 3px;" colspan="2">
								<!--{lang k=TOTAL_REALES}-->: <!--{$ticket->total_reales_string}-->
								</td>
							
						</table></td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;">
						
						<!--{if $displayEditor}-->
						<input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" name="cmdAceptar" value="1" />
						<!--{/if}-->
						
						<!--{if $displayPreviw}-->
						<input type="image" src="<!--{ipath name="bt-editar.gif" owner="1" lang="1"}-->" name="btnEditar" value="1" onclick="document.getElementById('etapaProceso_dmmx').value=0;document.frm_dmmx.action='<!--{$URLRetEditor}-->';document.frm_dmmx.submit();" />
						<input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" name="btnPagar" value="1" onclick="document.frm_dmmx.submit();" />
						<!--{/if}-->
						
						</td>
                    </tr>
                </table>
            </form>
			<!--{/if}-->
			
			<!--{if $displayProcess}-->
			<script type="text/javascript">
				setTimeout('document.frm_dmmx.submit();',1000);
			</script>
			<!--{/if}-->
			
			<!--{if ($displayResultadoExito)}-->
				<!--{lang k=DINERO_MAIL_BR_EXITO}-->
			<!--{/if}-->
			
			<!--{if ($displayResultadoFracaso)}-->
				<!--{lang k=DINERO_MAIL_BR_FRACASO}-->
			<!--{/if}-->
			
		</td></tr>	
		
		
		
    <!--{elseif $pm_dinero_mail}-->
        <!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Dinero Mail</font>
            </td></tr>
        <!--{/if}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr><td align="center">
                    <table border="0" cellspacing="0" cellpadding="1" width="600" style="border: 1px solid #7F7F7F;">
                        <tr><td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr><td style="height: 22px;" class="scr_resalt" align="center"><!--{lang k=CUPON_DINERO_MAIL}--></td></tr>
                                <tr><td style="padding: 10px; padding-bottom: 0px;"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr><td colspan="4"><img src="<!--{ipath name="clogo.gif" owner="1" lang="1"}-->" /></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px; " align="left"><!--{lang k=CLIENT}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->client}--></td>
									<!--{if $ticket->ticketid != ""}-->
									<td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="left"><!--{lang k=TICKET_N}-->:</td>
									<td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->ticketid}--></td>
									<!--{else}-->
									<td colspan="2">&nbsp;</td>
									<!--{/if}-->
									</tr>
                                    <tr><td colspan="4" style="padding-top: 10px;"><hr style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="left"><!--{lang k=TOTAL_TO_PAY}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->total_simbol}-->&nbsp;<!--{$ticket->total_string}--></td><td colspan="2">&nbsp;</td></tr>
									 <tr><td colspan="4" style="padding-top: 10px;"><hr width="100%" style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                   
                                </table></td></tr>
                                <tr><td style="padding: 10px;"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr><td style="padding-bottom: 10px;" class="ticket_row_title"><!--{lang k=PAY_IN_BANKS}--></td></tr>
                                    <tr><td><b>1.</b>&nbsp;<!--{lang k=PRINT_THIS}--></td></tr>
                                    <tr><td><b>2.</b>&nbsp;<!--{lang k=PRESENT_THIS}--></td></tr>
                                    <tr><td style="padding-top: 10px; padding-bottom: 10px;"><hr style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                    <tr><td style="padding-top: 5px;"><b><!--{lang k=BANAMEX}--></b>: <!--{lang k=ACCOUNT_N}--> <!--{$ticket->banamex_account}--> / <!--{lang k=REFERENCE}-->: <!--{$ticket->banamex_ref}--></td></tr>
                                    <tr><td style="padding-top: 10px; padding-bottom: 10px;"><hr style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                    <tr><td><!--{capture assign="myacl"}--><!--{lang k=DINERO_MAIL_ACLARATION}--><!--{/capture}--><!--{$myacl|replace:"%currency%":$ticket->original_currency}--></td></tr>
                                </table></td></tr>
                            </table>
                        </td></tr>
                    </table>
                </td></tr>
                <!--{if !$print}-->
                    <tr><td align="center" style="padding-top: 10px;">
                        <form action="ticket.ca" method="GET" style="margin: 0px;" target="_blank" onsubmit="if ( _is_email) this.target='_top';">
                            <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                            <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                                <tr valign="middle">
                                    <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;"><!--{lang k=TOTAL_TO_PAY}-->:</td>
                                    <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->dollar_simbol}--></td>
                                    <td style="padding: 5px; padding-left: 3px;"><input type="text" name="import" value="<!--{$ticket->total_dollars}-->" /></td>
                                    <td style="padding: 5px; border-left: 1px solid #7F7F7F;"><input type="image" src="<!--{ipath name="bt-imprimir.gif" owner="1" lang="1"}-->" name="print" value="1" />&nbsp;<input type="image" src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" name="email" value="1" onclick="_is_email = true;" /></td>
                                </tr>
                            </table>
                        </form>
                    </td></tr>
                <!--{/if}-->
            </table>
     

      <!--{elseif $pm_pagos_online}-->
        <!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pagos Online</font>
            </td></tr>
        <!--{/if}-->
		<!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr><td align="center">
                    <table border="0" cellspacing="0" cellpadding="1" width="600" style="border: 1px solid #7F7F7F;">
                        <tr><td>
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr><td style="height: 22px;" class="scr_resalt" align="center"><!--{lang k=CUPON_PAGOS_ONLINE}--></td></tr>
                                <tr><td style="padding: 10px; padding-bottom: 0px;"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <tr><td colspan="4"><img src="<!--{ipath name="clogo.gif" owner="1" lang="1"}-->" /></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px; " align="left"><!--{lang k=CLIENT}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->client}--></td>
									<!--{if $ticket->ticketid != ""}-->
									<td class="ticket_row_title" style="padding-top: 10px; padding-left: 10px;" align="left"><!--{lang k=TICKET_N}-->:</td>
									<td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->ticketid}--></td>
									<!--{else}-->
									<td colspan="2">&nbsp;</td>
									<!--{/if}-->
									</tr>
                                    <tr><td colspan="4" style="padding-top: 10px;"><hr style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                    <tr><td class="ticket_row_title" style="padding-top: 10px;" align="left"><!--{lang k=TOTAL_TO_PAY}-->:</td><td style="padding-top: 10px; padding-left: 10px;"><!--{$ticket->total_simbol}-->&nbsp;<!--{$ticket->total_string}--></td><td colspan="2">&nbsp;</td></tr>
									 <tr><td colspan="4" style="padding-top: 10px;"><hr width="100%" style="border: 0px; border-top: 1px solid black; margin: 0px; padding: 0px;"></td></tr>
                                   
                                </table></td></tr>
                                <tr><td style="padding: 10px;"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                   
                                    <tr><td><!--{capture assign="myacl"}--><!--{lang k=PAGOS_ONLINE_ACLARATION}--><!--{/capture}--><!--{$myacl|replace:"%currency%":$ticket->original_currency}--></td></tr>
                                </table></td></tr>
                            </table>
                        </td></tr>
                    </table>
                </td></tr>
                <!--{if !$print}-->
                    <tr><td align="center" style="padding-top: 10px;">
                        <form name="frm_POL" id="frm_POL" action="<!--{$pm_pagos_online_frmAction}-->" method="post" style="margin: 0px;">
                        
            
			<!-- BOTON DE PAGO -->
                        
                            <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                            <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                                <tr valign="middle">
                                    <td class="scr_resalt" style="padding: 5px;border-right: 1px solid #7F7F7F;"><!--{lang k=TOTAL_TO_PAY}-->:</td>
                                    <td style="padding: 5px; padding-right: 0px;"><!--{$ticket->dollar_simbol}--></td>
                                    
									
									<!--{if $pm_pagos_online_modo}-->
									
									<td style="padding: 5px; padding-left: 3px;"><input type="text" name="valor" value="<!--{$ticket->valor_venta}-->" /></td>
                                    <td style="padding: 5px; border-left: 1px solid #7F7F7F;">&nbsp;
									<!--btn: aceptar-->
									<input id="datCompl" name="datCompl" type="hidden" value="1" />
									<input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->" name="cmdAceptar" value="1" onclick="document.frm_POL.submit();" />
									
									<!--{else}-->
									
									<!-- datos requeridos por pagos online -->

									<input name="usuarioId" type="hidden" value="<!--{$ticket->id_usuario}-->">
									<input name="refVenta" type="hidden" value="<!--{$ticket->id_venta}-->">
									<input name="descripcion" type="hidden" value="<!--{$ticket->descripcion_venta}-->">
									
									<input name="iva" type="hidden" value="<!--{$ticket->valor_iva}-->">
									<input name="baseDevolucionIva" type="hidden" value="<!--{$ticket->valor_base_dev}-->">

									<!-- VARIABLES OPCIONALES SUGERIDAS -->
									<input name="emailComprador" type="hidden" value="<!--{$ticket->email_comprador}-->">
									<input name="firma" type="hidden" value="<!--{$ticket->firma_codificada}-->">
									<!--
						            <input name="firmaOriginal" type="hidden" value="<!--{$ticket->firma}-->">
						        	-->
						            
									<!-- VARIABLES OPCIONALES -->
									<input name="moneda" type="hidden" value="<!--{$ticket->moneda}-->">
									<input name="url_respuesta" type="hidden" value="<!--{$ticket->url_respuesta}-->" size="40">
									<input name="url_confirmacion" type="hidden" value="<!--{$ticket->url_confirmacion}-->" size="40">
									<input name="lng" type="hidden" value="<!--{$ticket->lenguaje}-->">
									<input name="extra1" type="hidden" value="<!--{$ticket->extra1}-->">
									<input name="extra2" type="hidden" value="<!--{$ticket->extra2}-->">
									<input name="plantilla" type="hidden" value="<!--{$ticket->plantilla}-->" />
									<input name="prueba" type="hidden" value="<!--{$ticket->prueba}-->" />  
									<input name="valor" type="hidden" value="<!--{$ticket->valor_venta}-->" />
									<td style="padding: 5px; padding-left: 3px;"><!--{$ticket->valor_venta}--></td>
                                    <td style="padding: 5px; border-left: 1px solid #7F7F7F;">&nbsp;
									<!--btn: editar monto / pagar-->
									<input type="image" src="<!--{ipath name="bt-editar.gif" owner="1" lang="1"}-->" name="btnEditar" value="1" onclick="document.frm_POL.action='<!--{$pm_pagos_online_frmAction2}-->';document.frm_POL.submit();" />
									<input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" name="btnPagar" value="1" onclick="document.frm_POL.submit();" />
									
									<!--{/if}-->
									
									</td>
                                </tr>
                            </table>
                        </form>
                    </td></tr>
                <!--{/if}-->
            </table>
			
			
			
			
			
			
			
			
			
		
			
			
			
			
			
			
			
	<!--{elseif $pm_pagos_online_respuesta}-->
		<!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pagos Online</font>
            </td></tr>
        <!--{/if}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td>
			
			<center><!--{lang k=PAGOS_ONLINE_ESPERA_RESPUESTA}--></center>
			
			</td></tr>
			</table>
		</td></tr>

	<!--{elseif $pm_pagos_online_respuesta_exito}-->
		<!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pagos Online</font>
            </td></tr>
        <!--{/if}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td>
			<center><!--{lang k=PAGOS_ONLINE_RESPUESTA_EXITO}--></center>
			</td></tr>
			</table>
		</td></tr>
		
	<!--{elseif $pm_pagos_online_respuesta_error}-->
		<!--{if !$print}-->
		    <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pagos Online</font>
            </td></tr>
        <!--{/if}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td>
			<center><!--{lang k=PAGOS_ONLINE_RESPUESTA_ERROR}--></center>
			</td></tr>
			</table>
		</td></tr>
		
			
    <!--{elseif $pay}-->
		<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
        </font>
        </td></tr>
        <tr><td style="padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr><td class="acttitle"><!--{lang k=CHOOSE_PAYMENT}-->:</td></tr>
                <tr><td>
                    <table border="0" cellspacing="0" cellpadding="0" width="100%"><tr>
                    	<td style="text-align:center">
                        <!--{foreach name="payment_gateways" from=$payment_gateways key=key item="pg"}-->
                            <!--{strip}-->
                                
                                    <!--{if $pg.href || $pg.implemented}--><a <!--{if $pg.href}-->target="_blank" <!--{/if}-->href="<!--{if $pg.implemented}-->ticket.ca?ticketid=<!--{$ticket->ticketid}-->&pay=1&pm=<!--{$pg.id}--><!--{else}--><!--{$pg.href}--><!--{/if}-->"><!--{/if}-->
                                       <img style="padding: 0 15px" src="<!--{ipath name=$pg.img}-->" border="0" />
                                    <!--{if $pg.href || $pg.implemented}--><!--{/if}-->
                                
                            <!--{/strip}-->
                        <!--{/foreach}-->
                        </td>
                    </tr></table>
                </tr></td>
            </table>
        </tr>
    <!--{else}-->
        <!--{if !$print}-->
            <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
        	</font>
            </td></tr>
            <tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=SELECT_BY_MONTH}--></td></tr>
            <!--{if $ticket_months}-->
                <tr><td style="padding: 5px;" class="scr_resalt">
                    <form name="months" action="ticket.ca" method="GET" style="margin: 0px;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td align="left"><!--{lang k=SELECT_THE_MONTH}--></td>
                                <td align="right">
                                    <select name="month">
                                        <!--{foreach name=ticket_months from=$ticket_months key=key item=ticket_month}-->
                                            <option value="<!--{$key}-->"<!--{if $key == $ticket_sel_month}--> selected="selected"<!--{/if}-->><!--{$ticket_month}-->
                                        <!--{/foreach}-->
                                    </select>
									
									<select name="year">
									 <!--{foreach name=ticket_years from=$ticket_years key=key item=year}-->
										<option value="<!--{$year}-->" <!--{if $year == $ticket_sel_year}--> selected="selected"<!--{/if}-->><!--{$year}-->
									<!--{/foreach}-->
									</select>
                                </td>
                                <td align="right" width="66" style="padding-left: 5px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->"></td>
                            </tr>
                        </table>
                    </form>
                </td></tr>
                <!--{/if}-->
        <!--{/if}-->
		<!--{if $noticket }-->
		<tr><td style="padding-top: 35px; text-align:center"><!--{lang k=MSG_THERE_IS_NOT_INVOICES}--></td></tr>
		<!--{else}-->
        <!--{include file="email.tpl" email_ptop="20"}-->
        <tr><td style="padding-top: 35px; padding-right: 10px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="265"><img src="<!--{ipath name="clogo.gif" owner="1" lang="1"}-->" width="265" height="68" /></td>   
                    <!--{capture assign="imgname"}--><!--{if $ticket->factura_tipo == "FA"}-->A<!--{elseif $ticket->factura_tipo == "FB"}-->B<!--{elseif $ticket->factura_tipo == "FE"}-->E<!--{/if}-->.gif<!--{/capture}-->
                    <td style="padding-left: 10px;"></td>
                    <td align="right">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr><td style="padding-right: 30px;" class="ticket_row_title" align="right"><!--{lang k=TICKET_N}--></td><td align="right"><b><!--{$ticket->factura_nro}--></b></td></tr>
                            <tr><td style="padding-right: 30px; padding-top: 5px;" class="ticket_row_title" align="right"><!--{lang k=DATE}--></td><td align="right"><!--{$ticket->date}--></td></tr>
                            <tr><td style="padding-right: 30px; padding-top: 5px;" class="ticket_row_title" align="right"><!--{lang k=EXPIRE_DATE}--></td><td align="right"><!--{$ticket->date_expire}--></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td></tr>
        <tr><td style="padding-right: 10px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr valign="top">
                    <td class="ticket_owner_info" width="275">
			
		    	<!--{foreach name=info_contact from=$info_contact key=key item=line}-->
                        		<!--{$line}--><br />
                    		<!--{/foreach}--></td>
			
				
                    
		    <td class="ticket_owner_info" style="padding-left: 10px;">&nbsp;
		    	
							
		    </td>
                    <td align="right" style="padding-top: 15px;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr><td align="right"></td></tr>
                            <tr><td align="right" style="padding-top: 10px;"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td></tr>
        <tr><td style="padding-top: 40px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr valign="top">
                    <td><b><!--{lang k=TITULAR}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->titular}--></td>
                    <td style="padding-left: 10px;"><b><!--{lang k=CUIT}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->cuit}--></td>
                </tr>
                <tr style="height: 10px;"><td colspan="4">&nbsp;</td></tr>
                <tr valign="top">
                    <td><b><!--{lang k=ADDRESS}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->address}--><br /><!--{$ticket->city}--><br /><!--{$ticket->state}--></td>
                    <td style="padding-left: 10px;"><b><!--{lang k=PAY_COND}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->condpago}--></td>
                </tr>
                <tr style="height: 10px;"><td colspan="4">&nbsp;</td></tr>
                <tr valign="top">
                    <td><b><!--{lang k=CLIENT_CODE}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->userid}--></td>
                    <td style="padding-left: 10px;"><b><!--{lang k=IVA_COND}--></b></td>
                    <td style="padding-left: 10px;"><!--{$ticket->condiva}--></td>
                </tr>
            </table>
        </td></tr>
        <tr><td style="padding-top: 30px;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                    <tr style="height: 20px;">
                        <td class="ticket_detail_header" style="padding-left: 5px;"><!--{lang k=DESCRIPTION}--></td>
                        <td class="ticket_detail_header"><!--{lang k=UNITS}--></td>
                        <td class="ticket_detail_header" align="right" style="padding-right: 5px;"><!--{lang k=PRICE}--></td>
                    </tr>
                </thead>
                <tbody>
                    <!--{foreach name=comsumo_list from=$ticket->comsumo_list key=key item=consumo_item}-->
                        <tr style="height: 20px;">
                            <td class="ticket_detail_body" style="padding-left: 5px;"><!--{if $consumo_item->isdetailed}--><a href="ticket_item.ca?ticketid=<!--{$ticket->ticketid}-->&itemid=<!--{$consumo_item->itemid}-->"><!--{/if}--><!--{$consumo_item->description}--><!--{if $consumo_item->isdetailed}--></a><!--{/if}-->
                            <td class="ticket_detail_body"><!--{$consumo_item->units}--></td>
                            <td class="ticket_detail_body" align="right" style="padding-right: 5px;"><!--{$consumo_item->importe}--></td>
                        </tr>
                    <!--{foreachelse}-->
                        <tr><td colspan="3" class="ticket_detail_body" style="padding-left: 5px; padding-right: 5px;"><!--{lang k=NO_TICKET_DETAILS}--></td></tr>
                    <!--{/foreach}-->
                        <tr><td colspan="3" style="padding-top: 20px; padding-left: 5px; padding-right: 5px; padding-bottom: 5px;" class="ticket_detail_body">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <!--{if $show_iva_details && $owner != 'hola'}-->
                                    <tr style="height: 20px;">
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">Neto 21%</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">Neto 27%</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">IVA 21%</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">IVA 27%</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">IVA 21% NI</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="center">IVA 27% NI</td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;" align="right"><!--{lang k=SUBTOTAL}--></td>
                                    </tr>
                                    <tr style="height: 20px;">
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->neto21}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->neto27}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->iva21}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->iva27}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->iva21ni}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black;" align="right"><!--{$ticket->iva27ni}--></td>
                                        <td style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;" align="right"><!--{$ticket->subtotal}--></td>
                                    </tr>
                                <!--{/if}-->
                                    <tr style="height: 20px;">
                                        <td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-left: 5px;" colspan="5"><!--{$ticket->total_string}--></td>
                                        <td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-right: 5px;" align="right"><b><!--{lang k=TOTAL}-->:</b></td>
                                        <td style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; padding-right: 5px;" align="right"><b><!--{$ticket->total}--></b></td>
                                    </tr>
                            </table>
                        </td></tr>
                
            </table>
        </td></tr>
        <tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
        <!--{if !$print}-->
            <tr><td style="padding-top: 10px;">
                <!--{include file="buttons.tpl" button_print="1" button_pay="1" button_email="1"}-->
            </td></tr>
        <!--{/if}-->
    <!--{/if}-->
<!--{/if}-->
</table>

