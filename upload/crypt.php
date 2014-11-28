<?php

	
	$str = $_GET['str'];
	$salt = '3bb580c8e8a0ac593eb524387c0ce949';
	$session_crypt = json_encode(crypt($str, $salt));
	// echo $session_crypt;
	
	echo $_GET['callback'] . '(' . "{'session_crypt' : '" .$session_crypt. "'}" . ')';
	
?>
