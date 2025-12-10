<?php
    require_once __DIR__ .'/../models/conexion.php';

    class ModeloAdministrador extends Conexion{
        public function __construct(){
            parent::__construct();
        }
        
        public function añadir($nombre,$contrasenia,$email,$tipo){
            try{
                $contrasenia_hash = password_hash($contrasenia, PASSWORD_DEFAULT);
            
                $sql = "INSERT INTO Usuarios(nombre, contrasenia, email, tipo) VALUES (?, ?, ?, ?)";

                $stmt = $this->conexion->prepare($sql);
                
                $stmt->bindValue(1, $nombre, PDO::PARAM_STR);
                $stmt->bindValue(2, $contrasenia_hash, PDO::PARAM_STR);
                $stmt->bindValue(3, $email, PDO::PARAM_STR);
                $stmt->bindValue(4, $tipo, PDO::PARAM_INT);
                
                $stmt->execute();
                
                return $this->conexion->lastInsertId();
            }catch(PDOException $e){
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
            
        }

        public function eliminar($id){
            try{
                $sql = "DELETE FROM Usuarios WHERE idUsuario = ?";

                $stmt = $this->conexion->prepare($sql);

                return $stmt->execute([$id]);

            }catch(PDOException $e){
                return 'Code error: ' . $e->getCode() . ' Mensaje error: ' . $e->getMessage();
            }
        }

        public function modificar($id, $nombre, $email, $tipo) {
            try {
                $sql = "UPDATE Usuarios SET nombre = ?, email = ?, tipo = ? WHERE idUsuario = ?";
                
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([$nombre, $email, $tipo, $id]);
                
                if($stmt->rowCount()>0){
                    return true;
                }else{
                    return "No se pudo modificar la pregunta";
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