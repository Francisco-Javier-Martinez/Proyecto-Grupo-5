<?php
    header('Content-Type: application/json');
    require_once "Config/Conexion.php";

    $db = new Conexion();

    // Consulta de personajes
    $stmt = $db->conexion->prepare("SELECT idPersonaje, nombre, imagen FROM personajes");
    $stmt->execute();

    $resultado = $stmt->get_result();
    $avatares = [];

    while ($row = $resultado->fetch_assoc()) {
        $avatares[] = [
            "idPersonaje" => $row["idPersonaje"],
            "nombre" => $row["nombre"],
            "imagen" => "data:image/png;base64," . base64_encode($row["imagen"])
        ];
    }

    echo json_encode($avatares);
?>
