<?php
    require_once('Cliente.php');
    require_once('Producto.php');
    class Credito extends Producto {                
        public $TasaInteres;
        public $FechaDePago;
        public $Aprobado;
    }
?>