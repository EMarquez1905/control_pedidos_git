<?php
class Database {
    private $host = 'localhost'; // Cambia según tu configuración
    private $db_name = 'control_pedidos'; // Nombre de tu base de datos
    private $username = 'root'; // Usuario de la base de datos
    private $password = ''; // Contraseña de la base de datos
    public $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    // Método para preparar consultas
    public function prepare($query) {
        return $this->conn->prepare($query);
    }
}
?>
