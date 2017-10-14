<?

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
		
		
		$owner = owner_to_ownerid();

		if($owner != 6 && $owner != 4){
			$productos = array(
								array('id' =>'plateada', 'nombre' => "Tarjeta plateada")
								);
	
		}
	
	
		if(!isset($_GET['producto'])){
			$smarty->assign('show_select', true);
			$smarty->assign('productos', $productos);
		}else{
			$existe = false;
			foreach($productos as $producto){
				if($producto['id'] == $_GET['producto']){
					$existe = true;
				}
			}
			
			if(!$existe){
				header("location: instructions.ca");
				exit;
			}
			
			require_once(INCLUDE_PATH .'nusoap/nusoap.php');
			
			//$soapclient = new soapclient2('https://zonasegura.grupoalternativa.com/services/index.php');
			$soapclient = new soapclient2('https://webseg.alternativa.com.ar/services/index.php');
			if (!$soapclient->getError()) {
				// obtengo un token
				$token = $soapclient->call('core_auth', 
					array(
						'username'=>'test',
						'password'=>'test123'
					));
			}
			
		
		
			if (!$soapclient->fault && !$soapclient->getError()) {
				if($owner == 7){
					$result = $soapclient->call('servicios_listaNroAccTLLInternacional_T2', array('token'=>$token, 'tipo' => 'RESIDENCIAL'));
					
				}else{
					$result = $soapclient->call('servicios_listaNroAccTLLInternacional', array('token'=>$token));
				}
			}
			if(count($result) > 0){   
				/*
				echo "<pre>";
				print_r($result);
				echo "</pre>";
				*/
				$arr_paises = array();
				$arr_numeros = array();
				foreach($result as $pais){
					if($owner == 7){
						if(!in_array(utf8_decode($pais['pais']), $arr_paises)){
							$arr_paises[] = utf8_decode($pais['pais']);
						}
						$arr_numeros[] = array( 'nombre' => utf8_decode($pais['pais']), 'nroAccTLLInternacional' => utf8_decode($pais['numAcceso']), 'cargoAcceso' => 'USD '. $pais['cargo'], 'codigoAcceso' => $pais['numSAC'] );
					}else{
						if(!in_array($pais['nombre'], $arr_paises)){
							$arr_paises[] = $pais['nombre'];
						}
						$arr_numeros[] = array( 'nombre' => $pais['nombre'], 'nroAccTLLInternacional' => $pais['nroAccTLLInternacional'], 'cargoAcceso' => $pais['cargoAcceso'], 'codigoAcceso' => $pais['codigoAcceso']);
					}
					
				}
				
				$smarty->assign('numeros_acceso', $arr_numeros);
				$smarty->assign('paises_acceso', $arr_paises);
			}	 
			
			$smarty->assign('producto', $_GET['producto']);
		}
		
		return true;
	}
}

?>
