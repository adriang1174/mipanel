<style type="text/css">

	th {cursor: pointer}
	.table1 td {cursor: pointer; width: 32px; text-align:center;}
	td.footer {width: 100%;}
	td.conBorde {width: 30px; border: 2px solid black;}
	td.noseleccionado {width: 30px; border: 2px solid #cccccc;}
	.tdTop {border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;}
	.tdTopLeft {border: 1px solid black; }
	.tdLeft{border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;}
	.tdInterno {border-bottom: 1px solid black; border-right: 1px solid black;}
	.tdInternoHeader {border-bottom: 1px solid black; border-right: 1px solid black;}
	.tdLeftHeader{border-bottom: 1px solid black; border-right: 1px solid black; border-left: 1px solid black;}
	.tdInternoTopHeader {border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;}
	.tdLeftTopHeader {border: 1px solid black;}
</style>
<script type="text/javascript">

var selColor = 'lightsteelblue';

function setValues() {
         document.getElementById('colortable').rows[0].cells[0].className = 'conBorde';
}
</script>

<script type="text/javascript">

function colorSelector(elColor) {
	switch(elColor) {
   		case 'lightsteelblue': if(document.getElementById('mat').t1.value == '') {alert('Debe asignar un número válido'); return(0);} else {break;}
  		case 'palevioletred': if(document.getElementById('mat').t2.value == '') {alert('Debe asignar un número válido'); return(0)} else {break;};
   		case 'wheat': if(document.getElementById('mat').t3.value == '') {alert('Debe asignar un número válido'); return(0)} else {break;};
   		case 'darkorange': if(document.getElementById('mat').t4.value == '') {alert('Debe asignar un número válido'); return(0)} else {break;};
   		case 'lemonchiffon': if(document.getElementById('mat').t5.value == '') {alert('Debe asignar un número válido'); return(0)} else {break;};
	}
	document.getElementById('colortable').rows[0].cells[0].className = 'noseleccionado';
	document.getElementById('colortable').rows[0].cells[2].className = 'noseleccionado';
	document.getElementById('colortable').rows[0].cells[4].className = 'noseleccionado';
	document.getElementById('colortable').rows[0].cells[6].className = 'noseleccionado';
	document.getElementById('colortable').rows[0].cells[8].className = 'noseleccionado';
	<!--{if $service_name == "followme"}-->
		document.getElementById('colortable').rows[1].cells[5].className = 'noseleccionado';
		document.getElementById('colortable').rows[0].cells[10].className = 'noseleccionado';	
		<!--{if $show_netfono}-->
			document.getElementById('colortable').rows[1].cells[4].className = 'noseleccionado';
		<!--{/if}-->	
    <!--{/if}-->

	switch(elColor) {
   		case 'lightsteelblue': document.getElementById('colortable').rows[0].cells[0].className = 'conBorde'; selColor = 'lightsteelblue'; break;
   		case 'palevioletred': document.getElementById('colortable').rows[0].cells[2].className = 'conBorde'; selColor = 'palevioletred'; break;
   		case 'wheat': document.getElementById('colortable').rows[0].cells[4].className = 'conBorde'; selColor = 'wheat'; break;
   		case 'darkorange': document.getElementById('colortable').rows[0].cells[6].className = 'conBorde'; selColor = 'darkorange'; break;
   		case 'lemonchiffon': document.getElementById('colortable').rows[0].cells[8].className = 'conBorde'; selColor = 'lemonchiffon'; break;
   		case 'blue': document.getElementById('colortable').rows[0].cells[10].className = 'conBorde'; selColor = 'blue'; break;
   		case 'black': document.getElementById('colortable').rows[0].cells[12].className = 'conBorde'; selColor = 'black'; break;
		<!--{if $show_netfono}-->
   		case 'red': document.getElementById('colortable').rows[1].cells[4].className = 'conBorde'; selColor = 'red'; 
		<!--{else}-->
   		case 'red': document.getElementById('colortable').rows[1].cells[5].className = 'conBorde'; selColor = 'red'; 		
		<!--{/if}-->
		break;
	}
}

function selectFullDay(cual) {
	if (cual <=7) {
		i = cual + 2;
	}
	else {
		i = cual + 5;
	}
	for (j=1; j < document.getElementById('table1').rows[i].cells.length; j++) {
		document.getElementById('table1').rows[i].cells[j].style.backgroundColor = selColor;
    }
}

function selectHalfDay(cual) {
	if (cual == 'M') {
		ini = 3;
	}
	else {
		ini = 13;
	}
    for (i=ini; i < ini + 7; i++) {
        for (j=1; j < document.getElementById('table1').rows[i].cells.length; j++) {
			document.getElementById('table1').rows[i].cells[j].style.backgroundColor = selColor;
		}
    }
}

function selectFullHour(col) {
	if (col <= 11) {
		ini = 3;
	}
	else {
		ini = 13;
		col = col - 12;
	}
    for (i=ini; i < ini + 7; i++) {
		document.getElementById('table1').rows[i].cells[col * 2 + 1].style.backgroundColor = selColor;
		document.getElementById('table1').rows[i].cells[col * 2 + 2].style.backgroundColor = selColor;
    }
}

function selectHalfHour(col) {
	if (col <= 24) {
		ini = 3;
	}
	else {
		ini = 13;
		col = col - 24;
	}
    for (i=ini; i < ini + 7; i++) {
		document.getElementById('table1').rows[i].cells[col].style.backgroundColor = selColor;
    }
}

function generarCD() {
	var tmpData = '';

    for (i=3; i < document.getElementById('table1').rows.length; i++) {
        for (j=1; j < document.getElementById('table1').rows[i].cells.length; j++) {
        	if (i == 10 || i == 11 || i == 12) break;
        	//alert(document.getElementById('table1').rows[i].cells[j].style.backgroundColor);
            switch(document.getElementById('table1').rows[i].cells[j].style.backgroundColor) {
            	case 'red': tmpData += 'B'; break;
            	case 'blue': tmpData += 'H'; break;
            	case 'black': tmpData += 'N'; break;
            	
            	case 'lightsteelblue': tmpData += '1'; break;
            	case 'rgb(176, 196, 222)': tmpData += '1'; break;
            	
            	case 'palevioletred': tmpData += '2'; break;
            	case 'rgb(216, 112, 147)': tmpData += '2'; break;
            	
            	case 'wheat': tmpData += '3'; break;
            	case 'rgb(245, 222, 179)': tmpData += '3'; break; 
            	
            	case 'darkorange': tmpData += '4'; break;
            	case 'rgb(255, 140, 0)': tmpData += '4'; break;
            	
            	
            	case 'lemonchiffon': tmpData += '5'; break;
            	case 'rgb(255, 250, 205)': tmpData += '5'; break;
            	
            	default: tmpData += 'B'; break;
            }
        }
    }
    document.getElementById('mat_horaria').value = tmpData;
    //alert(tmpData);
    //return false;
    return(true);
}


function mostrarCD(campoDatos) {
	var cont = 0;
    for (i=3; i < document.getElementById('table1').rows.length; i++) {
        for (j=1; j < document.getElementById('table1').rows[i].cells.length; j++) {
        	if (i == 10 || i == 11 || i == 12) break;
            switch(campoDatos.slice(cont, cont + 1)) {   
				<!--{if $service_name == "followme"}-->
		            case 'H': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'blue'; break;
	 	           	case 'N': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'black'; break;
			    <!--{/if}-->
			 
            	case 'B': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'red'; break;
            	case '1': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'lightsteelblue'; break;
            	case '2': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'palevioletred'; break;
            	case '3': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'wheat'; break;
            	case '4': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'darkorange'; break;
            	case '5': document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'lemonchiffon'; break;
            	default: document.getElementById('table1').rows[i].cells[j].style.backgroundColor = 'red'; break;
            }
        	cont++
        }
    }
}

function openPopup(){
	var w = window.screen.width;
	var h = window.screen.height;
	var popW = 500, popH = 400;
	var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	window.open('conf_services_popup.ca?popup=1&accion=ofg2_grid_help','popup_help','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);

}
</script>



<table border="0" cellspacing="0" cellpadding="0" width="100%" style="cursor:default">
<tr style="height: 25px;"><td style="cursor: default;" class="scr_header_popup"><!--{$TITLE}--></td></tr>
<tr style="height: 5px; cursor: default;"><td>&nbsp;</td></tr>
<tr><td align="left" style="padding:10px; text-align: left; cursor:default"><!--{$HELP_TEXT}--></td></tr>
<!--{if ($SHOW_HELP_LINK) }-->
<tr><td align="center" style="padding:5px; text-align: center;; cursor:default"><span class="scr_header" style="padding: 5px;" onmouseover="this.style.cursor='pointer';" onclick="openPopup();">&nbsp;Ver pasos para configurar su grilla&nbsp;</span></td></tr>
<!--{/if}-->

    <tr><td style="padding-top: 10px; cursor: default; ">

<form name="mat" id="mat" method="post" action="" onsubmit="return generarCD();" style="cursor:default">




<table id="colortable" align="center" style='margin: 0 auto; background-color: #cccccc; border: 1px solid black' CELLSPACING="0" CELLPADDING="0">
	<tr>
		<td bgcolor=lightsteelblue onclick="colorSelector('lightsteelblue')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>		<td><INPUT maxlength="20" size="18" class=input2D type="text" id="t1" name="t1" value="<!--{if $service_name == "followme"}--><!--{$grid[0].DestinoCF1|trim}--><!--{$grid[0].t1|trim}--><!--{else}--><!--{$grid[0].DestinoCBK1|trim}--><!--{/if}-->"></td>
		<td bgcolor=palevioletred onclick="colorSelector('palevioletred')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td><INPUT maxlength="20" size="18" class=input2D type="text" id="t2" name="t2" value="<!--{if $service_name == "followme"}--><!--{$grid[0].DestinoCF2|trim}--><!--{$grid[0].t2|trim}--><!--{else}--><!--{$grid[0].DestinoCBK2|trim}--><!--{/if}-->"></td>
		<td bgcolor=wheat onclick="colorSelector('wheat')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td><INPUT maxlength="20" size="18" class=input2D type="text" id="t3" name="t3" value="<!--{if $service_name == "followme"}--><!--{$grid[0].DestinoCF3|trim}--><!--{$grid[0].t3|trim}--><!--{else}--><!--{$grid[0].DestinoCBK3|trim}--><!--{/if}-->"></td>
		<td bgcolor=darkorange onclick="colorSelector('darkorange')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td><INPUT maxlength="20" size="18" class=input2D type="text" id="t4" name="t4" value="<!--{if $service_name == "followme"}--><!--{$grid[0].DestinoCF4|trim}--><!--{$grid[0].t4|trim}--><!--{else}--><!--{$grid[0].DestinoCBK4|trim}--><!--{/if}-->"></td>
		<td bgcolor=lemonchiffon onclick="colorSelector('lemonchiffon')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td><INPUT maxlength="20" size="18" class=input2D type="text" id="t5" name="t5" value="<!--{if $service_name == "followme"}--><!--{$grid[0].DestinoCF5|trim}--><!--{$grid[0].t5|trim}--><!--{else}--><!--{$grid[0].DestinoCBK5|trim}--><!--{/if}-->"></td>
	
	<!--{if $service_name == "followme"}-->
		<td bgcolor=blue onclick="colorSelector('blue')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td>Contestador</td>
		<!--{if $show_netfono}-->
		<td bgcolor=black onclick="colorSelector('black')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td>NetFono</td>
		<!--{/if}-->
    <!--{/if}-->	

	</tr>
	<tr>
		<td colspan="2" align="center"><b>Derivaci&oacute;n 1</b></td>
		<td colspan="2" align="center"><b>Derivaci&oacute;n 2</b></td>
		<td colspan="2" align="center"><b>Derivaci&oacute;n 3</b></td>
		<td colspan="2" align="center"><b>Derivaci&oacute;n 4</b></td>
		<td colspan="2" align="center"><b>Derivaci&oacute;n 5</b></td>
	    <!--{if $service_name == "followme"}-->
		<td bgcolor="red" onclick="colorSelector('red')" class="noseleccionado" style="cursor: pointer">&nbsp;</td>
		<td>Bloqueado</td>
	<!--{/if}-->	
	</tr>
</table>


<hr size=1>



<!-- ******************************************************* -->

<table border="0" cellspacing="0" id="table1" align="center" class="table1" style='margin: 0 auto; background-color: #cccccc; border: 2px solid black; '>
	<tr height="10">
		<th colspan=48 onclick="selectHalfDay('M')" class="scr_header" style="font-size: 13px;cursor: default;">Mañana</th>
	</tr>
	<tr>
		<th rowspan=2><font size="2">&nbsp;</font></th>
		<th colspan=2 onclick="selectFullHour(0)" class="tdLeftTopHeader"><font size="2">0 hs</font></th>
		<th colspan=2 onclick="selectFullHour(1)" class="tdInternoTopHeader"><font size="2">1 hs</font></th>
		<th colspan=2 onclick="selectFullHour(2)" class="tdInternoTopHeader"><font size="2">2 hs</font></th>
		<th colspan=2 onclick="selectFullHour(3)" class="tdInternoTopHeader"><font size="2">3 hs</font></th>
		<th colspan=2 onclick="selectFullHour(4)" class="tdInternoTopHeader"><font size="2">4 hs</font></th>
		<th colspan=2 onclick="selectFullHour(5)" class="tdInternoTopHeader"><font size="2">5 hs</font></th>
		<th colspan=2 onclick="selectFullHour(6)" class="tdInternoTopHeader"><font size="2">6 hs</font></th>
		<th colspan=2 onclick="selectFullHour(7)" class="tdInternoTopHeader"><font size="2">7 hs</font></th>
		<th colspan=2 onclick="selectFullHour(8)" class="tdInternoTopHeader"><font size="2">8 hs</font></th>
		<th colspan=2 onclick="selectFullHour(9)" class="tdInternoTopHeader"><font size="2">9 hs</font></th>
		<th colspan=2 onclick="selectFullHour(10)" class="tdInternoTopHeader"><font size="2">10 hs</font></th>
		<th colspan=2 onclick="selectFullHour(11)" class="tdInternoTopHeader"><font size="2">11 hs</font></th>
	</tr>
	<tr height=10 bgcolor=gainsboro>
		<td onclick="selectHalfHour(1)" class="tdLeftHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(2)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(3)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(4)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(5)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(6)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(7)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(8)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(9)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(10)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(11)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(12)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(13)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(14)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(15)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(16)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(17)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(18)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(19)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(20)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(21)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(22)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(23)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(24)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(1)" class="tdTop"><font size="2">Do</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(2)" class="tdInterno"><font size="2">Lu</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(3)" class="tdInterno"><font size="2">Ma</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(4)" class="tdInterno"><font size="2">Mi</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(5)" class="tdInterno"><font size="2">Ju</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(6)" class="tdInterno"><font size="2">Vi</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(7)" class="tdInterno"><font size="2">Sa</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>

		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th colspan=48 onclick="selectHalfDay('T')" class="scr_header" style="font-size: 13px;cursor: default;">Tarde</th>
	</tr>
	<tr>
		<th rowspan=2><font size="2">&nbsp;</font></th>
		<th colspan=2 onclick="selectFullHour(12)" class="tdLeftTopHeader"><font size="2">12 hs</font></th>
		<th colspan=2 onclick="selectFullHour(13)" class="tdInternoTopHeader"><font size="2">13 hs</font></th>
		<th colspan=2 onclick="selectFullHour(14)" class="tdInternoTopHeader"><font size="2">14 hs</font></th>
		<th colspan=2 onclick="selectFullHour(15)" class="tdInternoTopHeader"><font size="2">15 hs</font></th>
		<th colspan=2 onclick="selectFullHour(16)" class="tdInternoTopHeader"><font size="2">16 hs</font></th>
		<th colspan=2 onclick="selectFullHour(17)" class="tdInternoTopHeader"><font size="2">17 hs</font></th>
		<th colspan=2 onclick="selectFullHour(18)" class="tdInternoTopHeader"><font size="2">18 hs</font></th>
		<th colspan=2 onclick="selectFullHour(19)" class="tdInternoTopHeader"><font size="2">19 hs</font></th>
		<th colspan=2 onclick="selectFullHour(20)" class="tdInternoTopHeader"><font size="2">20 hs</font></th>
		<th colspan=2 onclick="selectFullHour(21)" class="tdInternoTopHeader"><font size="2">21 hs</font></th>
		<th colspan=2 onclick="selectFullHour(22)" class="tdInternoTopHeader"><font size="2">22 hs</font></th>
		<th colspan=2 onclick="selectFullHour(23)" class="tdInternoTopHeader"><font size="2">23 hs</font></th>
	</tr>
	<tr height=10 bgcolor=gainsboro>
		<td onclick="selectHalfHour(25)" class="tdLeftHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(26)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(27)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(28)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(29)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(30)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(31)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(32)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(33)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(34)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(35)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(36)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(37)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(38)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(39)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(40)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(41)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(42)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(43)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(44)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(45)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(46)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
		<td onclick="selectHalfHour(47)" class="tdInternoHeader"><font style="font-size: 10px">0/30</font></td>
		<td onclick="selectHalfHour(48)" class="tdInternoHeader"><font style="font-size: 10px">30/60</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(8)" class="tdTop"><font size="2">Do</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(9)" class="tdInterno"><font size="2">Lu</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(10)" class="tdInterno"><font size="2">Ma</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(11)" class="tdInterno"><font size="2">Mi</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(12)" class="tdInterno"><font size="2">Ju</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(13)" class="tdInterno"><font size="2">Vi</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
	<tr height=10>
		<th onclick="selectFullDay(14)" class="tdInterno"><font size="2">Sa</font></th>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
		<td onclick="this.style.backgroundColor=selColor;" class="tdInterno"><font size="2">&nbsp;</font></td>
	</tr>
</table>

<hr size=1>
	<div align="center" style="cursor: default;">
	<INPUT type="hidden" id="mat_horaria" name="mat_horaria">
	<input type="hidden" name="process" value="1" />
	<input type="image" src="<!--{ipath name="bt-cancelar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=CANCEL}-->" onclick="window.close(); return false;"/>
	
	
	<input type="image" src="<!--{ipath name="bt-aceptar.gif" lang="1" owner="1"}-->" alt="<!--{lang k=ACCEPT}-->" onclick="generarCD();"/>
	</div>




<script type="text/javascript">
        mostrarCD('<!--{if $service_name == "followme"}--><!--{$grid[0].MatrizHorariaFM}--><!--{$grid[0].mat_horaria}--><!--{else}--><!--{$grid[0].MatrizHorariaCBK}--><!--{/if}-->');


</script>








  
</table>
