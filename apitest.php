<?php 
require('conf/config.php');
require('funcs/funciones.php');

$token = getToken();
$resp = callModel('ecuador', 'senegal', $token);

echo $resp;
?> 