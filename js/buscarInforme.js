const inicializarSelectPersonalizado = async (idInput, idLista, idSpinner) => {
  const inputSelect = document.getElementById(idInput);
  const listaSelect = document.getElementById(idLista);
  const spinner = document.getElementById(idSpinner);

  // MOSTRAR/OCULTAR LA LISTA AL HACER CLIC EN EL INPUT
  inputSelect.addEventListener('click', function() {
      listaSelect.style.display = listaSelect.style.display === 'block' ? 'none' : 'block';
  });

  // OCULTAR LA LISTA SI SE HACE CLIC FUERA DEL SELECT
  document.addEventListener('click', function(evento) {
      if (!evento.target.closest('.custom-select-wrapper')) {
        listaSelect.style.display = 'none';
      }
  });

  // FUNCIÓN DEBOUNCE
  const debounce = (func, delay) => {
    let debounceTimer;
    return function() {
      const context = this;
      const args = arguments;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
  };

  // FUNCIÓN DE BÚSQUEDA
  const buscarDatos = async () => {
    const filtro = inputSelect.value.toLowerCase();
    console.log(filtro);
    if (filtro.length === 0) {
      // LIMPIAR LA LISTA SI EL INPUT ESTÁ VACÍO
      listaSelect.innerHTML = '';
      // OCULTAR LA LISTA SI NO HAY TEXTO
      listaSelect.style.display = 'none';
      // OCULTAR EL SPINNER
      spinner.style.display = 'none';
      return; // SALIR SI EL INPUT ESTÁ VACÍO
    }
    // MOSTRAR EL SPINNER
    spinner.style.display = 'block';
    try {
      const respuesta = await fetch(`servidor.php?search=${filtro}`);
      if (!respuesta.ok) {
        throw new Error('La respuesta de la red falló');
      }
      const datos = await respuesta.json();

      if (datos.length === 0) {
        // MOSTRAR MENSAJE DE NO HABER RESULTADOS
        listaSelect.innerHTML = `<div class="custom-select-item" style="font-size:15px; font-weight:300">No se encontraron resultados</div>`;
        listaSelect.style.display = 'block';
      } else {
        // LIMPIAR LISTA ACTUAL
        listaSelect.innerHTML = ''; 
        datos.forEach(elemento => {
          const itemLista = document.createElement('div');
          itemLista.className = 'custom-select-item';
          // ESTRUCTURA DE RESPUESTA JSON
          itemLista.textContent = elemento.nombre;             
          itemLista.addEventListener('click', function() {
            inputSelect.value = this.textContent;
            // LIMPIANDO LISTA ACTUAL PARA MOSTRAR LA SELECCIONADA
            listaSelect.innerHTML = '';
            // OCULTANDO LISTA DESPUES DE SELECCIÓN
            listaSelect.style.display = 'none'; 
          });
          listaSelect.appendChild(itemLista);
        });
        listaSelect.style.display = 'block';
      }
    } catch (error) {
        console.error('Error al cargar los datos:', error);
    } finally {
      // OCULTAR EL SPINNER 
      setTimeout(() => {
          spinner.style.display = 'none';
      }, 500); 
    }
  };
  // ASIGNAR LA FUNCIÓN DEBUNCED AL EVENTO INPUT
  inputSelect.addEventListener('input', debounce(buscarDatos, 1000));
}


// CARGANDO FECHA ACTUAL
const cargaFechaActual = () =>{
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');const day = String(today.getDate()).padStart(2, '0');

  const formattedDate = `${year}-${month}-${day}`;
  document.getElementById('fechaInicialInput').value = formattedDate;
  document.getElementById('fechaFinalInput').value = formattedDate;
}

// PETICIÓN A SERVIDOR
const fnBuscarInforme = async () => {
    const formData = new FormData();
  
    const informe    = document.querySelector('#informeInput').value.trim();
    const equipo     = document.querySelector('#equipoInput').value.trim();
    const fecInicial = document.querySelector('#fechaInicialInput').value;
    const fecFinal   = document.querySelector('#fechaFinalInput').value;
  
    formData.append('informe', informe);
    formData.append('equipo', equipo);
    formData.append('fecInicial', fecInicial);
    formData.append('fechFinal', fecFinal);
    
    console.log('Datos a enviar: ', { informe, equipo, fecInicial, fecFinal });
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

  document.addEventListener('DOMContentLoaded', () =>{
    inicializarSelectPersonalizado('equipoInput', 'equipoList', 'spinner');
    cargaFechaActual();
    //cargaDatosGenerales();
  });