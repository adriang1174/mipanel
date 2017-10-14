<?
  $ret = include ('./crypt_functions.php3');

  class PayOrder {
        var $clave;     // Clave de encripcion que usa el encriptador de PU
        var $appid;     // Identificador de negocio asignado por PU
        var $enc_xml;   // Guarda el XML encriptado
	var $username;  // Nombre de usuario del que esta haciendo la compra
    var $ticketid;  // El id del ticket que se esta pagando.

        function set_key($data) {
            $this->clave = $data;
        }

        function set_appid($data) {
            $this->appid = $data;
        }
	
	function set_username($data) {
	    $this->username = "++ $data ++";
	}

        function set_xml($data) {
            $this->enc_xml = CRY_Encrypt ( $data, $this->clave );
        }

        function set_ticketid($data) {
            $this->ticketid = $data;
        }
        
        function get_html() {
        //    $post_action = "https://www.pagouniversal.com.ar/External/Ext_Dispatcher.asp";
	      $post_action = "https://www.epayments.hsbc.com.ar/Public/Ssl/Routing.aspx";
	/*    $post_action = "http://stage.pagouniversal.com.ar/External/Ext_Dispatcher.asp"; */
	    if (stristr($this->username, "prueba")) $post_action = "http://stage.pagouniversal.com.ar/External/Ext_Dispatcher.asp";
	    $html = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2 Final//EN\">\n";
            $html .= "<HTML>\n";
            $html .= "<HEAD><TITLE>RED ALTERNATIVA</TITLE></HEAD>\n";
            $html .= "<BODY>\n";
            $html .= "<FORM NAME=\"frmSend\" ID=\"frmSend\" ACTION=\"$post_action\" method=post target=\"_new\">\n";
            $html .= " <INPUT TYPE=\"hidden\" name=\"XML\" id=\"XML\" value=\"$this->enc_xml\">\n";
            $html .= " <INPUT TYPE=\"hidden\" name=\"AppId\" id=\"AppId\" value=\"$this->appid\">\n";
            $html .= "</FORM>\n";
            $html .= "</BODY>\n";
            $html .= "</HTML>\n";
            $html .= "<SCRIPT LANGUAGE=\"javascript\">\n";
            $html .= "  document.frmSend.submit();\n";
            $html .= "  window.location = '/cuenta/ticket.ca?ticketid=" . $this->ticketid . "';\n";
            $html .= "</SCRIPT>\n";

            return $html;
        }
	
	function decrypt() {
		return CRY_Decrypt($this->enc_xml, $this->clave);
	}
  }
?>
