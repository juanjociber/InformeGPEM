const cargaSelect = () => {
  // FUNCIÓN
  const initCustomSelect = (inputId, listId) => {
    const selectInput = document.getElementById(inputId);
    const selectList = document.getElementById(listId);
    const selectItems = selectList.getElementsByClassName('custom-select-item');
    // MOSTRAR / OCULTAR LISTA AL HACER CLIC EN INPUT
    selectInput.addEventListener('click', function() {
        selectList.style.display = selectList.style.display === 'block' ? 'none' : 'block';
    });
    // SELECCIONAR UN ELEMENTO DE LA LISTA
    Array.from(selectItems).forEach(item => {
        item.addEventListener('click', function() {
            selectInput.value = this.textContent;
            //GUARDANDO VALOR ASOCIONADO AL SELECCIONAR
            selectInput.dataset.value = this.dataset.value;
            selectList.style.display = 'none';
        });
    });
    // OCULTAR LISTA SI SE HACE CLIC FUERA DE LISTA
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.custom-select-wrapper')) {
            selectList.style.display = 'none';
        }
    });
    // FILTRAR ELEMENTOS DE LA LISTA AL ESCRIBIR EN EL INPUT
    selectInput.addEventListener('input', function() {
        const filter = selectInput.value.toLowerCase();
        let textoEncontrado = false;
        Array.from(selectItems).forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(filter)) {
                item.style.display = '';
                textoEncontrado = true;
            } else {
                item.style.display = 'none';
            }
        });
        selectList.style.display = 'block';

        // LIMPIAR EL INPUT SI NO HAY CONCIDENCIAS
        if (!textoEncontrado) {
            selectInput.value = '';
            // MOSTRAR TODAS LAS OPCIONES DE LA LISTA
            Array.from(selectItems).forEach(item => {
                item.style.display = '';
            });
        }
    });
  }
  // INICIALIZANDO SELECT
  initCustomSelect('contactoInput', 'contactoList');
  initCustomSelect('supervisorInput', 'supervisorList');
};

// LLAMANDO FUNCIÓN PARA INICIALIZAR LOS SELECT PERSONALIZADOS
document.addEventListener('DOMContentLoaded', cargaSelect);
  
// CARGA DE FECHA ACTUAL
// const cargaFechaActual = () =>{
//   const today = new Date();
//   const year = today.getFullYear();
//   const month = String(today.getMonth() + 1).padStart(2, '0');const day = String(today.getDate()).padStart(2, '0');
//   const formattedDate = `${year}-${month}-${day}`;
//   document.getElementById('fechaInforme').value = formattedDate;
// }

const fnDatosGenerales = async () => {
  const formData = new FormData();
  const nombre = document.querySelector('#nombreInformeInput').value;
  const fecha = document.querySelector('#fechaInformeInput').value;
  const orden = document.querySelector('#OrdenTrabajoInput').value;
  const cliente = document.querySelector('#nombreClienteInput').value;
  const contacto = document.querySelector('#contactoInput').value;
  const lugar = document.querySelector('#ubicacionInput').value;
  const supervisor = document.querySelector('#supervisorInput').value;

  formData.append('nombre', nombre);
  formData.append('fecha', fecha);
  formData.append('orden', orden);
  formData.append('cliente', cliente);
  formData.append('contacto', contacto);
  formData.append('lugar', lugar);
  formData.append('supervisor', supervisor);

  console.log('Datos a enviar: ', { nombre, fecha, orden, cliente, contacto, lugar, supervisor });
  console.log(formData);


  // const response = await fetch('http://192.168.40.70/marcador/controller/RegistrarMarcacion.php', {
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
  // console.warn('Respuesta del servidor registro marcacion : ', datos);
}

