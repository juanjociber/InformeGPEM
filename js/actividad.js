// INICIALIZANDO VARIABLES PARA MODAL GLOBAL
let modalEditarActividad;

document.addEventListener('DOMContentLoaded', () => {
  modalEditarActividad = new bootstrap.Modal(document.getElementById('modalEditarActividad'), { keyboard: false });
});

//FUNCIÓN CREA ACTIVIDAD
const fnCrearActividad = async () => {
  // OBTENER DATOS DEL MODAL
  const actividad = document.getElementById('guardarNombreActividadInput').value.trim();
  const diagnostico = document.getElementById('guardarDiagnosticoInput').value.trim();
  const trabajos = document.getElementById('guardarTrabajoInput').value.trim();
  const observaciones = document.getElementById('guardarObservacionInput').value.trim();
  // VERIFICAR SI SE HA INGRESADO NOMBRE DE ACTIVIDAD
  if (!actividad) {
    Swal.fire({
      title: 'Aviso',
      html: `Por favor, ingrese el nombre de la actividad.`,
      icon: 'info',
      confirmButtonText: 'OK'
    });
    return;
  }
  // OBTENIENDO ID DEL INFORME
  const infid = document.getElementById('guardarActividadInput').value;
  // CREAR FORM-DATA
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

    const result = await response.json();
    if (result.res) {
      console.log('Respuesta de servidor :', result.msg);
      const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaActividad'));
      if (modal) {
        modal.hide();
      }
      location.reload();      
    } else {
      console.error('Error al registrar la actividad:', result.msg);
    }
  } catch (error) {
    console.error('Error en la solicitud:', error);
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
    console.log('Debe ingresar subactividad');
    return;
  }
  // OBTENIENDO ID DEL INFORME
  const infid = document.getElementById('guardarSubActividadInput').value; 
  // OBTENIENDO ID DEL INFORME
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
    const result = await response.json();
    if (result.res) {
      console.log('SubActividad registrada exitosamente:', result.msg);
      const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalNuevaSubActividad'));
      if (modalInstance) {
        modalInstance.hide();
      }
      location.reload();
    } else {
      console.error('Error al registrar la subactividad:', result.msg);
    }
  } catch (error) {
    console.error('Error en la solicitud:', error);
  }
};

//BUSCAR ACTIVIDAD
const fnEditarActividad = async (id) => {
  // MOSTRAR MODAL
  modalEditarActividad.show();
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/search/buscarActividad.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) { throw new Error(response.status + ' ' + response.statusText); }
    const datos = await response.json();
    if (!datos.res) { throw new Error(datos.msg); }
    console.log('Respuesta del servidor: ', datos.data);
    // MOSTRANDO DATA RECIBIDA DE SERVIDOR
    document.getElementById('editarActividadInput').value = datos.data.id;
    document.getElementById('editarNombreActividadInput').value = datos.data.actividad;
    document.getElementById('editarDiagnosticoInput').value = datos.data.diagnostico;
    document.getElementById('editarTrabajoInput').value = datos.data.trabajos;
    document.getElementById('editarObservacionInput').value = datos.data.observaciones;
  } 
  catch (error) { console.error('Error:', error); }
};

//MODIFICAR ACTIVIDAD
const FnModificarActividad = async () => {
  const id = document.getElementById('editarActividadInput').value;
  const actividad = document.getElementById('editarNombreActividadInput').value;
  const diagnostico = document.getElementById('editarDiagnosticoInput').value;
  const trabajo = document.getElementById('editarTrabajoInput').value;
  const observacion = document.getElementById('editarObservacionInput').value;
  console.log({ id, actividad, diagnostico, trabajo, observacion });

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

    if (!response.ok) { throw new Error(`Error: ${response.status} ${response.statusText}`); }
    const datos = await response.json();

    if (!datos.res) { throw new Error(datos.msg); }
    // ACTUALIZANDO CAMPOS : ACTIVIDAD-DIAGNOSTICO-TRABAJO-OBSERVACION
    document.querySelector(`#accordion-header-${id} .accordion-button`).textContent = actividad;
    document.getElementById(`diagnostico-${id}`).textContent = diagnostico;
    document.getElementById(`trabajo-${id}`).textContent = trabajo;
    document.getElementById(`observacion-${id}`).textContent = observacion;
    console.log('Actividad modificada:', datos);
    // CERRAR MODAL
    modalEditarActividad.hide();
  } 
  catch (error) { console.error('Error:', error); }
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

  console.log(id,archivo);
  if (!id || !titulo || !descripcion || !archivo) {
    console.log("Todos los campos son obligatorios.");
    
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
    //console.log(id,titulo,descripcion,archivo);

    try {
      const response = await fetch('http://localhost/informes/insert/AgregarArchivo.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.res) {
        console.log('Archivo registrado con éxito.');
        // LIMPIANDO MODAL
        //document.getElementById('cabeceraIdInput').value = '';
        document.getElementById('registrarTituloInput').value = '';
        document.getElementById('registarDescripcionInput').value = '';
        document.getElementById('adjuntarImagenInput').value = '';
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
        if (modalInstance) {
          modalInstance.hide();
        }
        Swal.fire({
          title: "Información de servidor",
          text: result.msg,
          icon: "success"
        });
        setTimeout(() => {
          location.reload();  
        }, 1000);
      } else {
        console.log(result.msg);
      }
    } catch (error) {
      console.error('Error:', error);
    }
  };
  // CONVIRTIENDO ARCHIVO A base64
  reader.readAsDataURL(archivo); 
};


//ELIMINAR ARCHIVO
const fnEliminarImagen = async (id) => {
  const formData = new FormData();
  formData.append('id', id);
  console.log(id);
  try {
      const response = await fetch('http://localhost/informes/delete/EliminarArchivo.php', {
          method: 'POST',
          body: formData,
          headers: {
              'Accept': 'application/json'
          }
      });

      const result = await response.json();
      if (result.res) {
          const elemento = document.getElementById(id);
          if (elemento) {
              elemento.remove();
          }
          location.reload();
          console.log('Imagen eliminada correctamente.');
      } else {
          console.log('Error eliminando la imagen: ' + result.msg);
      }
  } catch (error) {
      console.error('Error:', error);
  }
 };

// FUNCIÓN ELIMINAR ACTIVIDAD
const fnEliminarActividad = async (id) => {
  const formData = new FormData();
  formData.append('id', id);
  console.log(`Eliminando actividad con ID: ${id}`);
  try {
    const response = await fetch('http://localhost/informes/delete/EliminarActividad.php', {
        method: 'POST',
        body: formData
    });
    // Verificar si la respuesta es OK
    if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
    }
    const result = await response.json();
    if (result.res) {
        console.log(result.msg);
        // ELIMINADO ACCORDION POR SU ID
        const actividadDiv = document.getElementById(id);
        if (actividadDiv) {
            actividadDiv.remove();
        } else {
            console.error(`No se encontró el accordion con ID ${id}.`);
        }
    } else {
        console.error(result.msg);
    }
  } catch (error) {
      console.error('Hubo un problema con la operación de fetch:', error);
  }
}
















