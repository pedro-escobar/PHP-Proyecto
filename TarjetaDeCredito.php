<?php
    require_once('Cliente.php');
    require_once('Producto.php');
    class TarjetadeCredito extends Producto {
        public $tipo = 'TarjetaDeCredito';
        public $CupoMax;
        public $Sobrecupo;
        public $CuotaManejo;
        public $TasaInteres;
        public $Aprobada;
    }
?>