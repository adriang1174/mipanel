<?
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class CSV
{
    
    function generarCSV($header,$data) 
    {
        $csv='';
        $aux=array(); 
        foreach($header as $element)
        {
            array_push($aux,'"'.$element.'"');
        }
        $csv.=join(',',$aux)."\n";
        foreach ($data as $linea)
        {
            $aux=array();
            for($i=0;$i<count($header);$i++)
            {
                array_push($aux,'"'.$linea[$i].'"');
            }
            $csv.=join(',',$aux)."\n";
        }
        return $csv;
    }
}
?>
