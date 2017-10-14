<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
        <!--{capture assign="titrep"}--><!--{$nombre_servicio}--> (<!--{$rate_number}-->)<!--{/capture}-->
        <tr style="height: 25px;"><td class="scr_header"><!--{section_title title=TITLE_RATE replacement=$titrep}--></td></tr>
    <!--{/if}-->
    <!--{include file="email.tpl" email_pbottom="10" email_ptop="20"}-->
    <!--{if !$print || ( $print && ( $target || $prefix))}-->
        <tr><td style="padding: 5px; padding-top: 20px;">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <form action="rate.ca" method="GET" style="margin: 0px;">
                            <input type="hidden" name="t" value="<!--{$rate_type}-->" />
                            <input type="hidden" name="n" value="<!--{$rate_number}-->" />
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><!--{lang k=TARGET_NUMBER}-->:</td>
                                    <td style="padding-left: 5px;"><input type="text" name="target" value="<!--{$target}-->" /></td>
                                    <td align="right" width="66" style="padding-left: 5px;"><!--{if !$print}--><input type="image" src="<!--{ipath name="bt-buscar.gif" owner="1" lang="1"}-->" /><!--{/if}--></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                    <td style="padding-left: 20px;">
                        <form action="rate.ca" method="GET" style="margin: 0px;">
                            <input type="hidden" name="t" value="<!--{$rate_type}-->" />
                            <input type="hidden" name="n" value="<!--{$rate_number}-->" />
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><!--{lang k=TARGET_PREFIX}-->:</td>
                                    <td style="padding-left: 5px;"><input type="text" name="prefix" value="<!--{$prefix}-->" /></td>
                                    <td align="right" width="66" style="padding-left: 5px;"><!--{if !$print}--><input type="image" src="<!--{ipath name="bt-buscar.gif" owner="1" lang="1"}-->" /><!--{/if}--></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </td></tr>
    <!--{/if}-->
	<tr><td style="padding-top: 10px;">
		<!--{include file=ca_list.tpl}-->
		<br /><!--{lang k="TARIFAS_VIGENTES"}-->
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<tr><td style="padding-top: 10px;"><!--{lang k=RATE_ACLARATION}--></td></tr>
	<tr><td style="padding-top: 10px;"><!--{lang k=RATE_ACLARATION2}--></td></tr>
    <!--{capture assign="comment"}--><!--{lang k=RATE_MAINTENANCE}--><!--{/capture}-->
    <!--{if $comment}-->
        <tr><td style="padding-top: 10px;"><!--{$comment}--></td></tr>
    <!--{/if}-->
	<tr><td style="padding-top: 10px;"><!--{lang k=RATE_NO_IVA}--></td></tr>
	<!--{if !$print}-->
		<tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl" button_print="1" button_printall="1" button_exportcsv="1" button_email="1"}-->
        </td></tr>
	<!--{/if}-->
</table>
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
