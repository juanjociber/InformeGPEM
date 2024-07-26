

<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/main.css">
    <title>Sistema GPEM S.A.C</title>
  </head>
  <style>
    ::placeholder{
      color: #cecccc !important;
      font-weight: 200;
      text-transform: uppercase;
    }
    .form-label{
      color:#212529;
      font-weight:300; 
    }
    @media(max-width:767px){
      .form-label{
        font-size: 13px;
      }
    }
    @media(min-width:768px){
      .mt--mod{
        margin-top: 17px !important;
      }
    }
    @media(min-width:92px){
      .form-label{
        font-size: 15px;
      }
    }
    .form-control{
      border-radius:.25rem;
    }
    .btn-control{
      padding:.375rem .75rem;
    }
    @media(max-width:576px){
      .text-button{
        display:none;
      }
    }
    .color-contenido{
      color: #212529;
    }
    .color-titulo{
      color: #747272;
    }
    .textura-contenido{
      font-weight:300;
      font-size: 16px;
    }
    .vineta::before {
      content: '\2713'; /* Unicode para el check mark */
      font-size: 13px;
      color: green; /* Cambia el color según prefieras */
      margin-right: 8px;
    }
    </style>
  <body>

      <div class="container">

        <div class="row mb-3 mt-3">
          <div class="col-12 btn-group" role="group" aria-label="Basic example">
            <a href="/sisgein/gesman/buscarInforme.php" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0"><i class="bi bi-list-task"></i><span class="text-button"> Informes</span></button>
            </a>
            <a href="/sisgein/gesman/datoGeneral.php" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-pencil-square"></i><span class="text-button"> Editar</span></button>
            </a>
            <a href="#" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-check-square"></i><span class="text-button"> Finalizar</span></button>
            </a>
          </div>
        </div>

        <div class="row border-bottom mb-2 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0 text-secondary">CLIENTE</p>
            <input type="text" class="d-none" id="txtId" value="">
            <p class="m-0 p-0 text-center text-secondary">GP-INF-1</p>
          </div>
        </div>

        <div class="row p-1 mb-0">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">INFORMACIÓN GENERAL</p>
          </div>
        </div>

        <div class="row p-1 mb-2">
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nro. Informe</p> 
            <p class="m-0 p-0 textura-contenido">001</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre Informe</p> 
            <p class="m-0 p-0 textura-contenido">GP-INF-1</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Fecha</p> 
            <p class="m-0 p-0 textura-contenido">17/07/2024</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">OT N°</p> 
            <p class="m-0 p-0 textura-contenido">0101</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre de cliente:</p> 
            <p class="m-0 p-0 textura-contenido">PLANETA DIGITAL</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Contacto</p> 
            <p class="m-0 p-0 textura-contenido">TECH GENIUS STORE</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Lugar</p> 
            <p class="m-0 p-0 textura-contenido">AV. UNIVERSITARIA 5050</p>
          </div>
          <div class="col-6 col-sm-8 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Supervisor</p> 
            <p class="m-0 p-0 textura-contenido">INOCENTE TRANQUILO, BUENANCIO</p>
          </div>

          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">INFORMACIÓN DEL EQUIPO</p>
          </div>

          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre Equipo</p>
            <p class="m-0 p-0 textura-contenido">WORKBOT</p>              
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Modelo Equipo</p> 
            <p class="m-0 p-0 textura-contenido">MODELO CYBER</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Serie Equipo</p> 
            <p class="m-0 p-0 textura-contenido">S-50505050</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Marca Equipo</p> 
            <p class="m-0 p-0 textura-contenido">NIPONES</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Kilometraje</p> 
            <p class="m-0 p-0 textura-contenido">1234.00</p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Horas Motor</p> 
            <p class="m-0 p-0 textura-contenido">23:45:00</p>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Descripción</p>
            <div class="d-flex">
              <span class="vineta"></span>
              <p class="m-0 p-0 textura-contenido" id="description" style="text-align: justify;"> LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
            <div class="d-flex">
              <span class="vineta"></span>
              <p class="m-0 p-0 textura-contenido" id="description" style="text-align: justify;"> LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div> 
          </div>

          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">ACTIVIDADES REALIZADAS</p>
          </div>

          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Antecedentes</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Actividad</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Análisis</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Conclusiones</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Recomendaciones</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. CRAS EU VELIT AT URNA TEMPUS MOLESTIE ET VEL MASSA. MAECENAS VITAE ERAT RHONCUS, SODALES PURUS SED, IACULIS JUSTO.</p>
            </div>
          </div>
          <div class="col-12 col-lg-6 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Estado</p> 
            <p class="m-0 p-0 textura-contenido">UNKNOWN</p>
          </div>            
        </div>

        <div class="col-12 mb-0 border-bottom bg-light"></div>
       
        <div class="row p-1 mb-0">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="m-0 fw-bold">Imágenes</p>
          </div>
        </div>
        
        <div class="row p-2 mb-3">
          <div class="col-12">
            <p class="fst-italic">No hay imágenes asociadas a esta Órden.</p>
          </div>       
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- <script src="../js/vistaPreliminar.js"></script> -->
     <script>
      
      // iniciando
      // document.getElementById('description').value = '\u2022 ';

      document.getElementById('description').value = '+';
      
      document.getElementById('description').addEventListener('input', function(event) {
        console.log(event)
          let textarea = event.target;
          let value = textarea.value;
          let lastChar = value.slice(-1);

          if (lastChar === '.') {
              // Salto de linea al detectar .
              let lines = value.split('\n');
              // Obteniendo la ultima liea
              lines[lines.length - 1] = '\u2022 ' + lines[lines.length - 1];
              // Une la nueva liena
              textarea.value = lines.join('\n');
              // agrega una nueva linea 
              textarea.value += '\n\u2022 ';
          }
      });

     </script>
  </body>
</html>