<?php
// API: consultarPreguntas.php
// Devuelve JSON con las preguntas y sus respuestas para un tema dado.

// Desactivar la visualización de errores en salida (para no romper JSON)
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// CORS - permitir desarrollo desde localhost:8080
$allowed_origin = 'http://localhost:8080';
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === $allowed_origin) {
    header('Access-Control-Allow-Origin: ' . $allowed_origin);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Responder preflight
    http_response_code(204);
    exit(0);
}

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
    // Responder siempre JSON con clave 'error'
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

?>