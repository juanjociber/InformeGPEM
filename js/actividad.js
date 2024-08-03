// INICIALIZANDO VARIABLES PARA MODAL GLOBAL
let modalEditarActividad;

document.addEventListener('DOMContentLoaded', () => {
  modalEditarActividad = new bootstrap.Modal(document.getElementById('modalEditarActividad'), { keyboard: false });
});

//FUNCIÓN CREA ACTIVIDAD
const fnCrearActividad = async () => {
  const actividad = document.getElementById('guardarNombreActividadInput').value.trim();
  const diagnostico = document.getElementById('guardarDiagnosticoInput').value.trim();
  const trabajos = document.getElementById('guardarTrabajoInput').value.trim();
  const observaciones = document.getElementById('guardarObservacionInput').value.trim();
  if (!actividad) {
      Swal.fire({
          title: 'Aviso',
          text: 'Por favor, ingrese el nombre de la actividad.',
          icon: 'info',
          confirmButtonText: 'OK',
          timer:2000
      });
      return;
  }
  const infid = document.getElementById('guardarActividadInput').value;
  const formData = new FormData();
  formData.append('infid', infid);
  formData.append('actividad', actividad);
  formData.append('diagnostico', diagnostico);
  formData.append('trabajos', trabajos);
  formData.append('observaciones', observaciones);

  try {
    const response = await fetch('http://localhost/informes/insert/AgregarActividad.php', {
        method: 'POST',
        body: formData
    });
    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();

    if (result.res) {
        Swal.fire({
            title: 'Éxito',
            text: result.msg,
            icon: 'success',
            confirmButtonText: 'OK',
            timer:2000
        }).then(() => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaActividad'));
            if (modal) {
                modal.hide();
            }
            location.reload();
        });
    } else {
        Swal.fire({
          title: 'Error',
          text: result.msg,
          icon: 'error',
          confirmButtonText: 'OK',
          timer:2000
        });
    }
  } catch (error) {
      Swal.fire({
        title: 'Error',
        text: `Se produjo un error inesperado: ${error.message}`,
        icon: 'error',
        confirmButtonText: 'OK',
        timer:2000
      });
  }
};


// CREAR SUBACTIVIDAD
const fnCrearSubActividad = async (id) => {
  const modal = new bootstrap.Modal(document.getElementById('modalNuevaSubActividad'), { keyboard: false });
  modal.show();
  console.log(id)
  document.getElementById('cabeceraIdInput').value = id;
};

// GUARDAR SUB-ACTIVIDAD
const fnGuardarSubActividad = async () =>{
  const actividad = document.getElementById('guardarNombreSubActividadInput').value.trim();
  const diagnostico = document.getElementById('guardarDiagnosticoSubActividadInput').value.trim();
  const trabajos = document.getElementById('guardarTrabajoSubActividadInput').value.trim();
  const observaciones = document.getElementById('guardarObservacionSubActividadInput').value.trim(); 
  // VERIFICAR SI SE HA INGRESADO NOMBRE DE ACTIVIDAD
  if (!actividad) {
    Swal.fire({
      title: 'Aviso',
      text: 'Debe ingresar el nombre de la subactividad.',
      icon: 'info',
      confirmButtonText: 'OK',
      timer:2000
  });
  return;
  }
  // OBTENIENDO ID DEL INFORME
  const infid = document.getElementById('guardarSubActividadInput').value; 
  const ownid = document.getElementById('cabeceraIdInput').value; 
  // CREAR FORM-DATA
  const formData = new FormData();
  formData.append('infid', infid);
  formData.append('ownid', ownid);
  formData.append('actividad', actividad);
  formData.append('diagnostico', diagnostico);
  formData.append('trabajos', trabajos);
  formData.append('observaciones', observaciones);
  console.log(infid,ownid, actividad, diagnostico, trabajos, observaciones);

  try {
    const response = await fetch('http://localhost/informes/insert/AgregarActividad.php', {
      method: 'POST',
      body: formData
    });
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const result = await response.json();

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
          setTimeout(() => {
            location.reload();  
          }, 2000);
      });
    } else {
      Swal.fire({
        title: 'Error',
        text: result.msg,
        icon: 'error',
        confirmButtonText: 'OK',
        timer:2000
      });
    }
  } catch (error) {
    Swal.fire({
      title: 'Error',
      text: `Se produjo un error inesperado: ${error.message}`,
      icon: 'error',
      confirmButtonText: 'OK',
      timer:2000
    });
  }
};

//BUSCAR ACTIVIDAD
const fnEditarActividad = async (id) => {
  // Mostrar modal
  modalEditarActividad.show();
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/search/buscarActividad.php', {
        method: 'POST',
        body: formData
    });

    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const datos = await response.json();

    if (!datos.res) {
        throw new Error(datos.msg);
    }
    document.getElementById('editarActividadInput').value = datos.data.id;
    document.getElementById('editarNombreActividadInput').value = datos.data.actividad;
    document.getElementById('editarDiagnosticoInput').value = datos.data.diagnostico;
    document.getElementById('editarTrabajoInput').value = datos.data.trabajos;
    document.getElementById('editarObservacionInput').value = datos.data.observaciones;
  } catch (error) {
    Swal.fire({
        title: 'Error',
        text: error.message,
        icon: 'error',
        confirmButtonText: 'OK',
        timer:2000
    });
  }
};


//MODIFICAR ACTIVIDAD
const FnModificarActividad = async () => {
  const id = document.getElementById('editarActividadInput').value;
  const actividad = document.getElementById('editarNombreActividadInput').value;
  const diagnostico = document.getElementById('editarDiagnosticoInput').value;
  const trabajo = document.getElementById('editarTrabajoInput').value;
  const observacion = document.getElementById('editarObservacionInput').value;

  const formData = new FormData();
  formData.append('id', id);
  formData.append('actividad', actividad);
  formData.append('diagnostico', diagnostico);
  formData.append('trabajos', trabajo);
  formData.append('observaciones', observacion);

  try {
    const response = await fetch('http://localhost/informes/update/ModificarActividad.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      throw new Error(`Error: ${response.status} ${response.statusText}`);
    }

    const datos = await response.json();

    if (!datos.res) {
      throw new Error(datos.msg);
    }
    document.querySelector(`#accordion-header-${id} .accordion-button`).textContent = actividad;
    document.getElementById(`diagnostico-${id}`).textContent = diagnostico;
    document.getElementById(`trabajo-${id}`).textContent = trabajo;
    document.getElementById(`observacion-${id}`).textContent = observacion;
    Swal.fire({
      title: 'Éxito',
      text: datos.msg,
      icon: 'success',
      confirmButtonText: 'OK',
      timer:2000
    });

    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalEditarActividad'));
    if (modalInstance) {
      modalInstance.hide();
    }

  } catch (error) {
    Swal.fire({
      title: 'Error',
      text: error.message,
      icon: 'error',
      confirmButtonText: 'OK',
      timer:2000
    });
  }
};

// ABRIR MODAL REGISTRAR IMAGEN
const fnAbrirModalRegistrarImagen = (id) => {
  const modal = new bootstrap.Modal(document.getElementById('modalAgregarImagen'), { keyboard: false });
  modal.show();
  document.getElementById('cabeceraIdInput').value = id;

};

// REGISTRAR IMAGEN
const fnRegistrarImagen = async () => {
  const id = document.getElementById('cabeceraIdInput').value;
  const titulo = document.getElementById('registrarTituloInput').value;
  const descripcion = document.getElementById('registarDescripcionInput').value;
  const archivo = document.getElementById('adjuntarImagenInput').files[0];

  if (!id || !titulo || !descripcion || !archivo) {
    Swal.fire({
      title: "Error",
      text: "Todos los campos son obligatorios.",
      icon: "error"
    });
    return;
  }

  const reader = new FileReader();
  reader.onloadend = async () => {
  const base64 = reader.result.split(',')[1]; 
  const formData = new FormData();
  formData.append('refid', id);
  formData.append('titulo', titulo);
  formData.append('descripcion', descripcion);
  formData.append('archivo', base64); 

  try {
    const response = await fetch('http://localhost/informes/insert/AgregarArchivo.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      throw new Error(`Error: ${response.status} ${response.statusText}`);
    }

    const result = await response.json();

    if (result.res) {
      Swal.fire({
        title: "Éxito",
        text: result.msg,
        icon: "success",
        timer:2000
      });

      document.getElementById('registrarTituloInput').value = '';
      document.getElementById('registarDescripcionInput').value = '';
      document.getElementById('adjuntarImagenInput').value = '';
      const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
      if (modalInstance) {
        modalInstance.hide();
      }
      
      setTimeout(() => {
        location.reload();  
      }, 1000);
    } else {
      Swal.fire({
        title: "Error",
        text: result.msg,
        icon: "error",
        timer:2000
      });
    }
  } catch (error) {
    Swal.fire({
      title: "Error",
      text: error.message,
      icon: "error",
      timer:2000
    });
  }
  };
  // Convertir archivo a base64
  reader.readAsDataURL(archivo); 
};



//ELIMINAR ARCHIVO
const fnEliminarImagen = async (id) => {
  const formData = new FormData();
  formData.append('id', id);
  try {
    const response = await fetch('http://localhost/informes/delete/EliminarArchivo.php', {
      method: 'POST',
      body: formData,
      headers: {
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error(`Error: ${response.status} ${response.statusText}`);
    }

    const result = await response.json();

    if (result.res) {
      const elemento = document.getElementById(id);
      if (elemento) {
        elemento.remove();
      }
      Swal.fire({
        title: "Éxito",
        text: result.msg,
        icon: "success",
        timer:2000
      }).then(() => {
        location.reload();
      });
    } else {
      Swal.fire({
        title: "Error",
        text: result.msg,
        icon: "error",
        timer:2000
      });
    }
  } catch (error) {
    Swal.fire({
      title: "Error",
      text: error.message,
      icon: "error",
      timer:2000
    });
  }
};


// FUNCIÓN ELIMINAR ACTIVIDAD
const fnEliminarActividad = async (id) => {
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/delete/EliminarActividad.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      throw new Error(`Error en la respuesta del servidor: ${response.statusText}`);
    }

    const result = await response.json();

    if (result.res) {
      Swal.fire({
        title: "Éxito",
        text: result.msg,
        icon: "success",
        timer: 2000
      }).then(() => {
        const actividadDiv = document.getElementById(id);
        if (actividadDiv) {
          actividadDiv.remove();
        } 
      });
      console.log(result.msg);
    } else {
      Swal.fire({
        title: "Error",
        text: result.msg,
        icon: "error",
        timer: 2000
      });
    }
  } catch (error) {
    Swal.fire({
      title: "Error",
      text: error.message,
      icon: "error",
      timer: 2000
    });
  }
};

















