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
                                    <!--{if $owner == 'telephone2' || $owner == 'holared' || $owner == 't2' || $owner == 'red'}-->
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
                                    <td style="padding: 5px; border-left: 1px solid #7F7F7F;">
                                    <!--{if $owner_id != 7}-->

                                    <input type="image" src="<!--{ipath name="bt-imprimir.gif" owner="1" lang="1"}-->" name="print" value="1" />&nbsp;<!--{else}-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--{/if}--><input type="image" src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" name="email" value="1" onclick="_is_email = true;" /></td>

                                </tr>
                            </table>
                        </form>
                    </td></tr>
                <!--{/if}-->
            </table>
        </td></tr>
       <!--{elseif $pm_pago_online}-->
       	<!--{if $redirect_sub1}-->
       	<form action="<!--{$psp_FrontPSP_URL}-->" method="POST" id="frm_psp">
		<input type="hidden" name="psp_MerchantId" value="<!--{$psp_MerchantId}-->" />
		<input type="hidden" name="psp_TransactionId" value="<!--{$psp_TransactionId}-->" />
		<input type="hidden" name="psp_MerchTxRef" value="<!--{$psp_MerchTxRef}-->" />
		<input type="hidden" name="psp_Session3p" value="<!--{$psp_Session3p}-->" />

		</form>
       	<p>Por favor, aguarde. Esta transacci&oacute;n puede demorar unos minutos.</p>
		<div style="text-align:center">
			<img src="img/loading-ajax.gif" alt="loading" width="43" height="11" />
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#frm_psp').submit();
			});
		</script>
		<!--{elseif $smarty.get.r == 1}-->
			<!--{if $resultado_sub1_ok}-->
				<p>La operacion ha finalizado con exito.</p>
			<!--{/if}-->
			<!--{ if $resultado_sub1_ko}-->
				<p>Atencion, ocurri&oacute; un error. Codigo de error: <!--{$codigo_error_sub1}--></p>
			<!--{/if}-->
		
       	<!--{else}-->
		<tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--> : 
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
            &gt;Pago por &uacute;nica vez con Tarjeta de Cr&eacute;dito</font>
        </td></tr>
        <tr><td style="padding-top: 20px;">Indique el importe a abonar, y una vez que haga clic en Pagar, la p&aacute;gina lo llevar&aacute; directamente a un sitio seguro para que pueda realizar la operaci&oacute;n.</td></tr>
        <tr><td align="center" style="padding-top: 20px;">
            <form action="ticket.ca" method="POST" style="margin: 0px;" target="_top" onsubmit="return checkFrm();">

                <!--{currenthidden clean="print,printall,exportcsv,eaddr,email_failed,email_done,pay"}-->
                <table border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #7F7F7F;">
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;">Importe a pagar:</td>
                        <td style="padding: 5px; padding-right: 0px;"><!--{$theticket->total_simbol}--></td>
                        <td style="padding: 5px; padding-left: 3px;"><input type="text" class="required" name="import" id="import" value="<!--{$theticket->total_amount}-->" /></td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;">&nbsp;</td>
                        
                    </tr>
                    <tr valign="middle">
                        <td class="scr_resalt" style="padding: 5px; border-right: 1px solid #7F7F7F;">Selecciona la tarjeta:</td>
                        <td style="padding: 5px; padding-right: 0px;">&nbsp;</td>
                        <td style="padding: 5px; padding-left: 3px;">
                        <select id="select_tarjeta" name="select_tarjeta" class="required">
		        		<option value="">-- seleccionar tarjeta --</option>
		        		<!--{* <option value="14">Visa</option> *}-->
		        		<option value="5">MasterCard</option>
		        		<option value="1">American Express</option>
		        		
		        	</select>
                        </td>
                        <td style="padding: 5px; border-left: 1px solid #7F7F7F;"><input type="image" src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" /></td>
                        
                    </tr>
                </table>
                
            </form>
            <script type="text/javascript">
            function checkFrm(){
            	if( document.getElementById('select_tarjeta').value == "" || document.getElementById('import').value == "" ){
            		alert("Debe seleccionar un importe y el tipo de tarjeta de credito que desea usar");
            		return false;
            	}else{
            		return true;
            	}
            }
            </script>
        </td></tr>
        <tr><td style="padding-top: 20px;">Recuerde que puede adherirse al D&eacute;bito Autom&aacute;tico de Tarjeta de Cr&eacute;dito y obtener muchos beneficios y descuentos especial. Cualquier consulta env&iacute;e un mail a <a href="mailto:asistencia@alternativa.com.ar">asistencia@alternativa.com.ar</a></td></tr>
		
<!--{/if}-->
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
        	<!--{if $owner == 'telephone2' || $owner == 'holared' || $owner == 't2' || $owner == 'red'}-->
        	<div style=" width:100%;">
            	<div style=" width:100%; height:auto; float:left; margin-bottom:20px; font-size:13px !important; font-weight:bold; color:#FF9933 !important; text-transform:uppercase;">
            	<!--{lang k=CHOOSE_PAYMENT}-->:
                </div>
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="debito_bancario.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                    <p><span style="color:#FF9933; font-weight: bold;">Por D&eacute;bito Autom&aacute;tico:</span><br />
                    <ul style="list-style-type:disc">
                    <li><strong>CBU</strong> de Cuenta Corriente o Caja de Ahorro.</li>
                    <li><strong>Tarjeta de Cr&eacute;dito:</strong> Visa, Amex o Mastercard.</li>
                    </ul>
                    <strong>Puede hacerlo desde Ver/Modificar Datos - Datos de Facturaci&oacute;n - Cambio de Medio de Pago</strong>.
                    </p>
                </div>
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                        <img src="<!--{ipath name="telefono" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                	<p><span style="color:#FF9933; font-weight: bold;">Por Tel&eacute;fono:</span><br />
                	<ul>
                    		<li><strong>Rapipago:</strong> con Tarjetas de cr&eacute;dito <strong>Visa, Amex o Mastercard</strong> llamando al 0810-345-7274.</li>
                	</ul>
			</p>
		</div> 
                                
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="internet.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                    <p><span style="color:#FF9933; font-weight: bold;">Por Internet:</span><br />
                     <ul style="list-style-type:disc">
                    <li><strong>Pagomiscuentas:</strong> con el c&oacute;digo de pago electr&oacute;nico que figura en su factura.</li>
                    <li><strong><a href="http://www.visa.com.ar" target="_blank">www.visa.com.ar</a>:</strong> Desde la secci&oacute;n Pagos rubro Telefon&iacute;a.</li>
					</ul>
					</p>
                </div>
                
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="galicia.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:40px;"/>
                    <p><span style="color:#FF9933; font-weight: bold;">Si tiene su Factura o Cup&oacute;n de Pago:</span><br />
                    <ul style="list-style-type:disc">
                    <li><strong>Banco Galicia:</strong> Efectivo o Cheque.</li>
                    <li><strong>Pago F&aacute;cil:</strong> Efectivo o Cheque. Si necesita imprimir su cup&oacute;n de pago puede hacerlo desde <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->&pay=1&pm=pago_facil">aqu&iacute;</a>.</li>                    
                    <li><strong>Rapipago:</strong> Efectivo o Cheque.</li>                    
					</ul>
                    </p><br />
                    <p><span style="color:#FF9933; font-weight: bold;">Si No tiene su Factura o Cup&oacute;n de Pago:</span><br />
                    <ul style="list-style-type:disc">
                    <li><strong>Rapipago:</strong> Efectivo o Cheque.</li>                    
                    <li><strong>Banco Galicia:</strong> Efectivo o Cheque.</li>
					</ul>
                    </p>

</p>
                </div>
		<div style=" width:600px; height:auto; float:left; margin-left:74px;">
			Cualquier consulta env&iacute;e un mail a 
			<a href="mailto:asistencia@alternativa.com.ar"><font color="#ffa500">asistencia@alternativa.com.ar</font></a>
		</div>
        	</div>
            <!--{else}-->
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
                </tr>

                </td>
            </table>
            
            <!--{/if}-->
            
            <!--{if $owner == 'telephone2'}-->
            <div id="ahorre" style="position:relative; float:left"><span>Ahorre tiempo, es muy f&aacute;cil.<br /> Abone ahora mismo con tarjeta de cr&eacute;dito, llamando al <strong>0810-345-7274</strong></span></div>
            <!--{/if}-->
            </td>
        </tr>
    <!--{else}-->
        <!--{if !$print}-->
            <tr style="height: 25px;"><td class="scr_header">
            <font class="scr_header"><!--{$strPath}--> : <!--{if !$ticket->ticketid}--><!--{lang k=PAGO_CUSTOMIZADO}--> <!--{/if}-->
            <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->"><!--{$ticket->ticketid}--></a>
        	</font>
            </td></tr>
            <!--{if $ticket_months}-->
                <tr><td style="padding: 5px; padding-top:15px; padding-bottom:15px;" class="scr_resalt3">
                    <form name="months" action="ticket.ca" method="GET" style="margin: 0px;">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td align="left"><!--{lang k=SELECT_BY_MONTH}--></td>
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
       
        <!--{*
        <!--{include file="email.tpl" email_ptop="20"}-->
        *}-->
        
        
        
        <!--{if $email_pdf}-->
        <tr><td>&nbsp;</td></tr>
       <tr><td style="border: 1px solid #7F7F7F;">
                        <form style="margin: 0px;" method="post" action="">
                             
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="height: 27px;">
                                <tbody><tr valign="middle">
                                    <td class="scr_resalt" style="padding-left: 10px; border-right: 1px solid #7F7F7F; "><!--{lang k=EMAIL_ADDRESS}-->:</td>
                                    <td style="padding-left: 10px; border-right: 1px solid #7F7F7F;"><input type="text" size="40" value="<!--{$eaddr}-->" name="eaddr"></td>
                                    <td style="padding-left: 10px;"><input type="image" src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" />&nbsp;<a href="<!--{currenturi clean="email_pdf"}-->"><img src="<!--{ipath name="bt-cancelar.gif" owner="1" lang="1"}-->" border="0" /></a></td>
                                </tr>
                            </tbody></table>
                        </form>
                    </td></tr>

	<!--{/if}-->
        
        
        
        
        <tr><td style="padding-top: 27px;" class="marco-top">
            <table border="0" cellspacing="0" cellpadding="0" width="680px" style="margin-left:24px;">
                <tr valign="top">
                    <td style="padding-left: 7px; width:401px;"><img src="<!--{ipath name="flecha-factura.jpg" owner="2" lang="0"}-->" style="margin-right:9px;"/><span style="color:#f69929; font-size:11px;"><b><!--{lang k=DATE_EMI}-->: </b></span><!--{$ticket->date}--></td>
                    
                    
                    <td style="padding-left: 10px; width:279px;"><img src="<!--{ipath name="flecha-factura.jpg" owner="2" lang="0"}-->" style="margin-right:9px;"/><span style="color:#f69929; font-size:11px;"><b><!--{lang k=EXPIRE_DATE_VEN}-->: </b></span><!--{$ticket->date_expire}--></td>
                </tr>
                <tr style="height: 20px;"><td colspan="4">&nbsp;</td></tr>
                <tr valign="top">
                    <td style="padding-left: 7px; width:401px;"><img src="<!--{ipath name="flecha-factura.jpg" owner="2" lang="0"}-->" style="margin-right:9px;"/><span style="color:#f69929; font-size:11px;"><b><!--{lang k=COMPROBANTE_N}-->: </b></span><!--{$ticket->factura_nro}--></td>
                    <td style="padding-left: 10px; width:279px;"><img src="<!--{ipath name="flecha-factura.jpg" owner="2" lang="0"}-->" style="margin-right:9px;"/><span style="color:#f69929; font-size:11px;"><b><!--{lang k=IMPORTE}-->: </b></span><!--{$ticket->total}--> Impuestos inclu&iacute;dos.</td>
                </tr>
            </table>
        </td></tr>
        <tr><td style="padding-top: 20px;" class="marco-middle">
            <table border="0" cellspacing="0" cellpadding="0" width="696px" style="margin-left:26px;">
                <thead>
                    <tr>
                        <td class="ticket_detail_header" style="padding-left: 5px;"><img src="<!--{ipath name="flecha-down-factura.jpg" owner="2" lang="0"}-->" style="margin-right:9px;"/><!--{lang k=DESCRIPTION}--></td>
                    </tr>
                </thead>
                
                <tbody>
                	<tr class="detalles_top"><td></td><td></td></tr>
                    <!--{foreach name=comsumo_list from=$ticket->comsumo_list key=key item=consumo_item}-->
                        <tr style="height: 14px;">
                            <td class="ticket_detail_body" style="padding-left: 22px;"><!--{if $consumo_item->isdetailed}--><a href="ticket_item.ca?ticketid=<!--{$ticket->ticketid}-->&itemid=<!--{$consumo_item->itemid}-->"><!--{/if}--><!--{$consumo_item->description}--><!--{if $consumo_item->isdetailed}--></a><!--{/if}-->
                            <td class="ticket_detail_body" align="right" style="padding-right: 22px;"><!--{$consumo_item->importe}--></td>
                        </tr>
                    <!--{foreachelse}-->
                        <tr><td colspan="3" class="ticket_detail_body" style="padding-left: 7px; padding-right: 7px;"><!--{lang k=NO_TICKET_DETAILS}--></td></tr>
                    <!--{/foreach}-->
                        <tr class="detalles_bottom"><td></td><td></td></tr>
            	</tbody>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" width="696px" style="margin-left:26px;">
                <tr align="right">
                    <td style="padding: 7px; width:496px;" class="scr_resalt"></td>
                    <td style="padding: 7px; width:200px;" class="scr_resalt"><span style="color:#f69929; font-size:11px; margin-right:10px;"><b>Total: </b></span><!--{$ticket->total}--></td>
                </tr>
            </table>
        </td></tr>
        <tr><td style="padding-top: 15px;" class="marco-bottom"><div class="cont_disclamer"><!--{lang k=TICKET_DISCLAIMER}--></div></td></tr>
        <!--{if !$print}-->
        <tr><td style="padding-top: 15px;" class="marco-pdf">
        	<a href="<!--{currenturi flag="pdf"}-->"><img src="<!--{ipath name="pdf-icon.jpg" owner="2" lang="0"}-->" style=" position:relative; top:10px; left:16px;"/></a>
            <div class="cont_pdf"><!--{lang k=TEXTO_FACTURA_DIGITAL}--><!--{if $factura_dorso}--><br /><br />Si desea ver el dorso y las condiciones generales del servicio haga <a href="<!--{currenturi flag="pdf_dorso"}-->" style="color:#f69929;">clic aqu&iacute;.</a><!--{/if}-->
</div>
        </td></tr>
            <tr><td style="padding-top: 10px;">
                <!--{*
                <!--{include file="buttons.tpl" button_print="1" button_pay="1" button_email="1"}-->
                *}-->
                
                
                
                	<div style="width: 640px">
					
						<a href="<!--{currenturi flag="pdf"}-->" ><img src="<!--{ipath name="bt-imprimir.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;
					
					
					
						<a href="<!--{currenturi flag="email_pdf"}-->"><img src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;
					
						<a href="<!--{currenturi flag="pay"}-->"><img src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;
						<!--{*  // COMENTADO POR PEDIDO DE ROXANA EL 29/6/12
						<!--{if $owner == 'red' || $owner == 'telephone2'}-->
						<a href="<!--{currenturi uri="ticket.ca" flag="ticketid="|cat:$ticket->ticketid|cat:"&amp;pm=pago_facil&amp;pay" clean="lastticket"}-->"><img src="<!--{ipath name="bt-obtenercomprobante.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;
						<!--{/if}-->
						*}-->

					</div>
                
                
                
                
            </td></tr>
        <!--{/if}-->
    <!--{/if}-->
<!--{/if}-->
</table>



<!--{if $envio_mail_ok}-->
<script type="text/javascript">
window.onload = function(){
	alert("La factura fue enviada por mail a la direccion <!--{$smarty.post.eaddr}-->");
}	

</script>
<!--{/if}-->

<!--{if $smarty.session.ownerId == 1 ||  $smarty.session.ownerId == 7}-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2669879-18']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--{/if}-->

<!--{if $smarty.session.ownerId == 4 ||  $smarty.session.ownerId == 5}-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2669879-20']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--{/if}-->
