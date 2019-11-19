<?php

    class Admin{
        public $id;       
        public $username;        
        public $rol = "Admin"; 
        public $username;
    }

    class Cliente{ 
        public $id;       
        public $username;            
        public $rol = "Client";
        public $CuentadeAhorros;     
        public $TarjetadeCredito = [];       
        public $Credito;
    }

    class CuentadeAhorros extends Producto { 
        public $id;
        public $Owner;   
        public $tipo = 'CuentaAhorros';                
        public $JaveCoins;
    }

    class Credito extends Producto { 
        public $id;
        public $Owner;   
        public $tipo = 'Credito';               
        public $TasaInteres;
        public $FechaDePago;
        public $Aprobado;
    }

    class TarjetadeCredito extends Producto {
        public $id;
        public $Owner;   
        public $tipo = 'TarjetaCredito'; 
        public $CupoMax;
        public $Sobrecupo;
        public $CuotaManejo;
        public $TasaInteres;
        public $Aprobada;
    }
?>