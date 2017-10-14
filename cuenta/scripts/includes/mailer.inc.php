<?
class Mailer {
	
	var $mensaje;	//string - linea de mensaje que se quiere mostrar dentro del template
	var $datos;	//array asociativo con etiquetas : destinatario, nombre, apellido, ani, mail, remitente
	var $template;  //string con el contenido del archivo de template html
	var $imagenes;  //array con los nombres de los archivos de imágenes
	var $adjuntos;	//array con los de los archivos adjuntos 
	var $mem_att;	//array asociativo conteniendo las cadenas a attachear como archivos (name => ("content-type","content"))	
	var $plano;	//string con el contenido del archivo de template plano
	var $base;	//string con la ubicación absoluta de los archivos adjuntos y de imágenes
	var $img_sdir;  //string con la ruta del subdir de imagenes relativa a la base
			//(coincide con la ruta en el attr src del tag img)
	var $att_sdir;  //string con la ruta del subdir de attachment relativa a la base	
	var $subject;	//string con el asunto del mail
	var $cabeceras;	//variable con las cabeceras - generada después del prepare
	var $mail;	//variable con el contenido del mail
	var $SMTP; //variable con la ip del smtp
	
	var $debug;	//flag, determina si esta en modo de debug
    
    function Mailer($debug = false) {
    	
    	$this->debug = $debug;
    	
    }
    
	function init($data, $temp_html, $imgs, $adjuntos, $temp_plano, $base, 
			$img_sdir, $att_sdir, $str_att, $subject, $mensaje, $smtp, $bounce_mails_to) {
				
		if ($this->debug) {
        	echo "Mailer->init() modo DEBUG<br />\n";
        }
        
		$this->datos = $data;
		$this->mensaje = $mensaje;
		$this->template = join("", file("$base/$temp_html"));
		$this->plano = join("", file("$base/$temp_plano"));
		$this->adjuntos = $adjuntos;
		$this->subject = $subject;
		$this->base = $base;
		$this->imagenes = $imgs;
		$this->img_sdir = $img_sdir;
		$this->att_sdir = $att_sdir;
		$this->mem_att = $str_att;
		$this->SMTP = $smtp;
		$this->Bounce_Mails_To = $bounce_mails_to;
		
	}

	function send() {
		
		if ($this->debug) {
        	echo "Mailer->send() modo DEBUG<br />ENVIA MAIL A: ". $this->datos['destinatario'] ."\n";
        }
        
		$mail = new PHPMailer();
	
		foreach($this->imagenes as $image) {
	
			$imgFileName = $this->base . "/" . $this->img_sdir . "/" . $image;
			$cid = md5(uniqid(rand()));
			$mail->AddEmbeddedImage($imgFileName, $cid);
			$this->template=eregi_replace(("imgs/" . $image), ("cid:" . $cid), $this->template);
			
			if ($this->debug) {
				/*
				echo "-cid gen<br />" . $imgFileName . "<br />" . $cid . "<br />";
				echo "-busca: imgs/" . $image . "<br />";
				echo "-obs: ";
				if (file_exists($imgFileName)) {
					echo "la imagen existe<br />";
				} else {
					echo "la imagen NO existe en " . $imgFileName . "<br />";	
				}
				echo "<br />";
				*/
			}
			
			
		}	
		
		foreach($this->mem_att as $name => $spec) {
			
			$mail->AddStringAttachment($spec[1], $name);
			
		}
	
	
		$mail->From     = $this->datos['remitente'];
		$mail->FromName = $this->datos['nombre_remitente'];
		$mail->Sender   = $this->Bounce_Mails_To; 
		$mail->Host     = $this->SMTP;
		$mail->Mailer   = "smtp";
	
		$mail->Subject = $this->subject;
		$mail->Body    = $this->template;
		$mail->AltBody = $this->plano;
		
		//(!)para el desarrollo redireccion un eventual envio al cliente a mi mail
		$mail->AddAddress($this->datos['destinatario']);
		
		if ($this->debug) {
			/*
			echo "<hr />";
			echo $this->template;
			echo $this->plano;
			echo "<hr />";
			*/
		}
		
		$res = $mail->Send();
		if ($this->debug) {
			echo "\nERROR: ". $mail->ErrorInfo;
		}
		
		return $res;

	}

	function prepare() {
		
		if ($this->debug) {
        	echo "Mailer->prepare() modo DEBUG<br />\n";
        }
        
		foreach($this->datos as $clave => $valor) {
			$this->template=str_replace("<%$clave%>",$valor,$this->template);
		}
		$this->template=str_replace("<%mensaje%>",$this->mensaje,$this->template);
	
		$mensaje_plano=$this->mensaje;
		$mensaje_plano=eregi_replace("<br/*>","\n",$mensaje_plano);
		$mensaje_plano=eregi_replace("</*p/*>","\n",$mensaje_plano);
		$mensaje_plano=eregi_replace("</*[a-zA-Z \s \" \= \']+/*>","",$mensaje_plano);
		$mensaje_plano=html_entity_decode($mensaje_plano);
	

		foreach($this->datos as $clave => $valor) {
			$this->plano=str_replace("<%$clave%>",$valor,$this->plano);
		}
		
		$this->plano=str_replace("<%mensaje%>",$mensaje_plano,$this->plano);
		
	}

}
?>
