<?php
// list_files.php - Lista archivos en la carpeta juego/
    header('Content-Type: text/plain');

    $path = 'juego/';
    if (is_dir($path)) {
        echo "Archivos en carpeta 'juego/':\n";
        echo "=============================\n";
        
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "- $file\n";
            }
        }
    } else {
        echo "La carpeta 'juego/' no existe\n";
        echo "Directorio actual: " . __DIR__ . "\n";
    }
?>