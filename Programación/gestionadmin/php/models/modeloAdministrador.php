<?php
    require_once __DIR__ .'/../models/conexion.php';

    class ModeloAdministrador extends Conexion{
        public function __construct(){
            parent::__construct();
        }
        
        public function añadirAdministrador($nombre,$contrasenia,$email,$tipo){
            try{
                $contrasenia_hash = password_hash($contrasenia, PASSWORD_DEFAULT);
            
                $sql = "INSERT INTO Usuarios(nombre, contrasenia, email, tipo) VALUES (?, ?, ?, ?)";

                $stmt = $this->conexion->prepare($sql);
                
                $stmt->bindValue(1, $nombre, PDO::PARAM_STR);
                $stmt->bindValue(2, $contrasenia_hash, PDO::PARAM_STR);
                $stmt->bindValue(3, $email, PDO::PARAM_STR);
                $stmt->bindValue(4, 0, PDO::PARAM_INT);
                
                $stmt->execute();
                
                return $this->conexion->lastInsertId();
            }catch(PDOException $e){
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
            
        }

        public function eliminarAdministrador($id) {
            try {
                // PRIMERO: Eliminar los rankings de los juegos de este usuario
                $sql1 = "DELETE r FROM ranking r 
                        INNER JOIN juego j ON r.idJuego = j.idJuego 
                        WHERE j.idUsuario = ?";
                $stmt1 = $this->conexion->prepare($sql1);
                $stmt1->execute([$id]);
                
                // SEGUNDO: Eliminar los juegos de este usuario
                $sql2 = "DELETE FROM juego WHERE idUsuario = ?";
                $stmt2 = $this->conexion->prepare($sql2);
                $stmt2->execute([$id]);
                
                // TERCERO: Eliminar los temas creados por este usuario (si son NULL, se quedan)
                $sql3 = "UPDATE tema SET idUsuario = NULL WHERE idUsuario = ?";
                $stmt3 = $this->conexion->prepare($sql3);
                $stmt3->execute([$id]);
                
                // CUARTO: Ahora sí eliminar el usuario
                $sql4 = "DELETE FROM usuarios WHERE idUsuario = ?";
                $stmt4 = $this->conexion->prepare($sql4);
                $resultado = $stmt4->execute([$id]);
                
                return $resultado;
                
            } catch (PDOException $e) {
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
        }

        public function modificarAdministrador($id, $nombre, $email) {
            try {
                
                $sql = "UPDATE Usuarios SET nombre = ?, email = ? WHERE idUsuario = ?";
                
                $stmt = $this->conexion->prepare($sql);
                $success = $stmt->execute([$nombre, $email, $id]);
                
                if ($success) {
                    return true;
                } else {
                    $errorInfo = $stmt->errorInfo();
                    return "Error de BD: " . $errorInfo[2];
                }
                
            } catch (PDOException $e) {
                return 'Error: ' . $e->getMessage();
            }
        }

        public function traerAdministrador($id) {
            try {
                $sql = "SELECT * FROM Usuarios WHERE idUsuario = ? AND tipo = 0";
                
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$id]);
                
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($resultado) {
                    return $resultado;
                } else {
                    return false; 
                }
                
            } catch (PDOException $e) {
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
        }

        function iniciarSesion($email){
            $sql= "SELECT * FROM usuarios WHERE email= :email";
             // Preparamos la consulta con PDO;
            $preparacion=$this->conexion->prepare($sql);

            $preparacion->execute([
                ':email' => $email,
            ]);
            
            $resultado = $preparacion->fetch(PDO::FETCH_ASSOC);//devuelve un array asociativo con los nombres de columna como claves
            return $resultado; /*Si no hay resultados return TRUE*/
        }

        public function listarAdministradores() {
            try {
                $sql = "SELECT * FROM Usuarios WHERE tipo = 0";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
        }

    }
?>