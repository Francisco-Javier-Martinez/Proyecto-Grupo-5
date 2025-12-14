<?php
    header('Content-Type: application/json');

    require_once "Config/Conexion.php";
    $db = new Conexion();

    // Obtener todos los temas
    $result = $db->conexion->query("SELECT * FROM tema ORDER BY nombre");
    $temas = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($temas);
    
?>