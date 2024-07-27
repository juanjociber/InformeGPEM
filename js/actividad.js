// const limpiarInputs = (selector) => {
//   const textos = document.querySelectorAll(selector);
//   textos.forEach(text => text.value = '');
// };

// const cerrarModal = (modalId) => {
//   const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
//   modal.hide();
// };

// const setValues = (campos) => {
//   campos.forEach(({ id, value, isImage }) => {
//     const element = document.querySelector(`#${id}`);
//     if (element) {
//       if (isImage) {
//         element.src = value;
//       } else {
//         element.textContent = value;
//       }
//     }
//   });
// };

// const agregarAccordionItem = (idPadre, actividad, diagnostico, trabajo, observacion) => {
//   const idUnico = Date.now();
//   const nuevoItem = document.createElement('div');
//   nuevoItem.classList.add('accordion-item');
//   nuevoItem.id = `accordionId-${idUnico}`;
//   nuevoItem.setAttribute('data-id',`${idUnico}`);
//   nuevoItem.innerHTML = `
//     <h2 class="accordion-header accordion-header--mod" id="accordionHeaderId-${idUnico}">
//       <div class="item-actividad">
//         <div class="accordion-button accordion-button--mod collapsed" data-bs-toggle="collapse" data-bs-target="#collapseAcordion-${idUnico}" aria-expanded="false" aria-controls="collapseAcordion-${idUnico}" id="gpem${idUnico}">
//           <div class="accordion-actividad col-8 text-uppercase" id="actividadId-${idUnico}">${actividad}</div>
//         </div>
//         <div class="accordion-botones">
//           <i class="bi bi-plus-lg icono icono-agregar" data-id="${idUnico}" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
//           <i class="bi bi-pencil-square icono" data-bs-toggle="modal" data-bs-target="#actividadModal"></i>
//           <i class="bi bi-paperclip icono icono-cargar" data-bs-toggle="modal" data-bs-target="#imagenModal"></i>
//           <i class="bi bi-trash3 icono delete-activity" data-id="accordionId-${idUnico}"></i>
//         </div>
//       </div>
//     </h2>
//     <div id="collapseAcordion-${idUnico}" class="accordion-collapse collapse" aria-labelledby="accordionHeaderId-${idUnico}">
//       <div class="accordion-body accordion-body--mod">
//         <div class="row detalles">
//           <div class="detalles-diagnostico col-6">
//             <label for="diagnosticoId-${idUnico}" class="form-label mb-0">Diagnóstico</label>
//             <p class="mb-1" id="diagnosticoId-${idUnico}">${diagnostico}</p>
//           </div>
//           <div class="detalles-trabajo col-6">
//             <label for="trabajoId-${idUnico}" class="form-label mb-0">Trabajos</label>
//             <p class="mb-1" id="trabajoId-${idUnico}">${trabajo}</p>
//           </div>
//           <div class="detalles-observacion col-12">
//             <label for="observacionId-${idUnico}" class="form-label mb-0">Observaciones</label>
//             <p class="mb-1" id="observacionId-${idUnico}">${observacion}</p>
//           </div>
//         </div>
//         <div class="imagenes-actividad">
//           <div class="grid-imagen">
//             <div class="titulo-imagen">
//               <p class="mb-1" id="titulo1Id-${idUnico}" style="text-align:center;">Título 1</p>
//             </div>
//             <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
//               <img src="../img/imagen1.png" id="imagen1Id-${idUnico}" class="img-thumbnail">
//               <i class="bi bi-x-circle-fill remover-icono" data-target="imagen1Id-${idUnico}" onclick="removerImagen('imagen1Id-${idUnico}')" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
//             </div>
//             <div class="descripcion-imagen">
//               <p class="mb-1" id="descripcion1Id-${idUnico}" style="text-align:center;">Descripción 1</p>
//             </div>
//           </div>
//           <div class="grid-imagen">
//             <div class="titulo-imagen">
//               <p class="mb-1" id="titulo2Id-${idUnico}" style="text-align:center;">Título 2</p>
//             </div>
//             <div class="image-wrapper" style="position: relative; display: inline-block; margin: 10px;">
//               <img src="../img/imagen2.png" id="imagen2Id-${idUnico}" class="img-thumbnail">
//               <i class="bi bi-x-circle-fill remover-icono" data-target="imagen2Id-${idUnico}" onclick="removerImagen('imagen2Id-${idUnico}')" style="position: absolute; top: 5px; right: 5px; cursor: pointer;"></i>
//             </div>
//             <div class="descripcion-imagen">
//               <p class="mb-1" id="descripcion2Id-${idUnico}" style="text-align:center;">Descripción 2</p>
//             </div>
//           </div>
//         </div>
//       </div>
//     </div>
//   `;

//   if (idPadre) {
//     document.querySelector(`#${idPadre} .accordion-body`).appendChild(nuevoItem);
//   } else {
//     document.getElementById('contenedor-accordion').appendChild(nuevoItem);
//   }
// };


// const fnGuardarActividad = () => {
//   const actividad = document.querySelector('#nombreActividadInput').value.trim();
//   const diagnostico = document.querySelector('#diagnosticoInput').value.trim();
//   const trabajo = document.querySelector('#trabajosInput').value.trim();
//   const observacion = document.querySelector('#observacionesInput').value.trim();
//   const idPadre = document.querySelector('#actividadModal').dataset.padreId || null;

//   // Agregar nuevo ítem al acordeón
//   agregarAccordionItem(idPadre, actividad, diagnostico, trabajo, observacion);

//   //setValues(campos);
//   limpiarInputs('#modal-body textarea');
//   cerrarModal('actividadModal');
// };

// const fnGuardarDetallesActividad = () => {
//   const basePath = "../img/";

//   const imagen1Input = document.querySelector('#imagen1Input').files[0];
//   const imagen2Input = document.querySelector('#imagen2Input').files[0];

//   const campos = [
//     { id: 'titulo1Id', value: document.querySelector('#titulo1Input').value.trim() },
//     { id: 'descripcion1Id', value: document.querySelector('#descripcion1Input').value.trim() },
//     { id: 'titulo2Id', value: document.querySelector('#titulo2Input').value.trim() },
//     { id: 'descripcion2Id', value: document.querySelector('#descripcion2Input').value.trim() }
//   ];

//   if (imagen1Input) {
//     const imagen1Path = basePath + imagen1Input.name;
//     campos.push({ id: 'imagen1Id', value: imagen1Path, isImage: true });
//   }

//   if (imagen2Input) {
//     const imagen2Path = basePath + imagen2Input.name;
//     campos.push({ id: 'imagen2Id', value: imagen2Path, isImage: true });
//   }

//   setValues(campos);
//   limpiarInputs('#modal-body-imagen input');
//   cerrarModal('imagenModal');
// };

// document.addEventListener('DOMContentLoaded', () => {
//   document.querySelectorAll('.remove-icon').forEach(icon => {
//     icon.addEventListener('click', (event) => {
//       const targetId = event.target.getAttribute('data-target');
//       const imageElement = document.getElementById(targetId);

//       if (imageElement) {
//         // Eliminando imagen de raiz
//         imageElement.src = '';

//         // Reseteando archivo input
//         const inputId = targetId.replace('Id', 'Input'); // reemplanzando id con INPUT
//         const inputElement = document.getElementById(inputId);
//         if (inputElement) {
//           inputElement.value = ''; // Limpiar archivo input
//         }
//       }
//     });
//   });
// });


// document.addEventListener('DOMContentLoaded', () => {
//   // Manejar clic en íconos de eliminación de imagen
//   document.querySelectorAll('.remove-icon').forEach(icon => {
//     icon.addEventListener('click', (event) => {
//       const targetId = event.target.getAttribute('data-target');
//       const imageElement = document.getElementById(targetId);

//       if (imageElement) {
//         // Eliminar la imagen visualmente
//         imageElement.src = '';

//         // Restablecer el campo de entrada de archivos correspondiente
//         const inputId = targetId.replace('Id', 'Input');
//         const inputElement = document.getElementById(inputId);
//         if (inputElement) {
//           inputElement.value = ''; // Limpiar el campo de entrada de archivos
//         }
//       }
//     });
//   });
// });

//   document.querySelectorAll('.delete-activity').forEach(icon => {
//     icon.addEventListener('click', (event) => {
//       console.log(event.target);
//       const id = event.target.getAttribute('data-id');
//       document.getElementById(id).remove();
//     });
//   });
// // });


const fnAgregarActividad = () => {
  const modal = new bootstrap.Modal(document.getElementById('modalNuevaActividad'),{keyboard:false});
  modal.show(); 
}

const fnEditarActividad = async (id) => {
  const modal = new bootstrap.Modal(document.getElementById('modalEditarActividad'),{keyboard:false});
  modal.show();
  console.log(id);

  const formData = new FormData();
  formData.append('id', id);

  console.log('Datos a enviar: ', {id });
  console.log(formData);


  const response = await fetch(``, {
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

}

const fnEliminarActividad = (element) => {
  if (element.classList.contains('eliminarActividad')) {
    console.log('ELIMINAR');
  }
}

const fnAgregarImagen = (element) => {
  if (element.classList.contains('agregarImagen')) {
    console.log('ADDIMAGEN');
  }
}

const fnEliminarImagen = (element) => {

  console.log(element);
  // OBTENGO ELEMENTO PADRE DE ICONO
  var parentDiv = element.parentElement;
  // OBTENGO ELEMENTO img DENTRO DE PADRE 'div'
  var img = parentDiv.querySelector('img');
  // ELIMINO ELEMENTO 'img'
  if (img) {
      parentDiv.removeChild(img);
  }
}

const fnGuardarActividad = (elemento) =>{
  // console.log(elemento.target);
  // const formData = new FormData();
  // const actividad = document.querySelector('#actividadId').textContent;
  // const diagnostico = document.querySelector('#diagnosticoId').textContent;
  // const trabajo     = document.querySelector('#trabajoId').textContent;
  // const observacion = document.querySelector('#observacionId').textContent;
  // const titulo1 = document.querySelector('#titulo1Id').textContent;
  // const descripcion1 = document.querySelector('#descripcion1Id').textContent; 
  // const titulo2 = document.querySelector('#titulo2Id').textContent;
  // const descripcion2 = document.querySelector('#descripcion2Id').textContent; 

  // formData.append('actividad', actividad);
  // formData.append('diagnostico', diagnostico);
  // formData.append('trabajo', trabajo);
  // formData.append('observacion', observacion); 
  // formData.append('titulo1', titulo1);
  // formData.append('descripcion1', descripcion1);
  // formData.append('titulo2', titulo2);
  // formData.append('descripcion2', descripcion2);

  // console.log('Datos a enviar: ', {actividad, diagnostico, trabajo, observacion,titulo1,descripcion1,titulo2,descripcion2 });
  // console.log(formData);


  // const response = await fetch(``, {
  //   method: 'POST',
  //   body: formData
  // });
  // if (!response.ok) {
  //   throw new Error(response.status + ' ' + response.statusText);
  // }
  // const datos = await response.json();
  // if (!datos.res) {
  //   throw new Error(datos.msg);
  // }
};


