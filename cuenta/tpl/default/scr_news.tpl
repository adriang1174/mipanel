<table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr style="height: 25px;"><td class="scr_header">
        <font class="scr_header"><!--{$strPath}--></font>
        </td></tr>
		
        
		<!--{foreach from=$novedades item=novedad name=novedades}-->
			<!--{if !$smarty.foreach.novedades.first}-->
				<tr><td style="padding-top: 15px;"><hr></td></tr>
			<!--{/if}-->
			<tr><td style="padding-top: 15px;"><!--{$novedad}--></td></tr>
			
		<!--{/foreach}-->
</table>
