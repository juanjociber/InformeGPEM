// INICIALIZANDO VARIABLES PARA MODAL GLOBAL
// let modalEditarEquipo;

// document.addEventListener('DOMContentLoaded', () => {
//   modalEditarEquipo = new bootstrap.Modal(document.getElementById('modalEditarEquipo'), { keyboard: false });
// });

// FUNCIÓN BUSCAR EQUIPO POR ID
const fnBuscarEquipoPorId = async (id)=>{
  console.log(id);
  document.getElementById('idInforme').value = id;
  const modal = new bootstrap.Modal(document.getElementById('modalEquipo'), { keyboard: false });
  modal.show();
  const formData = new FormData();
  formData.append('id', id);

  try {
    const response = await fetch('http://localhost/informes/search/BuscarEquiposMatriz.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) { throw new Error(response.status + ' ' + response.statusText); }
    const datos = await response.json();
    
    if (!datos.res) { throw new Error(datos.msg); }
    console.log('Respuesta del servidor: ', datos.data);
    document.getElementById('nombreModalEquipo').value = datos.data.nombre;
    document.getElementById('marcaModalEquipo').value = datos.data.equmarca;
    document.getElementById('modeloModalEquipo').value = datos.data.equmodelo;
    document.getElementById('serieModalEquipo').value = datos.data.equserie;
    document.getElementById('kilometrajeModalEquipo').value = datos.data.equkm;
    document.getElementById('horaMotorModalEquipo').value = datos.data.equhm;
  } 
  catch (error) { console.error('Error:', error); }
};

// FUNCIÓN MÓDIFICAR EQUIPOS
const fnEditarDatosEquipos = async () => {
  const id = document.getElementById('idInforme').value;
  const equnombre = document.getElementById('nombreModalEquipo').value.trim();
  const equmarca = document.getElementById('marcaModalEquipo').value.trim();
  const equmodelo = document.getElementById('modeloModalEquipo').value.trim();
  const equserie = document.getElementById('serieModalEquipo').value.trim();
  const equkm = document.getElementById('kilometrajeModalEquipo').value.trim();
  const equhm = document.getElementById('horaMotorModalEquipo').value.trim();

  console.log({ id, equnombre, equmarca, equmodelo, equserie, equkm, equhm });

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
      document.querySelector('#horaMotorEquipo').textContent = equhm;
    
      console.log('Actividad modificada:', datos);
      // CERRAR MODAL
      modalEditarEquipo.hide();
  } 
  catch (error) { console.error('Error:', error); }
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
          console.log('Imagen eliminada correctamente.');
      } else {
          console.log('Error eliminando la imagen: ' + result.msg);
      }
  } catch (error) {
      console.error('Error:', error);
      console.log('Hubo un problema al eliminar la imagen.');
  }
 };

 
// ABRIR MODAL PARA REGISTRAR IMAGEN
 const fnAbrirModalRegistrarImagen = () => {
  const modal = new bootstrap.Modal(document.getElementById('modalAgregarImagen'), { keyboard: false });
  modal.show();
  // document.getElementById('cabeceraIdInput').value = id;
};

// REGISTRAR IMAGEN
const fnRegistrarImagen = async () => {
  const refid = document.getElementById('refid').value;
  const titulo = document.getElementById('tituloInput').value;
  const descripcion = document.getElementById('descripcionInput').value;
  const archivo = document.getElementById('imagenInput').files[0];

  if (!refid || !titulo || !descripcion || !archivo) {
    console.log("Todos los campos son obligatorios.");
    return;
  }

  const reader = new FileReader();
  reader.onloadend = async () => {
    const base64 = reader.result.split(',')[1]; 
    const formData = new FormData();
    formData.append('refid', refid);
    formData.append('titulo', titulo);
    formData.append('descripcion', descripcion);
    formData.append('archivo', base64); 
    console.log(refid,titulo,descripcion,archivo);

    try {
      const response = await fetch('http://localhost/informes/insert/AgregarArchivo.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.res) {
        console.log('Archivo registrado con éxito.');
        // LIMPIANDO MODAL
        document.getElementById('refid').value = '';
        document.getElementById('tituloInput').value = '';
        document.getElementById('descripcionInput').value = '';
        document.getElementById('imagenInput').value = '';
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
        if (modalInstance) {
          modalInstance.hide();
        }
        location.reload();
      } else {
        console.log('Error al registrar el archivo: ' + result.msg);
      }
    } catch (error) {
      console.error('Error:', error);
      console.log('Error al registrar el archivo.');
    }
  };
  // CONVIRTIENDO ARCHIVO A base64
  reader.readAsDataURL(archivo); 
};