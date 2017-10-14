<!--{if !$printall}-->
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr class="scr_resalt" valign="middle" style="height: 30px;">
            <td align="right" style="padding-right: 15px;"><!--{lang k=$paginate_element}-->&nbsp;<b><!--{$paginate.first}--></b><!--{lang k=PAGINATE_SEPARATOR}--><b><!--{$paginate.last}--></b><!--{lang k=PAGINATE_OF}--><b><!--{$paginate.total}--></b>.<!--{if !$print}-->&nbsp;<!--{lang k=$paginate_element}-->&nbsp;<!--{lang k=PAGINATE_BY_PAGE}--><!--{/if}--></td>
            <!--{if !$print}-->
                <td align="right" width="10" style="paading-left: 5px; padding-right: 5px;">
                    <form style="margin: 0px;">
                        <select name="limit" onchange="location.href = '<!--{$pagination_limit_uri|replace:"\\":"%5C"|replace:"'":"%27"|replace:"\"":"%22"}-->' + this.options[ this.selectedIndex].value;">
                            <!--{foreach name=pagination_limits from=$pagination_limits key=key item=limit}-->
                                <option value="<!--{$limit.limit}-->"<!--{if $limit.limit == $pagination_limit}--> selected<!--{/if}-->><!--{$limit.limit}--></option>
                            <!--{/foreach}-->
                        </select>
                    </form>
                </td>
            <!--{/if}-->
        </tr>
        <!--{if !$print}-->
            <tr valign="middle" style="height: 30px;"><td colspan="2" align="center" style="border: 1px solid #eee;"><!--{paginate_prev class="paginate"}--> <!--{paginate_middle class="paginate" format="page" link_suffix=" "}--> <!--{paginate_next class="paginate"}--></td></tr>
        <!--{/if}-->
    </table>
<!--{/if}-->
