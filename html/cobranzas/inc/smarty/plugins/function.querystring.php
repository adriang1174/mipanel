<?php

function smarty_function_querystring($params, &$smarty){
	echo Misc::getQueryString($params);
}


?>
