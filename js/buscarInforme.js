const inicializarSelectPersonalizado = async (idInput, idLista, idSpinner, idCliId) => {
  const inputSelect = document.getElementById(idInput);
  const listaSelect = document.getElementById(idLista);
  const spinner = document.getElementById(idSpinner);
  const cliIdInput = document.getElementById(idCliId);

  if (!inputSelect || !listaSelect || !spinner || !cliIdInput) { return; }

  // Mostrar/ocultar la lista al hacer clic en el input
  inputSelect.addEventListener('click', function() {
    listaSelect.style.display = listaSelect.style.display === 'block' ? 'none' : 'block';
  });

  // Ocultar la lista y limpiarla si se hace clic fuera del select
  document.addEventListener('click', function(evento) {
    if (!evento.target.closest('.custom-select-wrapper')) {
      listaSelect.style.display = 'none';
      listaSelect.innerHTML = ''; 
    }
  });

  const fetchEquipos = async () => {
    const query = inputSelect.value.trim(); 
    const cliId = cliIdInput.value.trim();

    if (query.length < 1 || cliId.length < 1) { listaSelect.style.display = 'none'; return; }

    spinner.style.display = 'flex';

    const url = `http://localhost/informes/search/BuscarEquipos.php?search=${encodeURIComponent(query)}&CliId=${encodeURIComponent(cliId)}`;
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const result = await response.json();

      if (result.res) {
        const equipos = result.data;
        listaSelect.innerHTML = '';

        equipos.forEach(equipo => {
          const item = document.createElement('div');
          item.className = 'custom-select-item';
          item.textContent = equipo.activo;
          // Guardar idactivo en un atributo data
          item.dataset.idactivo = equipo.idactivo;  
          // Guardar idcleinte en atributo data
          item.dataset.idcliente = equipo.idcliente; 
          item.onclick = () => {
            inputSelect.value = equipo.activo;
            // Actualizando idActivoInput
            document.getElementById('idActivoInput').value = equipo.idactivo;  
            listaSelect.style.display = 'none';
            listaSelect.innerHTML = ''; // Limpiar la lista al seleccionar un elemento
          };
          listaSelect.appendChild(item);
        });

        listaSelect.style.display = 'block';
      } else {
        listaSelect.innerHTML = '<div class="custom-select-item">No se encontraron resultados</div>';
        listaSelect.style.display = 'block';
      }
    } catch (error) {
      console.error('Error fetching equipos:', error);
    } finally {
      spinner.style.display = 'none';
    }
  };

  // Función debounce
  const debounce = (func, delay) => {
    let debounceTimer;
    return function() {
      const context = this;
      const args = arguments;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => func.apply(context, args), delay);
    }
  };
  inputSelect.addEventListener('input', debounce(fetchEquipos, 1000));
};

document.addEventListener('DOMContentLoaded', function() {
  inicializarSelectPersonalizado('equipoInput', 'equipoList', 'spinner', 'cliIdInput');
  cargaFechaActual();
});



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
    const formData  = new FormData();
    const nombre    = document.querySelector('#informeInput').value.trim();
    const idactivo  = document.querySelector('#idActivoInput').value;
    const activo    = document.querySelector('#equipoInput').value.trim();
    const fecInicial= document.querySelector('#fechaInicialInput').value;
    const fecFinal  = document.querySelector('#fechaFinalInput').value;
  
    formData.append('nombre', nombre);
    formData.append('idactivo', idactivo);
    formData.append('activo', activo);
    formData.append('fecInicial', fecInicial);
    formData.append('fechFinal', fecFinal);
    
    console.log('Datos a enviar: ', { nombre, idactivo, activo, fecInicial, fecFinal });
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