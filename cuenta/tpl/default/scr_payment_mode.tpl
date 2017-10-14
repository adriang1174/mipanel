<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td><font class="scr_header"><!--{$strPath}--></font></td></tr>
        <tr>
        	<td style="padding-top: 15px;"><div style=" width:100%;">
            	
               
               
               <!--{if $owner == 'telephone2' || $owner == 'holared' || $owner == 't2' || $owner == 'red'}-->
        	<div style=" width:100%;">
            	<div style=" width:100%; height:auto; float:left; margin-bottom:20px; font-size:13px !important; font-weight:bold; color:#FF9933 !important; text-transform:uppercase;">
            	<!--{lang k=CHOOSE_PAYMENT}-->:
                </div>
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="debito_bancario.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                    <p><span style="color:#FF9933">D&eacute;bito bancario:</span><br /><strong>Adhiera al d&eacute;bito directo bancario</strong> con su cuenta corriente o caja de ahorro. Puede hacerlo desde <strong>Servicios > Modificar Datos > Datos > Cambio de Medio de Pago</strong>.</p>
                </div>
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="tarjeta_de_credito.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                    <p><span style="color:#FF9933">Tarjeta de cr&eacute;dito:</span><br /><strong>D&eacute;bito autom&aacute;tico:</strong> Adhiera al d&eacute;bito autom&aacute;tico con su tarjeta de cr&eacute;dito <strong>American Express, Visa o MasterCard</strong>. Puede hacerlo desde <strong>Servicios > Modificar Datos > Datos > Cambio de Medio de Pago</strong>.<br /><strong>Pago por &uacute;nica vez:</strong> Abone con su tarjeta de cr&eacute;dito <strong>American Express, Visa o MasterCard</strong> accediendo desde <a href="ticket.ca?ticketid=<!--{$ticketid}-->&pay=1&pm=pago_online">aqu&iacute;</a>.</p>
                </div>
                                
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="pago_electronico.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:20px;"/>
                    <p><span style="color:#FF9933">Pago electr&oacute;nico:</span><br /><strong>Cajero autom&aacute;tico:</strong> Abone a trav&eacute;s de los cajeros autom&aacute;ticos de las redes <strong>Banelco</strong> de todo el pa&iacute;s, con la clave de pago electr&oacute;nico que figura en su factura.<br /><strong>Internet:</strong> Puede abonar su factura haciendo clic aqu&iacute; <a href="http://www.pagomiscuentas.com" target="_blank">Pago Mis Cuentas</a>.</p>
                    
                    
                </div>
                <div style=" width:600px; height:auto; float:left; margin-left:74px;">
                	<img src="<!--{ipath name="efectivo_cheque.jpg" owner="0" lang="0"}-->" style=" float:left; margin-right:20px; margin-bottom:40px;"/>
                    <p><span style="color:#FF9933">Efectivo o cheque:</span><br /><strong>Banco Galicia:</strong> Puede abonar en efectivo o con cheque. Debe mencionar que el dep&oacute;sito es para Cobranza Integrada de <strong>Alternativa</strong>. El n&uacute;mero de referencia es igual a su c&oacute;digo de cliente. No es necesario presentar su factura.<br /><strong>Pago F&aacute;cil:</strong> Puede abonar en efectivo o con cheque. Debe presentar el cup&oacute;n de pago impreso en su factura, o llevar el cup&oacute;n con el importe deseado que haya impreso desde <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->&pay=1&pm=pago_facil">aqu&iacute;</a>.<br /><strong>RapiPago:</strong> Puede abonar en efectivo. Debe presentar el cup&oacute;n de pago impreso en su factura, o llevar el cup&oacute;n con el importe deseado que haya impreso desde <a href="ticket.ca?ticketid=<!--{$ticket->ticketid}-->&pay=1&pm=pago_facil">aqu&iacute;</a>.
</p>
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
               
               
               
               
        	</div>
        </td>
    </tr>
</table>
