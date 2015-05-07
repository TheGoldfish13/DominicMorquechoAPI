<?php
    require_once(__DIR__ . "/../model/config.php");
    
    unset($_SESSION["authenticated"]);

    session_destroy();