<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
    $Id = $_GET['informe'];

    // INICIALIZANDO VARIABLES
    $Ordid = $Equid = $Cliid = $Nombre = $Ord_Nombre = $Cli_Nombre = $Equ_Codigo = $Equ_Nombre = $Equ_Marca = $Equ_Modelo = $Equ_Serie = $Equ_Datos = $Equ_Km = $Equ_Hm = $Estado = '';

    try {
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // CONSULTA 
        $stmt = $conmy->prepare("SELECT id, ordid, equid, cliid, nombre, ord_nombre, cli_nombre, equ_codigo, equ_nombre, equ_marca, equ_modelo, equ_serie, equ_datos, equ_km, equ_hm, estado FROM tblinforme WHERE id=:Id;");
        $stmt->execute(array(':Id' => $Id));
        $row = $stmt->fetch();
        if ($row) {
          $Ordid = $row['ordid'];
          $Equid = $row['equid'];
          $Cliid = $row['cliid'];
          $Nombre = $row['nombre'];
          $Ord_Nombre = $row['ord_nombre'];
          $Cli_Nombre = $row['cli_nombre'];
          $Equ_Codigo = $row['equ_codigo'];
          $Equ_Nombre = $row['equ_nombre'];
          $Equ_Marca = $row['equ_marca'];
          $Equ_Modelo = $row['equ_modelo'];
          $Equ_Serie = $row['equ_serie'];
          $Equ_Datos = $row['equ_datos'];
          $Equ_Km = $row['equ_km'];
          $Equ_Hm = $row['equ_hm'];
          $Estado = $row['estado'];
        }
    } catch (PDOException $ex) {
        $conmy = null;
        echo $ex;
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

    <title>Equipos</title>
    <style>
      ::placeholder{
        color: #cecccc !important;
        font-weight: 300;
        font-size:15px;
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
      .fixed-size-textarea {
        resize: none; /* Evita que el textarea se pueda redimensionar */
      }
      .btn-cerrar{
        position:absolute;
        width: 20px;
        height: 20px;
        background-color: black;
        color: white;
      }
      .contenedor-imagen{
        position: relative;
        border: 1px solid #67646442;
        border-radius: 4px;
        padding: 5px; 
      }
      .caja-imagen{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
        margin-bottom: 5px;
      }
      @media(min-width:992px){
        .caja-imagen{
          grid-template-columns: 1fr 1fr 1fr 1fr;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row border-bottom mb-3 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
              <p class="m-0 p-0"><?php echo htmlspecialchars($Cli_Nombre); ?></p>
              <input type="text" class="d-none" id="txtIdOt" value="" readonly/>
              <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($Nombre); ?></p>
          </div>
      </div>
      <div class="row">
          <div class="col-12">
              <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                  <ol class="breadcrumb">                        
                  <li class="breadcrumb-item fw-bold"><a href="/informes/datoGeneral.php" class="text-decoration-none">INFORME</a></li>
                      <li class="breadcrumb-item active fw-bold" aria-current="page">EQUIPO</li>
                      <li class="breadcrumb-item fw-bold"><a href="/informes/resumen.php" class="text-decoration-none">RESUMEN</a></li>
                      <li class="breadcrumb-item fw-bold"><a href="/informes/actividad.php" class="text-decoration-none">ACTIVIDAD</a></li>
                  </ol>
              </nav>
          </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#equipoModal"><i class="bi bi-pencil-square"></i></button>
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#adjuntarImagenModal"><i class="bi bi-paperclip"></i></button>
        </div>
      </div>
      <hr>

      <!--DATOS EQUIPOS-->
      <div class="row g-3">
        <div class="col-6 col-lg-4 col-xl-3 mt-2">
            <label class="form-label mb-0">Nombre</label>
            <p class="mb-0" style="font-size:15px" id="nombreEquipo"><?php echo htmlspecialchars($Equ_Nombre); ?></p>
        </div>
        <div class="custom-select-container col-6 col-lg-4 col-xl-3 mt-2">
          <label class="form-label mb-0">Modelo</label>
          <p class="mb-0" style="font-size:15px" id="modeloEquipo"><?php echo htmlspecialchars($Equ_Modelo); ?></p>
        </div>
        <div class="col-6 col-lg-4 col-xl-3 mt-2">
          <label class="form-label mb-0">Serie</label>
          <p class="mb-0" style="font-size:15px" id="serieEquipo"><?php echo htmlspecialchars($Equ_Serie); ?></p>
        </div>
        <div class="col-6 col-lg-4 col-xl-3 mt-2">
          <label class="form-label mb-0">Marca</label>
          <p class="mb-0" style="font-size:15px" id="marcaEquipo"><?php echo htmlspecialchars($Equ_Marca); ?></p>
        </div>
        <div class="col-6 col-lg-4 col-xl-3 mt-2">
          <label class="form-label mb-0">Kilometraje</label>
          <p class="mb-0" style="font-size:15px" id="kilometrajeEquipo"><?php echo htmlspecialchars($Equ_Km); ?></p>
        </div>
        <div class="col-6 col-lg-4 col-xl-3 mt-2">
          <label class="form-label mb-0">Horas de motor</label>
          <p class="mb-0" style="font-size:15px" id="horasMotorEquipo"><?php echo htmlspecialchars($Equ_Hm); ?></p>
        </div>
        <div class="caja-imagen col-12" id="5">
          <div class="contenedor-imagen" id="archivo-19">
            <p class="text-center mt-4 mb-1">título 14</p>
              <i class="bi bi-x-circle" style="position: absolute; font-size: 23px;color: tomato;top: 40px;left: 5px; top:5px" onclick="fnEliminarImagen(19)"></i>
              <img src="/mycloud/gesman/files/ORD_112_651f18cf9b6de.jpeg" class="img-fluid" alt="">
            <p class="text-center">Prueba de imagen</p>
          </div>
          <div class="contenedor-imagen" id="archivo-29">
            <p class="text-center mt-4 mb-1">título 19</p>
              <i class="bi bi-x-circle" style="position: absolute; font-size: 23px;color: tomato;top: 40px;left: 5px; top:5px" onclick="fnEliminarImagen(29)"></i>
              <img src="/mycloud/gesman/files/ORD_112_651f18cf9b6de.jpeg" class="img-fluid" alt="">
            <p class="text-center">Imagen 1</p>
          </div>
        </div>
      </div>
    </div>

    <!-- M O D A L   D A T O S  D E  E Q U I P O -->
    <div class="modal fade" id="equipoModal" tabindex="-1" aria-labelledby="equipoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5 text-uppercase" id="equipoModalLabel">Datos del equipo</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!-- START MODAL-BODY -->
          <div class="modal-body" id='modal-body'>
            <div class="row">
              <div class="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Nombre</label>
                <input type="text" name="nombreEquipo" class="form-control" row=3 placeholder="Ingrese nombre de equipo."/>
              </div>
              <div class="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Modelo</label>
                <input type="text" name="modelo" class="form-control" placeholder="Ingrese modelo."/>
              </div>
              <div class="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Serie</label>
                <input type="text" name="serie" class="form-control" placeholder="Ingrese número de serie."/>
              </div>
              <div class ="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Marca</label>
                <input type="text" name="marca" class="form-control" placeholder="Ingrese marca."></textarea>
              </div>
              <div class ="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Kilometraje</label>
                <input type="text" name="kilometraje" class="form-control" placeholder="Ingrese kilometraje."></textarea>
              </div>
              <div class ="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Horas de motor</label>
                <input type="text" name="horasMotor" class="form-control" placeholder="Ingrese horas de motor."></textarea>
              </div>
              <div class ="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Descripcion</label>
                <textarea type="text" name="descripcion" class="form-control" row=3 style="text-align:justify" placeholder="Puede ingresar adicionalmente la fecha de fabricación, número interno, número de padron,tipo de combustible y otros que considere necesario."></textarea>
              </div>

              <div id="contenedorGuardarActividad" class="col-6 mt-4">
                <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12 fw-light">Guardar <i class="bi bi-floppy"></i></button>
              </div>
            </div>
          </div>
          <!-- END MODAL-BODY -->
        </div>
      </div>
    </div><!-- END MODAL -->

    <!-- M O D A L - I M A G E N E S -->
    <div class="modal fade" id="adjuntarImagenModal" tabindex="-1" aria-labelledby="adjuntarImagenLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title text-uppercase" id="adjuntarImagenLabel">Agregar Actividad</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formAdjuntarImagen">
              <div class="col-md-12 mt-2">
                <label for="" class="form-label mb-0">Agregar imagen</label>
                <input name="imagen" class="form-control" type="file">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-uppercase fw-light">Guardar <i class="bi bi-floppy"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="js/datoEquipo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>