
<script type="text/javascript">
function show_hide(theDiv){
	if(!document.getElementById(theDiv)){
		return;
	}
	mostrar = false;
	if(document.getElementById(theDiv).style.display == 'none'){
		mostrar = true;
	}

	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++){
		if(divs[i].id.substring(0, 6) == "action"){
		   document.getElementById(divs[i].id).style.display = 'none';
		 }
	}
	if(mostrar){
		document.getElementById(theDiv).style.display = 'block';
	}
}

</script>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr style="height: 25px;"><td class="scr_header"><font class="scr_header"><!--{$strPath}--></font></td></tr>
<!--{if $email_not_verif}-->
</table><br />
            <table border="0" cellspacing="0" cellpadding="0" class="info_table">
                <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{lang k=ERR_EMAIL_NOT_VERIFIED}--></b></td></tr>
                <tr><td align="center" style="padding: 5px;"><a href="email.ca" target="_self"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" border="0" /></a>&nbsp;<a href="index.ca" target="_self"><img src="<!--{ipath name="bt-cancelar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=CANCEL}-->" border="0" /></a></td></tr>
            </table>
<!--{else}-->
    <tr><td style="padding-top: 10px;">

   <!--{if $show == "select"}-->

<!-- ################################################################################# -->
   <!--{lang k=MSG_EDIT_SERVICE}--><br /><br />
<!-- ################################################################################# -->

   <form name="frmLine" id="frmLine" method="post" action="">
   <table>
   <tr>
	<!--{if $lines|@count > 0}-->
   <td>
	<!--{lang k=MSG_SELECT_LINE}-->&nbsp; 
	</td>
	<td>
		<select name="line">
			<!--{foreach name="lines" from=$lines item="line"}-->
			<option value="<!--{$line[2]}-->"><!--{$line[2]}--> - <!--{$line[1]}--></option>
			<!--{/foreach}-->
		</select>
		</td>
		<td>
	<input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" />
	</td>
	<!--{else}-->
	<td><b><!--{lang k=NO_CONF_LINES}--></b>
    </td>
	<!--{/if}-->
	</tr></table>
	</form>
	<!--{else}-->
	<b><!--{lang k=LINE}-->:</b>&nbsp; <!--{$line}-->
	<br />
	<b><!--{lang k=SERVICE}-->:</b>&nbsp; <!--{$service}-->
	<br /><br />
	<table width="100%">
	<!--{foreach name="actions" from=$actions item="action"}-->

		<!--{include file="$action[2]"}-->
	<!--{/foreach}-->		
	</table>	
	<!--{/if}-->
    </td></tr>
</table>
 <!--{if $show_id}-->
<script type="text/javascript">
	show_hide('action<!--{$show_id}-->');
</script>
 <!--{/if}-->
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
