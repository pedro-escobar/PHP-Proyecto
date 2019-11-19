<?php
    require_once('Usuario.php');
    class Admin extends Usuario {
        public $username;
        public $rol = "Admin";  
    }
?>