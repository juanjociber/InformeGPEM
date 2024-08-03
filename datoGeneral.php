<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
  require_once 'Datos/InformesData.php';

  $Id =  $_GET['informe'];

  try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_GET['informe'])) {
        $informe = FnBuscarInformeMatriz($conmy, $Id);
        $supervisores = FnBuscarSupervisores($conmy,$informe->cliid);
    } 
  } catch (PDOException $e) {
      throw new Exception($e->getMessage());
  } catch (Exception $e) {
      throw new Exception($e->getMessage());
  } finally {
      $conmy = null;
  }

  // VERIFICAR SI EL SUPERVISOR PERTENECE AL CLIENTE
  $supervisorValido = false;
  foreach ($supervisores as $supervisor) {
    if ($supervisor['supervisor'] == $informe->supervisor) {
        $supervisorValido = true;
        break;
    }
  }
  $supervisorInputValue = $supervisorValido ? $informe->supervisor : '';

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Datos Generales</title>
  </head>
  <style>
    ::placeholder{
      color: #cecccc !important;
      font-weight: 300;
      font-size: 15px;
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
      font-size: 15px;
    }
    .btn-control{
      padding:.375rem .75rem;
    }
  </style>
  <body>

    <div class="container">

      <div class="row border-bottom mb-3 fs-5">
        <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($informe->clinombre); ?></p>
            <input type="text" class="d-none" id="txtIdOt" value="<?php echo htmlspecialchars($informe->id); ?>" readonly/>
            <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($informe->nombre); ?></p>
        </div>
      </div>
      <!-- ENLACES -->
      <div class="row">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">                        
                    <li class="breadcrumb-item active fw-bold" aria-current="page">INFORME</li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/datoEquipo.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">EQUIPO</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/resumen.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">RESUMEN</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/actividad.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">ACTIVIDAD</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/anexos.php" class="text-decoration-none">ANEXOS</a></li>
                </ol>
            </nav>
        </div>
      </div>

      <!--DATOS GENERALES-->
      <div class="row g-3">
        
        <input type="hidden" id="idInforme" value="<?php echo htmlspecialchars($Id) ?>">

        <div class="col-6 col-md-4 col-lg-4">
          <label for="nombreInformeInput" class="form-label mb-0">Nro. Informe</label>
          <input type="text" class="form-control" id="nombreInformeInput" value="<?php echo htmlspecialchars($informe->nombre); ?>" disabled>
        </div>
        <div class="col-6 col-md-4 col-lg-4">
          <label for="fechaInformeInput" class="form-label mb-0">Fecha</label>
          <input type="date" class="form-control" id="fechaInformeInput" value="<?php echo htmlspecialchars($informe->fecha); ?>">
        </div>
        <div class="col-6 col-md-4 col-lg-4 mt-2 mt--mod">
          <label for="OrdenTrabajoInput" class="form-label mb-0">Orden de trabajo</label>
          <input type="text" class="form-control" id="OrdenTrabajoInput" value="<?php echo htmlspecialchars($informe->ordnombre); ?>" disabled>
        </div>
        <div class="col-6 col-md-6 col-lg-6 mt-2">
          <label for="nombreClienteInput" class="form-label mb-0">Cliente</label>
          <input type="text" class="form-control" id="nombreClienteInput" value="<?php echo htmlspecialchars($informe->clinombre); ?>" disabled>
        </div>
        
        <div class="custom-select-container col-md-6 col-lg-6 mt-2">
          <label for="contactoInput" class="form-label mb-0">Contacto</label>
          <div class="custom-select-wrapper">
            <input type="text" id="contactoInput" class="custom-select-input" value="<?php echo htmlspecialchars($informe->clicontacto); ?>" placeholder="Seleccionar contacto" />
            <span class="custom-select-arrow"><i class="bi bi-chevron-down"></i></span>
            <div id="contactoList" class="custom-select-list">
              <!-- CONTACTOS -->
              <?php foreach ($supervisores as $supervisor): ?>
                <div class="custom-select-item" data-value="<?php echo htmlspecialchars($supervisor['idsupervisor']); ?>">
                  <?php echo htmlspecialchars($supervisor['supervisor']); ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-6 mt-2">
          <label for="ubicacionInput" class="form-label mb-0">Lugar</label>
          <input type="text" class="form-control" id="ubicacionInput" value="<?php echo htmlspecialchars($informe->ubicacion); ?>" placeholder="Ingresar lugar">
        </div>      
        
        <div class="custom-select-container col-md-6 col-lg-6 mt-2">
          <label for="supervisorInput" class="form-label mb-0">Supervisor</label>
          <div class="custom-select-wrapper">
            <input type="text" class="custom-select-input" id="supervisorInput" value="<?php echo  htmlspecialchars($supervisorInputValue);?>" placeholder="Seleccionar supervisor" />
            <span class="custom-select-arrow"><i class="bi bi-chevron-down"></i></span>
            <div id="supervisorList" class="custom-select-list">
              <!-- SUPERVISORES -->
              <?php foreach ($supervisores as $supervisor): ?>
                <div class="custom-select-item" data-value="<?php echo htmlspecialchars($supervisor['idsupervisor']); ?>">
                  <?php echo htmlspecialchars($supervisor['supervisor']); ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        
      </div>  

      <div class="row mt-4">
        <div class="col-6 col-md-3 col-lg-2 mt-2">
          <button id="guardarDataEquipo" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick="fnGuardarDatosGenerales()" >Guardar <i class="bi bi-floppy"></i></button>
        </div>
      </div> 

    </div>
    <script src="js/datoGeneral.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzW7S6U7h6C7Ll5/oqb5yiFTRHlFxB4OlF9AMMXNR9hl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cu6U7+UzTQpS3/6TLAJ+8HXTFM3zUddWkaSbYfR6wv4l/5EXp7XKVI1LG6J9D2Bg" crossorigin="anonymous"></script>
  </body>
</html>
