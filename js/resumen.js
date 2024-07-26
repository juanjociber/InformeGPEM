let nuevoId;

// FUNCIÓN PARA AGREGAR ITEM
const agregarItem = (categoria) => {
  const input = document.getElementById(`modal${capitalizarPrimeraLetra(categoria)}Input`);
  const value = input.value.trim();
  
  if (value === "") {
    Swal.fire({
      title: 'Aviso',
      html: `<div class="custom-select-item">Debe Ingresar ${categoria}</div>`,
      icon: 'info',
      confirmButtonText: 'OK'
    }); 
    return;
  }
  const form = document.getElementById(`form${capitalizarPrimeraLetra(categoria)}`);
  const editId = form.dataset.editId;

  if (editId) {
    // SI HAY UN EDIT-ID, ACTUALIZA EL ITEM EXISTENTE
    const item = document.querySelector(`div[data-id='${editId}']`);
    if (item) {
      item.querySelector('p').textContent = value;
      // LIMPIA EL EDIT-ID Y EL VALOR DEL INPUT
      delete form.dataset.editId;
    } else {
      Swal.fire({
        title: 'Aviso',
        html: `<div class="custom-select-item">${categoria} no encontrado para editar</div>`,
        icon: 'info',
        confirmButtonText: 'OK'
      });
    }
  } 
  else {
    // SI NO HAY UN EDIT-ID, AGREGA UN NUEVO ITEM 
    const nuevoItem = document.createElement("div");
    nuevoItem.className = "input-group mt-2";
    // GENERA UN IDENTIFICADOR ÚNICO
    nuevoId = `id-${Date.now()}`;
    nuevoItem.setAttribute("data-id", nuevoId);

    if (categoria === 'actividad') {
      nuevoItem.innerHTML = `
        <p class="mb-0" id="${categoria}-${nuevoId}" style="text-align: justify;">${value}</p>
        <div class="input-grop-icons">
          <span class="input-group-text"><i class="bi bi-pencil-square" onclick="editarItem('${categoria}', '${nuevoId}')"></i></span>
          <span class="input-group-text"><i class="bi bi-trash3" onclick="eliminarItem('${nuevoId}')"></i></span>
        </div>
      `;
    } else {
      nuevoItem.innerHTML = `
        <div class="d-flex">
          <span class="vineta"></span>
          <p class="mb-0" id="${categoria}-${nuevoId}" style="text-align: justify;">${value}</p>
        </div>
        <div class="input-grop-icons">
          <span class="input-group-text"><i class="bi bi-pencil-square" onclick="editarItem('${categoria}', '${nuevoId}')"></i></span>
          <span class="input-group-text"><i class="bi bi-trash3" onclick="eliminarItem('${nuevoId}')"></i></span>
        </div>
      `;
    }
    const container = document.getElementById(`container${capitalizarPrimeraLetra(categoria)}`);
    container.appendChild(nuevoItem);
  }
  // LIMPIAR EL VALOR DEL INPUT Y CIERRA EL MODAL.
  input.value = "";
  const modal = bootstrap.Modal.getInstance(document.getElementById(`modal${capitalizarPrimeraLetra(categoria)}`));
  modal.hide();
}

// FUNCIÓN MUESTRA VALORES ACTUALES PARA EDITAR
const editarItem = (categoria, id) => {
  // OBTIENE EL ITEM PARA EDITAR
  const item = document.querySelector(`div[data-id='${id}']`);
  const text = item.querySelector('p').textContent.trim();

  // RELLENA EL MODAL CON EL VALOR ACTUAL
  const modalInput = document.getElementById(`modal${capitalizarPrimeraLetra(categoria)}Input`);
  modalInput.value = text;

  // GUARDA EL VALOR VALOR DEL ID EN EL MODAL
  const modalForm = document.getElementById(`form${capitalizarPrimeraLetra(categoria)}`);
  modalForm.dataset.editId = id;

  // MUESTRA EL MODAL
  const modal = new bootstrap.Modal(document.getElementById(`modal${capitalizarPrimeraLetra(categoria)}`));
  modal.show();
}

// FUNCIÓN PARA ELIMINAR ITEM
const eliminarItem = (id) => {
  const item = document.querySelector(`div[data-id='${id}']`);
  if (item) {
    item.remove();
  }
}

// FUNCIÓN PARA CAPITALIZAR LA PRIMERA LETRA
const capitalizarPrimeraLetra = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

const fnResumen = async () => {
  const formData = new FormData();
  console.log(nuevoId);
  const actividad     = document.querySelector(`#actividadId`).textContent.trim();
  // const actividad     = document.querySelector(`#actividad-${nuevoId}`).textContent.trim();
  const antecedente   = document.querySelector('#antecedenteId').textContent.trim();
  const diagnostico   = document.querySelector('#analisisId').textContent.trim();
  const conclusion    = document.querySelector('#conclusionId').textContent.trim();
  const recomendacion = document.querySelector('#recomendacionId').textContent.trim();

  formData.append('actividad', actividad);
  formData.append('antecedente', antecedente);
  formData.append('diagnostico', diagnostico);
  formData.append('conclusion', conclusion);
  formData.append('recomendacion', recomendacion);

  console.log('Datos a enviar: ', { actividad, antecedente, diagnostico, conclusion,recomendacion });
  console.log(formData);

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