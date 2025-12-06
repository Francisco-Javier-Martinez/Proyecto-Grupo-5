<?php
    header('Content-Type: application/json');

    require_once "Config/Conexion.php";
    $db = new Conexion();

    $idTema = $_GET['idTema'] ?? 1;

    // Obtener preguntas
    $stmt = $db->conexion->prepare("SELECT * FROM preguntas WHERE idTema = ?");
    $stmt->bind_param("i", $idTema);
    $stmt->execute();
    $preguntas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Para cada pregunta, obtener respuestas
    foreach ($preguntas as &$p) {
        $stmt2 = $db->conexion->prepare("SELECT * FROM respuestas WHERE idTema = ? AND nPregunta = ?");
        $stmt2->bind_param("ii", $p['idTema'], $p['nPregunta']);
        $stmt2->execute();
        $p['respuestas'] = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    echo json_encode($preguntas);
?>