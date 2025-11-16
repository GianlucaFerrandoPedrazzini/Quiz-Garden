<!-- Archivo para borrar la sesión del último jugador y redirigir al inicio -->
<?php
    session_destroy(); //Borro la sesión
    header("Location: index.php"); //Redirijo al jugador
    exit();
?>