<?php
    header('Content-Type: application/json; charset=utf-8');

    require_once "Config/Conexion.php";

    try {
        $db = new Conexion();

        $idTema = isset($_GET['idTema']) ? intval($_GET['idTema']) : 1;

        // Obtener preguntas
        $stmt = $db->conexion->prepare("SELECT * FROM preguntas WHERE idTema = ?");
        if (!$stmt) throw new Exception('Prepare failed: ' . $db->conexion->error);
        $stmt->bind_param("i", $idTema);
        $stmt->execute();
        $result = $stmt->get_result();
        $preguntas = $result->fetch_all(MYSQLI_ASSOC);

        // Para cada pregunta, obtener respuestas
        foreach ($preguntas as &$p) {
            $stmt2 = $db->conexion->prepare("SELECT * FROM respuestas WHERE idTema = ? AND nPregunta = ?");
            if (!$stmt2) throw new Exception('Prepare failed (respuestas): ' . $db->conexion->error);
            $stmt2->bind_param("ii", $p['idTema'], $p['nPregunta']);
            $stmt2->execute();
            $res = $stmt2->get_result();
            $p['respuestas'] = $res->fetch_all(MYSQLI_ASSOC);
        }

        echo json_encode($preguntas, JSON_UNESCAPED_UNICODE);
        $db->cerrarConexion();
    } catch (Exception $e) {
        http_response_code(500);
        // Responde siempre JSON 
        echo json_encode(['error' => true, 'message' => $e->getMessage()]);
    }
?>