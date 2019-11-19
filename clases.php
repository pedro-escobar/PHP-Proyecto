<?php

    class Usuario {            
        public $username;        
        public $id;
        public $rol;        
    }

    class Admin extends Usuario {
        public $username;
        public $rol = "Admin";  
    }

    class Cliente extends Usuario {    
        public $rol = "Client";
        public $CuentadeAhorros;     
        public $TarjetadeCredito = [];       
        public $Credito;
    }

    class Producto {            
        public $id;
        public $Owner;   
        public $tipo;     
    }

    class CuentadeAhorros extends Producto {                
        public $JaveCoins;
    }

    class Credito extends Producto {                
        public $TasaInteres;
        public $FechaDePago;
        public $Aprobado;
    }

    class TarjetadeCredito extends Producto {
        public $tipo = 'TarjetaDeCredito';
        public $CupoMax;
        public $Sobrecupo;
        public $CuotaManejo;
        public $TasaInteres;
        public $Aprobada;
    }
?>