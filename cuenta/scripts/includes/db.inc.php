<?
class Db
{

	/* Convención de salida:

		 Valores específicos de salida para errores:
		 	
			-1 : Falló conexión a la base	
			 0 : Falló consulta o ejecución
			-2 : No se especificó consulta o línea de ejecución

		 Estructura de Error:

		 	Si la respuesta normal de la rutina es un escalar, el error se presentará como
			segundo elemento de un array.
			Si la respuesta normal de la rutina es un array, el error se presentará como
			escalar
			En métodos de ejecución, que hagan updates, inserts o deletes se especificará como
			escalares, excepto que se aclare lo contrario en la decalración de la función.

			Excepciones:
			--

	*/
		

	function dbConnect()
	{
		$db = &ADONewConnection('postgres');
		$db->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$db->debug = false;
		return $db;
	}
	
	######################################################################################################################

	function getSingleValue($query='',$valores=array())
	{
		if($query)
		{
			$db=$this->dbConnect();
			if($db)
			{
				//hago la consulta
				$result=$db->execute($query,$valores);
				if($result)
				{
					$row=$result->FetchRow();
					$db->close();
					return $row[0];
				}
				else
				{
					$db->close();
					return array(-1,0);	// cómo espero un valor simple en el error devuelvo un array
				}
			}
			else
			{
				return array(-1,-1); // cómo espero un valor simple en el error devuelvo un array
			}
		}
		else
		{
			return array(-1,-2);	// cómo espero un valor simple en el error devuelvo un array
		}
	}

	######################################################################################################################
	
	function setSingleValue($query='',$valores=array()) //inserta o actualiza un valor específico
	{
		if($query)
		{
			$db=$this->dbConnect();
			if($db)
			{
				//hago la consulta
				if($db->execute($query,$valores))
				{
					$db->close();
					return 1;
				}
				else
				{
					$db->close();
					error_log("Fatal Error: No se pudo setear valor \n",0);
					return 0;
				}
			}
			else
			{
				return -1; 
			}
		}
		else
		{
			return -2; 
		}
	}

	######################################################################################################################

	function getMultiTuplasObject($query='',$valores=array(),$upper=false)
	{
		if($query)
		{
			$db=$this->dbConnect();
			if($db)
			{
				//hago la consulta
				
				$result=$db->execute($query,$valores);
				
				if($result)
				{
					$salida=array();
					while($o = $result->FetchNextObject($upper))
					{
						array_push($salida,$o);   //agrego la  info sobre el cliente en la lista de salida
					}
					$db->close();
					return $salida;
				}
				else
				{	
					error_log("Fatal Error: Error en la búsqueda \n",0);
					return 0;
				}
			}
			else
			{
				return -1;
			}
		}
		else
		{
			return -2;
		}
	}


	######################################################################################################################

	function getMultiTuplasAssoc($query='',$valores=array(),$upper=false)
	{                               
		if($query)                                              
		{                                                                       
			$db=$this->dbConnect();
			if($db) 
			{
				//hago la consulta
				$result=$db->execute($query,$valores);
				if($result)
				{
					$salida=array();                                                                
					while($assoc = $result->GetRowAssoc($upper))
					{                   
						array_push($salida,$assoc);   //agrego la  info sobre el cliente en la lista de salida
						$result->MoveNext();
					}                                                                                           
					$db->close();                                                                               
					return $salida;
				}                                                                                                   
				else
				{                                                                                                   
					$db->close();                                               
					error_log("Fatal Error: error en la búsqueda \n",0);
					return 0;
				}       
			}       
			else
			{
				return -1;
			}
		}
		else
		{
			return -2;
		}
	}
	

	######################################################################################################################

	function getMultiTuplas($query='',$valores=array())
	{
		if($query)
		{
			$db=$this->dbConnect();
			if($db)
			{
				//hago la consulta
				$result=$db->execute($query,$valores);
				if($result)
				{
					$salida=array();
					while($row=$result->FetchRow())
					{
						array_push($salida,$row);   //agrego la  info sobre el cliente en la lista de salida
					}
					$db->close();
					return $salida;
				}
				else
				{
					$db->close();
					error_log("Fatal Error: error en la busqueda \n",0);
					return 0;
				}
			}
			else
			{
				return -1;
			}
		}
		else
		{
			return -2;
		}
	}
}
?>
