<?

class p_gateways_pago_universal_ticket
{
    var $ticketid;
    var $date;
    var $total_simbol;
    var $total_amount;
    var $total_moneyid;

    function p_gateways_pago_universal_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_pago_universal extends p_gateways
{
    function p_gateways_pago_universal( $userid)
    {
        parent::p_gateways( $userid, "pago_universal");
    }

    function get_ticket( $ticketid)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;

        $myticket = $this->userdata->get_ticket($ticketid);
        $p_gateways_pago_universal_ticket = new p_gateways_pago_universal_ticket( $ticketid);
        $p_gateways_pago_universal_ticket->date = $myticket->date;
        $p_gateways_pago_universal_ticket->total_simbol = $this->userdata->get_currency($myticket->monedaid);
        $p_gateways_pago_universal_ticket->total_amount = $myticket->itotal;
        $p_gateways_pago_universal_ticket->total_moneyid = $myticket->monedaid;
        return $p_gateways_pago_universal_ticket;
    }

    function amount_to_pesos_argentinos( $amount, $amount_currencyid, $date)
    {
        if ( $amount_currencyid != 2) // 2 es "pesos argentinos"
        {
            trigger_error( $amount_currencyid);
            $cot = ca_currency::get_last_quotation_by_id( $amount_currencyid);
            $cot = ( float)$cot[ "cotizacion"];
            if ( $cot)
                $amount = ( float)$amount * $cot;
        }
        
        return $amount; // Convertir a pesos argentinos.
    }
}

?>
