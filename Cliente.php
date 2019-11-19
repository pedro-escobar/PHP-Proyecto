<?php
    require_once('Usuario.php');
    require_once('TarjetaDeCredito.php');
    class Cliente extends Usuario {    
        public $rol = "Client";
        public $CuentadeAhorros;     
        public $TarjetadeCredito = [];       
        public $Credito;
    }
?>