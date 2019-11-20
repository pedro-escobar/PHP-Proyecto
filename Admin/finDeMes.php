<?php
    session_start();
?>
<!DOCTYPE HTML>
<HEAD>
    <title>Fin de mes</title>
</HEAD>
<BODY>
    <?php
        include_once dirname(__FILE__) . '/../Utils/config.php'; 
        $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        // Verificar conexión
        if (mysqli_connect_errno())
        {
            echo "Error en la conexión: ". mysqli_connect_error();
        }else{
            $monthActual = date('m');
            $yearActual = date('y');
            $dayActual = date('d');
            if($dayActual == DIA_CORTE){
                $sql = "SELECT * FROM creditos";
                $resultadoCreditos = mysqli_query($con,$sql);
                while($filaCredito = mysqli_fetch_array($resultadoCreditos)) {
                    if(is_null($filaCredito['idCliente'])){
                        echo 'visitante<br>';
                    }else{
                        echo 'cliente<br>';
                        $idCliente = $filaCredito['idCliente'];
                        $idCredito = $filaCredito['id'];
                        $sql = "SELECT * FROM cuentadeahorros WHERE idCliente = $idCliente ORDER BY javeCoins DESC";
                        $resultadoCuentasAhorro = mysqli_query($con,$sql);
                        $deuda = (float) $filaCredito['javeCoins'];
                        echo 'deuda: '. $deuda . '<br>';
                        $cuentasAfectas = array();
                        
                        while($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)){
                            $dineroCuenta = (float)$filaCuenta['javeCoins'];
                            echo 'cuenta: '. $dineroCuenta . '<br>';
                            if($dineroCuenta >= $deuda){
                                $cuentasAfectas[$filaCuenta['id']] = $dineroCuenta - $deuda;
                                $deuda = 0.0;
                            }
                            elseif($dineroCuenta < $deuda){
                                $deuda = $deuda - $dineroCuenta;
                                $cuentasAfectas[$filaCuenta['id']] = 0.0;
                            }
                            if($deuda == 0){
                                break;
                            }
                        }
                        if($deuda==0.0){
                            echo 'Se pudo pagar<br>';
                            foreach($cuentasAfectas as $key => $value){
                                $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                                mysqli_query($con,$sql);                     
                            }
                            $sql = "DELETE FROM creditos WHERE id = $idCredito";
                            mysqli_query($con,$sql);
                        }else{
                            echo 'falta money<br>';
                        }
                        
                    }
                }
            }else{
                echo "Aún no es día de corte ";
            }


        }
    ?>
</BODY>