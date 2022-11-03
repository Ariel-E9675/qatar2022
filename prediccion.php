<?php
require('conf/config.php');
require('funcs/funciones.php');

//equipos
$equipo1 = $_POST['param_equipo1'];
$equipo2 = $_POST['param_equipo2'];

//planteles
$img_equipo1 = IMG_EQUIPOS_PATH . $equipo1 . PNG;
$img_equipo2 = IMG_EQUIPOS_PATH . $equipo2 . PNG;

//nombre equipos
$uppercase_equipo1 = ucase($equipo1);
$uppercase_equipo2 = ucase($equipo2);
$nombre_equipos = ['1' => $uppercase_equipo1, '2' => $uppercase_equipo2];
$nro_equipo = [$equipo1 => 1, $equipo2 => 2];

//simulacion API REST
// $empate = rand(0,2);
// $nro_equipo_ganador = rand(1, 2);
// $nombre_ganador = $nombre_equipos[$nro_equipo_ganador]; 
// $msg_resultado = ($empate == 0)? 'EMPATE!!!' : 'VICTORIA DE ' . $nombre_ganador . '!!!';
// $probabilidad = rand(35, 90);

//obtener resultados
$resp = getResults($equipo1, $equipo2);
$nombre_ganador = $resp['resultado'];
// echo $nombre_ganador;exit;
$empate = ($nombre_ganador == 'empate');
$nro_equipo_ganador = $nro_equipo[$nombre_ganador];
$nombre_ganador = ucase($nombre_ganador);

$probabilidad = $resp['probabilidad'];
$msg_resultado = ($empate)? 'EMPATE!!!' : 'VICTORIA DE ' . $nombre_ganador . '!!!';

//asignación aleatoria
$img_estrellas = IMG_ESTRELLAS_PATH . rand(1, MAX_IMG_ESTRELLAS) . PNG;
$img_copa = IMG_COPAS_PATH . rand(1, MAX_IMG_COPAS) . PNG;

if ($empate == 1) {
  $img_index1 = rand(1, MAX_IMG_EMPATES);
  if (MAX_IMG_EMPATES > 1) {
    do {
      $img_index2 = rand(1, MAX_IMG_EMPATES);
    } while ($img_index1 == $img_index2);

  } else $img_index2 = 1; 

  $img_min_equipo1 = IMG_MINIONS_EMPATE . formatear_digitos($img_index1) . GIF;
  $img_min_equipo2 = IMG_MINIONS_EMPATE . formatear_digitos($img_index2) . GIF;


} else {
  $img_victoria =  IMG_MINIONS_VICTORIA . formatear_digitos(rand(1, MAX_IMG_VICTORIAS)) . GIF; 
  $img_derrota =  IMG_MINIONS_DERROTA . formatear_digitos(rand(1, MAX_IMG_DERROTAS)) . GIF;


  $img_min_equipo1 = ($nro_equipo_ganador == 1) ? $img_victoria : $img_derrota;
  $img_min_equipo2 = ($nro_equipo_ganador == 2) ? $img_victoria : $img_derrota;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Qatar 2022 - IBM Watson Studio</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/estilos_pred.css">
    <script src="js/prediccion.js"></script>  
    <script src="js/efectos.js"></script>  
    <script>
      const img = document.getElementById("img_equipo2");
	    img.onload = function() {inicio() }
    </script>
  </head>
  <body onload="inicio();">
    <div>
      <table style="width: 100%;  margin: 0; padding: 0;">
        <tr>
          <td style="align-items: left; width: 25%;"><img src="img/logos/logo_IBM.png" style="height: 80px"></td>
          <td style="width: 50%;"><a href="grupos.html"><img src="img/logos/logo_fifa3.png" style="height: 80px"></a></td>
          <td style="align-items: right;width: 25%;"><a href="index.html"><img src="img/fondos/watson.png" style="height: 80px"></a></td>
      </tr> 
    </table>
    </div>
    <div style="width: 100%;height:100%; background-color: #105020;position:absolute;top:100px;">
    <div> &nbsp;</div>

    <div style="text-align: center; font-weight: bold; color: white;font-size: 38px;">

      <table style="width: 800px; text-align: left; margin-left: auto; margin-right: auto;border:0">
        <colgroup>
          <col span="1" style="width: 40%;">
          <col span="1" style="width: 20%;">
          <col span="1" style="width: 40%;">
       </colgroup>
        <tbody>

          <tr>
            <td rowspan="1" colspan="3">
            </td>
          </tr>

          <tr>
            <td style="text-align: right;" >
              <div id="fading" style="height:200px; width:300px;position:relative;">
              <img src="<?php echo $img_equipo1; ?>"
              alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo1"> 
              <img src="<?php echo $img_estrellas; ?>"
                alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo1_top"> 
            </div>
          </td>
            <td style="text-align: center;font-style: italic;font-size: 36px;" class="text;" id="texto_vs">
               VS. 
            </td>
            <td style="text-align: left;" >
              <div id="fading" style="height:200px; width:300px; position: relative;">

              <img src="<?php echo $img_equipo2; ?>"
              alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo2"> 

              <img src="<?php echo $img_copa; ?>"
                alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo2_top"> </td>
              </div>

          </tr>

          <tr>
            <td style="text-align: center; display:none;" class="text" id="nombre_equipo1"><i><?php echo $uppercase_equipo1;?></i></td>
            <td style="text-align: center;">
              &nbsp;
            </td>
            <td style="text-align: center;display:none;" class="text" id="nombre_equipo2"><i><?php echo $uppercase_equipo2;?></i></td>      
          </tr>

          <tr>
            <td>
              <img src="<?php echo $img_min_equipo1;?>"
                alt="" style="height: 100px;display:none" class="center" class="caja; hidden_text" id="img_min_equipo1"></td>
                <td style="text-align: center;">
                  <img src="img/fondos/fifa.png" alt="" style="height: 100px;display:none" id="img_fifa">
                </td>
            <td ><img src="<?php echo $img_min_equipo2;?>"
                alt="" style="height: 100px;display:none" class="center" class="caja " id="img_min_equipo2"> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="text-align:center; color:white;font-size: 18px;display:none" id="texto_titulo">Nuestro modelo predice:</div>
    <div style="text-align:center; color:white;font-size: 38px;display:none" class="text" id="texto_resultado"><?php echo $msg_resultado; ?></div>
    <div style="text-align:center; color:white;font-size: 28px;display:none" class="text" id="texto_probabilidad">Probabilidad: <?php echo $probabilidad.'%';?></div>
    
    <form id="form_equipos" method="POST">
      <input type="text" id="param_equipo1" name="param_equipo1" value="brasil" hidden>
      <input type="text" id="param_equipo2" name="param_equipo2" value="serbia" hidden>
    </form>
    
    </div>
  </body>
</html>
