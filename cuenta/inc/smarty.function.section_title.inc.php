<?

function smarty_function_section_title( $params, &$smarty)
{
	$classes = array( "scr_header");

	// Title.
	if ( !isset( $params[ 'title']))
	{
		$smarty->trigger_error( "section_title: missing 'title' parameter");
		return;
	}
	$title = lang( $params[ 'title']);

	// Truncate.
	$truncate = false;
	if ( isset( $params[ 'truncate']) && $params[ 'truncate'] == "1")
	{
		$truncate = true;
	}

	// Replacement.	
	if ( isset( $params[ 'replacement']))
	{
		$title = str_replace( "[REPLACEMENT]", $params[ 'replacement'], $title);
	}

    // Second level.
    $second = null;
    if ( isset( $params[ '2nd_txt']) && isset( $params[ '2nd_href']))
    {
        $second = array( );
        $second[ "text"] = $params[ '2nd_txt'];
        $second[ "href"] = $params[ '2nd_href'];
    }
    
	// Href.
	$href = null;
	$current_scr = $smarty->get_template_vars( "full_scr");
	if ( $current_scr && array_key_exists( "title_href", $current_scr) && $current_scr[ "title_href"] && strlen( $current_scr[ "title_href"]) > 0)
	{
		$href = $current_scr[ "title_href"];
	}

    // Exploding the title.	
	$buffer = "";
	$parts = explode( ',,', $title);

	if ( $truncate && count( $parts) >= 1)
	{
		return $parts[ 0];
	}
	
	if ( count( $parts) == 1)
	{
		$buffer .= $parts[ 0];
	}
	else if ( count( $parts) > 1)
	{
		$n = 0;
		foreach( $parts as $key => $part)
		{
			if ( $n == 0 && $href)
				$buffer .= '<a href="' . $href . '" class="' . ( $inverse ? $classes[ 1] : $classes[ 0]) . '">';
			
				
				
			$buffer .= $part;

			if ( $n == 0 && $href)
				$buffer .= '</a>';
			

            if ( $n == 0 && is_array( $second))
            {
                $buffer .= '&nbsp;&gt;&nbsp;';
                $buffer .= '<a href="' . $second[ "href"] . '" class="' . ( $inverse ? $classes[ 1] : $classes[ 0]) . '">';
                $buffer .= $second[ "text"];
                $buffer .= '</a>';
            }
                
			$inverse = ( $inverse ? false : true);
			$n ++;
		}
	}

	return $buffer;
}

?>
