<?php
    session_start();
    // unset($_SESSION["now"]);
    setcookie("now", "", time()-3600);
    unset($_COOKIE["now"]);
    header('Location: index.php');
    
?>