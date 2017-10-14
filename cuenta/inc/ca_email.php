<?
require_once( 'language.php');
define( "PATH_INC", INCLUDE_PATH);
require_once( 'PEAR/Mail.php');
require_once( 'PEAR/Mail/mime.php');

define( "CA_EMAIL_TEMPLATE_CC", "cc");
define( "CA_EMAIL_TEMPLATE_RATE", "rate");
define( "CA_EMAIL_TEMPLATE_RATES", "rates");
define( "CA_EMAIL_TEMPLATE_RECEIPT", "receipt");
define( "CA_EMAIL_TEMPLATE_TICKET", "ticket");
define( "CA_EMAIL_TEMPLATE_TICKET_ITEM", "ticket_item");
define( "CA_EMAIL_TEMPLATE_TICKETS", "tickets");
define( "CA_EMAIL_TEMPLATE_TRAFF", "traff");
define( "CA_EMAIL_TEMPLATE_TRAFF_F", "traff_f");
define( "CA_EMAIL_TEMPLATE_TRAFF_NF", "traff_nf");
define( "CA_EMAIL_TEMPLATE_TRAFF_P", "traff_p");
define( "CA_EMAIL_TEMPLATE_EML_CONFIRM_GOLDMINE", "eml_confirm_goldmine");
define( "CA_EMAIL_TEMPLATE_EML_GOLDMINE", "mail_gm");
define( "CA_EMAIL_TEMPLATE_EML_USER", "mail_user");
define( "CA_EMAIL_TEMPLATE_EML_CONFIRM_USER", "eml_confirm_user");
define( "CA_EMAIL_TEMPLATE_SERVICE_ADD_USER", "service_add_user");
define( "CA_EMAIL_TEMPLATE_SERVICE_ADD", "service_add");
define( "CA_EMAIL_TEMPLATE_PASSWD", "passwd");

define( "CA_EMAIL_RECIPIENT_TYPE_TO", "to");
define( "CA_EMAIL_RECIPIENT_TYPE_CC", "cc");
define( "CA_EMAIL_RECIPIENT_TYPE_BCC", "bcc");

class ca_email_recipient
{
    var $name;
    var $email;
    var $raw_recipient;

    function ca_email_recipient( $name, $email, $raw_recipient = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->raw_recipient = $raw_recipient;
    }
}

class ca_email_attachment
{
    var $data;
    var $content_type;
    var $filename;

    function ca_email_attachment( $data, $content_type, $filename)
    {
        $this->data = $data;
        $this->content_type = $content_type;
        $this->filename = $filename;
    }
}

class ca_email
{
    var $_isvalid;
    var $_file;
    var $_subject;
    var $_from;
    var $_to;
    var $_cc;
    var $_bcc;
    var $_tags;
    var $_attachments;
    var $_txtbody;
    var $_html_images;
    
    function ca_email( $template, $language, $txtbody = false, $owner = NULL)
    {
        $this->_isvalid = false;
        if ( !$template || !preg_match( "/[a-z0-9]+/i", $template)){			
            return;
		}

        $lang = language::sanitize_lang( $language);
        if ( !$lang){			
            return;
		}
		
		if($owner == NULL){
			$owner = owner_to_ownerid();
		}
		
		if($owner == 1 || $owner == 2){ // red
			$suf = 'red';
		}else if($owner == 3){ // hotatel
			$suf = 'hola';
		}else if($owner == 4){ // viatel
			$suf = 'viatel';
		}else if($owner == 5){ // latinatel
			$suf = 'latinatel';	
		} else if($owner == 7 || $owner == 8){ // t2
			$suf = 't2';
		}
		
		
		// Me fijo si existe un template especial para este owner
		$file = PATH_EMAIL_TPL . $lang . '/' . $template .'_'. $suf .'.eml';	
		
		if ( !is_file( $file)){				
		    $file = PATH_EMAIL_TPL . $lang . '/' . $template . '.eml';	
		    if ( !is_file( $file)){				
		        return;
			}
		}

        $this->_isvalid = true;
        $this->_file = $file;
        $this->_from = null;
        $this->_subject = null;
        $this->_to = array( );
        $this->_cc = array( );
        $this->_bcc = array( );
        $this->_tags = array( );
        $this->_txtbody = ( $txtbody ? true : false);
    }

    function set_from( $from)
    {
        if ( !$this->_isvalid)
            return false;

        if ( !$from)
            return false;

        $this->_from = $from;
        return true;
    }

    function add_to( $type, $email){		
        if ( !$this->_isvalid) {			
            return false;
		}
        
        if ( !in_array( $type, array(CA_EMAIL_RECIPIENT_TYPE_TO, 
        		CA_EMAIL_RECIPIENT_TYPE_CC, CA_EMAIL_RECIPIENT_TYPE_BCC))
            	|| !$email) {
			
            return false;
        }

        switch( $type)
        {
            case CA_EMAIL_RECIPIENT_TYPE_TO: $this->_to[ ] = $email; break;
            case CA_EMAIL_RECIPIENT_TYPE_CC: $this->_cc[ ] = $email; break;
            case CA_EMAIL_RECIPIENT_TYPE_BCC: $this->_bcc[ ] = $email; break;
            default: return false;
        }
        
        return true;
    }

    function set_subject( $subject)
    {
        if ( !$this->_isvalid)
            return false;
        
        if ( !$subject)
            return false;
        
        $this->_subject = $subject;
        return true;
    }

    function _recipient_string( $rec)
    {
        if ( $rec->raw_recipient)
            return $rec->raw_recipient;
        
        return ( $rec->name . " <" . $rec->email . ">");
    }

    function _recipient_email( $str)
    {
        // TODO:Fixme!
        return $str;
    }
    
    function _get_headers( )
    {
        $headers = array( );

        // From.
        $headers[ "From"] = $this->_recipient_string( $this->_from);

        // To.
        if ( count( $this->_to) <= 0)
            return null;
        foreach( $this->_to as $to)
        {
            $headers[ "To"] = $this->_recipient_string( $to);
        }

        // Cc.
        if ( count( $this->_cc) > 0)
        {
            foreach( $this->_cc as $cc)
            {
                $headers[ "Cc"] = $this->_recipient_string( $cc);
            }
        }

        // Bcc.
        if ( count( $this->_bcc) > 0)
        {
            foreach( $this->_bcc as $bcc)
            {
                $headers[ "Bcc"] = $this->_recipient_string( $bcc);
            }
        }

        // Subject.
        $headers[ "Subject"] = $this->_subject;

        // Other headers.
        $headers[ "Date"] = date( "r");
        $headers[ "MIME-Version"] = "1.0";
        $headers[ "Content-Type"] = "text/html; charset=iso-8859-1";
        $headers[ "X-Mailer"] = "Mi Panel";

        // Getting the headers of the template.
        $tplheaders = $this->_get_message_headers( );
        if ( $tplheaders && is_array( $tplheaders) && count( $tplheaders) > 0)
        {
            foreach( $tplheaders as $key => $tplheader)
            {
                $headers[ $key] = $tplheader;
            }
        }
 
        if ( !$headers[ "From"] || strlen( trim( $headers[ "From"])) <= 0)
            return false;

        if ( !$headers[ "Subject"] || strlen( trim( $headers[ "Subject"])) <= 0)
            return false;

        // Setting the From-dependent headers.
        if ( !@$headers[ "Reply-To"])
            $headers[ "Reply-To"] = $headers[ "From"];
        if ( !@$headers[ "Return-Path"])
            $headers[ "Return-Path"] = $headers[ "From"];

        return $headers;
    }

    function set_tag_replacement( $tag, $replacement)
    {
        if ( !$this->_isvalid)
            return false;

        if ( !$tag)
            return false;

        $this->_tags[ $tag] = $replacement;
        return true;
    }

    function add_attachment( $attachment)
    {
        if ( !$attachment || !is_object( $attachment))
            return false;

        if ( !$this->_attachments || !is_array( $this->_attachments))
            $this->_attachments = array( );

        $this->_attachments[ ] = $attachment;
        return true;
    }

    function add_html_image( $img_path)
    {
        if ( !$img_path || !is_file( $img_path))
            return false;

        $this->_html_images[ ] = $img_path;
    }
    
    function _get_message_headers( )
    {
        $message = $this->_get_message( );
        if ( !$message || !$message[ 'headers'])
            return null;

        $headers = array( );
        $strheaders = explode( "\n", $message[ 'headers']);
        foreach( $strheaders as $strheader)
        {
            $exp = explode( ":", $strheader, 2);
            if ( count( $exp) != 2)
                continue;
            $headers[ ucwords( trim( $exp[ 0]))] = trim( $exp[ 1]);
        }

        if ( count( $headers) <= 0)
            return null;

        return $headers;
    }

    function _get_message_body( )
    {
        global $smarty;
        
        $message = $this->_get_message( );
        if ( !$message || !$message[ 'body'])
            return null;

        $body = trim( $message[ 'body']);

        if ( $this->_txtbody)
            return $body;

        $begin = $smarty->fetch( "email_begin.tpl");
        $end = $smarty->fetch( "email_end.tpl");
        return ( $begin . "\n" . $body . "\n" . $end);
    }

    function _get_message( )
    {
        $message = file_get_contents( $this->_file);
		

        foreach( $this->_tags as $tag => $replacement)
            $message = str_replace( $tag, $replacement, $message);

        $message = str_replace( "\r\n", "\n", $message);
        $tmp = explode( "\n\n", $message, 2);
        if ( count( $tmp) <= 0)
            return null;

        if ( count( $tmp) == 1)
            return array( 'body' => trim( $message), 'headers' => null);

        if ( count( $tmp) == 2)
            return array( 'body' => trim( $tmp[ 1]), 'headers' => trim( $tmp[ 0]));
        
        return null;
    }

    function _get_recipients( )
    {
        $recipients = array( );
        $tmp = array( );
        $tplheaders = $this->_get_message_headers( );

        // To.
        if ( $this->_to && count( $this->_to) > 0)
        {
            $tmp = array_merge( $tmp, $this->_to);
        }
        else
        {
            return null;
        }

        // Cc.        
        if ( array_key_exists( 'Cc', $tplheaders) && strlen( trim( $tplheaders[ 'Cc'])) > 0)
        {
            $recipients[ ] = $this->_recipient_email( $tplheaders[ 'Cc']);
        }
        else if ( $this->_cc && count( $this->_cc) > 0)
        {
            $tmp = array_merge( $tmp, $this->_cc);
        }

        // Bcc.
        if ( array_key_exists( 'Bcc', $tplheaders) && strlen( trim( $tplheaders[ 'Bcc'])) > 0)
        {
            $recipients[ ] = $this->_recipient_email( $tplheaders[ 'Bcc']);
        }
        else if ( $this->_bcc && count( $this->_bcc) > 0)
        {
            $tmp = array_merge( $tmp, $this->_bcc);
        }

        foreach( $tmp as $t)
        {
            $recipients[ ] = $t->email;
        }
        
        if ( !$recipients || count( $recipients) <= 0)
            return null;

        return $recipients;
    }

    function send_pear( )
    {
        // Recipients.
        $recipients = $this->_get_recipients( );
        if (!$recipients || !is_array( $recipients) || count( $recipients) <= 0){		
            return false;
		}
         
        // Body.
        $body = $this->_get_message_body( );
        if ( !$body){			
            return false;
		}

        $Mail_mime = new Mail_mime( "\n");
        if ( $this->_txtbody)
            $Mail_mime->setTxtBody( $body, false);
        else
            $Mail_mime->setHTMLBody( $body, false);
        if ( is_array( $this->_attachments) && count( $this->_attachments) > 0)
        {
            foreach( $this->_attachments as $attachment)
            {
                if ( is_object( $attachment))
                {
                    $Mail_mime->addAttachment( $attachment->data, $attachment->content_type, $attachment->filename, false, 'base64');
                }
            }
        }
        if ( is_array( $this->_html_images) && count( $this->_html_images) > 0)
        {
            foreach( $this->_html_images as $html_image)
                $Mail_mime->addHTMLImage( $html_image, "image/gif");
        }
        $mime_body = $Mail_mime->get( array( "head_charset" => DEF_CHARSET, "text_charset" => DEF_CHARSET, "html_charset" => DEF_CHARSET));

        
        // Headers.
        $headers = $this->_get_headers( );
        if ( !$headers || !is_array( $headers) || count( $headers) <= 0) {			
            return false;
		}

        unset( $headers[ "MIME-Version"]);
        unset( $headers[ "Content-Type"]);
        $mime_headers = $Mail_mime->headers( $headers);

        // Constructing the SMTP sender.
        $params = array(
            'host' => DEF_SMTP_HOST,
            'port' => DEF_SMTP_PORT,
            'auth' => false,
            'localhost' => "localhost",
            'timeout' => 30,
            'verp' => false,
            'debug' => false,
            'persist' => true
        );
        $mailer = &Mail::factory( 'smtp', $params);
        if ( !$mailer){
            return false;
        }

        // Sending the e-mail.
        $e = $mailer->send( $recipients, $mime_headers, $mime_body);

        if ( PEAR::isError( $e)) {		
            return false;
		}

        // E-Mail sent sucessfully.
        return true;
    }
    
    function send( )
    {
        if ( !$this->_isvalid){
            return false;
		}

        if ( !$this->_subject || !$this->_from || count( $this->_to) <= 0){
			return false;
		}

        // Headers.
        $headers = $this->_get_headers( );
        if ( !$headers){
			return false;
		}
        $strheaders = "";
        foreach( $headers as $key => $value)
            $strheaders .= ( $key . ": " . $value . "\n");

        // To.
        $strtos = "";
        $first = true;
        foreach( $this->_to as $to)
        {
            $strtos .= ( ( !$first ? ", " : "") . $to->email);
            $first = false;
        }
        foreach( $this->_cc as $to)
        {
            $strtos .= ( ( !$first ? ", " : "") . $to->email);
            $first = false;
        }
        foreach( $this->_bcc as $to)
        {
            $strtos .= ( ( !$first ? ", " : "") . $to->email);
            $first = false;
        }
        
        // Message.
        $message = $this->_get_message( );

        // Sending the e-mail.
        return mail( $strtos, $this->_subject, $message, $strheaders);
    }
}

?>
