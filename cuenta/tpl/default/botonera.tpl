<!--{assign var="enfoque_id" value="0"}--><!--{assign var="enfoque_subId" value="0"}--><!--{assign var="id_titulo_anterior" value="0"}--><!--{foreach item=section from=$botonera name=titulos}--><!--{ if ($section.titulo_principal == "")}--><!--{ if ($section.id_titulo_principal != $id_titulo_anterior)}--><!--{assign var="id_titulo_anterior" value=$section.id_titulo_principal}--><!--{/if}--><!--{if $section.titulo == "NOTITLE"}--><!--{foreach name=mitems item=link from=$section.items}--><!--{if $link.id == $scr}--><!--{assign var="enfoque_id" value=$section.id_titulo_principal}--><!--{/if}--><!--{/foreach}--><!--{else}--><!--{foreach name=mitems item=link from=$section.items}--><!--{if $link.id == $scr}--><!--{assign var="enfoque_id" value=$section.id_titulo_principal}--><!--{assign var="enfoque_subId" value=$section.id_sub}--><!--{/if}--><!--{/foreach}--><!--{/if}--><!--{if $smarty.foreach.titulos.last}--><!--{/if}--><!--{/if}--><!--{/foreach}-->
<div id="menu" >
<div id="nivel-1" class="right">

<ul class="first">
    <!--{foreach from=$botonera item=b}-->
	<li>
    	<a href="#" onclick="return false;" style="width:111px;"><!--{$b.titulo}--></a>
        <ul class="submenu">
            <!--{foreach from=$b.items item=sub}-->
			<li><a href="<!--{$sub.script}-->"><!--{$sub.name}--></a></li>
			<!--{/foreach}-->
		</ul>
    </li>
    <!--{/foreach}-->
    

<!--{*
<!--{assign var="id_titulo_anterior" value="0"}-->
<!--{foreach item=section from=$botonera name=titulos}-->
	<!--{ if ($section.titulo_principal != "")}-->
		<!--{if !$smarty.foreach.titulos.first}-->
			</ul>
			</div>	
		</li>
		<!--{/if}-->
		<li>
        <a href="#" onclick="return false;" onmouseover="do_menu('principal_<!--{$section.id_titulo_principal}-->', 'block')" style="width:111px;"<!--{if ($enfoque_id == $section.id_titulo_principal)}--> class="enfoqueMenuSeccionActual_main"<!--{/if}-->><!--{$section.titulo_principal}--></a>
	<!--{else}-->
	<!--{ if ($section.id_titulo_principal != $id_titulo_anterior)}-->
		<div id="principal_<!--{$section.id_titulo_principal}-->" style="display:none;">
		<ul>
		<!--{assign var="id_titulo_anterior" value=$section.id_titulo_principal}-->
	<!--{/if}-->
		
		<!--{if $section.titulo == "NOTITLE"}-->
			<!--{foreach name=mitems item=link from=$section.items}-->	
				<li>
				<a href="<!--{$link.uri}-->"<!--{if $link.onclick}--> onclick="<!--{$link.onclick}-->"<!--{/if}--><!--{if $link.id == $scr}--> class="enfoqueMenuSeccionActual_submenu"<!--{/if}-->><!--{if $link.id == $scr}--><!--marca de seleccion como un *--><!--{/if}--><!--{$link.name}--></a>
				</li>
			<!--{/foreach}-->
		<!--{else}-->
			<li onmouseover="do_submenu('item_<!--{$section.id_titulo_principal}--><!--{$section.id_sub}-->')" onmouseout="do_submenu('item_<!--{$section.id_titulo_principal}--><!--{$section.id_sub}-->')">
			<a href="#" onclick="return false;"<!--{if ($enfoque_id == $section.id_titulo_principal)}--><!--{if ($enfoque_subId == $section.id_sub)}--> class="enfoqueMenuSeccionActual_submenu"<!--{/if}--><!--{/if}-->><!--{$section.titulo}--> &gt;</a>
				<ul id="item_<!--{$section.id_titulo_principal}--><!--{$section.id_sub}-->">
				<!--{foreach name=mitems item=link from=$section.items}-->	
                    <li><a href="<!--{$link.uri}-->"<!--{if $link.onclick}--> onclick="<!--{$link.onclick}-->"<!--{/if}--><!--{if $link.id == $scr}--> class="enfoqueMenuSeccionActual_submenu"<!--{/if}-->><!--{if $link.id == $scr}--><!--marca de seleccion como un *--><!--{/if}--><!--{$link.name}--></a></li>
				<!--{/foreach}-->	                        
				</ul>    
			</li>
		<!--{/if}-->
		<!--{if $smarty.foreach.titulos.last}-->
			
			</ul>
			</div>
		<!--{/if}-->
	<!--{/if}-->
<!--{/foreach}-->
*}-->

</ul>            
</div>
</div>

<script type="text/javascript">
	$(function () {
		// Menu
		$('.first li:has(ul.submenu)').hover( 
			function(){$(this).find('ul:hidden').show(); $(this).find('a:first').addClass('current');},
			function(){$(this).find('ul:visible').hide(); $(this).find('a:first').removeClass('current')}	  
		);
	});
</script>
