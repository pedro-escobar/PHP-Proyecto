<?php
session_start();
?>
<!DOCTYPE HTML>

<HEAD>
    <title>Fin de mes</title>
</HEAD>

<BODY>
    <?php

    function enviarCorreo($correo, $mensaje, $subject)
    {
        require_once(dirname(__FILE__) . '/PHPMailer/config.php');
        $mail->ClearAllRecipients();
        $mail->Subject = $subject;
        $mail->AddAddress($correo);
        $msg = $mensaje;

        $mail->Body    = $msg;
        $mail->Send();
    }

    include_once dirname(__FILE__) . '/../Utils/config.php';
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    // Verificar conexión
    if (mysqli_connect_errno()) {
        echo "Error en la conexión: " . mysqli_connect_error();
    } else {
        $monthActual = date('m');
        $yearActual = date('y');
        $dayActual = date('d');
        $fechaActual = date('y-m-d');
        if ($dayActual == DIA_CORTE) {
            echo "-------Cobro de creditos <br>";
            $sql = "SELECT * FROM creditos WHERE aprobado = 1";
            $resultadoCreditos = mysqli_query($con, $sql);
            while ($filaCredito = mysqli_fetch_array($resultadoCreditos)) {
                $timePago = strtotime($filaCredito['fechaPago']) * 1000;
                $timeAcutal = strtotime($fechaActual) * 1000;
                if (is_null($filaCredito['idCliente'])) {
                    echo '--visitante<br>';
                    $idCredito = $filaCredito['id'];
                    $correoUsuario = $filaCredito['correoVisitante'];
                    $deuda = (float) $filaCredito['javeCoins'];
                    $mora = (float) $filaCredito['mora'];
                    $totalPagar = $mora + $deuda;
                    echo 'deuda: ' . $totalPagar . '<br>';

                    if (!is_null($filaCredito['fechaPagado'])) {

                        $timePagado = strtotime($filaCredito['fechaPagado']) * 1000;


                        if ($timePago >= $timePagado) {
                            echo 'OK <br>';
                        } elseif (($timePago <= $timePagado) && ($timePagado < $timeAcutal)) {
                            echo 'OK con mora <br>';
                            $dias = (int) date("d", (int) $timePagado / 1000 - (int) $timePago / 1000);

                            $intereses = (float) $filaCredito['tasaInteres'];
                            echo "Días mora : $dias <br>";
                            $mora = $mora + ($deuda * $intereses * $dias);
                            echo 'Nueva mora: ' . $mora . '<br>';

                            $sql = "UPDATE creditos SET mora = $mora WHERE id = $idCredito";
                            mysqli_query($con, $sql);
                        }
                    } elseif ($timePago < $timeAcutal) {
                        echo 'moroso <br>';
                        $intereses = (float) $filaCredito['tasaInteres'];
                        $mora = $mora + ($deuda * $intereses * 30);
                        echo 'Nueva mora: ' . $mora . '<br>';

                        $sql = "UPDATE creditos SET mora = $mora WHERE id = $idCredito";
                        mysqli_query($con, $sql);
                        enviarCorreo($correoUsuario, "Recordatorio de impago del credito: $idCredito", "Impago de credito");
                    }
                } elseif (is_null($filaCredito['pagado']) && ($timePago <= $timeAcutal)) {
                    echo '--cliente<br>';
                    $idCliente = $filaCredito['idCliente'];
                    $idCredito = $filaCredito['id'];
                    $sql = "SELECT * FROM cuentadeahorros WHERE idCliente = $idCliente  ORDER BY javeCoins DESC";
                    $resultadoCuentasAhorro = mysqli_query($con, $sql);
                    $intereses = (float) $filaCredito['tasaInteres'];
                    $deuda = (float) $filaCredito['javeCoins'] + ((float) $filaCredito['javeCoins']  * $intereses);
                    echo 'deuda: ' . $deuda . '<br>';
                    $cuentasAfectas = array();

                    while ($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)) {
                        $dineroCuenta = (float) $filaCuenta['javeCoins'];
                        echo 'dinero cuenta: ' . $dineroCuenta . '<br>';
                        if ($dineroCuenta >= $deuda) {
                            $cuentasAfectas[$filaCuenta['id']] = $dineroCuenta - $deuda;
                            $deuda = 0.0;
                        } elseif ($dineroCuenta < $deuda) {
                            $deuda = $deuda - $dineroCuenta;
                            $cuentasAfectas[$filaCuenta['id']] = 0.0;
                        }
                        if ($deuda == 0) {
                            break;
                        }
                    }
                    if ($deuda == 0.0) {
                        echo 'Se pudo pagar<br>';
                        foreach ($cuentasAfectas as $key => $value) {
                            $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                            mysqli_query($con, $sql);
                        }
                        $date = $yearActual . '-' . $monthActual . '-' . $dayActual;
                        echo $date . '<br>';
                        $sql = "UPDATE creditos SET pagado = 1, fechaPagado = '$date' WHERE id = $idCredito";
                        mysqli_query($con, $sql);
                    } else {
                        echo 'falta dinero<br>';
                    }
                }
            }
            //Cobrar tarjetas
            echo "-------Pago tarjetas<br>";
            $sql = "SELECT * FROM compras WHERE pagado IS NULL";
            $resultadoCompras = mysqli_query($con, $sql);
            while ($filaCompra = mysqli_fetch_array($resultadoCompras)) {
                $idCompra = $filaCompra['id'];
                $idTarjeta = $filaCompra['idTarjeta'];
                echo "--Compra $idCompra<br>";
                $mesCompra = date("m", strtotime($filaCompra['fechaCompra']));
                $sql = "SELECT * FROM tarjetascredito LIMIT 1";
                $result = mysqli_query($con, $sql);
                $tarjeta = mysqli_fetch_assoc($result);
                $idCliente = $tarjeta['idCliente'];
                $cobroInteres = $tarjeta['tasaInteres'];
                echo "Cliente : $idCliente <br>";

                if ($mesCompra == $monthActual) {
                    echo 'No se cobran intereses <br>';
                    $deuda = (float) $filaCompra['valorCompra'] / (float) $filaCompra['Cuotas'];
                    $sql = "SELECT * FROM cuentadeahorros WHERE idCliente = $idCliente  ORDER BY javeCoins DESC";
                    $resultadoCuentasAhorro = mysqli_query($con, $sql);

                    while ($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)) {
                        $dineroCuenta = (float) $filaCuenta['javeCoins'];
                        echo 'dinero cuenta: ' . $dineroCuenta . '<br>';
                        if ($dineroCuenta >= $deuda) {
                            $cuentasAfectas[$filaCuenta['id']] = $dineroCuenta - $deuda;
                            $deuda = 0.0;
                        } elseif ($dineroCuenta < $deuda) {
                            $deuda = $deuda - $dineroCuenta;
                            $cuentasAfectas[$filaCuenta['id']] = 0.0;
                        }
                        if ($deuda == 0) {
                            break;
                        }
                    }
                    if ($deuda == 0.0) {
                        echo 'Se pudo pagar la compra<br>';
                        foreach ($cuentasAfectas as $key => $value) {
                            $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                            mysqli_query($con, $sql);
                        }
                    } else {
                        echo 'falta dinero<br>';
                        enviarCorreo($correoUsuario, "No se ha podido pagar una cuota de una compra por fondos insuficientes, Id: $idCompra", "Impago cuota de compra");
                    }
                } else {
                    echo 'Cobro de intereses <br>';
                    $cuotas = (float) $filaCompra['Cuotas'];
                    $deuda = (float) $filaCompra['valorCompra'] / $cuotas;
                    $deuda = $deuda + ($deuda*$cobroInteres);
                    $sql = "SELECT * FROM cuentadeahorros WHERE idCliente = $idCliente  ORDER BY javeCoins DESC";
                    $resultadoCuentasAhorro = mysqli_query($con, $sql);

                    while ($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)) {
                        $dineroCuenta = (float) $filaCuenta['javeCoins'];
                        echo 'dinero cuenta: ' . $dineroCuenta . '<br>';
                        if ($dineroCuenta >= $deuda) {
                            $cuentasAfectas[$filaCuenta['id']] = $dineroCuenta - $deuda;
                            $deuda = 0.0;
                        } elseif ($dineroCuenta < $deuda) {
                            $deuda = $deuda - $dineroCuenta;
                            $cuentasAfectas[$filaCuenta['id']] = 0.0;
                        }
                        if ($deuda == 0) {
                            break;
                        }
                    }
                    if ($deuda == 0.0) {
                        echo 'Se pudo pagar el manejo<br>';
                        foreach ($cuentasAfectas as $key => $value) {
                            $mesUltimo = $monthActual - $mesCompra; 
                            if($mesUltimo==$cuotas){
                                echo 'Ultimo mes<br>';
                                $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                                mysqli_query($con, $sql);
                                $sql = "UPDATE compras SET pagado = 1 WHERE id = $idCompra";
                                mysqli_query($con, $sql);
                            }else{
                                $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                            }
                            
                        }
                    } else {
                        echo 'falta money<br>';
                        enviarCorreo($correoUsuario, "No se ha podido pagar una cuota de una compra por fondos insuficientes, Id: $idCompra", "Impago cuota de compra");
                    }
                 }
            }
            //Aumentar saldos
            echo "-------Aumento de saldos<br>";
            $sql = "SELECT * FROM cuentadeahorros";
            $resultadoCuentasAhorro = mysqli_query($con, $sql);
            while ($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)) {
                $idCuenta = $filaCuenta['id'];
                echo "--Cuenta $idCuenta <br>";
                $dineroCuenta = (float) $filaCuenta['javeCoins'];
                $nuevoDinero = $dineroCuenta + ($dineroCuenta * INTERES_GLOBAL);
                $sql = "UPDATE cuentadeahorros SET javeCoins = $nuevoDinero WHERE id = $idCuenta";
                mysqli_query($con, $sql);
                echo "Nuevo monto: $nuevoDinero<br>";
            }
            //Cobrar manejo
            echo "-------Cobro manejo de tarjetas<br>";
            $sql = "SELECT * FROM tarjetascredito";
            $resultadoCreditos = mysqli_query($con, $sql);
            while ($filaCredito = mysqli_fetch_array($resultadoCreditos)) {
                $idCliente = $filaCredito['idCliente'];
                $idTarjeta = $filaCredito['id'];
                echo "--Tarjeta $idTarjeta <br>";
                $sql = "SELECT * FROM cuentadeahorros WHERE idCliente = $idCliente  ORDER BY javeCoins DESC";
                $resultadoCuentasAhorro = mysqli_query($con, $sql);
                $deuda = (float) $filaCredito['cuotaManejo'];
                while ($filaCuenta = mysqli_fetch_array($resultadoCuentasAhorro)) {
                    $dineroCuenta = (float) $filaCuenta['javeCoins'];
                    echo 'dinero cuenta: ' . $dineroCuenta . '<br>';
                    if ($dineroCuenta >= $deuda) {
                        $cuentasAfectas[$filaCuenta['id']] = $dineroCuenta - $deuda;
                        $deuda = 0.0;
                    } elseif ($dineroCuenta < $deuda) {
                        $deuda = $deuda - $dineroCuenta;
                        $cuentasAfectas[$filaCuenta['id']] = 0.0;
                    }
                    if ($deuda == 0) {
                        break;
                    }
                }
                if ($deuda == 0.0) {
                    echo 'Se pudo pagar el manejo<br>';
                    foreach ($cuentasAfectas as $key => $value) {
                        $sql = "UPDATE cuentadeahorros SET javeCoins = $value WHERE id = $key";
                        mysqli_query($con, $sql);
                    }
                } else {
                    echo 'falta money<br>';
                    enviarCorreo($correoUsuario, "No se ha podido pagar el manejo de una tarjeta por fondos insuficientes, Id tarjeta: $idTarjeta", "Impago cuota de manejo");
                }
            }
        } else {
            echo "Aún no es día de corte ";
        }
    }
    ?>
</BODY>