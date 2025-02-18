<?php
class LoginModelo {
    private $conn;

    // Constructor para establecer la conexión a la base de datos
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para autenticar al usuario
    public function login($correo, $clave) {
        // Sanitizar los datos
        $correo = htmlspecialchars(strip_tags($correo));
        $clave = htmlspecialchars(strip_tags($clave));

        // Preparar la consulta SQL
        $query = "SELECT id_usuario, correo, nombre, clave, imagen FROM usuarios WHERE correo = ? LIMIT 1";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el usuario
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($clave, $usuario['clave'])) {
                // Retornar el usuario si las credenciales son correctas
                return $usuario;
            } else {
                // Contraseña incorrecta
                return null;
            }
        }

        // No se encontró el usuario
        return null;
    }
}
?>