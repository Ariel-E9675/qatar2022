<?php
require('conf/config.php');
require('funcs/funciones.php');

//equipos
$equipo1 = $_POST['param_equipo1'];
$equipo2 = $_POST['param_equipo2'];
error_log($_SERVER['REMOTE_ADDRESS']."-Equipos:".$equipo1.','.$equipo2);

//planteles
$img_equipo1 = IMG_EQUIPOS_PATH . $equipo1 . PNG;
$img_equipo2 = IMG_EQUIPOS_PATH . $equipo2 . PNG;

//nombre equipos
$uppercase_equipo1 = ucase($equipo1);
$uppercase_equipo2 = ucase($equipo2);
$nombre_equipos = ['1' => $uppercase_equipo1, '2' => $uppercase_equipo2];
$nro_equipo = [$equipo1 => 1, $equipo2 => 2];

//obtener resultados
$resp = getResults($equipo1, $equipo2);
$nombre_ganador = $resp['resultado'][1];
$probabilidad = $resp['probabilidad'][1] . '%';
$nro_equipo_ganador = $nro_equipo[$nombre_ganador];

// echo $nombre_ganador;exit;
$msg_resultado = getMessages($resp);

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
      preloads = "<?php echo $img_estrellas . ',' . $img_copa; ?>".split(",")
      var tempImg = []

      for(var x=0;x<preloads.length;x++) {
          tempImg[x] = new Image()
          tempImg[x].src = preloads[x]
      }
    </script>
  </head>
  <body onload="inicio();">
    <div class="header">
      <img src="img/logos/logo_fifa3.png" style="height: 80px">
    </div>

    <div class="banderas-boton">
      <div class="pais">
        <div id="fading" style="height:200px; width:300px;position:relative;">
          <img src="<?php echo $img_equipo1; ?>" alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo1"> 
          <img src="img/fondos/green_layer.gif" style="width: 300px;height: 190px;" id="layer1"> 
          <img src="<?php echo $img_estrellas; ?>" alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo1_top"> 
        </div>
        <span class="elegido" style="text-align: center; display:none;" id="nombre_equipo1"><?php echo $uppercase_equipo1;?></span>
      </div>
      <div>
        <span class="elegido"> vs </span>
      </div>
      <div class="pais">
        <div id="fading" style="height:200px; width:300px; position: relative;">
          <img src="<?php echo $img_equipo2; ?>" alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo2"> 
          <img src="img/fondos/green_layer.gif" style="width: 300px;height: 190px;" class="caja" id="layer2"> 
          <img src="<?php echo $img_copa; ?>" alt="" style="width: 300px;height: 190px;" class="caja" id="img_equipo2_top">
        </div>
        <span class="elegido" style="text-align: center;display:none;" id="nombre_equipo2"><?php echo $uppercase_equipo2;?></span>
      </div>
    </div>
    
    <div class="resultados">
      <div style="text-align:center; color:white;font-size: 24px; display:none" id="texto_titulo">Nuestro modelo predice:</div>
      <div style="text-align:center; color:white;font-size: 34px; display:none; font-style: bold" id="texto_resultado"><?php echo $msg_resultado[1]; ?></div>
      <div style="text-align:center; color:white;font-size: 24px; display:none; font-style: italic" id="texto_probabilidad">Probabilidad: <?php echo $probabilidad;?></div>
      <div style="text-align:center; color:white;font-size: 18px; display:none;" id="texto_extra1"><?php echo $msg_resultado[2];?></div>
      <div style="text-align:center; color:white;font-size: 18px; display:none;" id="texto_extra2"><?php echo $msg_resultado[3];?></div>
    </div>

    <div class="footer">
      <img onclick="toggleMusic()" src="img/logos/rebus-light-small.png" style="height: 60px">
    </div>
  </body>
</html>
