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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-DOXMLfHhQkvFFp+rWTZwVlPVqdIhpDVYT9csOnHSgWQWPX0v5MCGtjCJbY6ERspU" crossorigin="anonymous">
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
    .contenedor-imagen{
      position: relative;
      border: 1px solid #67646442;
      border-radius: 4px;
      padding: 5px; 
    }
    .caja-imagen{
      margin-bottom: 5px;
    }
  </style>
  <body>

    <div class="container">

      <div class="row border-bottom mb-3 fs-5">
        <div class="col-12 fw-bold d-flex justify-content-between">
            <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($informe->clinombre); ?></p>
            <input type="text" class="d-none" id="txtIdInforme" value="<?php echo htmlspecialchars($informe->id); ?>" readonly/>
            <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($informe->nombre); ?></p>
        </div>
      </div>
      <!-- ENLACES -->
      <div class="row">
        <div class="col-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">                        
                    <li class="breadcrumb-item fw-bold"><a href="/informes/datoGeneral.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">INFORME</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/datoEquipo.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">EQUIPO</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/resumen.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">RESUMEN</a></li>
                    <li class="breadcrumb-item fw-bold"><a href="/informes/actividad.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">ACTIVIDAD</a></li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page">ANEXOS</li>
                </ol>
            </nav>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header bg-primary"><h5 class="card-title text-white">ANEXOS</h5></div>
        <div class="card-body">

          <div class="row">

            <label for="adjuntarImagenInput" class="form-label mb-0">Ingresar archivo</label>
            <div class="col-6 col-lg-2 mt-2">
              <button id="descripcion" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" data-bs-toggle="modal" data-bs-target="#modalArchivo"><i class="bi bi-paperclip"></i> Agregar</button>
            </div>
          </div>

        </div>
      </div>

      <!-- M O D A L - I M A G E N E S -->
      <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivoLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title fs-5 text-uppercase" id="modalArchivoLabel">Agregar Anexo</h5>
              <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <input type="hidden" id="cabeceraIdInput">
              <div class="row">
                <div class ="col-md-12 mt-2">
                  <label for="registrarTituloInput" class="form-label mb-0">Título</label>
                  <input name="titulo" type="text" class="form-control" id="tituloInput" placeholder="Ingresar título.">
                </div>
                <div class="col-md-12 mt-2">
                  <label for="adjuntarImagenInput" class="form-label mb-0">Imagen</label>
                  <input name="archivo" class="form-control" type="file" id="anexoInput">
                </div>
                <div class ="col-md-12 mt-2">
                  <label for="registarDescripcionInput" class="form-label mb-0">Descripción</label>
                  <textarea type="descripcion1" name="titulo1" class="form-control" row=3 id="descripcionInput" placeholder="Ingresar título."></textarea>
                </div>
                <div id="contenedorGuardarActividad" class="col-6 mt-4">
                  <button id="descripcion" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" style="font-weight:200;" onclick="fnRegistrarAnexo()"><i class="bi bi-floppy"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- END IMAGENES - M O D A L -->


      <div class="row">
        <?php foreach($archivos as $archivo): ?>
          <input type="hidden" id="refid" value="<?php echo htmlspecialchars($archivo['refid']); ?>">
          <div class="caja-imagen col-6 col-lg-3" id="<?php echo htmlspecialchars($archivo['archivoid']); ?>">
            <div class="contenedor-imagen">
              <p class="text-center mt-4 mb-1"><?php echo htmlspecialchars($archivo['titulo']); ?></p>
                <i class="bi bi-x-lg" style="position: absolute; font-size: 23px;color: tomato;top: 40px;left: 5px; top:5px" onclick="fnEliminarAnexo(<?php echo htmlspecialchars($archivo['archivoid']); ?>)"></i>
                <img src="/mycloud/gesman/files/ORD_112_651f18cf9b6de.jpeg" class="img-fluid" alt="">
              <p class="text-center"><?php echo htmlspecialchars($archivo['descripcion']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="js/anexo.js"></script>

  </body>
</html>
