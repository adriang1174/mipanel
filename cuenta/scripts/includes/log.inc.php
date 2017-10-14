<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class Loger {
    
    var $log_file;      //string - contiene la ruta y el nombre del archivo de log
    var $log_app;       //string - contiene el nombre de la aplicación que está logeando
    var $advice_to;     //mail al que avisará si existen errores en el logeo
    var $advice_from;   //mail desde el que avisará si existen errores en el logeo
    var $log_text;
    
    var $debug;	//flag, determina si esta en modo de debug
    
    function Loger($debug = false) {
    	
    	$this->debug = $debug;
    	
    }
    
    function init($log_file, $log_app, $advise_to, $advise_from) {
    	
    	if ($this->debug) {
        	//echo "Loger->init() modo DEBUG<br />\n";
        	//echo "- log_file = " . $log_file . "<br />\n";
        }
        
    	//inicializa las variables de logeo
        $this->advice_to=$advise_to;
        $this->advice_from=$advise_from;
        $this->log_file=$log_file;
        $this->log_app=$log_app;
        $this->log_text = "";
     
        if(is_writable($this->log_file)) {
    
           return 1;   // correcto
        
        } else {
       
             if ($this->debug) {
             	echo "no se puede logear porque el archivo no existe o no tiene permisos de escritura<br />\n";
             	return 1;	//simula un correcto
             }
             
             mail($this->advise_to, $this->log_app." - Error", 
             	"[".$this->log_app."] No se puede logear (error de escritura)\n\nen: " . $this->log_file, 
             	"From: " . $this->advise_from . "\r\n"."Reply-To: " 
             	. $this->advise_from . "\r\n"."X-Mailer: PHP/" . phpversion());
             return 0;   // no se puede logear porque el archivo no existe o no tiene permisos de escritura
             
        }
    }

    function mkLog($message, $type) {
        
        if ($this->debug) {
        	//echo "Loger->mkLog() modo DEBUG<br />\n";
        	//echo "- type = " . $type . "; message = " . $message . "<br />\n";
        	return 1;
        }
        
        $error=0;
        $this->log_text .= "[".date("Y-m-d H:i:s")."] - $type - $message\n";
        $fp=fopen($this->log_file,'a+');
        if($fp) {
            if(!fwrite($fp,"[".date("Y-m-d H:i:s")."] - $type - $message\n")) {
                $error=1;
            }
            fclose($fp);
        } else {
            $error=1;
        }
        if($error) {
            mail($this->advise_to, $this->log_app . " - Error", "[" 
            	. $this->log_app."] Error al logear: \n\n$type:$message\n\nen: " . $this->log_file, 
            	"From: " . $this->advise_from . "\r\n"."Reply-To: " . $this->advise_from . "\r\n" 
            	. "X-Mailer: PHP/" . phpversion());
            return 0;
        } else {
            return 1;
        }
    }

    function sendLog($to) {
        
        if ($this->debug) {
        	//echo "- Loger->sendLog() modo DEBUG<br />\n";
        	//evitamos que se envie el mail
        	return 1;
        }
        
        mail($to, $this->log_app." - Informe de proceso", $this->log_text ,"From: ".$this->advise_from."\r\n"."Reply-To: ".$this->advise_from."\r\n"."X-Mailer: PHP/" . phpversion());
        return 1;
        
    }
    
}
?>
