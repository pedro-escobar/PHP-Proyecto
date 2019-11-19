<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Página principal del proyecto</title>
        </head>
        <body>
            <?php	
                include_once dirname(__FILE__) . '/Utils/config.php'; 
                $flag = true;
                $cce = $namee = $surnamee = $cce = $emaile = $agee = $message = "";            
                if(isset($_POST['submit'])){                
                    	
                }
                echo '<h1>has venido a comprar</h1>';
                echo '<p>Selecciona una de tus tarjetas</p>';
                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
                if (mysqli_connect_errno()) { 
                    echo "Error en la conexión: " . mysqli_connect_error(); 
                } 
                else{
                    $checkPK = 'SELECT * FROM  TarjetasCredito  WHERE IdCliente = '.$_SESSION["Id"];
                    $resultado = mysqli_query($con, $checkPK);
                    
                }

            ?>		
        </body>
    </html>
<?php
	
?>
<?php
include_once dirname(__FILE__) . '/config.php'; 
$flag = true;
$cce = $namee = $surnamee = $cce = $emaile = $agee = $message = "";            
if(isset($_POST['submit']))
{
    if ($_POST['submit'] == 'Crear') {
        if(empty($_POST["Cedula"])){
            $cce = "La cédula es requerida";
            $flag = false;
        }
        else if(!filter_var($_POST["Cedula"], FILTER_VALIDATE_INT)) {
            $cce = "Formato de cédula incorrecto, ingrese solo números";
            $flag = false;    
        }
        if(empty($_POST["Nombre"])){
            $namee = "Nombre requerido";
            $flag = false;
        }
        else if(!filter_var($_POST["Nombre"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z ]*$/")))){
            $namee = "Formato de nombre incorrecto, utilice letras y espacios solamente";
            $flag = false;
        }
        if(empty($_POST["Apellido"])){
            $surnamee = "Apellido requerido";
            $flag = false;
        }
        else if(!filter_var($_POST["Apellido"], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z ]*$/")))){
            $surnamee = "Formato de apellido incorrecto, utilice letras y espacios solamente";
            $flag = false;
        }
        if(empty($_POST["Edad"])){
            $agee = "Edad requerida";
            $flag = false;
        }
        else if(!filter_var($_POST["Edad"], FILTER_VALIDATE_INT)) {
            $agee = "Formato de edad incorrecto, ingrese solo números";
            $flag = false;    
        }
        if(empty($_POST["Email"])){
            $emaile = "La cédula es requerida";
            $flag = false;
        }
        else if(!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
            $emaile = "Formato de correo incorrecto";
            $flag = false;    
        }                                                    
        if($flag){
            $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB); 
            if (mysqli_connect_errno()) { 
                echo "Error en la conexión: " . mysqli_connect_error(); 
            } 
            else{
                $checkPK = 'SELECT * FROM  Personas  WHERE Cedula = '.$_POST["Cedula"];
                $resultado = mysqli_query($con, $checkPK);

                if(!mysqli_num_rows($resultado)){// PK doesn't exist
                    $sql = 'INSERT INTO Personas (Cedula, Nombre, Apellido, Email, Edad) VALUES ("'.$_POST["Cedula"].'", "'.trim($_POST["Nombre"], "\t\n\r").'", "'.trim($_POST["Apellido"], "\t\n\r").'", "'.trim($_POST["Email"], "\t\n\r").'", '.$_POST["Edad"].')'; 
                    if(mysqli_query($con,$sql)){ 
                        $message = "Persona agregada";
                        header('Location: http://localhost/mailSend.php?email='.$_POST['Email'].'&user='.$_POST['Nombre'].'');                                
                    } else{ 
                        $message = "Error creando persona".mysqli_error($con); 
                    } 
                }
                else{//PK exists
                    $sql = 'UPDATE Personas set Nombre="'.trim($_POST["Nombre"], "\t\n\r").'", Apellido="'.trim($_POST["Apellido"], "\t\n\r").'", Email="'.trim($_POST["Email"], "\t\n\r").'", Edad='.$_POST["Edad"].' where Cedula='.$_POST["Cedula"];
                    if(mysqli_query($con,$sql)){ 
                        $message = "Persona actualizada";
                    } else{ 
                        $message = "Error actualizando persona".mysqli_error($con); 
                    } 
                }                                               
            }    
            mysqli_close($con);                 
        }   
    }
    if ($_POST['submit'] == 'Borrar') {
        if(isset($_POST['Cedula'])){
            if(empty($_POST["Cedula"])){
                $cce = "La cédula es requerida";
                $flag = false;
            }
            else if(!filter_var($_POST["Cedula"], FILTER_VALIDATE_INT)) {
                $cce = "Formato de cédula incorrecto, ingrese solo números";
                $flag = false;    
            }
            if($flag){
                $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
                if (mysqli_connect_errno()) { 
                    $str_datos.= "Error en la conexión: " . mysqli_connect_error();
                }
                $sql = 'DELETE from Personas where Cedula='.$_POST['Cedula'];
                if(mysqli_query($con,$sql)){
                    $message = "Persona eliminada";
                    $_POST['Cedula'] = $_POST['Nombre'] = $_POST['Apellido'] = $_POST['Email'] = $_POST['Edad'] = "";
                } else{ 
                    $message =  "Error borrando persona".mysqli_error($con); 
                } 
            }                        
        }                 
    }                                        
}

?>
