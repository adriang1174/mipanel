<?php

$tmpfile = tempnam("dummy","");
$path = dirname($tmpfile);
echo $path;
unlink($tmpfile);
?>
