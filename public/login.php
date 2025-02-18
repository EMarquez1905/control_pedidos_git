<?php
session_start();
if (!empty($_SESSION['activa'])) {
  header("location: ../views/home.php");
}

?>
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

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-warning">
      <div class="card-header text-center">
        <img src="../views/assets/dist/img/logo.png" alt="logo" style="max-width: 100%;padding: 10px;"><br />
      </div>
      <div class="card-body">
        <p class="login-box-msg">Ingresa con tu cuenta al sistema.</p>
        <div class="alert alert-danger alert-dismissible fade show" id="login_error" role="alert" style="display: none;">
          Credenciales incorrectas
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="quickForm">
          <div class="form-group mb-3">
            <div class="input-group">
              <input type="email" class="form-control" name="correo" placeholder="Correo">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope text-warning"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" class="form-control" name="clave" placeholder="Contraseña">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock text-warning"></span>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-warning btn-block">INICIA SESION</button>
            </div>
          </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
        </div>
        <p class="mb-1">
          <a href="cambiar_contrasena.php">¿No recuerdas tu contraseña?</a>
        </p>
        <p class="mb-0">
          <a href="registro.php" class="text-center">¿No tienes cuenta?</a>
        </p>
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
            url: "../controllers/login/LoginController.php",
            data: formData,
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                $('#quickForm')[0].reset();
                window.location.href = response.redirect;
              } else {
                $('#quickForm')[0].reset();
                document.getElementById('login_error').style.display = 'block';
              }
            },
            error: function(xhr, status, error) {
              alert("Error al enviar el formulario: " + error);
            }
          });
        }
      });

      $('#quickForm').validate({
        rules: {
          correo: {
            required: true,
            email: true,
          },
          clave: {
            required: true,
            minlength: 5
          }
        },
        messages: {
          correo: {
            required: "Por favor, ingrese su correo.",
            email: "Por favor, ingrese un correo válido."
          },
          clave: {
            required: "Por favor, ingrese su contraseña."
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');

          // Cambiar a text-danger en caso de error
          if ($(element).attr('name') === 'correo') {
            $('.input-group-text .fas').eq(0).removeClass('text-warning').addClass('text-danger');
          } else if ($(element).attr('name') === 'clave') {
            $('.input-group-text .fas').eq(1).removeClass('text-warning').addClass('text-danger');
          }
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');

          // Restaurar a text-warning si no hay errores
          if ($(element).attr('name') === 'correo') {
            $('.input-group-text .fas').eq(0).removeClass('text-danger').addClass('text-warning');
          } else if ($(element).attr('name') === 'clave') {
            $('.input-group-text .fas').eq(1).removeClass('text-danger').addClass('text-warning');
          }
        }
      });
    });
  </script>
</body>

</html>