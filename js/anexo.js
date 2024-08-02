
  
// REGISTRAR IMAGEN
// const fnRegistrarAnexo = async () => {
//   const refid = document.getElementById('refid').value;
//   const titulo = document.getElementById('tituloInput').value;
//   const descripcion = document.getElementById('descripcionInput').value;
//   const archivo = document.getElementById('imagenInput').files[0];

//   if (!refid || !titulo || !descripcion || !archivo) {
//     console.log("Todos los campos son obligatorios.");
//     return;
//   }

//   const reader = new FileReader();
//   reader.onloadend = async () => {
//     const base64 = reader.result.split(',')[1]; 
//     const formData = new FormData();
//     formData.append('refid', refid);
//     formData.append('titulo', titulo);
//     formData.append('descripcion', descripcion);
//     formData.append('archivo', base64); 
//     console.log(refid,titulo,descripcion,archivo);

//     try {
//       const response = await fetch('http://localhost/informes/insert/AgregarArchivo.php', {
//         method: 'POST',
//         body: formData
//       });

//       const result = await response.json();

//       if (result.res) {
//         console.log('Archivo registrado con éxito.');
//         document.getElementById('refid').value = '';
//         document.getElementById('tituloInput').value = '';
//         document.getElementById('descripcionInput').value = '';
//         document.getElementById('imagenInput').value = '';
//         const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalAgregarImagen'));
//         if (modalInstance) {
//           modalInstance.hide();
//         }
//         location.reload();
//       } else {
//         console.log('Error al registrar el archivo: ' + result.msg);
//       }
//     } catch (error) {
//       console.error('Error:', error);
//       console.log('Error al registrar el archivo.');
//     }
//  };
//   reader.readAsDataURL(archivo); 
// };

//ELIMINAR ARCHIVO
// const fnEliminarAnexo = async (id) => {
//   const formData = new FormData();
//   formData.append('id', id);
//   console.log(id);
//   try {
//       const response = await fetch('http://localhost/informes/delete/EliminarArchivo.php', {
//           method: 'POST',
//           body: formData,
//           headers: {
//               'Accept': 'application/json'
//           }
//       });

//       const result = await response.json();
//       if (result.res) {
//           const elemento = document.getElementById(id);
//           if (elemento) {
//               elemento.remove();
//           }
//           console.log('Imagen eliminada correctamente.');
//       } else {
//           console.log('Error eliminando la imagen: ' + result.msg);
//       }
//   } catch (error) {
//       console.error('Error:', error);
//       console.log('Hubo un problema al eliminar la imagen.');
//   }
//  };

 
