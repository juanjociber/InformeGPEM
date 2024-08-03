const fnRegistrarAnexo = ()=>{
  const id = document.getElementById('txtIdInforme').value;
  const titulo = document.getElementById('tituloInput').value;
  const archivo = document.getElementById('anexoInput').files[0];
  const descripcion = document.getElementById('descripcionInput').value;
  

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
      const response = await fetch('http://localhost/informes/insert/AgregarAnexo.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.json();

      if (result.res) {
        // Limpiar los campos del modal
        document.getElementById('tituloInput').value = '';
        document.getElementById('descripcionInput').value = '';
        document.getElementById('anexoInput').value = '';
        // const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
        // if (modalInstance) {
        //   modalInstance.hide();
        // }
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

  
const fnEliminarAnexo = async (id) => {
  const formData = new FormData();
  formData.append('id', id);
  console.log(id);
  try {
      const response = await fetch('http://localhost/informes/delete/EliminarAnexo.php', {
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

 
