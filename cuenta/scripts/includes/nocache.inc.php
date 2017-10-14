<?php
    header("Expires: Mon, 01 Jul 2000 05:00:00 GMT");              ## Date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); ## always modified
    header("Cache-Control: no-cache, must-revalidate");            ## HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");                                    ## HTTP/1.0
    
?>
