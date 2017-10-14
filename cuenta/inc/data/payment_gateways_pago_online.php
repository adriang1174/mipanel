<?


class p_gateways_pago_online_ticket
{
    var $titular;
    var $address;
    var $cuit;
    var $expiration;
    var $clientid;
    var $payment_condition;
    var $total_simbol;
    var $total_amount;
    var $ticketid;
    var $barcodeid;

    function p_gateways_pago_online_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_pago_online extends p_gateways
{
    function p_gateways_pago_online( $userid)
    {
        parent::p_gateways( $userid, "pago_online");
    }

	function get_ticket( $ticketid, $amount2pay = 0)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;

        $myticket = $this->userdata->get_ticket($ticketid);
       
        $p_pagoonline = new p_gateways_pago_online_ticket($ticketid_short);
        $p_pagoonline->titular = $this->userdata->get_titular();
        $p_pagoonline->cuit = $myticket->cuit;
        $p_pagoonline->address = $myticket->address;
        $p_pagoonline->expiration = $myticket->date_expire;
        $p_pagoonline->clientid = $myticket->userid;
        $p_pagoonline->payment_condition = $myticket->condpago;
        $p_pagoonline->total_simbol = $this->userdata->get_currency($myticket->monedaid);
        $p_pagoonline->total_amount = $amount2pay ? $amount2pay : $myticket->itotal;
        $p_pagoonline->ticketid = $ticketid;

		
        return $p_pagoonline;
    }
   
}

?>
