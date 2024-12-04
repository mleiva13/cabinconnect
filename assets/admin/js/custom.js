function cerrarSesion() {
    Swal.fire({
        title: "¿Cerrar Sesión?",
        text: "Se cerrará su Sesión...",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, salir!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = base_url + 'dashboard/salir'
        }
    });
}
