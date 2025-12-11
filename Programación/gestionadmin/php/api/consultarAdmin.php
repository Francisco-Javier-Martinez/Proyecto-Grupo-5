<?php
    header('Content-Type: application/json');
    
    require_once "Config/Conexion.php";
    $db = new Conexion();

    // Obtener ID desde la URL
    $id = $_GET['id'];
    
    // Consulta para obtener un administrador por ID
    $result = $db->conexion->query("SELECT nombre,email FROM Usuarios WHERE idUsuario = $id");
    
    if ($result->num_rows > 0) {
        $administrador = $result->fetch_assoc();
        echo json_encode($administrador);
    } else {
        echo json_encode(['error' => 'Administrador no encontrado']);
    }
?>