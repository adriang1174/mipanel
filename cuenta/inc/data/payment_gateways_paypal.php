<?
require_once(INCLUDE_PATH . "data/paypal_gw.php");

class p_gateways_paypal_ticket
{
    var $ticketid;
    var $date;
    var $total_simbol;
    var $total_amount;
    var $total_moneyid;

    function p_gateways_paypal_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_paypal extends p_gateways
{
    function p_gateways_paypal( $userid)
    {
        parent::p_gateways( $userid, "paypal");
    }

    function get_ticket( $ticketid)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;

        $myticket = $this->userdata->get_ticket($ticketid);
        $p_gateways_paypal_ticket = new p_gateways_paypal_ticket( $ticketid);
        $p_gateways_paypal_ticket->date = $myticket->date;
        $p_gateways_paypal_ticket->total_simbol =  $this->userdata->get_currency(1); //$this->userdata->get_currency($myticket->monedaid);
		
		
        $cot_fact = ca_currency::get_last_quotation_by_id( $myticket->monedaid );
        $cot_medio = ca_currency::get_last_quotation_by_id( 1 ); // US
        $cot = $cot_fact['cotizacion'] / $cot_medio['cotizacion'];
		$tot = $amount2pay ? $amount2pay : $myticket->itotal;
		
		
		$p_gateways_paypal_ticket->total_amount = number_format($tot * $cot, 2);
		
        $p_gateways_paypal_ticket->total_moneyid = 1; //$myticket->monedaid;
		
		return $p_gateways_paypal_ticket;
    }
   
}


?>
