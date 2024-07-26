const fnDatosEquipos = async () => {
  const formData = new FormData();

  const equipo    = document.querySelector('#nombreEquipoInput').value.trim();
  const modelo    = document.querySelector('#modeloInput').value.trim();
  const serie     = document.querySelector('#serieEquipoInput').value.trim();
  const marca     = document.querySelector('#marcaInput').value.trim();
  const km        = document.querySelector('#kmEquipoInput').value.trim();
  const horamotor = document.querySelector('#horaMotorInput').value.trim();
  const descripcion = document.querySelector('#descripcionEquipoInput').value.trim();

  formData.append('equipo', equipo);
  formData.append('modelo', modelo);
  formData.append('serie', serie);
  formData.append('marca', marca);
  formData.append('km', km);
  formData.append('horamotor', horamotor);
  formData.append('descripcion', descripcion);

  console.log('Datos a enviar: ', { equipo, modelo, serie, marca, km, horamotor,descripcion });
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


function fnEliminarImagen(element) {
  // OBTENGO ELEMENTO PADRE DE ICONO
  var parentDiv = element.parentElement;
  // OBTENGO ELEMENTO img DENTRO DE PADRE 'div'
  var img = parentDiv.querySelector('img');
  // ELIMINO ELEMENTO 'img'
  if (img) {
      parentDiv.removeChild(img);
  }
}

 

