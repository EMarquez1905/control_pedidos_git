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
                            <h1 class="m-0"><i class="fas fa-users"></i>&nbsp;&nbsp;Listado de Clientes</h1>
                            <p>En esta sección se administrará todos los clientes del sistema. <?php echo $_SESSION['activa'] ?></p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $root; ?>views/home.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Catálogos</li>
                                <li class="breadcrumb-item active">Clientes</li>
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
                                <button type="button" data-toggle="modal" data-target="#cliente_add" class="btn btn-warning">Agregar Cliente&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                                <!-- Modal de agregar -->
                                <div class="modal fade modal_cliente_add" id="cliente_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-users"></i>&nbsp;&nbsp;Agregar Cliente</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-success alert-dismissible fade show" id="registro_exitoso" role="alert" style="display: none;">
                                                    ¡Felicidades! Has registrado con éxito el clientes.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="formClienteAdd">

                                                    <input type="hidden" class="form-control" name='usuario_captura' value="<?php echo $_SESSION['usuario_id'] ?>">
                                                    <input type="hidden" class="form-control" name='accion' value='agregar'>

                                                    <label class="form-label" style="width: 100%;">Nombre:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name='nombre' placeholder="Nombre del cliente">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">RFC:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="rfc" placeholder="RFC">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-id-card text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Dirección:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="direccion" placeholder="Dirección">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-map-marker-alt text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Teléfono:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="telefono" placeholder="Teléfono">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Nombre de Contacto:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="nombre_contacto" placeholder="Nombre de contacto">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Teléfono de Contacto:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="telefono_contacto" placeholder="Teléfono de contacto">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Email:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-envelope text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Razón Fiscal:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="razon_fiscal" placeholder="Razón fiscal">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-building text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Estatus:</label>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" name="estatus">
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-toggle-on text-success"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-warning btn-block">Registrar Cliente</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de actualizar -->
                                <div class="modal fade modal_cliente_add" id="cliente_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-sync"></i>&nbsp;&nbsp;Actualizar Cliente</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-success alert-dismissible fade show" id="update_exitoso" role="alert" style="display: none;">
                                                    ¡Felicidades! Has actualizado con éxito el cliente.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="form_update">

                                                    <input type="hidden" class="form-control" id="id_clienteUp" name='id_cliente' value=''>
                                                    <input type="hidden" class="form-control" name='accion' value='actualizar'>

                                                    <label class="form-label" style="width: 100%;">Nombre:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id='nombreUp' name='nombre' placeholder="Nombre del cliente">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">RFC:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="rfcUp" name="rfc" placeholder="RFC">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-id-card text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Dirección:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="direccionUp" name="direccion" placeholder="Dirección">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-map-marker-alt text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Teléfono:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="telefonoUp" name="telefono" placeholder="Teléfono">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Nombre de Contacto:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="nombre_contactoUp" name="nombre_contacto" placeholder="Nombre de contacto">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Teléfono de Contacto:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="telefono_contactoUp" name="telefono_contacto" placeholder="Teléfono de contacto">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Email:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="email" class="form-control" id="emailUp" name="email" placeholder="Email">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-envelope text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Razón Fiscal:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="razon_fiscalUp" name="razon_fiscal" placeholder="Razón fiscal">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-building text-warning"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-label" style="width: 100%;">Estatus:</label>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" id="estatusUp" name="estatus">
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-toggle-on text-success"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <button type="button" onclick="actualizar()" class="btn btn-warning btn-block">Actualizar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="clientes" class="table table-bordered table-striped">
                                    <thead class="table-thead-section">
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>RFC</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Nombre de Contacto</th>
                                        <th>Teléfono de Contacto</th>
                                        <th>Email</th>
                                        <th>Razón Fiscal</th>
                                        <th>Fecha de Registro</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../../config/database.php");
                                        require_once("../../models/ClientesModelo.php");

                                        $clienteModelo = new ClientesModelo();

                                        $clientes = $clienteModelo->obtener_clientes();
                                        $tabla = $clienteModelo->generar_tabla($clientes);

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
            // Detectar clic en cualquier botón con clase delete_cliente

            $('.delete-class').on('click', function(e) {
                e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
                console.log("delete")

                // Obtener el ID del cliente desde el atributo data-id del botón que fue clickeado
                const clienteId = $(this).data('id');

                // Mostrar alerta de confirmación con SweetAlert
                Swal.fire({
                    title: '¿Realmente quieres eliminar este cliente?',
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
                            url: '../../controllers/clientes/ClientesController.php', // Cambia esto al nombre de tu archivo controlador
                            type: 'POST',
                            data: {
                                accion: 'eliminar',
                                id_cliente: clienteId // Enviamos el ID del cliente
                            },
                            success: function(response) {
                                // Convertir la respuesta en JSON

                                console.log("Res", response)
                                const res = response;

                                // Verificar si la eliminación fue exitosa
                                if (res.status === 'success') {
                                    Swal.fire(
                                        'Eliminado',
                                        res.message,
                                        'success'
                                    ).then(() => {
                                        // Opcional: Recargar la página o eliminar la fila del cliente
                                        location.reload(); // Recarga la página
                                        // O eliminar la fila directamente:
                                        // $(`[data-id="${clienteId}"]`).closest('tr').remove();
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
                                    'Hubo un problema al intentar eliminar el cliente.',
                                    'error'
                                );
                                console.error('Error al eliminar el cliente:', error);
                            }
                        });
                    }
                });
            });
        });

        function actualizar() {
            // Seleccionar el formulario específico por su ID
            var form = document.getElementById('form_update');

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
                url: "../../controllers/clientes/ClientesController.php", // Cambia la URL al controlador correspondiente
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

        // Abre el modal y pone los datos
        function actualizarModal(id_cliente, nombre, rfc, direccion, telefono, nombre_contacto,
            telefono_contacto, email, razon_fiscal, estatus) {
            $('#cliente_update').modal('show');
            $("#id_clienteUp").val(id_cliente)
            $("#nombreUp").val(nombre);
            $("#rfcUp").val(rfc);
            $("#direccionUp").val(direccion);
            $("#telefonoUp").val(telefono);
            $("#nombre_contactoUp").val(nombre_contacto);
            $("#telefono_contactoUp").val(telefono_contacto);
            $("#emailUp").val(email);
            $("#razon_fiscalUp").val(razon_fiscal);
        }

        // Agregar proovedor
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    var formData = $(form).serialize();
                    console.log("Formulario", formData);

                    $.ajax({
                        type: "POST",
                        url: "../../controllers/clientes/ClientesController.php", // Cambia la URL al controlador correspondiente
                        data: formData,
                        dataType: 'json', // Esperamos una respuesta JSON
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#formClienteAdd')[0].reset();
                                Swal.fire(
                                    'Cliente Agregado',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Opcional: Recargar la página o limpiar el formulario
                                    location.reload(); // Recarga la página
                                });
                            } else {
                                $('#formClienteAdd')[0].reset();
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario: " + error);
                        }
                    });
                }
            });

            $('#formClienteAdd').validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 2
                    },
                    rfc: {
                        required: true,
                        minlength: 12
                    },
                    direccion: {
                        required: true
                    },
                    telefono: {
                        required: true
                    },
                    nombre_contacto: {
                        required: true
                    },
                    telefono_contacto: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    razon_fiscal: {
                        required: true
                    }
                },
                messages: {
                    nombre: {
                        required: "Por favor, ingrese un nombre.",
                        minlength: "El nombre debe tener al menos 2 caracteres."
                    },
                    rfc: {
                        required: "Por favor, ingrese un RFC.",
                        minlength: "El RFC debe tener al menos 12 caracteres."
                    },
                    direccion: {
                        required: "Por favor, ingrese una dirección."
                    },
                    telefono: {
                        required: "Por favor, ingrese un teléfono."
                    },
                    nombre_contacto: {
                        required: "Por favor, ingrese un nombre de contacto."
                    },
                    telefono_contacto: {
                        required: "Por favor, ingrese un teléfono de contacto."
                    },
                    email: {
                        required: "Por favor, ingrese un correo.",
                        email: "Por favor, ingrese un correo válido."
                    },
                    razon_fiscal: {
                        required: "Por favor, ingrese una razón fiscal."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>