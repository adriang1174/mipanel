<?

    class csv
    {
        var $convert_html_to_txt;
        var $charset;
        
        var $_buffer;
        var $_separator;
        var $_rowempty;

        function csv( $separator = null)
        {
            if ( $separator === null || strlen( $separator) <= 0)
                $separator = ",";
            $this->_separator = $separator;
            $this->_buffer = "";
            $this->_rowempty = true;
            $this->convert_html_to_txt = false;
            $this->charset = "ISO-8859-1";
        }
        
        function _escape( $haystack)
        {
            $haystack = str_replace( "\\", "\\\\", $haystack);
            $haystack = str_replace( $this->_separator, "\\" . $this->_separator, $haystack);
            return $haystack;
        }
        
        function RowInit( )
        {
            if ( strlen( $this->_buffer) > 0)
                $this->_buffer .= "\n";
            $this->_rowempty = true;
        }

        function ColWrite( $haystack)
        {
            if ( $this->_rowempty)
                $this->_rowempty = false;
            else
                $this->_buffer .= $this->_separator;

            $this->_buffer .= '"' . $this->_escape( $this->convert_html_to_txt ? html_entity_decode( $haystack, ENT_NOQUOTES, $this->charset) : $haystack) . '"';
        }

        function PrintToScreen( )
        {
            echo $this->_buffer;
        }

        function WriteToFile( $filename)
        {
            $fd = fopen( $filename, "w");
            if ( !$fd)
                return false;

            $bytes = fwrite( $fd, $this->_buffer);

            fflush( $fd);
            fclose( $fd);

            if ( $bytes != strlen( $this->_buffer))
                return false;

            return true;
        }

        function GetBuffer( )
        {
            return $this->_buffer;
        }
    }

?>
