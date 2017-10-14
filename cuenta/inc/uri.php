<?

class uri
{
	var $uri;
    var $excluded;
    var $flags;
    
	function uri( $uri = false)
	{
		if ( $uri)
			$this->uri = $uri;
		else
			$this->uri = $_SERVER[ "REQUEST_URI"];

        $this->flags = array( );
	}
	
	function exclude_params( $exclude_params = false)
	{
		if ( !$this->uri)
			return false;
        
		if ( !$exclude_params || !is_array( $exclude_params) || count( $exclude_params) <= 0)
			return true;

        // Setting the object excluded params.
        if ( !$this->excluded || !is_array( $this->excluded) || count( $this->excluded) <= 0)
            $this->excluded = $exclude_params;
        else
            $this->excluded = array_merge( $this->excluded, $exclude_params);
        $this->excluded = array_unique( $this->excluded);

        // Start parsing.
		$euri = explode( '?', $this->uri);
		$this->uri = $euri[ 0];
			
		$usequestion = true;
		foreach( $_GET as $key => $value)
		{
            if ( !in_array( $key, $this->excluded))
			{
				if ( $usequestion)
					$this->uri .= "?";
				else
					$this->uri .= "&";
				
				$this->uri .= urlencode( $key) . "=" . urlencode( $value);
				$usequestion = false;
			}
		}

		return true;
	}

	function concat( $name, $value)
	{
		if ( !$this->uri || strlen( $name) <= 0)
			return false;

		$usequestion = true;
		if ( strchr( $this->uri, '?'))
			$usequestion = false;

		if ( $usequestion)
			$this->uri .= "?";
		else
			$this->uri .= "&";

		$this->uri .= $name;
		$this->uri .= '=';
		$this->uri .= urlencode( $value);

		return true;
	}
	
	function set_flags( $flags)
	{
		if ( !$this->uri)
			return false;
		
		if ( !is_array( $flags))
			$flags = array( $flags);

		if ( !$this->exclude_params( $flags))
			return false;

		foreach( $flags as $key => $flag)
		{
            $this->flags[ $flag] = "1";
			if ( !$this->concat( ( string)$flag, "1"))
				return false;
		}

        $this->flags = array_unique( $this->flags);
		return true;
	}

    function _export_one_hidden( $key, $value)
    {
        return ( '<input type="hidden" name="' . htmlspecialchars( $key, ENT_QUOTES, DEF_CHARSET) . '" value="' . htmlspecialchars( $value, ENT_QUOTES, DEF_CHARSET) . '" />');
    }
    
    function export_hidden( )
    {
        $buffer = "";

		foreach( $_GET as $key => $value)
		{
            if ( !in_array( $key, $this->excluded))
			{
                $buffer .= $this->_export_one_hidden( $key, $value);
   			}
		}

        foreach( $this->flags as $key => $value)
        {
            $buffer .= $this->_export_one_hidden( $key, $value);
        }

        return $buffer;
    }
}

?>
