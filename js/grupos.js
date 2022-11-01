var total = 0;
var equipo = [];
var rival = [];

function marcar(x) {
  if (!equipo[x.id] && total < 2) {
    x.className = "fila_remarcada";          
  }
}

function desmarcar(x) {
  if (!equipo[x.id]) {
    x.className = "fila";
  }
}

function seleccion(x) {
  var lugar;

  playClick();
  if (!equipo[x.id] && total < 2) {
    total = total + 1;
    lugar = (rival[1]) ? 2 :1;   
    equipo[x.id] = lugar;
    rival[lugar] = true;
    x.className = "fila_elegida";
    nombre_equipo = document.getElementById('equipo' + equipo[x.id]);
    nombre_equipo.innerText = x.id.replace(/_/g, ' ').toUpperCase();

    img_equipo = document.getElementById('img_equipo' + equipo[x.id]);
    img_equipo.src = 'img/banderas/png/bandera-' + x.id + '.png';
    document.getElementById('param_equipo' + lugar).value = x.id;
    if (total == 2) document.getElementById("submit_button").hidden = false;
    
  }

  else if (equipo[x.id])  {
    lugar = equipo[x.id];
    nombre_equipo = document.getElementById('equipo' + lugar);
    nombre_equipo.innerText = "EQUIPO " + lugar;

    img_equipo = document.getElementById('img_equipo' + lugar);
    img_equipo.src = 'img/banderas/png/bandera-vacante.png';
    if (total == 2) document.getElementById("submit_button").hidden = true;
    total = total - 1;
    rival[lugar] = false;
    equipo[x.id] = 0;
    x.className = "fila_remarcada";
  }
}
function enviar() {
  playClick();
  var form_equipos = document.getElementById('form_equipos');
  form_equipos.submit();
}