<?php
    require_once "../Config/Conexion.php";

    $conexion = Conexion();
    $sql = "SELECT idTema, nombre, descripcion, publico, abreviatura, idUsuario FROM tema";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $temas
    ]);
?>