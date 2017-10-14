<?
define( 'CA_FORM_FIELD_HTML_TYPE_TEXT', "text");
define( 'CA_FORM_FIELD_HTML_TYPE_PASSWORD', "password");
define( 'CA_FORM_FIELD_HTML_TYPE_SELECT', "select");
define( 'CA_FORM_FIELD_HTML_TYPE_DATE', "date");
define( 'CA_FORM_FIELD_HTML_TYPE_CHECKBOX', "checkbox");
define( 'CA_FORM_FIELD_HTML_TYPE_TEXTAREA', "textarea");
define( 'CA_FORM_FIELD_HTML_TYPE_SEPARATOR', "separator");
define( 'CA_FORM_FIELD_HTML_TYPE_STATICTEXT', "statictext");
define( 'CA_FORM_FIELD_HTML_TYPE_RADIO', "radio");
define( 'CA_FORM_FIELD_HTML_TYPE_HIDDEN', "hidden");

class ca_form_field_stock
{
    var $value;
    var $display;

    function ca_form_field_stock( $value, $display)
    {
        $this->value = $value;
        $this->display = $display;
    }
}

class ca_form_field
{
    var $name;
    var $isrequired;
    var $mustcleaned;
    var $type;
    var $title;
    var $errormsg;
    var $htmltype;
    var $stock;
    var $size;
    var $stock_default;
    var $default_data;
    var $isreadonly;
    var $hidden_data;
    var $comments;

    function ca_form_field( $name, $isrequired, $mustcleaned, $type, $title, $errormsg, $htmltype, $stock, $size, $stock_default = null, $default_data = null, $isreadonly = false)
    {
        $this->name = $name;
        $this->isrequired = $isrequired;
        $this->mustcleaned = $mustcleaned;
        $this->type = $type;
        $this->title = $title;
        $this->errormsg = $errormsg;
        $this->htmltype = $htmltype;
        $this->stock = $stock;
        $this->size = $size;
        $this->stock_default = $stock_default;
        $this->default_data = $default_data;
        $this->isreadonly = $isreadonly;
    }

    function set_error( $err = false)
    {
        global $smarty;

        // If $err != false, then we should use it instead
        // of the error passed at the creation of the class.
        if ( $err)
            $smarty->assign( $this->name . "_error", $err);
        else if ( $this->errormsg)
            $smarty->assign( $this->name . "_error", $this->errormsg);

        $smarty->assign( $this->name . "_invalid", true);
        return true;
    }
}

?>
