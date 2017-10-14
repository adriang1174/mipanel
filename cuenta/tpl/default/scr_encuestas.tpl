<script type="text/javascript">

// Por default valido los checks para primer respuesta SI
var validar = "validar_si";

// Reseteo respuestas y vuelve todo a cero
function formreset(){
	document.getElementById("encuesta").reset();  
	document.getElementById("todosi").style.display = "none";
	document.getElementById("respuesta_1_no").style.display = "none";
}

function validador(){
	var error = "Por favor complete todos campos...\n";
	var valida = true;
	// Valido campos para respuesta SI
	if (validar  == "validar_si") {
		if(!document.getElementById("respuesta_si_inicio").checked){
			valida = false;
		}
		if(!document.getElementById("respuesta_1_nolonecesito").checked && !document.getElementById("respuesta_1_2").checked && !document.getElementById("respuesta_1_3").checked){
			valida = false;
		}
		if(!document.getElementById("pregunta_2_si").checked && !document.getElementById("pregunta_2_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_2_si").checked){ 
			if(!document.getElementById("respuesta_2_1").checked && !document.getElementById("respuesta_2_2").checked && !document.getElementById("respuesta_2_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("pregunta_3_si").checked && !document.getElementById("pregunta_3_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_3_si").checked){
			if(!document.getElementById("respuesta_3_1").checked && !document.getElementById("respuesta_3_2").checked && !document.getElementById("respuesta_3_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("pregunta_4_si").checked && !document.getElementById("pregunta_4_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_4_si").checked){
			if(!document.getElementById("respuesta_4_1").checked && !document.getElementById("respuesta_4_2").checked && !document.getElementById("respuesta_4_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("pregunta_5_si").checked && !document.getElementById("pregunta_5_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_5_si").checked){
			if(!document.getElementById("respuesta_5_1").checked && !document.getElementById("respuesta_5_2").checked && !document.getElementById("respuesta_5_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("pregunta_6_si").checked && !document.getElementById("pregunta_6_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_6_si").checked){
			if(!document.getElementById("respuesta_6_1").checked && !document.getElementById("respuesta_6_2").checked && !document.getElementById("respuesta_6_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("pregunta_7_si").checked && !document.getElementById("pregunta_7_no").checked){
			valida = false;
		}
		if(document.getElementById("respuesta_1_nolonecesito").checked && document.getElementById("pregunta_7_si").checked){
			if(!document.getElementById("respuesta_7_1").checked && !document.getElementById("respuesta_7_2").checked && !document.getElementById("respuesta_7_3").checked){
				valida = false;
			}
		}
		if(!document.getElementById("respuesta_8_si").checked && !document.getElementById("respuesta_8_no").checked){
			valida = false;
		}
		if(!document.getElementById("respuesta_9_si").checked && !document.getElementById("respuesta_9_no").checked){
			valida = false;
		}
		if (!valida) {
			alert(error); // Si valida es false lanzo el error
			return false;
		} else {
			return true; // Si valida es true mando submit
		}
	} else {
		// Valido campos para respuesta NO
		if(!document.getElementById("respuesta_no_inicio").checked){
			valida = false;
		}
		if(!document.getElementById("pregunta_1_1no").checked && !document.getElementById("pregunta_1_2no").checked && !document.getElementById("pregunta_1_3no").checked && !document.getElementById("pregunta_1_4no").checked){
			valida = false;
		}
		if(!document.getElementById("pregunta_h_si").checked && !document.getElementById("pregunta_h_no").checked){
			valida = false;
		}
		if(!document.getElementById("pregunta_i_si").checked && !document.getElementById("pregunta_i_no").checked){
			valida = false;
		}
		
		if(!document.getElementById("ocultar_a").checked){
			if(!document.getElementById("pregunta_a_si").checked && !document.getElementById("pregunta_a_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_a_si").checked){
				if(!document.getElementById("pregunta_a_in_1").checked && !document.getElementById("pregunta_a_in_2").checked){
					valida = false;
				}
			}
		}
		if(!document.getElementById("ocultar_b").checked){
			if(!document.getElementById("pregunta_b_si").checked && !document.getElementById("pregunta_b_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_b_si").checked){
				if(!document.getElementById("pregunta_b_in_1").checked && !document.getElementById("pregunta_b_in_2").checked && !document.getElementById("pregunta_b_in_3").checked){
					valida = false;
				}
			}
		}
		if(!document.getElementById("ocultar_c").checked){
			if(!document.getElementById("pregunta_c_si").checked && !document.getElementById("pregunta_c_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_c_si").checked){
				if(!document.getElementById("pregunta_c_in_1").checked && !document.getElementById("pregunta_c_in_2").checked && !document.getElementById("pregunta_c_in_3").checked){
					valida = false;				}
			}
		}
		if(!document.getElementById("ocultar_d").checked){
			if(!document.getElementById("pregunta_d_si").checked && !document.getElementById("pregunta_d_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_d_si").checked){
				if(!document.getElementById("pregunta_d_in_1").checked && !document.getElementById("pregunta_d_in_2").checked && !document.getElementById("pregunta_d_in_3").checked){
					valida = false;
				}
			}
		}
		if(!document.getElementById("ocultar_e").checked){
			if(!document.getElementById("pregunta_e_si").checked && !document.getElementById("pregunta_e_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_e_si").checked){
				if(!document.getElementById("pregunta_e_in_1").checked && !document.getElementById("pregunta_e_in_2").checked && !document.getElementById("pregunta_e_in_3").checked){
					valida = false;
				}
			}
		}
		if(!document.getElementById("ocultar_f").checked){
			if(!document.getElementById("pregunta_f_si").checked && !document.getElementById("pregunta_f_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_f_si").checked){
				if(!document.getElementById("pregunta_f_in_1").checked && !document.getElementById("pregunta_f_in_2").checked && !document.getElementById("pregunta_f_in_3").checked){
					valida = false;
				}
			}
		}
		if(!document.getElementById("ocultar_g").checked){
			if(!document.getElementById("pregunta_g_si").checked && !document.getElementById("pregunta_g_no").checked){
				valida = false;
			}
			if(document.getElementById("pregunta_g_si").checked){
				if(!document.getElementById("pregunta_g_in_1").checked && !document.getElementById("pregunta_g_in_2").checked && !document.getElementById("pregunta_g_in_3").checked){
					valida = false;
				}
			}
		}
		if(!valida){
			alert(error);
			return false;
		}else{
			return true;
		}
	}
}

// MOSTRAR BLOQUES INICIO
function mostrarbloque(si){
	if(si){
		// Despliego preguntas si la primer respuesta es SI
		document.getElementById("todosi").style.display = "block";
		document.getElementById("respuesta_1_no").style.display = "none";
	}else{
		// Despliego preguntas si la primer respuesta es NO 
		document.getElementById("todosi").style.display = "none";
		document.getElementById("respuesta_1_no").style.display = "block";
		validar = "validar_no";  // Valido los checks para este bloque
	}
}

// Muestro preguntas segun las respuestas marcadas.
function actualizarsi(){

	// ############################################################
	// Cuando es SI
	// ############################################################
	
	nolonecesita = document.getElementById('respuesta_1_nolonecesito').checked;
	
	if(document.getElementById("pregunta_2_si").checked && nolonecesita){
		document.getElementById("respuesta_2_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_2_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_2_no").checked){
		document.getElementById("no_2").style.display = 'block';
	}else{
		document.getElementById("no_2").style.display = 'none';
	}
	if(document.getElementById("pregunta_3_si").checked && nolonecesita){
		document.getElementById("respuesta_3_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_3_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_3_no").checked){
		document.getElementById("no_3").style.display = 'block';
	}else{
		document.getElementById("no_3").style.display = 'none';
	}
	if(document.getElementById("pregunta_4_si").checked && nolonecesita){
		document.getElementById("respuesta_4_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_4_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_4_no").checked){
		document.getElementById("no_4").style.display = 'block';
	}else{
		document.getElementById("no_4").style.display = 'none';
	}
	if(document.getElementById("pregunta_5_si").checked && nolonecesita){
		document.getElementById("respuesta_5_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_5_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_5_no").checked){
		document.getElementById("no_5").style.display = 'block';
	}else{
		document.getElementById("no_5").style.display = 'none';
	}
	if(document.getElementById("pregunta_6_si").checked && nolonecesita){
		document.getElementById("respuesta_6_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_6_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_6_no").checked){
		document.getElementById("no_6").style.display = 'block';
	}else{
		document.getElementById("no_6").style.display = 'none';
	}
	if(document.getElementById("pregunta_7_si").checked && nolonecesita){
		document.getElementById("respuesta_7_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_7_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_7_no").checked){
		document.getElementById("no_7").style.display = 'block';
	}else{
		document.getElementById("no_7").style.display = 'none';
	}
	
	
	if(document.getElementById("pregunta_a_si").checked){
		document.getElementById("respuesta_a_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_a_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_a_no").checked){
		document.getElementById("no_a").style.display = 'block';
	}else{
		document.getElementById("no_a").style.display = 'none';
	}
	if(document.getElementById("pregunta_b_si").checked){
		document.getElementById("respuesta_b_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_b_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_b_no").checked){
		document.getElementById("no_b").style.display = 'block';
	}else{
		document.getElementById("no_b").style.display = 'none';
	}
	if(document.getElementById("pregunta_c_si").checked){
		document.getElementById("respuesta_c_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_c_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_c_no").checked){
		document.getElementById("no_c").style.display = 'block';
	}else{
		document.getElementById("no_c").style.display = 'none';
	}
	if(document.getElementById("pregunta_d_si").checked){
		document.getElementById("respuesta_d_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_d_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_d_no").checked){
		document.getElementById("no_d").style.display = 'block';
	}else{
		document.getElementById("no_d").style.display = 'none';
	}
	if(document.getElementById("pregunta_e_si").checked){
		document.getElementById("respuesta_e_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_e_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_e_no").checked){
		document.getElementById("no_e").style.display = 'block';
	}else{
		document.getElementById("no_e").style.display = 'none';
	}
	if(document.getElementById("pregunta_f_si").checked){
		document.getElementById("respuesta_f_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_f_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_f_no").checked){
		document.getElementById("no_f").style.display = 'block';
	}else{
		document.getElementById("no_f").style.display = 'none';
	}
	if(document.getElementById("pregunta_g_si").checked){
		document.getElementById("respuesta_g_in").style.display = 'block';
	}else{
		document.getElementById("respuesta_g_in").style.display = 'none';
	}
	if(document.getElementById("pregunta_g_no").checked){
		document.getElementById("no_g").style.display = 'block';
	}else{
		document.getElementById("no_g").style.display = 'none';
	}
	
	// ############################################################
	// Cuando es NO
	// ############################################################
	
	if(document.getElementById("ocultar_a").checked){
		document.getElementById("pregunta_a").style.display = 'none';
	}else{
		document.getElementById("pregunta_a").style.display = 'block';
	}
	if(document.getElementById("ocultar_b").checked){
		document.getElementById("pregunta_b").style.display = 'none';
	}else{
		document.getElementById("pregunta_b").style.display = 'block';
	}
	if(document.getElementById("ocultar_c").checked){
		document.getElementById("pregunta_c").style.display = 'none';
	}else{
		document.getElementById("pregunta_c").style.display = 'block';
	}
	if(document.getElementById("ocultar_d").checked){
		document.getElementById("pregunta_d").style.display = 'none';
	}else{
		document.getElementById("pregunta_d").style.display = 'block';
	}
	if(document.getElementById("ocultar_e").checked){
		document.getElementById("pregunta_e").style.display = 'none';
	}else{
		document.getElementById("pregunta_e").style.display = 'block';
	}
	if(document.getElementById("ocultar_f").checked){
		document.getElementById("pregunta_f").style.display = 'none';
	}else{
		document.getElementById("pregunta_f").style.display = 'block';
	}
	if(document.getElementById("ocultar_g").checked){
		document.getElementById("pregunta_g").style.display = 'none';
	}else{
		document.getElementById("pregunta_g").style.display = 'block';
	}
}
</script>

<table border="0" cellspacing="0" cellpadding="0" width="100%">

	<!--{if $yaencuestado >= 1}-->
    	<div class="mensaje">
            <p><!--{lang k=MJE_YAENCUESTADO}--></p>
        </div>
	<!--{else}-->
        <!--{if $encuesta}-->
        <form action="" name="encuesta" method="post" id="encuesta" onsubmit="return validador();">
        <tr style="height: 25px;">
            <td class="scr_header"><font class="scr_header"><!--{lang k=TITULO_ENCUESTA}--></font></td>
        </tr>
        
		 <!--{if $email_not_verif}-->
		 <tr>
         <td>
		<table border="0" cellspacing="0" cellpadding="0" class="info_table">
		    <tr><td style="padding: 5px;" class="ticket_row_title"><b><!--{lang k=ERR_EMAIL_NOT_VERIFIED}--></b></td></tr>
		    <tr><td align="center" style="padding: 5px;"><a href="email.ca" target="_self"><img src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" border="0" /></a>&nbsp;<a href="index.ca" target="_self"><img src="<!--{ipath name="bt-cancelar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=CANCEL}-->" border="0" /></a></td></tr>
		</table>
		</td>
		</tr>
		<!--{else}-->
        
        <tr>
            <td><!--{lang k=DESCRIPCION_ENCUESTA}--></td>
        </tr>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td style="padding-top: 20px;">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%x">
                        <tr valign="top">
                            <td nowrap="nowrap" class="scr_resalt" style="padding: 5px; border: 1px solid #7F7F7F; "><b><!--{lang k=PREGUNTA_1}--></b>:</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_1" id="respuesta_si_inicio" onclick="mostrarbloque(true);" /><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_1" id="respuesta_no_inicio" onclick="mostrarbloque(false);"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                            </td>
                        </tr>
                    </table>
                    <div id="todosi" style="display:none;">
                        <div id="respuesta_1_si">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px;">
                                <tr>
                                    <td style="padding-left: 5px; padding: 5px;">
                                        <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_1}--></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 20px;" align="left">
                                <input type="radio" value="<!--{lang k=OPCION_SI_1}-->" name="PREGUNTA_SI_1" id="respuesta_1_nolonecesito" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_1}--></font></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 20px;" align="left">
                                <input type="radio" value="<!--{lang k=OPCION_SI_2}-->" name="PREGUNTA_SI_1" id="respuesta_1_2" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_2}--></font></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 20px;" align="left">
                                <input type="radio" value="<!--{lang k=OPCION_SI_3}-->" name="PREGUNTA_SI_1" id="respuesta_1_3" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_3}--></font></td>
                                </tr>
                            </table>
                        </div>
                        <div id="respuesta_2">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_2}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_2" id="pregunta_2_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_2_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_1}-->" id="respuesta_2_1" name="PREGUNTA_SI_2_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_1}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_2_2" name="PREGUNTA_SI_2_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_6}-->" id="respuesta_2_3" name="PREGUNTA_SI_2_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_6}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_2" id="pregunta_2_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_2" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_2}--></p>
                        </div>
                        <div id="respuesta_3">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_3}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_3" id="pregunta_3_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                        <div id="respuesta_3_in" style="display:none;">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="respuesta_3_1" name="PREGUNTA_SI_3_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_3_2" name="PREGUNTA_SI_3_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_7}-->" id="respuesta_3_3" name="PREGUNTA_SI_3_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_7}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_3" id="pregunta_3_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_3" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_3}--></p>
                        </div>
                        <div id="respuesta_4">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_4}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_4" id="pregunta_4_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                        <div id="respuesta_4_in" style="display:none;">
                                            <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                                <tr valign="top">
                                                    <td style="padding-left: 5px; padding: 5px;">
                                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="respuesta_4_1" name="PREGUNTA_SI_4_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_4_2" name="PREGUNTA_SI_4_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_8}-->" id="respuesta_4_3" name="PREGUNTA_SI_4_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_8}--></font>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_4" id="pregunta_4_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_4" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_4}--></p>
                        </div>
                        <div id="respuesta_5">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_5}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_5" id="pregunta_5_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_5_in" style="display:none;">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="respuesta_5_1" name="PREGUNTA_SI_5_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_5_2" name="PREGUNTA_SI_5_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_9}-->" id="respuesta_5_3" name="PREGUNTA_SI_5_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_9}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_5" id="pregunta_5_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_5" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_5}--></p>
                        </div>
                        <div id="respuesta_6">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_6}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_6" id="pregunta_6_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                        <div id="respuesta_6_in" style="display:none;">
                                            <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                                <tr valign="top">
                                                    <td style="padding-left: 5px; padding: 5px;">
                                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="respuesta_6_1" name="PREGUNTA_SI_6_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_6_2" name="PREGUNTA_SI_6_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_10}-->" id="respuesta_6_3" name="PREGUNTA_SI_6_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_10}--></font>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_6" id="pregunta_6_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_6" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_6}--></p>
                        </div>
                        <div id="respuesta_7">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_7}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_SI_7" id="pregunta_7_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                        <div id="respuesta_7_in" style="display:none;">
                                            <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                                <tr valign="top">
                                                    <td style="padding-left: 5px; padding: 5px;">
                                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="respuesta_7_1" name="PREGUNTA_SI_7_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="respuesta_7_2" name="PREGUNTA_SI_7_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                                    <input type="radio" value="<!--{lang k=OPCION_SI_11}-->" id="respuesta_7_3" name="PREGUNTA_SI_7_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_11}--></font>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_SI_7" id="pregunta_7_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="no_7" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                            <p><!--{lang k=NO_PREGUNTA_7}--></p>
                        </div>
                        <div id="respuesta_8">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_8}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" id="respuesta_8_si" name="PREGUNTA_SI_8"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" id="respuesta_8_no" name="PREGUNTA_SI_8"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="respuesta_9">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI_9}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" id="respuesta_9_si" name="PREGUNTA_SI_9"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" id="respuesta_9_no" name="PREGUNTA_SI_9"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="respuesta_10">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=ULTIMA_SI}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <textarea name="TEXTAREA_SI" style="width:300px; height:70px; margin-left:10px;" cols="" rows=""></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="respuesta_1_no" style=" display:none;">
                        <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px;">
                            <tr>
                                <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_1}--></font>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=OPCION_NO_1}-->" id="pregunta_1_1no" name="PREGUNTA_NO_1"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_1}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=OPCION_NO_2}-->" id="pregunta_1_2no" name="PREGUNTA_NO_1"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_2}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=OPCION_NO_3}-->" id="pregunta_1_3no" name="PREGUNTA_NO_1"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_3}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="radio" value="<!--{lang k=OPCION_NO_4}-->" id="pregunta_1_4no" name="PREGUNTA_NO_1"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_4}--></font></td>
                            </tr>
                        </table>
                        <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top:10px;">
                            <tr>
                                <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_2}--></font>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_5}-->" name="PREGUNTA_NO_2[]" id="ocultar_a" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_5}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_6}-->" name="PREGUNTA_NO_2[]" id="ocultar_b" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_6}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_7}-->" name="PREGUNTA_NO_2[]" id="ocultar_c" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_7}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_8}-->" name="PREGUNTA_NO_2[]" id="ocultar_d" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_8}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_9}-->" name="PREGUNTA_NO_2[]" id="ocultar_e" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_9}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_10}-->" name="PREGUNTA_NO_2[]" id="ocultar_f" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_10}--></font></td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px;" align="left">
                            <input type="checkbox" value="<!--{lang k=OPCION_NO_11}-->" name="PREGUNTA_NO_2[]" id="ocultar_g" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_NO_11}--></font></td>
                            </tr>
                        </table>
                        <div id="pregunta_a">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_A}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_A" id="pregunta_a_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_a_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="pregunta_a_in_1" name="PREGUNTA_NO_A_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->"  id="pregunta_a_in_2" name="PREGUNTA_NO_A_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_A" id="pregunta_a_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_a" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_8}--></p>
                            </div>
                        </div>
                        <div id="pregunta_b">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_B}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_B" id="pregunta_b_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_b_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->"  id="pregunta_b_in_1" name="PREGUNTA_NO_B_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="pregunta_b_in_2" name="PREGUNTA_NO_B_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_6}-->" id="pregunta_b_in_3" name="PREGUNTA_NO_B_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_6}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_B" id="pregunta_b_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_b" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_9}--></p>
                            </div>
                        </div>
                        <div id="pregunta_c">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_C}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_C" id="pregunta_c_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_c_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="pregunta_c_in_1" name="PREGUNTA_NO_C_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="pregunta_c_in_2" name="PREGUNTA_NO_C_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_7}-->" id="pregunta_c_in_3" name="PREGUNTA_NO_C_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_7}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_C" id="pregunta_c_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_c" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_10}--></p>
                            </div>
                        </div>
                        <div id="pregunta_d">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_D}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_D" id="pregunta_d_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_d_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="pregunta_d_in_1" name="PREGUNTA_NO_D_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->"  id="pregunta_d_in_2" name="PREGUNTA_NO_D_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_8}-->"  id="pregunta_d_in_3" name="PREGUNTA_NO_D_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_8}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_D" id="pregunta_d_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_d" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_11}--></p>
                            </div>
                        </div>
                        <div id="pregunta_e">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_E}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_E" id="pregunta_e_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_e_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->"  id="pregunta_e_in_1" name="PREGUNTA_NO_E_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="pregunta_e_in_2" name="PREGUNTA_NO_E_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_9}-->" id="pregunta_e_in_3" name="PREGUNTA_NO_E_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_9}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_E" id="pregunta_e_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_e" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_12}--></p>
                            </div>
                        </div>
                        <div id="pregunta_f">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_F}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_F" id="pregunta_f_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_f_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="pregunta_f_in_1" name="PREGUNTA_NO_F_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="pregunta_f_in_2" name="PREGUNTA_NO_F_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_10}-->" id="pregunta_f_in_3" name="PREGUNTA_NO_F_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_10}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_F" id="pregunta_f_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_f" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_13}--></p>
                            </div>
                        </div>
                        <div id="pregunta_g">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_G}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" name="PREGUNTA_NO_G" id="pregunta_g_si" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    <div id="respuesta_g_in" style="display:none">
                                        <table border="0" cellspacing="0" cellpadding="0" width="400px" style="margin-left:50px; margin-top: 10px;">
                                            <tr valign="top">
                                                <td style="padding-left: 5px; padding: 5px;">
                                                <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_SI}--></font></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_4}-->" id="pregunta_g_in_1" name="PREGUNTA_NO_G_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_4}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_5}-->" id="pregunta_g_in_2" name="PREGUNTA_NO_G_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_5}--></font>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px;" align="left">
                                                <input type="radio" value="<!--{lang k=OPCION_SI_11}-->" id="pregunta_g_in_3" name="PREGUNTA_NO_G_IN"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=OPCION_SI_11}--></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" name="PREGUNTA_NO_G" id="pregunta_g_no" onclick="actualizarsi();"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                            <div id="no_g" style="display:none; margin-left: 50px; width:600px; margin-top: 10px;">
                                <p><!--{lang k=NO_PREGUNTA_14}--></p>
                            </div>
                        </div>
                        <div id="respuesta_h">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_H}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" id="pregunta_h_si" name="PREGUNTA_NO_H"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" id="pregunta_h_no" name="PREGUNTA_NO_H"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="respuesta_i">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_I}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=SI}-->" id="pregunta_i_si" name="PREGUNTA_NO_I"/><font style="position:relative; top: -3px;">&nbsp; <!--{lang k=SI}--></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <input type="radio" value="<!--{lang k=NO}-->" id="pregunta_i_no" name="PREGUNTA_NO_I"/><font style="position:relative; top: -3px;">&nbsp <!--{lang k=NO}--></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="respuesta_j">
                            <table border="0" cellspacing="0" cellpadding="0" width="600px" style="margin-left:50px; margin-top: 10px;">
                                <tr valign="top">
                                    <td style="padding-left: 5px; padding: 5px;">
                                    <font style=" font-weight:bold; color:#FF9900"><!--{lang k=PREGUNTA_NO_J}--></font></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 20px;" align="left">
                                    <textarea name="TEXTAREA_NO" style="width:300px; height:70px; margin-left:10px;" cols="" rows=""></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table style="margin-top:40px; margin-left:50px; width:400px">
                        <tr>
                            <td>
                                <input type="image" src="<!--{ipath name="bt-enviar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" />
                                <input type="image" src="<!--{ipath name="bt-borrar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" onclick="formreset(); return false"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--{/if}-->
            </form>
            <!--{/if}-->
            <!-- BEGIN MSG_CONTACTO_OK -->
            <!--{if $sms}-->
            <div class="mensaje">
                <p><!--{lang k=MJE_ENVIADO}--></p>
            </div>
            <!--{/if}-->
            <!-- END MSG_CONTACTO_OK -->
        <!--{/if}-->
    </table>
</table>
