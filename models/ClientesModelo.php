<?php

class ClientesModelo
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregar_cliente($nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $email, $razon_fiscal, $usuario_captura, $estatus)
    {
        date_default_timezone_set('America/Mexico_City');

        // Obtener la fecha y hora actual de México
        $fecha_captura = date('Y-m-d H:i:s');

        $query = "INSERT INTO clientes 
              (nombre, rfc, direccion, telefono, nombre_contacto, telefono_contacto, email, razon_fiscal, usuario_captura, estatus, fecha_captura) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // 11 parámetros

       
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Vincular los parámetros
            $stmt->bind_param(
                'sssssssssss', 
                $nombre,
                $rfc,
                $direccion,
                $telefono,
                $nombre_contacto,
                $telefono_contacto,
                $email,
                $razon_fiscal,
                $usuario_captura,
                $estatus,
                $fecha_captura
            );

            return $stmt->execute();
        } else {
            return false;
        }
    }

    public function obtener_clientes()
    {
        $query = "SELECT * FROM clientes WHERE estatus = 'activo'";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
    }

    public function actualizar_cliente($id_cliente, $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $email, $razon_fiscal, $estatus)
    {
        $query = "UPDATE clientes SET nombre = ?, rfc = ?, direccion = ?, telefono = ?, nombre_contacto = ?, telefono_contacto = ?, email = ?, razon_fiscal = ?, estatus = ? WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('sssssssssi', $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $email, $razon_fiscal, $estatus, $id_cliente);
            return $stmt->execute();
        } else {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
    }

    public function eliminar_cliente($id_cliente)
    {
        $query = "UPDATE clientes SET estatus = 'inactivo' WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id_cliente);
            return $stmt->execute();
        } else {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
    }

    public function generar_tabla($clientes)
    {
        $tabla = '';
        if (!empty($clientes)) {
            foreach ($clientes as $cliente) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . htmlspecialchars($cliente['id_cliente']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['nombre']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['rfc']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['direccion']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['telefono']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['nombre_contacto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['telefono_contacto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['email']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['razon_fiscal']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['fecha_captura']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($cliente['estatus']) . '</td>';
                $tabla .= '<td>';
                $tabla .= '<a onclick="actualizarModal(\'' . $cliente['id_cliente'] . '\',
                                                   \'' . $cliente['nombre'] . '\',
                                                   \'' . $cliente['rfc'] . '\',
                                                   \'' . $cliente['direccion'] . '\',
                                                   \'' . $cliente['telefono'] . '\',
                                                   \'' . $cliente['nombre_contacto'] . '\',
                                                   \'' . $cliente['telefono_contacto'] . '\',
                                                   \'' . $cliente['email'] . '\',
                                                   \'' . $cliente['razon_fiscal'] . '\',
                                                   \'' . $cliente['estatus'] . '\')" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a> ';
                $tabla .= '<a data-id="' . htmlspecialchars($cliente['id_cliente']) . '" class="btn btn-sm btn-danger delete-class"><i class="fas fa-trash"></i></a>';
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="12">No hay clientes registrados.</td></tr>';
        }
        return $tabla;
    }
}
