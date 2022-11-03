<?php
//request al modelo
//define('SCORING_URL', 'https://us-south.ml.cloud.ibm.com/ml/v4/deployments/861913e4-25ce-4348-a099-9f4904f6e052/predictions?version=2022-10-31');
define('SCORING_URL', 'https://us-south.ml.cloud.ibm.com/ml/v4/deployments/match_pred_regression_function/predictions?version=2022-11-02');
define('TOKEN_URL', 'https://iam.cloud.ibm.com/identity/token');
define('API_KEY', 'eXkKbixdE_4VdLbpi2MgO2Pki0iA7naSPtqTdbwMFUaC');

//Cantidad de imágenes
define('MAX_IMG_ESTRELLAS', 5);
define('MAX_IMG_COPAS', 8);
define('MAX_IMG_VICTORIAS', 12);
define('MAX_IMG_EMPATES', 5);
define('MAX_IMG_DERROTAS', 13);

//PATHs
define('IMG_ESTRELLAS_PATH', 'img/fondos/estrellas');
define('IMG_COPAS_PATH', 'img/fondos/copa');
define('IMG_EQUIPOS_PATH', 'img/equipos/equipo_');
define('IMG_MINIONS_VICTORIA', 'img/minions/victoria/apaisado/victoria_');
define('IMG_MINIONS_EMPATE', 'img/minions/empate/apaisado/empate_');
define('IMG_MINIONS_DERROTA', 'img/minions/derrota/apaisado/derrota_');
define('PNG', '.png');
define('GIF', '.gif');
?>