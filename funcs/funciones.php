<?php

function formatear_digitos($i) {
  if ($i < 10) return '0'.$i;
  return $i;
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

function getToken() {
    $data['grant_type'] = 'urn:ibm:params:oauth:grant-type:apikey';
    $data['apikey'] = API_KEY;

    $resp = callAPI('POST', TOKEN_URL, $data, false);
    $resp = json_decode($resp);
    $array = json_decode(json_encode($resp), true);

    return $array['access_token'];
}

function callModel($equipo1, $equipo2, $token) {
    $fields['fields'] = array('local', 'visitante');
    $values['values'] = array(array('argentina'), array('alemania'));
    $data['input_data'] = array($fields, $values);

    $resp = callAPI('POST', SCORING_URL, $data, $token);
    
    print_r($resp);
    $resp = json_decode($resp);
    $array = json_decode(json_encode($resp), true);
    print_r($array);

    return $resp;
}
//curl -X POST --header “Content-Type: application/json” --header “Accept: application/json” --header “Authorization: Bearer $IAM_TOKEN” -d ‘{“input_data”: [{“fields”: [ “local”, “visitante” ],“values”: [[ “argentina”], [“alemania”]]}]}’ “https://us-south.ml.cloud.ibm.com/ml/v4/deployments/match_pred_regression_function/predictions?version=2022-10-31”
?>