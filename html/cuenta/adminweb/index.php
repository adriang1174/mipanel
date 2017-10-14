<?php
session_start();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" >
<html>
<head>
<title>Mi Panel - Administracion</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	function goBack() {
		var idStep = document.getElementById('step');
		idStep.value = idStep.value - 2;
		document.getElementById('formulario').action="index.php";
		document.getElementById('formulario').submit();
	}
	function restart() {
		var idStep = document.getElementById('step');
		idStep.value = 0;
		document.getElementById('formulario').action="index.php";
		document.getElementById('formulario').submit();
	}
</script>
</head>
<body>
<div id="pagewidth" >
	<div id="header" >Configuracion Mi Panel</div>
			<div id="wrapper" class="clearfix" > 
			<div id="maincol" > 
			<?php
				switch($_POST['step']){
					case 1:
						require('step1.inc.php');
					break;
					case 2:
						require('step2.inc.php');
					break;
					case 3:
						require('step3.inc.php');
					break;
					case 4:
						require('step4.inc.php');
					break;
					default:
						require('step0.inc.php');
					break;
				
				}
			
			?>
			</div>
</div>
</div>
</body>
</html>
<?php
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
?>