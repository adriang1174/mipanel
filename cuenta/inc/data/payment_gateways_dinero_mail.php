<?
require_once( INCLUDE_PATH . "db.php");

define('BANK_ACCOUNT_BANAMEX', '575-4952042');
define('BANK_ACCOUNT_HSBC', '6073');

class p_gateways_dinero_mail_ticket
{
    var $client;
    var $ticketid;
    var $total_string;
    var $total_dollars;
    var $dollar_simbol;
    var $hsbc_key;
    var $hsbc_ref;
    var $banamex_account;
    var $banamex_ref;
    var $original_currency;

    function p_gateways_dinero_mail_ticket( $ticketid)
    {
        $this->ticketid = $ticketid;
    }
}

class p_gateways_dinero_mail extends p_gateways
{
    function p_gateways_dinero_mail( $userid)
    {
        parent::p_gateways( $userid, "dinero_mail");
    }

    function get_ticket( $ticketid, $amount2pay = 0)
    {
        list($tipodoc, $sucdoc, $numdoc) = explode('-', $ticketid);
        $ticketid_short = $sucdoc."-".$numdoc;

        $myticket = $this->userdata->get_ticket($ticketid);
        
        $p_dineromail = new p_gateways_dinero_mail_ticket($ticketid_short);
        $p_dineromail->client = $this->userid." - ".$this->userdata->get_titular();
    	$p_dineromail->ticketid = $ticketid;

        $cot_fact = ca_currency::get_last_quotation_by_id( $myticket->monedaid );
        $cot_medio = ca_currency::get_last_quotation_by_id( 3 ); // $MX
        $cot = $cot_fact['cotizacion'] / $cot_medio['cotizacion'];
        
        $tot = $amount2pay ? $amount2pay : $myticket->itotal;
        $p_dineromail->total_dollars = $tot;
        $p_dineromail->total_string = $this->userdata->get_currency(3)." ".number_format($tot * $cot, 2)." (".$this->userdata->get_currency($myticket->monedaid)." ".$tot.")";
        $p_dineromail->dollar_simbol = $this->userdata->get_currency($myticket->monedaid);
        $p_dineromail->original_currency = $this->userdata->get_currency_desc($myticket->monedaid);

        $bank_accounts = $this->get_bank_data();
        
    	$p_dineromail->hsbc_key = BANK_ACCOUNT_HSBC;
        $p_dineromail->hsbc_ref = $bank_accounts['HSBC'];
    	$p_dineromail->banamex_account = BANK_ACCOUNT_BANAMEX;
    	$p_dineromail->banamex_ref = $bank_accounts['Banamex'];
        
        return $p_dineromail;
    }
    
    function get_bank_data()
    {
        db::init();
        $query = "select * from codigos_cobranza where medio_cobranza_id = 'dinero_mail' and cliente_id = '".$this->userid."'";
        $accounts = db::get_rows_as_array_of_hashes($query);
        $myaccounts = array();
        foreach($accounts as $account)
        {
            $id = $account['banco_id'];
            $myaccounts[$id] = $account['identificador'];
        }
        return $myaccounts;
    }
}

?>
