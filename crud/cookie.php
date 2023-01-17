<?php

$cookie_name="sayantan";
$cookie_value="software engineer";
setcookie($cookie_name, $cookie_value, time()+(86400 * 30),"/");
if($cookie_name){
	echo "cookie_name=".$cookie_name." "."cookie_value=".$cookie_value;
}

?>