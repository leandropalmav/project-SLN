<?php
ob_start();
include('Conexion.php');


session_start();
setlocale(LC_ALL,"es_CL.UTF-8");
date_default_timezone_set('America/Argentina/Buenos_Aires');

//filtro para los estados
$TIPOu=$_SESSION['ID'];
$NombreU = $_SESSION['NombreU'];



if (!isset($NombreU)) {
  header("location: iniciar.php");
}

if ($TIPOu==2) {
  header("location: Servicios.php"); 
}
//secuencia sql para obtener los usuarios con el id de area 1 osea el de revencion de riesgo
$contarusuarios=mysqli_query($con,'SELECT * FROM usuarios WHERE Rut IN (SELECT Rut FROM clientesinternos WHERE IDarea=1)');

$usuarios= $contarusuarios->num_rows;
$total=$usuarios*2;

//secuencia sql para obtener los vehiculos disponibles
$Vehiculos=mysqli_query($con,'SELECT * FROM vehiculos WHERE Estadov ="Disponible"');
$Nvehiculos= $Vehiculos->num_rows;

//secuencia sql para otener las visitas no asignadas
$visitas=mysqli_query($con,'SELECT * FROM visitas WHERE Estado ="Pendiente"');
$Nvisitas= $visitas->num_rows;

//se establecen los horarios
$Hora1="9:30:00";
$Hora2="13:30:00";
$Hora3="15:30:00";


//print_r ($DatosVehiculos);



//bucle para los dias
for ($I=0; $I < 5; $I++) {
    //validacion de que existan filas en las secuencias ejecutadas anteriormente
    if ($total > 0 and $Nvehiculos > 0 and $Nvisitas > 0) {
        //se establece zora horaria
        setlocale(LC_ALL,"es_CL.UTF-8");
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        //se captura la fecha del dia de hoy en una variable, el dia en otra, y el mes en otra.
        $hoy = date("Y-m-d");
        $dia=date("d");    
        $mes=date("m");
        //se verifica que dia es hoy utilzaindo mktime, este codigo devuelve el nombre del dia con las 3 letras inicales por la D.
        $Vdia=date("D", mktime(0, 0, 0, $mes, $dia, 2021));
        //se veriica si es el dia 1
        if ($I==0) {
            //se valida de que el dia no sea sabado ni domingo.
            if($Vdia=="Sat" OR $Vdia=="Sun"){
                //en caso de que sea sabado o domingo se establece como el siguiente lunes como el dia de la fecha inicial para la planificacion
                $Fechainicial= date("Y-m-d",strtotime("next Monday"));
            } else{

                $Fechainicial=$hoy;
            }
        }else{
            //en caso de que sea el dia 2,3,4... se va sumando 1 a la fecha inicial
            $Fechainicial=date("Y-m-d",strtotime($Fechainicial."+ 1 days"));
            $dia2=date("d",strtotime($Fechainicial));  
            $mes2=date("m",strtotime($Fechainicial));
            $Vdia=date("D", mktime(0, 0, 0, $mes2, $dia2, 2021));
            if($Vdia=="Sat" OR $Vdia=="Sun"){
                $Fechainicial= date("Y-m-d",strtotime("next Monday"));
            } 
        }

        //se inicia un contador
        $c=0;

        while ($Usuarios=$contarusuarios->fetch_assoc()) {
            if($Nvehiculos>0 and $Nvisitas>0){
                //validacion para que los administradores no tengan visitas asignadas
                if($Usuarios["Usuario_tipo"]==2){
                    //se pasan los campos de las diferentes tablas a variables locales 


                    $Nombreusuario=$Usuarios["NombreUsuario"];

                    

                    $Datosvisita = $visitas->fetch_array();
                    $Idvisita=$Datosvisita["IDvisita"];
                    

                    $DatosVehiculos=$Vehiculos->fetch_assoc() ;
                    $patente=$DatosVehiculos["patente"];

                    //se establecen la variable fecha con el formato necesario para guardar en el campo de la BD datatime



                    $Fecha=$Fechainicial." ".$Hora1; 

                    //se busca mediante el nombre y fecha si existe algun dato 
                    $busuario=mysqli_query($con,'SELECT * FROM `jornada` WHERE nombreusuario ="'.$Nombreusuario.'" and Fecha="'.$Fecha.'"');
                    $datos = $busuario->fetch_array(); 
                    
                    //se cuentan las filas de la secuencia sql
                    $cusuarios= $busuario->num_rows;

                    //Se verifica que el numero de filas sea mayor a 0


                    if ($cusuarios>0) {
                        //en caso de existir datos con la misma ya guardados para ese usuario se inicia un bucle el cual aumenta la fecha en un dia y reejecuta la secuencia para de esta forma buscar un dia el cual no tenga  ya una planificacion para el usuario.
                        while ($cusuarios>0) {
                            $Fechainicial=date("Y-m-d",strtotime($Fechainicial."+ 1 days"));
                            $Fecha=date("Y-m-d H:i:s",strtotime($Fecha."+ 1 days"));

                            $vdia2=date("d",strtotime($Fechainicial));  
                            $vmes2=date("m",strtotime($Fechainicial));
                            $Vdia=date("D", mktime(0, 0, 0, $vmes2, $vdia2, 2021));

                            if($Vdia=="Sat" OR $Vdia=="Sun"){
                                if ($Vdia=="Sun") {
                                    $Fechainicial= date("Y-m-d",strtotime($Fechainicial."next Monday"));
                                    $Fecha=date("Y-m-d H:i:s",strtotime($Fecha."+ 1 days"));
                                }else{
                                    $Fechainicial= date("Y-m-d",strtotime($Fechainicial."next Monday"));
                                    $Fecha=date("Y-m-d H:i:s",strtotime($Fecha."+ 2 days")); 

                                }

                            } 

                            $busuario=mysqli_query($con,'SELECT * FROM `jornada` WHERE nombreusuario ="'.$Nombreusuario.'" and Fecha="'.$Fecha.'"');
                            $datos = $busuario->fetch_array(); 


                            $cusuarios= $busuario->num_rows;
                        }

                    }
                    //cuando ya se encuantra un dia disponible o el dia inicial ya era el disponible se ejecuta la secuencia sql PREPARADA PDO y se guarda en la BD.
                    $query = $connection->prepare("INSERT INTO jornada(numerovisita,nombreusuario,Matricula,Fecha) VALUES(:Idvisita,:Nombreusuario,:patente,:Fecha)");
                    $query->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                    $query->bindParam("Nombreusuario", $Nombreusuario, PDO::PARAM_STR);
                    $query->bindParam("patente", $patente, PDO::PARAM_STR);
                    $query->bindParam("Fecha",$Fecha,PDO::PARAM_STR);
                    $result = $query->execute();
                    if ($result) {
                        --$Nvisitas;

                        $query3 = $connection->prepare("UPDATE `visitas` SET `Estado` = 'Asignada' WHERE `visitas`.`IDvisita` = :Idvisita");
                        $query3->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                        $result = $query3->execute();
                        if ($result) {

                        }
                    } else {

                    }
                    //se crea un rand entre 1 y 2 para designar el siguiente horario


                    $random =rand(1, 2);
                    

                    if ($random==1) {
                        $Fecha=$Fechainicial    ." ".$Hora2;

                    }else{
                        $Fecha=$Fechainicial    ." ".$Hora3;
                    }
                    //se ejecuta una secuencia sql para verificar que no existan datos duplciados en la BD.

                    $busuario=mysqli_query($con,'SELECT * FROM `jornada` WHERE nombreusuario ="'.$Nombreusuario.'" and Fecha="'.$Fecha.'"');
                    $datos = $busuario->fetch_array(); 
                    $cusuarios= $busuario->num_rows;
                    //se verifica que no existan datos
                    if ($cusuarios==0) {
                        $Datosvisita = $visitas->fetch_array();
                        $Idvisita=$Datosvisita["IDvisita"];
                        //se valida que existan visitas
                        if ( $Idvisita != NULL) {


                            //se ejecuta el codigo para asignarle otra visita al usuario con un horario diferente

                            $query2 = $connection->prepare("INSERT INTO jornada(numerovisita,nombreusuario,Matricula,Fecha) VALUES(:Idvisita,:Nombreusuario,:patente,:Fecha)");
                            $query2->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                            $query2->bindParam("Nombreusuario", $Nombreusuario, PDO::PARAM_STR);
                            $query2->bindParam("patente", $patente, PDO::PARAM_STR);
                            $query2->bindParam("Fecha",$Fecha,PDO::PARAM_STR);
                            $result = $query2->execute();
                            if ($result) {
                                --$Nvisitas;
                                
                                $query3 = $connection->prepare("UPDATE `visitas` SET `Estado` = 'Asignada' WHERE `visitas`.`IDvisita` = :Idvisita");
                                $query3->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                                $result = $query3->execute();
                                if ($result) {

                                }
                            } else {

                            }
                        }else{

                        }
                    }else{

                    }

                    //se crea una variable llamada usuarioa y se le asigna un numero random entre 1 y el numero de filas de la secuencia sql para buscar usuarios.


                    $usuarioA=rand(1, $usuarios);
                    //se le resta 1 para simular que es una fila en una tabla de una BD ya que estas parten en 0
                    --$usuarioA;
                    //se establece que la siguiente fila es la del numero aleatorio uusarioA
                    $contarusuarios->data_seek($usuarioA);
                    //se recibe el array en la variable usuarios.
                    $Usuarios=$contarusuarios->fetch_assoc();

                    //se verifica que el numero del contador no sea el mismo que el de usuarioA y que el tipo de usuario no sea administrador


                    if ($c==$usuarioA or $Usuarios["Usuario_tipo"]==1) {
                        //se crea un bucle para buscar un usuario adecuado
                        while ($c==$usuarioA or $Usuarios["Usuario_tipo"]==1) {
                            $usuarioA=rand(1, $usuarios);
                            --$usuarioA;
                            $contarusuarios->data_seek($usuarioA);
                            $Usuarios=$contarusuarios->fetch_assoc();

                            

                            

                        }
                    }
                    //se establece la fecha dependiendo del rand
                    if ($random==1) {
                        $Fecha=$Fechainicial    ." ".$Hora3;
                    }else{
                        $Fecha=$Fechainicial    ." ".$Hora2;
                    }
                    
                    $contarusuarios->data_seek($usuarioA);
                    $Usuarios=$contarusuarios->fetch_assoc();
                    $Nombreusuario=$Usuarios["NombreUsuario"];


                    //se busca si dicho usuario ya tiene el datos guardados con la misma fecha


                    $busuario2=mysqli_query($con,'SELECT * FROM `jornada` WHERE nombreusuario ="'.$Nombreusuario.'" and Fecha="'.$Fecha.'"');
                    $datos2 = $busuario2->fetch_array(); 
                    //se cuentan las filas
                    $cusuarios2= $busuario2->num_rows;

                    //se verifica que no existan registros
                    if ($cusuarios2==0) {
                        $Datosvisita = $visitas->fetch_array();   
                        $Idvisita=$Datosvisita["IDvisita"];
                        //se valida que exista visita
                        if ( $Idvisita != NULL) {
                            //se ejecuta la secuencia sql preparada PDO
                            $query = $connection->prepare("INSERT INTO jornada(numerovisita,nombreusuario,Matricula,Fecha) VALUES(:Idvisita,:Nombreusuario,:patente,:Fecha)");
                            $query->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                            $query->bindParam("Nombreusuario", $Nombreusuario, PDO::PARAM_STR);
                            $query->bindParam("patente", $patente, PDO::PARAM_STR);
                            $query->bindParam("Fecha",$Fecha,PDO::PARAM_STR);
                            $result = $query->execute();
                            if ($result) {
                                --$Nvisitas;
                                
                                $query3 = $connection->prepare("UPDATE `visitas` SET `Estado` = 'Asignada' WHERE `visitas`.`IDvisita` = :Idvisita");
                                $query3->bindParam("Idvisita", $Idvisita, PDO::PARAM_STR);
                                $result = $query3->execute();
                                if ($result) {

                                }
                            } else {

                            }
                        }else{

                        }
                    }else{

                    }
                    //se resta un vehiculo y se suma 1 al contador
                    --$Nvehiculos;
                    ++$c;
                    //se establece que la siguiente fila de usuario el al del contador

                    $contarusuarios->data_seek($c);
                }
            }
        }
    }
    //al completarse 1 dia se resetea el contador de filas de la secuencia usuarios, vehiculos.
    $contarusuarios->data_seek(0);
    $Vehiculos->data_seek(0);
    $Nvehiculos=$Vehiculos->num_rows;
}
header("location:Lista.php");


ob_end_flush();

?>
