<?

// Analoga a implode pero para arrays multidimensionales
function multi_implode($glue, $pieces){
	$string='';

	if(is_array($pieces)){
		reset($pieces);
		while(list($key,$value)=each($pieces)){
			$string.=$glue.multi_implode($glue, $value);
		}
	}else{
		return $pieces;
	}

	return trim($string, $glue);
}
class scr
{
	function parameters( $params)
	{
		return true;
	}
	function filter( $params)
	{
		return true;
	}
	function process( $params)
	{
		return true;
	}
	function assign( $params)
	{
		global $smarty;	
		
		return true;
	}
}

// This user is allowed to use this scr?
        $profile = new profile( ca_session::get_userid( ));
        $email_verif = $profile->is_mail_verif( );
        if ( !$email_verif){
            $smarty->assign( "email_not_verif", true);
        }
        
$user = ca_session::get_userid( );

global $dbh;
$yaencuestado = $dbh->getOne("SELECT count(*) AS cantidad FROM encuesta_mipanel WHERE id_cliente = '$user'");
$smarty->assign('yaencuestado', $yaencuestado);


if(!empty ($_POST) && isset($_POST['PREGUNTA_1']) ){
	
	$cliente = $dbh->qstr($user);
	$pregunta1 = $dbh->qstr($_POST['PREGUNTA_1']);
	$pregunta_si_1 = $dbh->qstr($_POST['PREGUNTA_SI_1']);
	$pregunta_si_2 = $dbh->qstr($_POST['PREGUNTA_SI_2']);
	$pregunta_si_2_in = $dbh->qstr($_POST['PREGUNTA_SI_2_IN']);
	$pregunta_si_3 = $dbh->qstr($_POST['PREGUNTA_SI_3']);
	$pregunta_si_3_in = $dbh->qstr($_POST['PREGUNTA_SI_3_IN']);
	$pregunta_si_4 = $dbh->qstr($_POST['PREGUNTA_SI_4']);
	$pregunta_si_4_in = $dbh->qstr($_POST['PREGUNTA_SI_4_IN']);
	$pregunta_si_5 = $dbh->qstr($_POST['PREGUNTA_SI_5']);
	$pregunta_si_5_in = $dbh->qstr($_POST['PREGUNTA_SI_5_IN']);
	$pregunta_si_6 = $dbh->qstr($_POST['PREGUNTA_SI_6']);
	$pregunta_si_6_in = $dbh->qstr($_POST['PREGUNTA_SI_6_IN']);
	$pregunta_si_7 = $dbh->qstr($_POST['PREGUNTA_SI_7']);
	$pregunta_si_7_in = $dbh->qstr($_POST['PREGUNTA_SI_7_IN']);
	$pregunta_si_8 = $dbh->qstr($_POST['PREGUNTA_SI_8']);
	$pregunta_si_9 = $dbh->qstr($_POST['PREGUNTA_SI_9']);
	$textarea_si = $dbh->qstr($_POST['TEXTAREA_SI']);
	$pregunta_no_1 = $dbh->qstr($_POST['PREGUNTA_NO_1']);
	$listado_checks = $_POST['PREGUNTA_NO_2'];
	$mostrar_checks = multi_implode(" ", $listado_checks);
	$mostrar_checks= $dbh->qstr($mostrar_checks);
	$pregunta_no_a = $dbh->qstr($_POST['PREGUNTA_NO_A']);
	$pregunta_no_a_in = $dbh->qstr($_POST['PREGUNTA_NO_A_IN']);
	$pregunta_no_b = $dbh->qstr($_POST['PREGUNTA_NO_B']);
	$pregunta_no_b_in = $dbh->qstr($_POST['PREGUNTA_NO_B_IN']);
	$pregunta_no_c = $dbh->qstr($_POST['PREGUNTA_NO_C']);
	$pregunta_no_c_in = $dbh->qstr($_POST['PREGUNTA_NO_C_IN']);
	$pregunta_no_d = $dbh->qstr($_POST['PREGUNTA_NO_D']);
	$pregunta_no_d_in = $dbh->qstr($_POST['PREGUNTA_NO_D_IN']);
	$pregunta_no_e = $dbh->qstr($_POST['PREGUNTA_NO_E']);
	$pregunta_no_e_in = $dbh->qstr($_POST['PREGUNTA_NO_E_IN']);
	$pregunta_no_f = $dbh->qstr($_POST['PREGUNTA_NO_F']);
	$pregunta_no_f_in = $dbh->qstr($_POST['PREGUNTA_NO_F_IN']);
	$pregunta_no_g = $dbh->qstr($_POST['PREGUNTA_NO_G']);
	$pregunta_no_g_in = $dbh->qstr($_POST['PREGUNTA_NO_G_IN']);
	$pregunta_no_h = $dbh->qstr($_POST['PREGUNTA_NO_H']);
	$pregunta_no_i = $dbh->qstr($_POST['PREGUNTA_NO_I']);
	$textarea_no = $dbh->qstr($_POST['TEXTAREA_NO']);
	
	//Guardo los datos en la base
	$res = $dbh->execute("INSERT INTO encuesta_mipanel (id_cliente, pregunta_1, pregunta_si_1, pregunta_si_2, pregunta_si_2_in, pregunta_si_3, pregunta_si_3_in, pregunta_si_4, pregunta_si_4_in, pregunta_si_5, pregunta_si_5_in, pregunta_si_6, pregunta_si_6_in, pregunta_si_7, pregunta_si_7_in, pregunta_si_8, pregunta_si_9, textarea_si, pregunta_no_1, pregunta_no_2, pregunta_no_a, pregunta_no_a_in, pregunta_no_b, pregunta_no_b_in, pregunta_no_c, pregunta_no_c_in, pregunta_no_d, pregunta_no_d_in, pregunta_no_e, pregunta_no_e_in, pregunta_no_f, pregunta_no_f_in, pregunta_no_g, pregunta_no_g_in,  pregunta_no_h, pregunta_no_i, textarea_no, fecha)
	
						VALUES (". $cliente .",". $pregunta1 .", ". $pregunta_si_1 .", ". $pregunta_si_2 .", ". $pregunta_si_2_in .", ". $pregunta_si_3 .", ". $pregunta_si_3_in .", ". $pregunta_si_4 .", ". $pregunta_si_4_in .", ". $pregunta_si_5 .", ". $pregunta_si_5_in .", ". $pregunta_si_6 .", ". $pregunta_si_6_in .", ". $pregunta_si_7 .", ". $pregunta_si_7_in .", ". $pregunta_si_8 .", ". $pregunta_si_9 .", ". $textarea_si .", ". $pregunta_no_1 .", ". $mostrar_checks .", ". $pregunta_no_a .", ". $pregunta_no_a_in .", ". $pregunta_no_b .", ". $pregunta_no_b_in .", ". $pregunta_no_c .", ". $pregunta_no_c_in .", ". $pregunta_no_d .", ". $pregunta_no_d_in .", ". $pregunta_no_e .", ". $pregunta_no_e_in .", ". $pregunta_no_f .", ". $pregunta_no_f_in .", ". $pregunta_no_g .", ". $pregunta_no_g_in .", ". $pregunta_no_h .", ". $pregunta_no_i .", ". $textarea_no .", NOW())");
	
	
	if($res){
		//Saco el email
		$ca_email = new ca_email("mail_gm_encuesta", ca_session::language_get());
				
		$owner = owner_to_ownerid();
		if($owner == 7){ // t2
			$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
						new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support_display() .'>'));
		}else{
			$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
						new ca_email_recipient('{$GM-WEBIMPORT$} <'.owner::addr_support() .'>', '{$GM-WEBIMPORT$} <'.owner::addr_support() .'>'));
		}
		
		/*$ca_email->add_to(CA_EMAIL_RECIPIENT_TYPE_TO, 
			new ca_email_recipient("fstecher@alternativa.com.ar", "fstecher@alternativa.com.ar"));*/
		
		$user = new user( ca_session::get_userid( ));
		$profile = new profile(ca_session::get_userid());
		$actual_email = $profile->get_mail_admin();
		
		//$ca_email->set_tag_replacement( "[MAIL_FROM]", '<'. owner::addr_support() .'>');

		$ca_email->set_tag_replacement( "[MAIL_FROM]", $user->get_titular() .'<'.$user->get_email().'>');
		$ca_email->set_tag_replacement( "[CLIENT_ID]", ca_session::get_userid());	
		$ca_email->set_tag_replacement( "[SUBJECT]", 'Encuesta Mi Panel - Cliente: '. $cliente);	
		
		$text = '';
		
		if ($_POST['PREGUNTA_1'] == "Sí"){
			$text .= TPL_PREGUNTA_1 .': ' . $_POST['PREGUNTA_1'] . '<br />';
			if (!empty($_POST['PREGUNTA_SI_1'])){
				$text .= TPL_PREGUNTA_SI_1 .': ' . $_POST['PREGUNTA_SI_1'] . '<br />';
			}
			if ($_POST['PREGUNTA_SI_2'] == "No"){
				$text .= TPL_PREGUNTA_SI_2 .': ' . $_POST['PREGUNTA_SI_2'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_2'] == "Sí" && empty($_POST['PREGUNTA_SI_2_IN'])){
				$text .= TPL_PREGUNTA_SI_2 .': ' . $_POST['PREGUNTA_SI_2'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_2'] == "Sí" && !empty($_POST['PREGUNTA_SI_2_IN'])){
				$text .= TPL_PREGUNTA_SI_2 .': ' . $_POST['PREGUNTA_SI_2'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_2_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_2_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_SI_3'] == "No"){
				$text .= TPL_PREGUNTA_SI_3 .': ' . $_POST['PREGUNTA_SI_3'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_3'] == "Sí" && empty($_POST['PREGUNTA_SI_3_IN'])){
				$text .= TPL_PREGUNTA_SI_3 .': ' . $_POST['PREGUNTA_SI_3'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_3'] == "Sí" && !empty($_POST['PREGUNTA_SI_3_IN'])){
				$text .= TPL_PREGUNTA_SI_3 .': ' . $_POST['PREGUNTA_SI_3'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_3_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_3_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_SI_4'] == "No"){
				$text .= TPL_PREGUNTA_SI_4 .': ' . $_POST['PREGUNTA_SI_4'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_4'] == "Sí" && empty($_POST['PREGUNTA_SI_4_IN'])){
				$text .= TPL_PREGUNTA_SI_4 .': ' . $_POST['PREGUNTA_SI_4'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_4'] == "Sí" && !empty($_POST['PREGUNTA_SI_4_IN'])){
				$text .= TPL_PREGUNTA_SI_4 .': ' . $_POST['PREGUNTA_SI_4'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_4_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_4_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_SI_5'] == "No"){
				$text .= TPL_PREGUNTA_SI_5 .': ' . $_POST['PREGUNTA_SI_5'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_5'] == "Sí" && empty($_POST['PREGUNTA_SI_5_IN'])){
				$text .= TPL_PREGUNTA_SI_5 .': ' . $_POST['PREGUNTA_SI_5'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_5'] == "Sí" && !empty($_POST['PREGUNTA_SI_5_IN'])){
				$text .= TPL_PREGUNTA_SI_5 .': ' . $_POST['PREGUNTA_SI_5'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_5_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_5_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_SI_6'] == "No"){
				$text .= TPL_PREGUNTA_SI_6 .': ' . $_POST['PREGUNTA_SI_6'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_6'] == "Sí" && empty($_POST['PREGUNTA_SI_6_IN'])){
				$text .= TPL_PREGUNTA_SI_6 .': ' . $_POST['PREGUNTA_SI_6'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_6'] == "Sí" && !empty($_POST['PREGUNTA_SI_6_IN'])){
				$text .= TPL_PREGUNTA_SI_6 .': ' . $_POST['PREGUNTA_SI_6'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_6_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_6_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_SI_7'] == "No"){
				$text .= TPL_PREGUNTA_SI_7 .': ' . $_POST['PREGUNTA_SI_7'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_7'] == "Sí" && empty($_POST['PREGUNTA_SI_7_IN'])){
				$text .= TPL_PREGUNTA_SI_7 .': ' . $_POST['PREGUNTA_SI_7'] . '<br />';
			} elseif ($_POST['PREGUNTA_SI_7'] == "Sí" && !empty($_POST['PREGUNTA_SI_7_IN'])){
				$text .= TPL_PREGUNTA_SI_7 .': ' . $_POST['PREGUNTA_SI_7'] . '<br />';
				if (!empty($_POST['PREGUNTA_SI_7_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_SI_7_IN'] . '<br />';
				}
			}
			if (!empty($_POST['PREGUNTA_SI_8'])){
				$text .= TPL_PREGUNTA_SI_8 .': ' . $_POST['PREGUNTA_SI_8'] . '<br />';
			}
			if (!empty($_POST['PREGUNTA_SI_9'])){
				$text .= TPL_PREGUNTA_SI_9 .': ' . $_POST['PREGUNTA_SI_9'] . '<br />';
			}
			if (!empty($_POST['TEXTAREA_SI'])){
				$text .= TPL_ULTIMA_SI .': ' . $_POST['TEXTAREA_SI'] . '<br />';
			}
		} else {
			$text .= TPL_PREGUNTA_1 .': ' . $_POST['PREGUNTA_1'] . '<br />';
			if (!empty($_POST['PREGUNTA_NO_1'])){
				$text .= TPL_PREGUNTA_NO_1 .': ' . $_POST['PREGUNTA_NO_1'] . '<br />';
			}
			if (!empty($_POST['PREGUNTA_NO_2'])){
				$text .= TPL_PREGUNTA_NO_2 .': ' . $mostrar_checks . '<br />';
			}
			if ($_POST['PREGUNTA_NO_A'] == "No"){
				$text .= TPL_PREGUNTA_NO_A .': ' . $_POST['PREGUNTA_NO_A'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_A'])) {
			} elseif ($_POST['PREGUNTA_NO_A'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_A .': ' . $_POST['PREGUNTA_NO_A'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_A_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_A_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_B'] == "No"){
				$text .= TPL_PREGUNTA_NO_B .': ' . $_POST['PREGUNTA_NO_B'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_B'])) {
			} elseif ($_POST['PREGUNTA_NO_B'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_B .': ' . $_POST['PREGUNTA_NO_B'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_B_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_B_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_C'] == "No"){
				$text .= TPL_PREGUNTA_NO_C .': ' . $_POST['PREGUNTA_NO_C'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_C'])) {
			} elseif ($_POST['PREGUNTA_NO_C'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_C .': ' . $_POST['PREGUNTA_NO_C'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_C_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_C_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_D'] == "No"){
				$text .= TPL_PREGUNTA_NO_D .': ' . $_POST['PREGUNTA_NO_D'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_D'])) {
			} elseif ($_POST['PREGUNTA_NO_D'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_D .': ' . $_POST['PREGUNTA_NO_D'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_D_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_D_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_E'] == "No"){
				$text .= TPL_PREGUNTA_NO_E .': ' . $_POST['PREGUNTA_NO_E'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_E'])) {
			} elseif ($_POST['PREGUNTA_NO_E'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_E .': ' . $_POST['PREGUNTA_NO_E'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_E_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_E_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_F'] == "No"){
				$text .= TPL_PREGUNTA_NO_F .': ' . $_POST['PREGUNTA_NO_F'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_F'])) {
			} elseif ($_POST['PREGUNTA_NO_F'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_F .': ' . $_POST['PREGUNTA_NO_F'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_F_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_F_IN'] . '<br />';
				}
			}
			if ($_POST['PREGUNTA_NO_G'] == "No"){
				$text .= TPL_PREGUNTA_NO_G .': ' . $_POST['PREGUNTA_NO_G'] . '<br />';
			} elseif (empty($_POST['PREGUNTA_NO_G'])) {
			} elseif ($_POST['PREGUNTA_NO_G'] == "Sí"){
				$text .= TPL_PREGUNTA_NO_G .': ' . $_POST['PREGUNTA_NO_G'] . '<br />';
				if (!empty($_POST['PREGUNTA_NO_G_IN'])){
					$text .= TPL_PREGUNTA_SI .': ' . $_POST['PREGUNTA_NO_G_IN'] . '<br />';
				}
			}
			if (!empty($_POST['PREGUNTA_NO_H'])){
				$text .= TPL_PREGUNTA_NO_H .': ' . $_POST['PREGUNTA_NO_H'] . '<br />';
			}
			if (!empty($_POST['PREGUNTA_NO_I'])){
				$text .= TPL_PREGUNTA_NO_I .': ' . $_POST['PREGUNTA_NO_I'] . '<br />';
			}
			if (!empty($_POST['TEXTAREA_NO'])){
				$text .= TPL_PREGUNTA_NO_J .': ' . $_POST['TEXTAREA_NO'] . '<br />';
			}
		}
		
		$ca_email->set_tag_replacement( "[FECHA_ENVIO]", date("d/m/Y H:i:s"));
		$ca_email->set_tag_replacement( "[RESPUESTAS]", $text);
		
		$ca_email->isHTML = true; // Manda el mail en texto html
		$res = $ca_email->send_pear();	//verificar si hubo exito
		$owner = owner_to_ownerid();
		
		$smarty->assign('sms', true);
	}else{
		$smarty->assign('consulta_ko', true);
	}
}else{
	$smarty->assign('encuesta', true);
	$smarty->assign('WFORMS', true);
}
?>
