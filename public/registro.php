<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de Pedidos | Mercado Insurgente</title>
    <link rel="shortcut icon" href="../views/assets/dist/img/favicon.png" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../views/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../views/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../views/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../views/assets/dist/css/estilosv1.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-warning">
            <div class="card-header text-center">
                <img src="../views/assets/dist/img/logo.png" alt="logo" style="max-width: 100%;padding: 10px;"><br />
            </div>
            <div class="card-body">
                <p class="login-box-msg">Registrate ¡Ahora!</p>
                <div class="alert alert-success alert-dismissible fade show" id="registro_exitoso" role="alert" style="display: none;">
                    ¡Felicidades! Te has registrado con exito.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formulario_adduser">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name='nombre' placeholder="Nombre completo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="correo" placeholder="Correo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="confirma_clave" placeholder="Repite contraseña">
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

                <a href="login.php" class="text-center">¿Ya tienes cuenta? Inicia sesion</a>
            </div>
        </div>
    </div>
    <script src="../views/assets/plugins/jquery/jquery.min.js"></script>
    <script src="../views/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../views/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../views/assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="../views/assets/dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    var formData = $(form).serialize();

                    $.ajax({
                        type: "POST",
                        url: "../controllers/usuarios/UsuariosController.php", // Cambia la URL al controlador correspondiente
                        data: formData,
                        dataType: 'json', // Esperamos una respuesta JSON
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#formulario_adduser')[0].reset();
                                document.getElementById('registro_exitoso').style.display = 'block'; // URL a donde redirigir
                            } else {
                                $('#formulario_adduser')[0].reset();
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario: " + error);
                        }
                    });
                }
            });

            $('#formulario_adduser').validate({
                rules: {
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
                    },
                    confirma_clave: {
                        required: true,
                        equalTo: "[name='clave']" // Verifica que coincida con la contraseña
                    }
                },
                messages: {
                    nombre: {
                        required: "Por favor, ingrese su nombre.",
                        minlength: "El nombre debe tener al menos 2 caracteres."
                    },
                    correo: {
                        required: "Por favor, ingrese su correo.",
                        email: "Por favor, ingrese un correo válido."
                    },
                    clave: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "La contraseña debe tener al menos 5 caracteres."
                    },
                    confirma_clave: {
                        required: "Por favor, repita la contraseña.",
                        equalTo: "Las contraseñas no coinciden."
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
                    if ($(element).attr('name') === 'nombre') {
                        $('.input-group-text .fas').eq(0).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'correo') {
                        $('.input-group-text .fas').eq(1).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'clave') {
                        $('.input-group-text .fas').eq(2).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'confirma_clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-warning').addClass('text-danger');
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');

                    // Restaurar a text-warning si no hay errores
                    if ($(element).attr('name') === 'nombre') {
                        $('.input-group-text .fas').eq(0).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'correo') {
                        $('.input-group-text .fas').eq(1).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'clave') {
                        $('.input-group-text .fas').eq(2).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'confirma_clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-danger').addClass('text-warning');
                    }
                }
            });
        });
    </script>
</body>

</html>