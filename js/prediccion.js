let intervalo, intervalo2;
let step = 0;

function inicio() {
    intervalo = setInterval(animacion, 900);
}
function pos_resultado() {
    intervalo2 = setInterval(flash_resultado, 250);
}
function delay(n){
    clearInterval(intervalo);
    intervalo = null;
    step++;
    intervalo = setInterval(animacion, n);
}

function animacion() {
  let img_equipo;

  switch(step) {
    case 0:
        document.getElementById('layer1').remove();
        document.getElementById('layer2').remove();
        document.getElementById('nombre_equipo1').style.display = "";
        delay(50);
        break;
    case 1:
        img_equipo = document.getElementById('img_equipo1_top');
        img_equipo.style.opacity = 0;
        delay(600);
        break;
    case 2:
        document.getElementById('texto_vs').style.display = "";
        delay(700);
        break;
    case 3:
        document.getElementById('nombre_equipo2').style.display = "";
        delay(50);
        break;
    case 4:
        img_equipo = document.getElementById('img_equipo2_top');
        img_equipo.style.opacity = 0;
        delay(100);
        break;
    case 5:
        document.getElementById('img_fifa').style.display = "";
        delay(6200);
        break;
    case 6:
        playClick();
        document.getElementById('texto_titulo').style.display = "";
        delay(1300);
        break;
    case 7:
        document.getElementById('texto_resultado').style.display = "";
        document.getElementById('texto_probabilidad').style.display = "";
        delay(100);
        break;             
    case 8:
        document.getElementById('texto_extra1').style.display = "";
        delay(100);
        break;
    case 9:
        document.getElementById('texto_extra2').style.display = "";
        delay(1500);
        pos_resultado();
        break;
    case 10:
        document.getElementById('img_min_equipo1').style.display = "";
        document.getElementById('img_min_equipo2').style.display = "";
        clearInterval(intervalo);
        intervalo = null;
  }
}

function flash_resultado() {
    switch(document.getElementById('texto_resultado').style.color) {
        case 'white':
            document.getElementById('texto_resultado').style.color = "blue";
            break;
        case 'blue':
            document.getElementById('texto_resultado').style.color = "red";
        case 'red':
            document.getElementById('texto_resultado').style.color = "green";
            break;
        case 'green':
            document.getElementById('texto_resultado').style.color = "white";
    }
}