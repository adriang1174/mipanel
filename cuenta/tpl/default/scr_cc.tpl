<script language="javascript">
	function verifyFromDate(obj,limit)
	{
		return true;
		
		var vDate=new Date();
		var alimit= new Array();
		alimit=limit.split('/');
		vDate.setFullYear(alimit[2],alimit[0]-1,alimit[1]);
		var oDate=new Date();
		var adate= new Array();
		adate=obj.value.split('/');
		oDate.setFullYear(adate[2],adate[0]-1,adate[1]);
		
		if(oDate<vDate)
		{
			obj.value=limit;
		}
		return true;
	}
</script>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <!--{if !$print}-->
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
        <tr><td style="padding-top: 10px; padding-bottom: 10px;"><!--{lang k=CHECKING_ACCOUNT_DESC}--></td></tr>
        <!--{include file="email.tpl" email_pbottom="25"}-->
        <tr><td style="padding: 5px;" class="scr_resalt">
            <form name="date" action="cc.ca" method="GET" style="margin: 0px;" onSubmit="verifyFromDate(document.date.datefrom,'<!--{if $owner!='hola'}--><!--{$cc_list->start_date}--><!--{else}-->07/31/2006<!--{/if}-->')">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td align="left"><!--{lang k=DATE_FROM}--></td>
                        <td align="left"><script type="text/javascript">DateInput( 'datefrom', true, 'MM/DD/YYYY', '<!--{if $owner!='hola'}--><!--{$cc_list->start_date}--><!--{else}-->07/31/2006<!--{/if}-->');</script></td>
                        <td align="left"><!--{lang k=DATE_TO}--></td>
                        <td align="left"><script type="text/javascript">DateInput( 'dateto', true, 'MM/DD/YYYY', '<!--{$cc_list->end_date}-->');</script></td>
                        <td align="right" width="66" style="padding-left: 5px;"><input type="image" src="<!--{ipath name="bt-aceptar.gif" owner="1" lang="1"}-->"></td>
                    </tr>
                </table>
            </form>
        </td></tr>
    <!--{/if}-->
	<tr><td style="padding-top: 35px;">
		<!--{include file=ca_list.tpl}-->
	</td></tr>
	<tr><td style="padding-top: 15px;"><!--{lang k=TICKET_DISCLAIMER}--></td></tr>
	<!--{if !$print}-->
        <tr><td style="padding-top: 10px;">
            <!--{include file="buttons.tpl" button_print="1" button_exportcsv="1" button_email="1"}-->
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
