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

        $stmt2 = $conmy->prepare("select id, ownid, tipo, actividad, diagnostico, trabajos, observaciones from tbldetalleinforme where infid=:InfId;");
        $stmt2->bindParam(':InfId', $Id, PDO::PARAM_INT);
        $stmt2->execute();
        $equipos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $ids = array_map(function($elemento) {
          return $elemento['id'];
        }, $equipos);

        $cadenaIds = implode(',', $ids);
        $imagenes = array();

        $stmt3 = $conmy->prepare("select id, refid, nombre, descripcion, titulo from tblarchivos where refid IN(".$cadenaIds.") and tabla=:Tabla and tipo=:Tipo;");				
        $stmt3->execute(array(':Tabla'=>'INFD', ':Tipo'=>'IMG'));
        while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
          $imagenes[$row3['refid']][] = array(
            'id' => (int)$row3['id'],
            'titulo' => $row3['titulo'],
            'descripcion' => $row3['descripcion'],
            'nombre' => $row3['nombre']
          );
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">

    <title>Sistema GPEM S.A.C</title>
    <style>
      ::placeholder {
        color: #cecccc !important;
        font-weight: 300;
        font-size: 15px;
      }
      .form-label {
        color: #212529;
        font-weight: 300; 
      }
      @media(max-width:767px) {
        .form-label {
          font-size: 13px;
        }
      }
      @media(min-width:768px) {
        .mt--mod {
          margin-top: 17px !important;
        }
      }
      @media(min-width:992px) {
        .form-label {
          font-size: 15px;
        }
      }
      .form-control {
        border-radius: .25rem;
      }
      .btn-control {
        padding: .375rem .75rem;
      }
      .fixed-size-textarea {
        resize: none; /* Evita que el textarea se pueda redimensionar */
      }
      .btn-cerrar {
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: black;
        color: white;
      }
      .contenedor-imagen {
        position: relative;
        border: 1px solid #67646442;
        border-radius: 4px;
        padding: 5px; 
      }
      .caja-imagen {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
        margin-bottom: 5px;
      }
      @media(min-width:992px) {
        .caja-imagen {
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
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtCodEquipo" class="form-label">Código</label>
            <input type="text" class="form-control" id="txtCodEquipo" value="<?php echo htmlspecialchars($Equ_Codigo); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtNombreEquipo" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="txtNombreEquipo" value="<?php echo htmlspecialchars($Equ_Nombre); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtMarcaEquipo" class="form-label">Marca</label>
            <input type="text" class="form-control" id="txtMarcaEquipo" value="<?php echo htmlspecialchars($Equ_Marca); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtModeloEquipo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="txtModeloEquipo" value="<?php echo htmlspecialchars($Equ_Modelo); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtSerieEquipo" class="form-label">Serie</label>
            <input type="text" class="form-control" id="txtSerieEquipo" value="<?php echo htmlspecialchars($Equ_Serie); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtDatosEquipo" class="form-label">Datos</label>
            <input type="text" class="form-control" id="txtDatosEquipo" value="<?php echo htmlspecialchars($Equ_Datos); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtKmEquipo" class="form-label">Km</label>
            <input type="text" class="form-control" id="txtKmEquipo" value="<?php echo htmlspecialchars($Equ_Km); ?>" readonly>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="form-group">
            <label for="txtHmEquipo" class="form-label">Hm</label>
            <input type="text" class="form-control" id="txtHmEquipo" value="<?php echo htmlspecialchars($Equ_Hm); ?>" readonly>
          </div>
        </div>
      </div>
      <hr>

      <!--IMÁGENES-->
      <div class="row">
        <div class="col-12">
          <div class="contenedor-imagen">
            <div class="caja-imagen">
              <?php
                foreach ($imagenes as $refid => $imgs) {
                  foreach ($imgs as $img) {
                    echo '<div class="position-relative">';
                    echo '<img src="/informes/archivos/'.$img['nombre'].'" class="img-fluid rounded" alt="'.$img['titulo'].'" style="max-height: 150px; object-fit: cover;">';
                    echo '<button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="eliminarImagen('.$img['id'].')"><i class="bi bi-x"></i></button>';
                    echo '</div>';
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Modals -->
      <!-- Modal for equipo -->
      <div class="modal fade" id="equipoModal" tabindex="-1" aria-labelledby="equipoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="equipoModalLabel">Editar Equipo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Formulario para editar el equipo -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal for agregar imagen -->
      <div class="modal fade" id="adjuntarImagenModal" tabindex="-1" aria-labelledby="adjuntarImagenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="adjuntarImagenModalLabel">Agregar Imagen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Formulario para agregar imagen -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9Nzm22X8wQK1pucBGT3X25aZcCh4HwhNFP3eu0brjhfF7G0RV2e" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cu7Iei9ZbV91POw+Xgnjrn4xM5O4EZw90Hb27zW1LpMyOUnuBqWmX+Gv6wG1hS1c+" crossorigin="anonymous"></script>
    <script>
      function eliminarImagen(id) {
        if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
          // Implementar la lógica de eliminación aquí
          console.log('Eliminar imagen con ID:', id);
        }
      }
    </script>
  </body>
</html>
