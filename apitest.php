<?php 
require('conf/config.php');
require('funcs/funciones.php');

function getResults2($equipo1, $equipo2) {
    session_start();
    if (!$_SESSION['token'] || (time() - $_SESSION['time']) > TOKEN_RENEW_TIME) {
        $_SESSION['token'] = getToken();
        $_SESSION['time'] = time(); 
    }

    $resp = callModel($equipo1, $equipo2, $_SESSION['token']);
    print_r($resp);

    if (str_contains($resp,  'expir')) {
        $_SESSION['token'] = '';
        return getResults2($equipo1, $equipo2);
    }
    return parseResults($resp);
}
// getResults2('estados_unidos', 'gales');
getResults2('costa_rica', 'canada');
?> 