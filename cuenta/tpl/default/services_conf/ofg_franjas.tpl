<tr style="height: 30px;"><td class="scr_resalt2">
<span style="cursor: pointer;" onclick="show_hide('action<!--{$action[3]}-->'); return false;">&nbsp;&nbsp;&nbsp;<img src="<!--{ipath name="arrow.gif"}-->" border="0">&nbsp;&nbsp;</span><a href="#" class="popup_link" onclick="show_hide('action<!--{$action[3]}-->'); return false;"><!--{$action[0]}--></a></td></tr>
		<tr><td>
		<div id="action<!--{$action[3]}-->" style="display: none;">
		<br />
<script type="text/javascript">
function showFollowme(ani){
	var w = window.screen.width;
	var h = window.screen.height;
	var popW = 900, popH = 550;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('fh_callback.ca?popup=1&followme=1&ani='+ani+'&id_accion=<!--{$action[3]}-->','popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos+',scrollbars=yes,resizable=yes');
}
</script>

	<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="left">
						<!--{lang k=DESCRIPCION_INTERNOS_OFG}--><br /><br />
					</td>
				</tr>

				<tr>	
					<td width="20">&nbsp;</td>
					<td><input type="image" src="<!--{ipath name="bt-ver-conf.gif" lang="1" owner="1"}-->" alt="<!--{lang k=VER_CONF}-->" onclick="showFollowme(<!--{$line}-->); return false;" /></td>
				</tr>
</table>
<br /><br />
					<table cellspacing="2" cellpadding="0" border="0">
						<tr style="height: 20px">
					<td width="20">&nbsp;</td>	
					<td align="center" class="scr_resalt" width="100"><a href="#" class="popup_link" title="<!--{lang k=INTERNO_TITLE}-->"><!--{lang k=INTERNO}--></a></td>
					
					<td align="center" class="scr_resalt" width="160"><a href="#" class="popup_link" title="<!--{lang k=REFERENCIA_TITLE}-->"><!--{lang k=REFERENCIA}--></a></td>
					<td align="center" class="scr_resalt" width="260"></td>
                    <td class="scr_resalt" align="center">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
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
                        <td align="center">Voicemail</td>
                        <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="popup_link">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig|trim}-->"/>
                    </td>
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
                            <td align="center">Fax</td>
                           <td align="left"><a href="#" title="<!--{lang k=MAIL_TITLE}-->" class="popup_link">mail:</a> <input type="text" name="mail_orig" style="width:200px" value="<!--{$email_values.hm_mailorig|trim}-->"/></td>
                            <td align="center"><input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->"/></td>
                        </form>
                    </tr>
				</table>

	</div>
</td></tr>
<tr><td>&nbsp;</td></tr>