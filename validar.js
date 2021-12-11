
function noespeciales(e) {
  key = e.keyCode || e.which;
  tecla= String.fromCharCode(key).toString();
  letras="ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890-_áéíóú ";

  especiales=[8,13];
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true;
      break;
    }
  }
  if(letras.indexOf(tecla)== -1 && !tecla_especial)
  {
    alert("Ingresar solo letras");
    return false;
  }
}

function noespeciales2(e) {
  key = e.keyCode || e.which;
  tecla= String.fromCharCode(key).toString();
  letras="ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890-_'@áéíóú,.:; ";

  especiales=[8,13];
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
     tecla_especial = true;
     break;
    }
  }
  if(letras.indexOf(tecla)== -1 && !tecla_especial)
  {
  alert("Ingresar solo letras");
  return false;
  }
}

function Solonumeros(e) {
  key = e.keyCode || e.which;
  tecla= String.fromCharCode(key).toString();
  letras="1234567890Kk-";

  especiales=[8,13];
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
     tecla_especial = true;
     break;
    }
  }
 if(letras.indexOf(tecla)== -1 && !tecla_especial)
  {
  alert("Por favor Ingresar solo numeros y -");
  return false;
  }
}
function telefonos(e) {
  key = e.keyCode || e.which;
  tecla= String.fromCharCode(key).toString();
  letras="1234567890+";

  especiales=[8,13];
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
     tecla_especial = true;
     break;
    }
  }
 if(letras.indexOf(tecla)== -1 && !tecla_especial)
  {
  alert("Por favor Ingresar solo numeros");
  return false;
  }
}

function Contraseñas(e) {
  key = e.keyCode || e.which;
  tecla= String.fromCharCode(key).toString();
  letras="ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890-_áéíóú.";

  especiales=[8,13];
  tecla_especial = false;
  for(var i in especiales){
    if(key == especiales[i]){
     tecla_especial = true;
     break;
    }
  }
 if(letras.indexOf(tecla)== -1 && !tecla_especial)
  {
  alert("Por favor Ingresar solo ingrese los caracteres especiales permitidos - _ .");
  return false;
  }
}

