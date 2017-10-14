<?

$smarty_function_ca_list_agrupation_depth = 0;


function smarty_function_ca_list_agrupation_init( )
{
	_smarty_function_ca_list_agrupation_depth_reset( );
}

function _smarty_function_ca_list_agrupation_depth_reset( )
{
	global $smarty_function_ca_list_agrupation_depth;
	$smarty_function_ca_list_agrupation_depth = 0;
}

function _smarty_function_ca_list_agrupation_depth_increment( )
{
	global $smarty_function_ca_list_agrupation_depth;
	$smarty_function_ca_list_agrupation_depth ++;
}

function _smarty_function_ca_list_agrupation_depth_decrement( )
{
	global $smarty_function_ca_list_agrupation_depth;
	$smarty_function_ca_list_agrupation_depth --;
}

function _smarty_function_ca_list_agrupation_depth_render( )
{
    global $smarty;
	global $smarty_function_ca_list_agrupation_depth;
	
	$buffer = "";
	for( $n = 0; $n < $smarty_function_ca_list_agrupation_depth; $n ++)
	{
        $buffer .= "<img src=\"" . smarty_function_ipath( array( "name" => "quote.gif", "owner" => "1"), $smarty) . "\" width=\"16\" height=\"23\">";
	}
	return $buffer;
}

function smarty_function_ca_list_agrupation( $params, &$smarty)
{
    global $smarty;
    
	$style = @$params[ 'style'];
	$agrupation = @$params[ 'agrupation'];
	$cols = @$params[ 'cols'];

	if ( !is_object( $agrupation))
	{
		$smarty->trigger_error( "ca_list_agrupation: missing or invalid 'agrupation' parameter'");
		return "";
	}

	$cols = ( int)$cols;
	if ( $cols <= 0)
	{
		$smarty->trigger_error( "ca_list_agrupation: missing or invalid 'cols' parameter'");
		return "";
	}

	$buffer = "";

	// Header.
	if ( $agrupation->segment_header === true)
	{
        $buffer .= '<tr valign="middle" style="height: 23px;"><td colspan="' . $cols . '" style="border-bottom: 1px solid #CCCCCC; background-color: #EEEEEE; padding-left: 5px;"><table border="0" cellspacing="0" cellpadding="0"><tr valign="middle"><td>' . _smarty_function_ca_list_agrupation_depth_render( ) . '<img src="' . smarty_function_ipath( array( "name" => "quote_header.gif", "owner" => "1"), $smarty) . '" width="16" height="23"></td><td>&nbsp;' . $agrupation->name. '</td></tr></table></td></tr>';
	}

	// Incrementing the depth.
	_smarty_function_ca_list_agrupation_depth_increment( );
	
	if ( is_array( $agrupation->agrupation) && count( $agrupation->agrupation) > 0)
	{
		// Showing the deepeer level agrupations.
		foreach( $agrupation->agrupation as $key => $one_agrupation)
		{
			$buffer .= smarty_function_ca_list_agrupation( array( 'style' => $style, 'agrupation' => $one_agrupation, 'cols' => $cols), $smarty);
		}
	}
	else
	{
		// This agrupation does not have any sub-agrupations, showing it's items.
		if ( count( $agrupation->items) > 0)
		{
			$nn = 0;
			foreach( $agrupation->items as $key => $item)
			{
				$buffer .= '<tr valign="middle" style="height: 23px;">';
				$isfirst = true;
				$n = 0;
				foreach( $item as $key => $item_value)
				{
					$padding = "";
					if ( $isfirst)
					{
						$padding = _smarty_function_ca_list_agrupation_depth_render( );
						$isfirst = false;
					}
				
					$align = "left";
					$right_padding = "";
					if ( count( $item) == $n +1)
					{
						$align = "right";
						$right_padding = " padding-right: 5px;";
					}
					
					if ( $padding)
					{
						$buffer .= ( '<td style="border-bottom: 1px solid #CCCCCC; padding-left: 5px;"><table border="0" cellspacing="0" cellpadding="0"><tr valign="middle"><td>' . $padding . '</td><td align="' . $align . '" style="'. $right_padding . '">&nbsp;' . $item_value[ "value"] . '</td></tr></table></td>');
					}
					else
					{
						$buffer .= ( '<td style="border-bottom: 1px solid #CCCCCC;' . $right_padding . '" align="' . $align . '">' . $item_value[ "value"] . '</td>');
					}

					$n ++;
				}
				$buffer .= '</tr>';
				$nn ++;
			}
		}
	}

	// Decrementing the depth.
	_smarty_function_ca_list_agrupation_depth_decrement( );
	
	// Footer.
	if ( $agrupation->segment_footer === true)
	{
        $buffer .= '<tr valign="middle" style="height: 24px;"><td colspan="' . ( $cols - count( $agrupation->footer_items)) . '" style="border-bottom: 1px solid #CCCCCC; background-color: #EEEEEE; padding-left: 5px;"><table border="0" cellspacing="0" cellpadding="0"><tr valign="middle"><td>' . _smarty_function_ca_list_agrupation_depth_render( ) . '<img src="' . smarty_function_ipath( array( "name" => "quote_footer.gif", "owner" => "1"), $smarty) . '" width="16" height="23"></td><td>&nbsp;' . $agrupation->footer_prefix . ' ' . $agrupation->name . '</td></tr></table></td>';

		$n = 0;
		foreach( $agrupation->footer_items as $key => $value)
		{
			$align = "left";
			if ( count( $agrupation->footer_items) == $n +1)
			{
				$align = "right";
				$right_padding = " padding-right: 5px;";
			}
			$buffer .= '<td style="border-bottom: 1px solid #CCCCCC; background-color: #EEEEEE;' . $right_padding . '" align="' . $align . '">' . $value . '</td>';
			$n ++;
		}
		$buffer .= '</tr>';
	}

	return $buffer;
}

?>
