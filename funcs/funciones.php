<?php

function formatear_digitos($i) {
    if ($i < 10) return '0'.$i;
    return $i;
}

function ucase($string) {
    $string = (str_replace('_', ' ', strtoupper($string)));

    return str_replace('ñ', 'Ñ', $string);
}

function getResults($equipo1, $equipo2) {
    session_start();
    
    if (!$_SESSION['token'] || (time() - $_SESSION['time']) > 3500) {
        $_SESSION['token'] = getToken();
        $_SESSION['time'] = time(); 
    }
    
    $resp = callModel($equipo1, $equipo2, $_SESSION['token']);
    
    return parseResults($resp);
}

function getToken() {
    $data['grant_type'] = 'urn:ibm:params:oauth:grant-type:apikey';
    $data['apikey'] = API_KEY;

    $resp = callAPI('POST', TOKEN_URL, $data, false);
    $resp = json_decode($resp);
    $array = json_decode(json_encode($resp), true);

    return $array['access_token'];
}

function callModel($equipo1, $equipo2, $token) {
    $payload = '{"input_data": [{"fields": [ "local", "visitante" ],"values": [[ "_EQ1_"], ["_EQ2_"]]}]}';
    $payload = str_replace("_EQ1_", $equipo1, $payload);
    $payload = str_replace("_EQ2_", $equipo2, $payload);

    $resp = callAPI2('POST', SCORING_URL, $payload, $token);
    
    $array = json_decode(json_encode($resp), true);

    return $resp;
}

function callAPI($method, $url, $data = false, $token = false) {
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
 
    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    $header_array = array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json');
    if ($token) array_push($header_array, 'Authorization: Bearer '. $token);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function callAPI2($method, $url, $data = false, $token = false) {
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));

            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    $header_array = array('Content-Type: application/json;charset=UTF-8', 'Accept: application/json');
    if ($token) array_push($header_array, 'Authorization: Bearer '. $token);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header_array);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function parseResults($json) {

    $x = json_decode($json, true);
    $x = $x['predictions'][0]["values"][0];

    $resp['resultado'] = $x[0];
    $resp['probabilidad'] = round($x[1], 2) * 100;

    return $resp;
}
?>