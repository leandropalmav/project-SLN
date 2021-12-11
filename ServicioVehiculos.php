
<?php
//metodo usado para obtener la ubicacion mediante el uso de HTML5 y JavaScript
?>

<script>
  geoloc();
function geoloc() {
  
  if (navigator.geolocation){
    
    navigator.geolocation.getCurrentPosition(showPosition,showError);
  }
else {
    alert("Hello! I am an alert box!!");
   }
}
function showPosition(position){
   latitud = position.coords.latitude;
    longitud= position.coords.longitude;

    javascript_to_php(latitud,longitud);


}


 
//Funcion encargada de mostrar los diferentes posibles errores al momento de mostrar la ubicacion    
function showError(error){
  switch(error.code) {
    case error.PERMISSION_DENIED:
      d.innerHTML+="<p>El usuario ha denegado el permiso a la localización.</p>"
      break;
    case error.POSITION_UNAVAILABLE:
      d.innerHTML+="<p>La información de la localización no está disponible.</p>"
      break;
    case error.TIMEOUT:
      d.innerHTML+="<p>El tiempo de espera para buscar la localización ha expirado.</p>"
      break;
    case error.UNKNOWN_ERROR:
      d.innerHTML+="<p>Ha ocurrido un error desconocido.</p>"
      break;
    }
  }

</script>
<script type="text/javascript">
  //metodo encargado de enviar la ubicacion a el api de google maps
function javascript_to_php(latitud,longitud) {
    
    window.location.href="ubicacion.php?w1="+latitud+"&w2="+longitud;
}
</script>