document.querySelectorAll('.logout-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Previene el comportamiento por defecto del enlace

        const href = this.getAttribute('href'); // Obtiene el href del enlace

        Swal.fire({
            title: '¿Realmente quieres cerrar sesión?',
            text: "No podrás revertir esto.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d4ac4c', // Color del botón "Sí"
            cancelButtonColor: '#d33', // Color del botón "No"
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'No, cancelar',
            customClass: {
                confirmButton: 'swal2-confirm swal2-styled',
                cancelButton: 'swal2-cancel swal2-styled'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href; // Redirige al href si se confirma
            }
        });
    });
});

$(document).ready(function () {
    var table = $('#usuarios').DataTable({
        pageLength: 10,
        "order": [],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});