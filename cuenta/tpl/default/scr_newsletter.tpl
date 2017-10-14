<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
		
		<!--{if $mostrar_msg_error != ""}-->
        <tr><td style="padding-top: 15px;"><!--{$mostrar_msg_error}--></td></tr>
		<!--{/if}-->
		
		<!--{if $mostrar_msg}-->
        <tr><td style="padding-top: 15px;"><!--{lang k=NEWSLETTER_SUBSCRIBE_CONFIRM}--></td></tr>
		<!--{/if}-->
		
		<!--{if $mostrar_form}-->
        <tr><td style="padding-top: 15px;"><!--{lang k=NEWSLETTER_TITLE}--></td></tr>
		<tr><td style="padding-top: 15px;">
			<!--{if $news_red}-->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="140" style="text-align: center"><a href="newsletters/red/201004/index.html" target="_blank"><img src="newsletters/red/201004.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/red/201005/index.html" target="_blank"><img src="newsletters/red/201005.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/red/201006/index.html" target="_blank"><img src="newsletters/red/201006.jpg" border="0"></a></td>
				</tr>
				<tr>				
					<td style="text-align: center">Abril 2010</td>
					<td style="text-align: center">Mayo 2010</td>
					<td style="text-align: center">Junio 2010</td>	
				</tr>
			</table>
			<!--{/if}-->
			<!--{if $news_hola}-->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td width="140" style="text-align: center"><a href="newsletters/hola/201004/index.html" target="_blank"><img src="newsletters/hola/201004.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/hola/201005/index.html" target="_blank"><img src="newsletters/hola/201005.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/hola/201006/index.html" target="_blank"><img src="newsletters/hola/201006.jpg" border="0"></a></td>
				</tr>
				<tr>				
					<td style="text-align: center">Abril 2010</td>
					<td style="text-align: center">Mayo 2010</td>
					<td style="text-align: center">Junio 2010</td>
				</tr>
			</table>
			<!--{/if}-->
			<!--{if $news_viatel}-->
			<table cellpadding="0" cellspacing="0">
				<tr>					
					<td width="140" style="text-align: center"><a href="newsletters/viatel/200911/index.html" target="_blank"><img src="newsletters/viatel/200911.gif" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/viatel/200912/index.html" target="_blank"><img src="newsletters/viatel/200912.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/viatel/201002/index.html" target="_blank"><img src="newsletters/viatel/201002.jpg" border="0"></a></td>
				</tr>
				<tr>				
					<td style="text-align: center">Novembro 2009</td>
					<td style="text-align: center">Dezembro 2009</td>
					<td style="text-align: center">Fevereiro 2010</td>
				</tr>
			</table>
			<!--{/if}-->
			<!--{if $news_t2}-->
			<p><b>Residencial</b></p><br />
			<table cellpadding="0" cellspacing="0">
				<tr>					
					<td width="140" style="text-align: center"><a href="newsletters/t2/residencial/201004/index.html" target="_blank"><img src="newsletters/t2/residencial/201004.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/t2/residencial/201005/index.html" target="_blank"><img src="newsletters/t2/residencial/201005.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/t2/residencial/201006/index.html" target="_blank"><img src="newsletters/t2/residencial/201006.jpg" border="0"></a></td>
				</tr>
				<tr>				
					<td style="text-align: center">Abril 2010</td>	
					<td style="text-align: center">Mayo 2010</td>	
					<td style="text-align: center">Junio 2010</td>			
				</tr>
			</table>
			<br /><br /><br />
			<p><b>Empresas</b></p><br />
			<table cellpadding="0" cellspacing="0">
				<tr>					
					<td width="140" style="text-align: center"><a href="newsletters/t2/corporate/201004/index.html" target="_blank"><img src="newsletters/t2/corporate/201004.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/t2/corporate/201005/index.html" target="_blank"><img src="newsletters/t2/corporate/201005.jpg" border="0"></a></td>
					<td width="140" style="text-align: center"><a href="newsletters/t2/corporate/201006/index.html" target="_blank"><img src="newsletters/t2/corporate/201006.jpg" border="0"></a></td>
				</tr>
				<tr>								
					<td style="text-align: center">Abril 2010</td>	
					<td style="text-align: center">Mayo 2010</td>
					<td style="text-align: center">Junio 2010</td>		
				</tr>
			</table>
			<!--{/if}-->
		</td></tr>
		<tr><td style="padding-top: 25px;"><!--{lang k=NEWSLETTER_SUBSCRIBE}--></td></tr>
		<tr><td style="padding-top: 15px;">
			<form name="frmNewsletter" method="post" action="">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>&nbsp;&nbsp;&nbsp;</td>
					<td valign="middle"><input type="text" name="email_addr" id="email_addr" /></td>
					<td>&nbsp;</td>
					<td valign="middle"><input type="image" src="<!--{ipath name="bt-enviar.gif" owner="1" lang="1"}-->" name="cancel" value="1" /></td>
				</tr>
			</table>
			</form>
		</td></tr>
		
		<!--{/if}-->
</table>
