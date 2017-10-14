<!--{strip}-->
	<div style="width: 640px">
    <!--{assign var="allflags" value="print,printall,exportcsv,email,eaddr,email_done,email_failed,pay,fP,next"}-->
	<!--{if "print"|allowed == "1"}-->
		<a href="<!--{currenturi flag="print" clean=$allflags}-->" target="_blank"><img src="<!--{ipath name="bt-imprimir.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
	<!--{/if}-->
	<!--{*  // COMENTADO POR PEDIDO DE ROXANA EL 29/6/12
	<!--{if "printall"|allowed == "1"}-->
		<a href="<!--{currenturi flag="printall" clean=$allflags}-->" target="_blank"><img src="<!--{ipath name="bt-imptodo.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
	<!--{/if}-->
	<!--{if "exportcsv"|allowed == "1"}-->
		<a href="<!--{currenturi flag="exportcsv" clean=$allflags}-->"><img src="<!--{ipath name="bt-exportar.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
	<!--{/if}-->
	*}-->
	
	<!--{if "email"|allowed == "1"}-->
		<a href="<!--{currenturi flag="email" clean=$allflags}-->"><img src="<!--{ipath name="bt-enviarpormail.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
	<!--{/if}-->
	

	<!--{if "pay"|allowed == "1"}-->
		<a href="<!--{currenturi flag="pay" clean=$allflags}-->"><img src="<!--{ipath name="bt-pagar.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
		<!--{*
		<!--{if $owner == 'red' || $owner == 'telephone2'}-->
		<a href="<!--{currenturi uri="ticket.ca" flag="ticketid="|cat:$ticket->ticketid|cat:"&amp;pm=pago_facil&amp;pay" clean="lastticket"}-->"><img src="<!--{ipath name="bt-obtenercomprobante.gif" owner="1" lang="1"}-->" border="0" /></a>&nbsp;&nbsp;&nbsp;
		<!--{/if}-->
		*}-->
	<!--{/if}-->

	</div>
<!--{/strip}-->
