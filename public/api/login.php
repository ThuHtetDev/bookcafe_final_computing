<?php

//die('access_denied');
	$result = array();
	$result = $_GET; // uid, email, name, profile
	$result['nickName'] = 'Mg Mg';
	$result['isAdmin'] = '0';
	$result['lang'] = 'jp';
	$result['bearToken'] = 'FWFWE3232432SDFADFCXZCVV';
	echo json_encode($result);

?>