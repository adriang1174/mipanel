<?php

function smarty_function_urlsegura($params, &$smarty){
	echo Misc::_URLSegura($params['k']);
}


?>
