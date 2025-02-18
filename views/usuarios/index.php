<?php
session_start();
if (empty($_SESSION['activa'])) {
    header("Location: ../../public/login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<?php include("../includes/header.php"); ?>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php include("../includes/navbar.php") ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><i class="fas fa-users"></i>&nbsp;&nbsp;Listado de Usuarios</h1>
                            <p>En esta sección se administrará todos los usuarios del sistema.</p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $root; ?>views/home.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Catálogos</li>
                                <li class="breadcrumb-item active">Usuarios</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="add-header">
                                <button type="button" data-toggle="modal" data-target="#usuario_add" class="btn btn-warning">Agregar Usuario&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                                <div class="modal fade modal_usuario_add" id="usuario_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Agregar Usuario</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-success alert-dismissible fade show" id="registro_exitoso" role="alert" style="display: none;">
                                                    ¡Felicidades! Has registrado con exito el usuario.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="formUsuarioAdd">
                                                    <label class="form-label" style="width: 100%;">Perfil:</label>
                                                    <div class="input-group mb-3">
                                                        <select class="custom-select" name="perfil" id="inputGroupSelect02">
                                                            <option selected>Selecciona un perfil</option>
                                                            <option value="1">Administrador</option>
                                                            <option value="2">Operador</option>
                                                            <option value="3">Consultor</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect02"><i class="fas fa-user text-warning"></i></label>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Nombre:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name='nombre' placeholder="Nombre completo">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Correo:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="email" class="form-control" name="correo" placeholder="Correo">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-envelope text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Contraseña:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" class="form-control" name="clave" placeholder="Contraseña">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-lock text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-warning btn-block">Registrate</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="usuarios" class="table table-bordered table-striped">
                                    <thead class="table-thead-section">
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Perfil</th>
                                        <th>Imagen</th>
                                        <th>Fecha de Registro</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../../config/database.php");
                                        require_once("../../models/UsuariosModelo.php");

                                        $usuarioModelo = new UsuariosModelo();

                                        $usuarios = $usuarioModelo->obtener_usuarios();
                                        $tabla = $usuarioModelo->generar_tabla($usuarios);

                                        echo $tabla;

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../includes/footer.php") ?>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script>
        $(document).ready(function() {
            // Detectar clic en cualquier botón con clase delete_usuario
            $('.delete_usuario').on('click', function(e) {
                e.preventDefault(); // Prevenir el comportamiento por defecto del enlace

                // Obtener el ID del usuario desde el atributo data-id del botón que fue clickeado
                const usuarioId = $(this).data('id');

                // Mostrar alerta de confirmación con SweetAlert
                Swal.fire({
                    title: '¿Realmente quieres cerrar sesión?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d4ac4c', // Color del botón "Sí"
                    cancelButtonColor: '#d33', // Color del botón "No"
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'No, cancelar',
                    customClass: {
                        confirmButton: 'swal2-confirm swal2-styled',
                        cancelButton: 'swal2-cancel swal2-styled'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Realizar la petición AJAX si el usuario confirma
                        $.ajax({
                            url: '../../controllers/usuarios/UsuariosController.php', // Cambia esto al nombre de tu archivo controlador
                            type: 'POST',
                            data: {
                                usuario_delete_id: usuarioId // Enviamos el ID del usuario
                            },
                            success: function(response) {
                                // Convertir la respuesta en JSON
                                const res = JSON.parse(response);

                                // Verificar si la eliminación fue exitosa
                                if (res.status === 'success') {
                                    Swal.fire(
                                        'Eliminado',
                                        res.message,
                                        'success'
                                    ).then(() => {
                                        // Opcional: Recargar la página o eliminar la fila del usuario
                                        location.reload(); // Recarga la página
                                        // O eliminar la fila directamente:
                                        // $(`[data-id="${usuarioId}"]`).closest('tr').remove();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        res.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                // Manejar errores
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al intentar eliminar el usuario.',
                                    'error'
                                );
                                console.error('Error al eliminar el usuario:', error);
                            }
                        });
                    }
                });
            });
        });

        function actualizar(id_usuario) {
            // Seleccionar el formulario específico por su ID
            var form = document.getElementById('form_update_' + id_usuario);

            // Crear un objeto FormData a partir del formulario
            var formData = new FormData(form);

            // Convertir FormData a un formato que pueda ser enviado por AJAX (opcional)
            var data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            console.log(data); // Verificar los datos antes de enviarlos

            // Enviar los datos mediante AJAX
            $.ajax({
                type: "POST",
                url: "../../controllers/usuarios/UsuariosController.php", // Cambia la URL al controlador correspondiente
                data: data, // Enviar los datos serializados
                dataType: 'json', // Esperamos una respuesta JSON del servidor
                processData: true, // Necesario para enviar datos correctamente
                success: function(response) {
                    // Manejar la respuesta del servidor
                    if (response.status === 'success') {
                        Swal.fire(
                            'Actualizado',
                            response.message,
                            'success'
                        ).then(() => {
                            // Opcional: Recargar la página o limpiar el formulario
                            location.reload(); // Recarga la página
                        });
                    } else {
                        // Si hubo un error en la actualización
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    Swal.fire(
                        'Error',
                        'Hubo un problema al intentar actualizar la información.',
                        'error'
                    );
                    console.error("Error al enviar el formulario:", error);
                }
            });
        }

        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    var formData = $(form).serialize();

                    $.ajax({
                        type: "POST",
                        url: "../../controllers/usuarios/UsuariosController.php", // Cambia la URL al controlador correspondiente
                        data: formData,
                        dataType: 'json', // Esperamos una respuesta JSON
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#formUsuarioAdd')[0].reset();
                                Swal.fire(
                                    'Usuario Agregado',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Opcional: Recargar la página o limpiar el formulario
                                    location.reload(); // Recarga la página
                                });
                            } else {
                                $('#formUsuarioAdd')[0].reset();
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario: " + error);
                        }
                    });
                }
            });

            $('#formUsuarioAdd').validate({
                rules: {
                    perfil: {
                        required: true
                    },
                    nombre: {
                        required: true,
                        minlength: 2
                    },
                    correo: {
                        required: true,
                        email: true
                    },
                    clave: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    perfil: {
                        required: "Por favor, selecciona un perfil.",
                        minlength: "El nombre debe tener al menos 2 caracteres."
                    },
                    nombre: {
                        required: "Por favor, ingrese un nombre.",
                        minlength: "El nombre debe tener al menos 2 caracteres."
                    },
                    correo: {
                        required: "Por favor, ingrese un correo.",
                        email: "Por favor, ingrese un correo válido."
                    },
                    clave: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "La contraseña debe tener al menos 5 caracteres."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');

                    // Cambiar a text-danger en caso de error
                    if ($(element).attr('name') === 'perfil') {
                        $('.input-group-text .fas').eq(0).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'nombre') {
                        $('.input-group-text .fas').eq(1).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'correo') {
                        $('.input-group-text .fas').eq(2).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-warning').addClass('text-danger');
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    // Restaurar a text-warning si no hay errores
                    if ($(element).attr('name') === 'perfil') {
                        $('.input-group-text .fas').eq(0).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'nombre') {
                        $('.input-group-text .fas').eq(1).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'correo') {
                        $('.input-group-text .fas').eq(2).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-danger').addClass('text-warning');
                    }
                }
            });
        });
    </script>
</body>

</html>