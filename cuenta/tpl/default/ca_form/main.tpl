<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td style="padding-top: 20px;">
	<form action="<!--{phpself}-->?post=1" method="POST" style="margin: 0px;">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<!--{if $ca_form_error}-->
				<tr>
					<td colspan="2" style="padding: 20px;" align="center">
						<table border="0" cellspacing="0" cellpadding="0" class="info_table">
							<tr><td style="padding: 10px;" class="error"><b><!--{$ca_form_error}--></b></td></tr>
						</table>
					</td>
				</tr>
            <!--{elseif $ca_form_info}-->
				<tr>
					<td colspan="2" style="padding: 10px;" align="center">
						<table border="0" cellspacing="0" cellpadding="0" class="info_table">
							<tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{$ca_form_info}--></b></td></tr>
						</table>
					</td>
				</tr>
			<!--{/if}-->
			<!--{foreach name=ca_form_fields from=$ca_form_fields key=name item=obj}-->
                <!--{if $obj->htmltype == "hidden"}-->
                    <input type="hidden" name="<!--{$name}-->" value="<!--{$obj->hidden_data}-->" />
                <!--{else}-->
                    <tr valign="top">
                        <!--{if $obj->htmltype == "separator"}-->
                            <td colspan="2" style="padding-top: 30px;"><h2><!--{$obj->title}--></h2></td></tr>
                            <tr><td colspan="2"><hr style="border: 0px; border-top: 1px solid #ff6600;"></td>
                        <!--{elseif $obj->htmltype == "statictext"}-->
                            <td class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->">&nbsp;</td><td style="padding: 5px; border: 1px solid #7F7F7F; border-left: 0px;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->"><!--{$obj->title}--></td></tr>
                        <!--{elseif $obj->htmltype == "checkbox"}-->
                            <td class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->"></td><td style="padding: 5px; border: 1px solid #7F7F7F; border-left: 0px;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->">
                                <input type="checkbox" name="<!--{$name}-->"<!--{if $name|varnotempty}--> checked="checked"<!--{/if}--> />
                                &nbsp;<!--{$obj->title}-->
                                <!--{if $name|cat:"_invalid"|varnotempty}-->&nbsp;<!--{include file="ca_form/wrong.tpl"}--><!--{/if}-->
                                <!--{if $name|cat:"_error"|varnotempty}-->&nbsp;<font class="form_err"><!--{varcontents var=$name|cat:"_error"}--></font><!--{/if}-->
                            </td>
                        <!--{else}-->
                            <td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->"><!--{if $obj->isrequired}--><b><!--{/if}--><!--{$obj->title}--><!--{if $obj->isrequired}--></b><!--{/if}-->:</td>
                            <td style="padding-left: 5px; padding: 5px; border: 1px solid #7F7F7F; border-left: 0px;<!--{if !$smarty.foreach.ca_form_fields.last}--> border-bottom: 0px;<!--{/if}-->">
                                <!--{if $obj->htmltype == "text" || $obj->htmltype == "password"}-->
                                    <!--{if $obj->comments}--><!--{$obj->comments}--><br /><br /><!--{/if}-->
                                    <input type="<!--{$obj->htmltype}-->" name="<!--{$name}-->" value="<!--{varcontents var=$name escape=1}-->" maxlength="128" size="<!--{$obj->size}-->"<!--{if $name|cat:"_invalid"|varnotempty}--> style="background-color: #f6b595;"<!--{/if}--><!--{if $obj->isreadonly}--> disabled="disabled"<!--{/if}--> />
                                <!--{elseif $obj->htmltype == "select"}-->
                                    <select name="<!--{$name}-->" <!--{if $name|cat:"_invalid"|varnotempty}--> style="background-color: #f6b595;"<!--{/if}-->>
                                        <!--{if !$obj->isrequired}-->
                                            <option value=""></option>
                                        <!--{/if}-->
                                        <!--{foreach from=$obj->stock key=key item=ustock}-->
                                            <option value="<!--{$ustock->value|escape:"htmlall"}-->"<!--{if $ustock->value == $name|varnotempty || ( !$name|varnotempty && $ustock->value == $obj->stock_default)}--> selected="selected"<!--{/if}-->><!--{$ustock->display}--></option>
                                        <!--{/foreach}-->
                                    </select>
                                <!--{elseif $obj->htmltype == "radio"}-->
                                    <!--{foreach from=$obj->stock key=key item=ustock}-->
                                        <input type="radio" name="<!--{$name}-->" value="<!--{$ustock->value|escape:"htmlall"}-->" <!--{if $ustock->value == $name|varnotempty || ( !$name|varnotempty && $ustock->value == $obj->stock_default)}--> checked="checked"<!--{/if}--> /><!--{$ustock->display}-->&nbsp;
                                    <!--{/foreach}-->
                                <!--{elseif $obj->htmltype == "date"}-->
                                    <script type="text/javascript">DateInput( '<!--{$name}-->', <!--{if $obj->isrequired}-->true<!--{else}-->false<!--{/if}-->, 'YYYY-MM-DD'<!--{if $name|varnotempty}-->, '<!--{varcontents var=$name}-->'<!--{/if}-->);</script>
                                <!--{elseif $obj->htmltype == "textarea"}-->
                                    <textarea name="<!--{$name}-->" cols="<!--{$obj->size.cols}-->" rows="<!--{$obj->size.rows}-->"><!--{varcontents var=$name escape=textarea}--></textarea>
                                <!--{elseif $obj->htmltype == "file"}-->
                                    <input type="file" name="<!--{$name}-->" value="" />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="<!--{$obj->file_maxsize}-->" />
                                <!--{/if}-->
                                <!--{if $name|cat:"_invalid"|varnotempty}-->&nbsp;<!--{include file="ca_form/wrong.tpl"}--><!--{/if}-->
                                <!--{if $name|cat:"_error"|varnotempty}-->&nbsp;<font class="form_err"><!--{varcontents var=$name|cat:"_error"}--></font><!--{/if}-->
                            </td>
                        <!--{/if}-->
                    </tr>
                <!--{/if}-->
			<!--{/foreach}-->
			<tr>
				<td colspan="2" style="padding-top: 20px;" align="center">
					<!--{foreach name=ca_form_buttons from=$ca_form_buttons key=key item=button}-->
						<!--{if $button->type == "submit"}-->
							&nbsp;<input type="image" name="submit" value="submit" src="<!--{ipath name=$button->image_name owner="1" lang="1"}-->" />
						<!--{elseif $button->type == "redirect"}-->
							&nbsp;<a href="<!--{$button->url}-->"><img src="<!--{ipath name=$button->image_name owner="1" lang="1"}-->" border="0" /></a>
						<!--{/if}-->
					<!--{/foreach}-->
				</td>
			</tr>
		</table>
	</form>
</td></tr></table>
