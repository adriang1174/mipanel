<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;">
        <td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td>
    </tr>
	
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td style="padding-top: 10px;">
			
				<!--{lang k=CONDICION_PAGO_ACTUAL}--> <b><!--{$nombre_forma_pago}--></b>
				<br /><br />
				<!--{if $muestra_detalles}-->
				<b><!--{lang k=NUMERO}-->:</b> **** **** **** <!--{$datos.nro_tc}--><br />
				<b><!--{lang k=VENCIMIENTO}-->:</b> <!--{$datos.vto_tc}--><br /><br />
				<!--{/if}-->
			
    		</td>
    	</tr>
    </table>
</table>

<div style="text-align: center; padding-top: 15px;">
<a href="home.ca">
<img src="<!--{ipath name="Volver.jpg" owner="1" lang="1"}-->"/>
</a>
</div>

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
