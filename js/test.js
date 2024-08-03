const fnGuardarSubActividad = async () => {
    const actividad = document.getElementById('guardarNombreSubActividadInput').value.trim();
    const diagnostico = document.getElementById('guardarDiagnosticoSubActividadInput').value.trim();
    const trabajos = document.getElementById('guardarTrabajoSubActividadInput').value.trim();
    const observaciones = document.getElementById('guardarObservacionSubActividadInput').value.trim();
    
    // Verificar si se ha ingresado nombre de subactividad
    if (!actividad) {
        Swal.fire({
            title: 'Aviso',
            text: 'Debe ingresar el nombre de la subactividad.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Obtener ID del informe y del ownid
    const infid = document.getElementById('guardarSubActividadInput').value;
    const ownid = document.getElementById('cabeceraIdInput').value;

    // Crear FormData
    const formData = new FormData();
    formData.append('infid', infid);
    formData.append('ownid', ownid);
    formData.append('actividad', actividad);
    formData.append('diagnostico', diagnostico);
    formData.append('trabajos', trabajos);
    formData.append('observaciones', observaciones);

    try {
        const response = await fetch('http://localhost/informes/insert/AgregarSubActividad.php', {
            method: 'POST',
            body: formData
        });

        // Verificar si la respuesta es válida
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();

        // Manejar la respuesta del servidor
        if (result.res) {
            Swal.fire({
                title: 'Éxito',
                text: result.msg,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalNuevaSubActividad'));
                if (modalInstance) {
                    modalInstance.hide();
                }
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: result.msg,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Error',
            text: `Se produjo un error inesperado: ${error.message}`,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
};
