<?      
class Validator
{
	function email($data,$max,$min)
        {
                if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
        function char($data,$max,$min)
        {
                if (ereg('^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$', $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
        function alphanum($data,$max,$min)
        {
                if (ereg('^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 \-]+$', $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
        function numeric($data,$max,$min)
        {
                if (ereg('^[0-9]', $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
	function phone($data,$max,$min)
	{
		if (ereg('^[0-9\ \-]+$', $data)){
			if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
			else {return 0;}
		}
		else {return 0;}
	}
        function password($data,$max,$min)
        {
                if (ereg('^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 \-]+$', $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
	function custom($data,$re,$max,$min)
        {
                if (ereg($re, $data)){
                        if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
                        else {return 0;}
                }
                else {return 0;}
        }
	function texto($data,$max,$min)
	{
	        if (ereg("^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 \:\-\.\,\;\!\?\¿\¡\t\n\r\f\v\s]+$", $data)){
			if ($min <= strlen($data) && strlen($data) <= $max){return 1;}
			else {return 0;}
		}
		else {return 0;}                                                                                
	}
}
?>
