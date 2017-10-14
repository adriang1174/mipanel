<?

define( 'CA_FORM_BUTTON_TYPE_SUBMIT', "submit");
define( 'CA_FORM_BUTTON_TYPE_REDIRECT', "redirect");

class ca_form_button
{
    var $type;
    var $image_name;
    var $image_islangdependent;
    var $url;

    function ca_form_button( $type, $image_name, $image_islangdependent, $url = null)
    {
        $this->type = $type;
        $this->image_name = $image_name;
        $this->image_islangdependent = $image_islangdependent ? 1 : 0;
        $this->url = $url;
    }
}

?>
