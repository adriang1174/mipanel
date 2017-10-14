<?

define( "CA_LIST_SECTION_SUBHEADER", 0x1);
define( "CA_LIST_SECTION_SUBFOOTER", 0x2);

// Es un objeto generico de agrupacion de listas.
//

class ca_list_agrupation
{
	var $name;
	var $agrupation;
	var $items;
	var $footer_prefix;
	var $footer_items;
	var $segment_header;
	var $segment_footer;

	// set_from_traff_agrupation: Carga la instancia actual del objeto generico "ca_list_agrupation"
    // con la data de un "traff_agrupation".
	
	function set_from_traff_agrupation($ta) {
		
		if ( !$ta || !is_object( $ta))
			return false;

		$this->name = $ta->title;

		if ( is_array( $ta->agrupation) && count( $ta->agrupation) > 0)
		{
			$this->agrupation = array( );
			$n = 0;
			foreach( $ta->agrupation as $key => $ta_agrupation) {
				
				
				//Parche de correc. de idioma para el portugues
				if (ca_session::language_get() == "pt") {
					//define("TRANSLATE_COMUNIC_LARGA_DIST", "Comunicações de Longa Distância Internacional");
					//define("TRANSLATE_COMUNIC_LARGA_DIST_NAC", "Comunicações de Longa Distância Nacional");
					if (defined('TRANSLATE_COMUNIC_LARGA_DIST')) {
						$ta_agrupation->title = 
							str_replace("Comunicaciones de Larga Distancia Internacional hasta el", 
							TRANSLATE_COMUNIC_LARGA_DIST, $ta_agrupation->title);
						$ta_agrupation->title = 
							str_replace("Comunicaciones de Larga Distancia Nacional hasta el", 
							TRANSLATE_COMUNIC_LARGA_DIST_NAC, $ta_agrupation->title);
					}
				}
				
				$this->agrupation[ $n] = new ca_list_agrupation( );
				$this->agrupation[ $n]->set_from_traff_agrupation( $ta_agrupation);
				$n ++;
			}
		}
		else
		{
			$this->agrupation = false;
		}
		
		if ( is_array( $ta->items) && count( $ta->items) > 0)
		{
			$this->items = array( );
			$n = 0;
			foreach( $ta->items as $key => $ta_item)
			{
                if ( !$ta_item->symbol) $ta_item->symbol = "$";
				foreach( $ta_item as $key => $value)
				{
                    if ( $key != "symbol")
                    {
                        if ( $key == "price") $value = ( ( $ta_item->symbol ? ( $ta_item->symbol . " ") : "") . $value);
                        if ( $key == "date")
                        {
                            // Fixeo el date, para que tenga el formato DD/MM/YYYY, (en esta instancia podria llegar a tener YYYY-MM-DD).
                            $matches = array( );
                            if ( preg_match( "/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $value, $matches))
                            {
                                $value = $matches[ 3] . "/" . $matches[ 2] . "/" . $matches[ 1];
                            }
                        }
					    $this->items[ $n][ ] = array( "value" => $value, "href" => false);
                    }
				}
				$n ++;
			}
		}
		else
		{
			$ta->items = false;
		}
		
		$this->footer_prefix = "SUBTOTAL";	// Templatized language-dependent constant.
		$this->footer_items = array( );
		if ( is_array( $ta->count))
		{
			foreach( $ta->count as $key => $i)
			{
				$this->footer_items[ ] = $i;
			}
		}
		else
		{
			$this->footer_items[ ] = $ta->count;
		}
        if ( !$ta->symbol) $ta->symbol = "$";
        $this->footer_items[ ] = ( ( $ta->symbol ? ( $ta->symbol . " ") : "") . $ta->subtotal);

		$this->segment_header = $ta->segment_header;
		$this->segment_footer = $ta->segment_footer;
	}
}

class ca_list
{
	var $header_elements;
	var $body_elements;
	var $body_agrupation;
	var $cols;
	var $subheader;
	var $subfooter;
	var $show_footer;
	var $valid;
	var $paginate;
	var $paginate_element;

	function ca_list( $header_elements = false, $body_elements = false, $body_agrupation = false)
	{
		$this->_init( $header_elements, $body_elements, $body_agrupation);
	}

	function _init( $header_elements, $body_elements, $body_agrupation)
	{
		$this->header_elements = $header_elements;
		$this->body_elements = $body_elements;
		$this->body_agrupation = $body_agrupation;
		$this->show_footer = false;
		$this->subheader = null;
		$this->subfooter = null;
		$this->valid = false;
		$this->paginate = false;
		$this->paginate_element = "";

		/* Checking the validity of the header. */
		if ( !$this->header_elements || !is_array( $this->header_elements) || count( $this->header_elements) <= 1)
		{
			/* Invalid header. */
			$this->valid = false;
			return;
		}

		/* Sanitizing the header array. In this foreach we convert non-strings into strings. */
		foreach( $this->header_elements as $key => $value)
		{
			$this->header_elements[ $key] = ( string)$value;
		}

		/* Checking if the body contains anything. */
		if ( !$this->body_elements || !is_array( $this->body_elements) || count( $this->body_elements) <= 0)
		{
			$this->body_elements = false;
		}
		else
		{
			/* Sanitizing the body array. Into this foreach we avoid all the illegal members and
			 * we convert non-arrays into arrays with the needed keys.
			 */
			$new_body = array( );
			foreach( $this->body_elements as $key => $row)
			{
				foreach( $this->body_elements[ $key] as $key2 => $col)
				{
					if ( is_array( $col))
						$this->body_elements[ $key][ $key2] = array( "value" => ( string)@$col[ "value"], "href" => ( string)@$col[ "href"]);
					else
						$this->body_elements[ $key][ $key2] = array( "value" => ( string)$col, "href" => false);
				}
			}
		}

		/* Checking the agrupation. */
		if ( !is_array( $this->body_agrupation) || count( $this->body_agrupation) <= 0)
		{
			$this->body_agrupation = false;
		}
		else
		{
			// A diferencia de los body_elements, este ya viene como un array de objetos
			// "ca_list_agrupation" bien formados. :)

			// TODO: Algun checkeo de integridad, aunque no es MUY necesario.
		}

		// Setting the arrays to null if they are empty in order to acomplish the foreachelse directive of smarty.
		if ( !$this->header_elements || !is_array( $this->header_elements) || count( $this->header_elements) <= 0)
			$this->header_elements = null;
	
		if ( !$this->body_elements || !is_array( $this->body_elements) || count( $this->body_elements) <= 0)
			$this->body_elements = null;
		
		/* Good list!! */
		$this->cols = count( $this->header_elements);
		$this->valid = true;
	}

	function set_section( $section, $key, $value)
	{
		if ( !$this->valid)
			return false;

		$newsection = array( "key" => $key, "value" => $value);

		switch( $section)
		{
			case CA_LIST_SECTION_SUBHEADER:
				$this->subheader = $newsection;
				break;

			case CA_LIST_SECTION_SUBFOOTER:
				$this->subfooter = $newsection;
				break;

			default:
				return false;
		}

		return true;
	}

	function set_from_traff_detail( $traff_detail) {
		
		//echo "DATA: " . var_export($traff_detail, true) . "<hr />";
		
		// Checking if the object is a traff_detail.
		if ( !is_object( $traff_detail))
			return false;

		// Walking through the items.
		if ( is_array( $traff_detail->items) && count( $traff_detail->items) > 0)
		{
			$ca_list_body = array( );
			foreach( $traff_detail->items as $key => $value) {
				
				$ca_list_body[ ] = array(
					array( 'value' => $value->date, 'href' => false),
					array( 'value' => $value->hour, 'href' => false),
					array( 'value' => $value->source, 'href' => false),
					array( 'value' => $value->called, 'href' => false),
					array( 'value' => $value->target, 'href' => false),
					array( 'value' => $value->duration, 'href' => false),
					array( 'value' => $value->price, 'href' => false)
				);
			}
		}
		else
		{
			$ca_list_body = false;
		}

		if ( is_array( $traff_detail->agrupation) && count( $traff_detail->agrupation) > 0)
		{
			$ca_list_agrupation = array( );
			$n = 0;
			foreach( $traff_detail->agrupation as $key => $value) {
				
				//echo "SUB - DATA: " . var_export($value, true) . "<hr />";
				
				$ca_list_agrupation[ $n] = new ca_list_agrupation( );
				$ca_list_agrupation[ $n]->set_from_traff_agrupation( $value);
				$n ++;
			}
		}
		else
		{
			$ca_list_agrupation = false;
		}

		$this->_init( array( "DATE", "HOUR", "SOURCE", "CALLED", "TARGET", "DURATION", "PRICE2"), $ca_list_body, $ca_list_agrupation);
		$this->show_footer = true;
		$this->paginate = true;
		$this->paginate_element = "CALLS";

		return true;
	}

	function set_from_traff_resume( $traff_resume, $first_col = NULL)
	{
		if ( is_array( $traff_resume->items) && count( $traff_resume->items) > 0)
		{
			$ca_list_body = array( );
			foreach( $traff_resume->items as $key => $value)
			{
                if ( !$value->symbol) $value->symbol = "$";
				$ca_list_body[ ] = array(
					array( 'value' => $value->title, 'href' => false),
					array( 'value' => $value->calls, 'href' => false),
					array( 'value' => $value->duration, 'href' => false),
                    array( 'value' => ( $value->symbol ? ( $value->symbol . " ") : "") . $value->price, 'href' => false)
				);
			}
			
		}
		else
		{
			$ca_list_body = false;
		}

		if ( is_array( $traff_resume->agrupation) && count( $traff_resume->agrupation) > 0)
		{
			$ca_list_agrupation = array( );
			$n = 0;
			foreach( $traff_resume->agrupation as $key => $value)
			{
				$ca_list_agrupation[ $n] = new ca_list_agrupation( );
				$ca_list_agrupation[ $n]->set_from_traff_agrupation( $value);
				$n ++;
			}
		}
		else
		{
			$ca_list_agrupation = false;
		}

		$this->_init( array( $first_col, "CALLS", "DURATION", "PRICE2"), $ca_list_body, $ca_list_agrupation);
		$this->show_footer = true;
		$this->paginate = true;
		$this->paginate_element = "TICKETS";

		return true;
	}

    function _csv_subs( &$csv, $subarray)
    {
        if ( $subarray && is_array( $subarray))
        {
            $csv->RowInit( );
            for( $n = 0; $n < $this->cols; $n ++)
            {
                if ( $n == 0)
                    $csv->ColWrite( lang( $subarray[ "key"]));
                else if ( $n == ( $this->cols -1))
                    $csv->ColWrite( $subarray[ "value"]);
                else
                    $csv->ColWrite( "");
            }
        }
    }
    
    function _csv_simple_str( &$csv, $str)
    {
        $csv->RowInit( );
        for( $n = 0; $n < $this->cols; $n ++)
        {
            if ( $n == 0)
                $csv->ColWrite( $str);
            else
                $csv->ColWrite( "");
        }
    }

    function _csv_agrupation( &$csv, $agrupation)
    {
        if ( $agrupation->segment_header === true)
        {
            $this->_csv_simple_str( $csv, $agrupation->name);
        }

        if ( is_array( $agrupation->agrupation) && count( $agrupation->agrupation) > 0)
        {
            foreach( $agrupation->agrupation as $one_agrupation)
            {
                $this->_csv_agrupation( $csv, $one_agrupation);
            }
        }
        else if ( count( $agrupation->items) > 0)
        {
            foreach( $agrupation->items as $key => $item)
            {
                $csv->RowInit( );
                foreach( $item as $key => $item_value)
                {
                    $csv->ColWrite( $item_value[ "value"]);
                }
            }
        }

        if ( $agrupation->segment_footer === true)
        {
            $csv->RowInit( );
            for( $n = 0; $n < $this->cols - count( $agrupation->footer_items); $n ++)
            {
                if ( $n == 0)
                    $csv->ColWrite( $agrupation->footer_prefix . ' ' . $agrupation->name);
                else
                    $csv->ColWrite( "");
            }

            foreach( $agrupation->footer_items as $footer_item)
            {
                $csv->ColWrite( $footer_item);
            }
        }
    }
    
    function csv_get( )
    {
        global $smarty;
        
 		if ( !$this->valid)
			return null;

        $csv = new csv( );
        $csv->convert_html_to_txt = true;
        $csv->charset = DEF_CHARSET;

        // Header.
        $csv->RowInit( );
        foreach( $this->header_elements as $element)
        {
            $csv->ColWrite( lang( $element));
        }

        // Subheader.
        $this->_csv_subs( $csv, $this->subheader);

        if ( $this->body_agrupation && is_array( $this->body_agrupation))
        {
            // Agrupation.
            foreach( $this->body_agrupation as $agrupation)
            {
                $this->_csv_agrupation( $csv, $agrupation);
            }
        }
        else
        {
            // Items.
            foreach( $this->body_elements as $element)
            {
                $csv->RowInit( );
                foreach( $element as $tmp)
                {
                    $csv->ColWrite( $tmp[ "value"]);
                }
            }
        }

        // Total.
        $show_total = $smarty->get_template_vars( "show_total");
        if ( $show_total)
        {
            $csv->RowInit( );
            $csv->ColWrite( lang( "TOTAL2"));

            $ca_list_total = $smarty->get_template_vars( "ca_list_total");
            $ca_list_total_count = ( int)$smarty->get_template_vars( "ca_list_total_count");
            for( $n = 1; $n < ( $this->cols - $ca_list_total_count); $n ++)
            {
                $csv->ColWrite( "");
            }

            foreach( $ca_list_total as $tmp)
            {
                $csv->ColWrite( $tmp);
            }
        }
        
        // Subfooter.
        $this->_csv_subs( $csv, $this->subfooter);

        // Returning the CSV.
        return $csv->GetBuffer( );
    }
}

?>
