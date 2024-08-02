<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
  require_once 'Datos/InformesData.php';

  $Id =  $_GET['informe'];

  try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_GET['informe'])) {
        $informe  = FnBuscarInformeMatriz($conmy, $Id);
        $archivos = FnBuscarInformesYArchivosPorId($conmy, $Id);
    } 
  } catch (PDOException $e) {
      throw new Exception($e->getMessage());
  } catch (Exception $e) {
      throw new Exception($e->getMessage());
  } finally {
      $conmy = null;
  }
?>
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
    
    <link rel="stylesheet" href="css/main.css">
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
    .textura-contenido-mod{
      width: 15%;
      text-align: center;
      color: #FFFFFF;
      border-radius: 4px;
      padding: 4px 8px !important
    }
    .vineta::before {
      content: '\2713'; /* Unicode para el check mark */
      font-size: 13px;
      color: green; /* Cambia el color según prefieras */
      margin-right: 8px;
    }
    .contenedor-imagen{
        position: relative;
        border: 1px solid #67646442;
        border-radius: 4px;
        padding: 5px; 
      }
      .caja-imagen{

        margin-bottom: 5px;
      }
      @media(min-width:992px){
        .caja-imagen{
          grid-template-columns: 1fr 1fr 1fr 1fr;
        }
      }
    </style>
  <body>

      <div class="container">

        <div class="row mb-3 mt-3">
          <div class="col-12 btn-group" role="group" aria-label="Basic example">
            <a href="/informes/buscarInforme.php" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0"><i class="bi bi-list-task"></i><span class="text-button"> Informes</span></button>
            </a>
            <a href="/informes/datoGeneral.php?informe=<?php echo htmlspecialchars($Id);?>" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-pencil-square"></i><span class="text-button"> Editar</span></button>
            </a>
            <a href="#" class="col-4">
              <button type="button" class="btn btn-outline-primary col-12 fw-bold d-flex flex-column align-items-center" style="border-radius:0; border-left:0"><i class="bi bi-check-square"></i><span class="text-button"> Finalizar</span></button>
            </a>
          </div>
        </div>

        <div class="row">
          <div id="generarInforme" class="col-6 col-lg-2 mt-4 mb-4">
            <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" >Descargar <i class="bi bi-cloud-download"></i></button>
          </div>
        </div>

        <div class="row border-bottom mb-2 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($informe->clinombre); ?></p>
            <input type="text" class="d-none" id="txtId" value="">
            <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($informe->nombre); ?></p>
          </div>
        </div>

        <div class="row p-1 mb-2 mt-2">
          <div class="col-12 mb-0 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">INFORMACIÓN GENERAL</p>
          </div>
        </div>
        <div class="row p-1 mb-2">
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nro. Informe</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->numero); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre Informe</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->nombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Fecha</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->fecha); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">OT N°</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->ordnombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre de cliente:</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->clinombre); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Contacto</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->clicontacto); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Lugar</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->ubicacion); ?></p>
          </div>
          <div class="col-6 col-sm-8 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Supervisor</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->supervisor); ?></p>
          </div>

          <div class="col-12 mb-2 mt-2 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">INFORMACIÓN DEL EQUIPO</p>
          </div>

          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Nombre Equipo</p>
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equnombre); ?></p>              
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Modelo Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equmodelo); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Serie Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equserie); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Marca Equipo</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equmarca); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Kilometraje</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equKm); ?></p>
          </div>
          <div class="col-6 col-sm-4 col-lg-4 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Horas Motor</p> 
            <p class="m-0 p-0 textura-contenido"><?php echo htmlspecialchars($informe->equhm); ?></p>
          </div>
          <div class="col-12 mb-1">
            <p class="m-0 text-secondary" style="font-size: 13px;">Descripción</p>
            <?php foreach($archivos as $archivo): ?>
              <div class="d-flex">
              <p><?php echo htmlspecialchars($archivo['titulo']); ?></p>
              <span class="vineta"></span>
              <p class="m-0 p-0 textura-contenido" id="description" style="text-align: justify;"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="col-12 mb-2 mt-2 border-bottom bg-light">
            <p class="mt-2 mb-2 fw-bold color-titulo">ACTIVIDADES REALIZADAS</p>
          </div>
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Antecedentes</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($informe->antecedentes); ?></p>
            </div>
          </div>
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Actividad</p>
            <?php foreach($archivos as $archivo): ?>
              <div class="d-flex">
                <span class="vineta"></span> 
                <p class="m-0 p-0 textura-contenido" id="actividad" style="text-align: justify;"><?php echo htmlspecialchars($archivo['actividad']); ?></p>
              </div>
              <?php endforeach; ?>
          </div>
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Diagnósticos</p>
            <?php foreach($archivos as $archivo): ?>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($archivo['diagnostico']); ?></p>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Conclusiones</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($informe->conclusiones); ?></p>
            </div>
          </div>
          <div class="col-12 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Recomendaciones</p>
            <div class="d-flex">
              <span class="vineta"></span> 
              <p class="m-0 p-0 textura-contenido" style="text-align: justify;"><?php echo htmlspecialchars($informe->recomendaciones); ?></p>
            </div>
          </div>
          <?php
            $Estado = 1; 
            $EstadoClass = ($Estado == 1) ? 'bg-primary' : ($Estado == 2 ? 'bg-success' : 'bg-danger');
            $EstadoText = ($Estado == 1) ? 'Abierto' : ($Estado == 2 ? 'Cerrado' : 'Anulado');
          ?>
          <div class="col-12 col-lg-6 mb-2 mt-2">
            <p class="m-0 text-secondary" style="font-size: 13px;">Estado</p> 
            <p class="m-0 p-0 textura-contenido textura-contenido-mod <?php echo $EstadoClass; ?>"><?php echo htmlspecialchars($EstadoText); ?></p>
          </div>            
        </div>

        <div class="col-12 mb-0 border-bottom bg-light"></div>
       
        <div class="col-12 mb-0 border-bottom bg-light">
          <p class="mt-2 mb-2 fw-bold color-titulo">IMÁGENES</p>
        </div>
        <div class="row mt-4">
          <!-- ARCHIVOS (TÍTULOS-IMAGENES-DESCRIPCIÓN) -->
          <?php foreach($archivos as $archivo): ?>
            <!-- REFID -->
            <input type="hidden" id="refid" value="<?php echo htmlspecialchars($archivo['refid']); ?>">
            <div class="caja-imagen col-6 col-lg-3" id="<?php echo htmlspecialchars($archivo['archivoid']); ?>">
              <div class="contenedor-imagen">
                <p class="text-center mt-4 mb-1"><?php echo htmlspecialchars($archivo['titulo']); ?></p>
                  <i class="bi bi-x-circle" style="position: absolute; font-size: 23px;color: tomato;top: 40px;left: 5px; top:5px" onclick="fnEliminarImagen(<?php echo htmlspecialchars($archivo['archivoid']); ?>)"></i>
                  <img src="/mycloud/gesman/files/ORD_112_651f18cf9b6de.jpeg" class="img-fluid" alt="">
                <p class="text-center"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="js/vistaPreliminar.js"></script>
  </body>
</html>