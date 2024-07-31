document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#equipoInput').addEventListener('input', function() {
        buscarEquipos();
    });
});

async function fnBuscarInforme() {
  const informeInput = document.querySelector('#informeInput').value;
  const equipoInput = document.querySelector('#equipoInput').value;
  const fechaInicialInput = document.querySelector('#fechaInicialInput').value;
  const fechaFinalInput = document.querySelector('#fechaFinalInput').value;
  const cliIdInput = document.querySelector('#cliIdInput').value;

  if (!fechaInicialInput || !fechaFinalInput) {
      alert('Por favor, completa las fechas.');
      return;
  }

  const formData = new FormData();
  formData.append('nombre', informeInput);
  formData.append('equid', equipoInput);
  formData.append('fechainicial', fechaInicialInput);
  formData.append('fechafinal', fechaFinalInput);
  formData.append('cliid', cliIdInput);

  try {
    const response = await fetch('http://localhost/informes/search/BuscarInformes.php', {
        method: 'POST',
        body: formData
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.res) {
        mostrarInformes(data.data);
    } else {
        alert(data.msg);
    }
  } catch (error) {
      console.error('Error:', error);
      alert('Hubo un error al buscar los informes.');
  }
}

function mostrarInformes(informes) {
    const resultadoDiv = document.querySelector('#resultado');
    resultadoDiv.innerHTML = '';

    informes.forEach(informe => {
      const informeDiv = document.createElement('div');
      informeDiv.classList.add('row', 'mb-3');
      informeDiv.innerHTML = `
        <div class="col-8">
          <span class="fw-bold">${informe.nombre}</span>
          <span style="font-size: 12px; font-style: italic;">${informe.fecha}</span>
        </div>
        <div class="col-4 text-end">
          <span class="badge ${informe.estado == 1 ? 'bg-primary' : (informe.estado == 2 ? 'bg-success' : 'bg-danger')}">
              ${informe.estado == 1 ? 'Abierto' : (informe.estado == 2 ? 'Cerrado' : informe.estado)}
          </span>
        </div>
        <div class="col-12">${informe.clinombre} ${informe.actividad}</div>
      `;
      resultadoDiv.appendChild(informeDiv);
    });
}

async function buscarEquipos() {
  const equipoInput = document.querySelector('#equipoInput').value;
  const equipoList = document.querySelector('#equipoList');
  const spinner = document.querySelector('#spinner');
  const CliId = '2'; // Reemplaza este valor con el ID del cliente real.

  if (equipoInput.length < 1) {
      equipoList.style.display = 'none';
      return;
  }

  const url = new URL('http://localhost/informes/search/BuscarEquipos.php');
  url.searchParams.append('search', equipoInput);
  url.searchParams.append('CliId', CliId);

  try {
      spinner.style.display = 'flex';
      const response = await fetch(url.toString(), {
          method: 'GET'
      });

      if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
      }

      const responseText = await response.text();

      try {
          const data = JSON.parse(responseText);
          equipoList.innerHTML = '';

          if (data.res) {
              data.data.forEach(equipo => {
                  const equipoItem = document.createElement('div');
                  equipoItem.classList.add('custom-select-item');
                  equipoItem.textContent = equipo.activo;
                  equipoItem.addEventListener('click', function() {
                      document.querySelector('#equipoInput').value = equipo.activo;
                      equipoList.style.display = 'none';
                  });
                  equipoList.appendChild(equipoItem);
              });
              equipoList.style.display = 'block';
          } else {
              equipoList.style.display = 'none';
          }
      } catch (jsonError) {
          console.error('Error parsing JSON:', jsonError);
          console.error('Response text was:', responseText);
          alert('Hubo un error al procesar la respuesta del servidor.');
      }
  } catch (error) {
      console.error('Error:', error);
      alert('Hubo un error al buscar los equipos.');
  } finally {
      spinner.style.display = 'none';
  }
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
  