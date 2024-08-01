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