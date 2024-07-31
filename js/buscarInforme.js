// FUNCIÓN PARA BUSCAR EQUIPOS
const buscarEquipos = async (idInput, idLista, idSpinner) => {
  const inputSelect = document.getElementById(idInput);
  const listaSelect = document.getElementById(idLista);
  const spinner = document.getElementById(idSpinner);

  if (!inputSelect || !listaSelect || !spinner) { return; }

  inputSelect.addEventListener('click', function() {
    listaSelect.style.display = listaSelect.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', function(event) {
    if (!event.target.closest('.custom-select-wrapper')) {
      listaSelect.style.display = 'none';
      listaSelect.innerHTML = ''; 
    }
  });

  const fetchEquipos = async () => {
    const nombre = inputSelect.value.trim(); 
    if (nombre.length < 1) { 
      listaSelect.style.display = 'none'; 
      return; 
    }
    spinner.style.display = 'flex';

    const formData = new FormData();
    formData.append('nombre', nombre);

    try {
      const response = await fetch('http://localhost/informes/search/BuscarEquipos.php', {
          method: 'POST',
          body: formData
      });

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
            item.dataset.idactivo = equipo.idactivo;  
            item.onclick = () => {
                inputSelect.value = equipo.activo;
                document.getElementById('idActivoInput').value = equipo.idactivo;  
                listaSelect.style.display = 'none';
                listaSelect.innerHTML = ''; 
            };
            listaSelect.appendChild(item);
        });

        listaSelect.style.display = 'block';
      } else {
          listaSelect.innerHTML = `<div class="custom-select-item">Error: ${result.msg}</div>`;
          listaSelect.style.display = 'block';
      }
    } catch (error) {
        listaSelect.innerHTML = `<div class="custom-select-item">Error: ${error.message}</div>`;
        listaSelect.style.display = 'block';
    } finally {
        spinner.style.display = 'none';
    }
  };
  // TEMPORIZADOR
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
  buscarEquipos('equipoInput', 'equipoList', 'spinner');
});

// FUNCIÓN PARA BUSCAR INFORME
const fnBuscarInforme = async () => {
  const nombre = document.querySelector('#informeInput').value;
  const equid = document.querySelector('#idActivoInput').value;
  const fechainicial = document.querySelector('#fechaInicialInput').value;
  const fechafinal = document.querySelector('#fechaFinalInput').value;

  if (!fechainicial || !fechafinal) {
    Swal.fire({
      text  : "Las fechas de busqueda están incompletas.",
      title : "Información!",
      icon  : "info",
      timer : 3000
    });
    return;
  }
  
  console.log({ nombre, equid, fechainicial, fechafinal });

  const formData = new FormData();
  formData.append('nombre', nombre);
  formData.append('equid', equid);
  formData.append('fechainicial', fechainicial);
  formData.append('fechafinal', fechafinal);
  console.log(formData);

  try {
    const response = await fetch('http://localhost/informes/search/BuscarInformes.php', {
      method: 'POST',
      body: formData
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    console.log(data);

    if (data.res) {
      mostrarInformes(data.data);
    } else {
      console.log('Mensaje del servidor:', data.msg);
    }
  } catch (error) {
    console.error('Error:', error);
    console.log('Hubo un error al buscar los informes.');
  }
}


// FUNCIÓN MOSTRAR INFORMES
function mostrarInformes(informes) {
  const resultadoDiv = document.querySelector('#contenedor-lista');
  // VERIFICANDO SI EL 'resultadoDiv' EXISTE EN EL DOM
  if (!resultadoDiv) {
    return;
  }
  // LIMPIANDO CONTENIDO PREVIO DEL CONTENEDOR
  resultadoDiv.innerHTML = '';
  // VERIFICANDO QUE INFOREM SEA UN ARRAY CON ELEMENTOS
  if (!Array.isArray(informes) || informes.length === 0) {
    resultadoDiv.innerHTML = '<div>No se encontraron informes.</div>';
    return;
  }
  // PROCESA CADA INFORME Y AÑADE AL CONTENEDOR
  informes.forEach(informe => {
    // VALIDANDO QUE LOS DATOS ESPERADOS EXISTAN
    const nombre = informe.nombre || 'Sin nombre';
    const fecha = informe.fecha || 'Sin fecha';
    const estado = informe.estado || 0;
    const id = informe.id || 0;
    const clinombre = informe.clinombre || 'Sin cliente';
    const equcodigo = informe.equcodigo || 0;
    const actividad = informe.actividad || 'Sin actividad';
  
    // CREAR Y AGREGA ITEM A CONTENEDOR
    const enlace = document.createElement('a');
    enlace.href = `http://localhost/informes/vistaPreliminar.php?informe=${id}`;
    enlace.style='text-decoration:none; color:#797979';

    const informeDiv = document.createElement('div');
    informeDiv.classList.add('row', 'mb-3');
    informeDiv.innerHTML = `
      <div class="col-8">
        <span class="fw-bold">${nombre}</span>
        <span style="font-size: 12px; font-style: italic;">${fecha}</span>
      </div>
      <div class="col-4 text-end">
        <span class="badge ${estado == 1 ? 'bg-primary' : (estado == 2 ? 'bg-success' : 'bg-danger')}">
            ${estado == 1 ? 'Abierto' : (estado == 2 ? 'Cerrado' : estado)}
        </span>
      </div>
      <div class="col-12">${equcodigo} <span> - </span> ${actividad}</div>
    `;
    enlace.appendChild(informeDiv);
    resultadoDiv.appendChild(enlace);
  });
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
cargaFechaActual();