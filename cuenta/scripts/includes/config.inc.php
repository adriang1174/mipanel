<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// defino las constantes de configuración

// base de datos
 
//define('DB_HOST', 'localhost');
define('DB_HOST', 'db-mipanel.alternativa.com.ar');
define('DB_USER', 'site_cuenta');
define('DB_PASS', 'cuenta*111');
define('DB_NAME', 'ra_cuenta');

// formatos y representaciones

define('DATE_FORMAT',"'dd/MM/yyyy'");
define('MINLEN_PASSWD','6');
define('MAXLEN_PASSWD','10');
define('MAXLEN_EMAIL','50');
define('PATTERN_PASSWD','^[A-Za-z0-9./_!@#$%^&*-]+$');
define('DOLARES','USD');
define('PESOS','ARS');

// tipos

define('CLIENTE_FINAL','C');
define('AGENTE','A');

// interfaz y mercado
    
define('ENTORNO_RED','1');
define('ENTORNO_HOLA','2');

define('INTERFAZ_ENTORNO_RED','red');
define('INTERFAZ_ENTORNO_HOLA','hola');


class Config
{
    	
    function getValue($clave,$cliente_id='')
    {
        if ($cliente_id)
        {
            # Es variable de cliente
            $query = 'select valor from cliente_config where cliente_id = ? and clave = ?';
            $valores=array($cliente_id,$clave);
            $db_obj= new Db;
            return $db_obj->getSingleValue($query,$valores);
        }
        else 
        {
            # Es variable generica
            $query = 'select valor from config where clave = ?';
            $valores=array($clave);
            $db_obj= new Db;
            return $db_obj->getSingleValue($query,$valores);
        }
    }

    function setValue($clave,$valor='',$cliente_id='')
    {
        if (isset($cliente_id)) 
        {
            $qins = 'insert into cliente_config (cliente_id, clave, valor) values (?, ?, ?)';
            $qupd = 'update cliente_config set valor = ? where cliente_id = ? and clave = ?';
            $qsel = 'select count(*) from cliente_config where cliente_id = ? and clave = ?';
            $db_obj= new Db;
            $aux=array($cliente_id,$clave);
            $count = $db_obj->getSingleValue($qsel,$aux);
            if ($count > 0) 
            {
                $values=array($valor, $cliente_id, $clave);
                return $db_obj->setSingleValue($qupd, $values);
            } 
            else 
            {
                $values=array($cliente_id, $clave, $valor);
                return $db_obj->setSingleValue($qins, $values);
            }
        }
        else
        {
            $query = 'update config set valor = ? where clave = ?';
            $values=array($valor,$clave);
            $db_obj= new Db;
            return $db_obj->setSingleValue($query, $values);
        }
    }
}

?>
