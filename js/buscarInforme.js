const inicializarSelectPersonalizado = async (idInput, idLista, idSpinner) => {
  const inputSelect = document.getElementById(idInput);
  const listaSelect = document.getElementById(idLista);
  const spinner = document.getElementById(idSpinner);

  // Mostrar/ocultar la lista al hacer clic en el input
  inputSelect.addEventListener('click', function() {
    listaSelect.style.display = listaSelect.style.display === 'block' ? 'none' : 'block';
  });

  // Ocultar la lista y limpiarla si se hace clic fuera del select
  document.addEventListener('click', function(evento) {
    if (!evento.target.closest('.custom-select-wrapper')) {
      listaSelect.style.display = 'none';
      listaSelect.innerHTML = ''; // Limpiar la lista
    }
  });

  const fetchEquipos = async () => {
    const query = inputSelect.value;

    if (query.length < 1) {
      listaSelect.style.display = 'none';
      return;
    }

    spinner.style.display = 'flex';

    const url = `http://localhost/informes/search/BuscarEquipos.php?search=${query}`;
    try {
      const response = await fetch(url);
      const result = await response.json();

      if (result.res) {
        const equipos = result.data;
        listaSelect.innerHTML = '';

        equipos.forEach(equipo => {
          const item = document.createElement('div');
          item.className = 'custom-select-item';
          item.textContent = equipo.activo;
          item.onclick = () => {
            inputSelect.value = equipo.activo;
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
  inicializarSelectPersonalizado('equipoInput', 'equipoList', 'spinner');
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