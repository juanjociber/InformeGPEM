// INICIALIZANDO VARIABLES PARA MODAL GLOBAL
let modalEquipo;

document.addEventListener('DOMContentLoaded', () => {
  modalEquipo = new bootstrap.Modal(document.getElementById('modalEquipo'), { keyboard: false });
});

// FUNCIÓN BUSCAR EQUIPO POR ID
const fnBuscarEquipoPorId = async (id)=>{
  //console.log(id);
  modalEquipo.show();
  document.getElementById('idInforme').value = id;
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/search/BuscarEquiposMatriz.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) { 
      throw new Error(response.status + ' ' + response.statusText); 
    }
    const datos = await response.json();
    
    if (!datos.res) { 
      Swal.fire({
        title: "Información de servidor",
        text: datos.msg,
        icon: "info",
        timer:2000,
      }); 
    }
    //console.log('Respuesta del servidor: ', datos.data);
    document.getElementById('nombreModalEquipo').value = datos.data.nombre;
    document.getElementById('marcaModalEquipo').value = datos.data.equmarca;
    document.getElementById('modeloModalEquipo').value = datos.data.equmodelo;
    document.getElementById('serieModalEquipo').value = datos.data.equserie;
    document.getElementById('kilometrajeModalEquipo').value = datos.data.equkm;
    document.getElementById('horaMotorModalEquipo').value = datos.data.equhm;
  } 
  catch (error) { 
    Swal.fire({
      title: "Información de servidor",
      text: error,
      icon: "error",
      timer:2000,
    });
  }
};

// FUNCIÓN MÓDIFICAR EQUIPOS
const fnEditarDatosEquipo = async () => {
  const id = document.getElementById('idInforme').value;
  const equnombre = document.getElementById('nombreModalEquipo').value.trim();
  const equmarca = document.getElementById('marcaModalEquipo').value.trim();
  const equmodelo = document.getElementById('modeloModalEquipo').value.trim();
  const equserie = document.getElementById('serieModalEquipo').value.trim();
  const equkm = document.getElementById('kilometrajeModalEquipo').value.trim();
  const equhm = document.getElementById('horaMotorModalEquipo').value.trim();

  //console.log({ id, equnombre, equmarca, equmodelo, equserie, equkm, equhm });

  const formData = new FormData();
  formData.append('id',id);
  formData.append('equnombre', equnombre);
  formData.append('equmarca', equmarca);
  formData.append('equmodelo', equmodelo);
  formData.append('equserie', equserie);
  formData.append('equkm', equkm);
  formData.append('equhm', equhm);

  try {
    const response = await fetch('http://localhost/informes/update/ModificarDatosEquipos.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) { throw new Error(`Error: ${response.status} ${response.statusText}`); }
    const datos = await response.json();

    if (!datos.res) { throw new Error(datos.msg); }
      document.querySelector('#nombreEquipo').textContent = equnombre;
      document.querySelector('#marcaEquipo').textContent = equmarca;
      document.querySelector('#modeloEquipo').textContent = equmodelo;
      document.querySelector('#serieEquipo').textContent = equserie;
      document.querySelector('#kilometrajeEquipo').textContent = equkm;
      document.querySelector('#horasMotorEquipo').textContent = equhm;
      // CERRAR MODAL
      modalEquipo.hide();
      Swal.fire({
        title: "Información de servidor",
        text: datos.msg,
        icon: "success",
        timer:2000
      });
  } 
  catch (error) {
    Swal.fire({
      title: "Información de servidor",
      text: error,
      icon: "error",
      timer:2000
    }); 
  }
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
          Swal.fire({
            title: "Información de servidor",
            text: result.msg,
            icon: "success"
          });
          setTimeout(() => {
            location.reload();          
          }, 2000);
      } else {
        Swal.fire({
          title: "Información de servidor",
          text: result.msg,
          icon: "error",
          timer: 2000
        });
      }
  } catch (error) {
      console.error('Error:', error);
  }
 };

// ABRIR MODAL PARA REGISTRAR IMAGEN
const fnAbrirModalRegistrarImagen = () => {
  const modal = new bootstrap.Modal(document.getElementById('modalAgregarImagen'), { keyboard: false });
  modal.show();
};

// REGISTRAR IMAGEN
const fnRegistrarImagen = async () => {
  const id = document.getElementById('idInforme').value;
  const titulo = document.getElementById('tituloInput').value;
  const descripcion = document.getElementById('descripcionInput').value;
  const archivo = document.getElementById('imagenInput').files[0];

  // Validar que los campos no estén vacíos
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
      const response = await fetch('http://localhost/informes/insert/AgregarArchivoEquipo.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.res) {
        // Limpiar los campos del modal
        document.getElementById('tituloInput').value = '';
        document.getElementById('descripcionInput').value = '';
        document.getElementById('imagenInput').value = '';
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
        if (modalInstance) {
          modalInstance.hide();
        }
        Swal.fire({
          title: "Éxito",
          text: result.msg,
          icon: "success",
          timer:2000
        });
        setTimeout(() => {
          location.reload();          
        }, 2000);       
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
        text: "Ocurrió un error al procesar la solicitud.",
        icon: "error",
        timer:2000
      });
    }
  };
  // Convertir archivo a base64
  try {
    reader.readAsDataURL(archivo); 
  } catch (error) {
    Swal.fire({
      title: "Error",
      text: "No se pudo leer el archivo. Asegúrate de que es un archivo válido.",
      icon: "error",
      timer:2000
    });
  }
};
