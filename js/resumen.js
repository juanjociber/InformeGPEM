// INICIALIZANDO VARIABLES PARA MODAL GLOBAL
let modalEditarActividad;

document.addEventListener('DOMContentLoaded', () => {
  modalEditarActividad = new bootstrap.Modal(document.getElementById('modalEditarActividad'), { keyboard: false });
});

const fnEditarActividad = async (id) => {
  // MOSTRAR MODAL
  modalEditarActividad.show();
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/search/BuscarActividadInforme.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) { 
      throw new Error(response.status + ' ' + response.statusText); 
    }
    const datos = await response.json();
    if (!datos.res) { 
      throw new Error(datos.msg); 
    }
    console.log(datos);
    // MOSTRANDO DATA RECIBIDA DE SERVIDOR
    document.getElementById('editarActividadInput').value = datos.data.actividad;
  } 
  catch (error) { console.error('Error:', error); }
};

//MODIFICAR ACTIVIDAD
const FnModificarActividad = async () => {
  const id = document.getElementById('txtIdInforme').value;
  const actividad = document.getElementById('editarActividadInput').value;

  if (isNaN(id)) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'ID debe ser un número',
          timer: 2000
      });
      return;
  }
  const formData = new FormData();
  formData.append('id', id);
  formData.append('actividad', actividad);
  try {
      const response = await fetch('http://localhost/informes/update/ModificarActividadInforme.php', {
          method: 'POST',
          body: formData
      });

      if (!response.ok) {
          const errorText = await response.text();
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: errorText,
              timer: 2000
          });
          return;
      }
      const datos = await response.json();
      if (!datos.res) {
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: datos.msg,
              timer: 2000
          });
          return;
      }
      // Mensaje de éxito
      Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: datos.msg,
          timer: 3000
      });
      // ACTUALIZANDO CAMPO : ACTIVIDAD
      document.querySelector('#actividadId').textContent = actividad;
      // CERRAR MODAL
      const modalEditarActividad = bootstrap.Modal.getInstance(document.getElementById('modalEditarActividad'));
      if (modalEditarActividad) {
          modalEditarActividad.hide();
      }
  } catch (error) {
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: `Se produjo un error inesperado: ${error.message}`,
          timer: 3000
      });
  }
};


// ABRIR MODAL
const abrirModalAgregar = ()=>{
  const modal = new bootstrap.Modal(document.getElementById('modalAntecedente'), { keyboard: false });
  modal.show() 
}

const abrirModalEditar = ()=>{
  const modal = new bootstrap.Modal(document.getElementById('modalAntecedente'), { keyboard: false });
  modal.show()
}

const abrirModalEliminar = ()=>{
  const modal = new bootstrap.Modal(document.getElementById('modalAntecedente'), { keyboard: false });
  modal.show()
}

// AGREGAR ACTIVIDADES
const FnAgregarAntecedente =()=>{
  
}
const FnAgregarConclusion =()=>{
  
}
const FnAgregarRecomendacion =()=>{
  
}

// const fnEliminarActividad = async (id) => {
//   const formData = new FormData();
//   formData.append('id', id);
//   try {
//     const response = await fetch('http://localhost/informes/delete/EliminarActividad.php', {
//         method: 'POST',
//         body: formData
//     });
//     // Verificar si la respuesta es OK
//     if (!response.ok) {
//         throw new Error('Error en la respuesta del servidor');
//     }
//     const result = await response.json();
//     if (result.res) {
//         console.log(result.msg);
//         // ELIMINADO ACCORDION POR SU ID
//         const actividadDiv = document.getElementById(id);
//         if (actividadDiv) {
//             actividadDiv.remove();
//         } else {
//             console.error(`No se encontró el accordion con ID ${id}.`);
//         }
//     } else {
//         console.error(result.msg);
//     }
//   } catch (error) {
//       console.error('Hubo un problema con la operación de fetch:', error);
//   }
// }