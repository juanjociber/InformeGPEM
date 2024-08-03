<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
  require_once 'Datos/InformesData.php';

  $Id =  $_GET['informe'];

  try {
    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_GET['informe'])) {
        $informe  = FnBuscarInformeMatriz($conmy, $Id);
    } 

    $stmt2 = $conmy->prepare("select id, ownid, tipo, actividad, diagnostico, trabajos, observaciones from tbldetalleinforme where infid=:InfId;");
		$stmt2->bindParam(':InfId', $Id, PDO::PARAM_INT);
		$stmt2->execute();
		$datos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		$conclusiones=array();
		$recomendaciones=array();
		$antecedentes=array();

		foreach($datos as $dato){
			if($dato['tipo']=='con'){
				$conclusiones[]=array('actividad'=>$dato['actividad']);
			}else if($dato['tipo']=='rec'){
				$recomendaciones[]=array('actividad'=>$dato['actividad']);
			}else if($dato['tipo']=='ant'){
				$antecedentes[]=array('actividad'=>$dato['actividad']);
			}	
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Resumen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
      ::placeholder {
        color: #cecccc !important;
        font-weight: 300;
        font-size: 15px;
        /* text-transform: uppercase; */
      }
      .form-label {
        color: #212529;
        font-weight: 700;
        padding-right: 0.5rem;
        margin-bottom: 0;
        text-transform: uppercase;
      }
      .form-label i {
        font-size: 18px;
        cursor: pointer;
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
      @media(min-width:92px) {
        .form-label {
          font-size: 15px;
        }
      }
      .form-control {
        border-radius: .25rem;
        font-weight:300;
      }
      .btn-control {
        padding: .375rem .75rem;
      }
      .fixed-size-textarea {
        resize: none; /* Evita que el textarea se pueda redimensionar */
      }
      .input-group-text{
        background-color: transparent;
        border: none;
      }
      .input-group{
        display: grid;
        grid-template-columns: 80% 20%;
        align-items: center;
        border-radius: 4px;
      }
      .input-group p{
        font-weight: 300;
      }
      .input-grop-icons{
        display: flex;
        justify-content: flex-end;
      }
      .vineta::before {
        content: '\2713'; 
        font-size: 13px;
        color: green; 
        margin-right: 8px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row border-bottom mb-3 fs-5">
          <div class="col-12 fw-bold d-flex justify-content-between">
              <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($informe->clinombre); ?></p>
              <input type="text" class="d-none" id="txtIdInforme" value="<?php echo htmlspecialchars($informe->id); ?>" readonly/>
              <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($informe->nombre); ?></p>
          </div>
      </div>
      <div class="row">
          <div class="col-12">
              <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item fw-bold"><a href="/informes/datoGeneral.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">INFORME</a></li>
                      <li class="breadcrumb-item fw-bold"><a href="/informes/datoEquipo.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">EQUIPO</a></li>
                      <li class="breadcrumb-item active fw-bold" aria-current="page">RESUMEN</li>
                      <li class="breadcrumb-item fw-bold"><a href="/informes/actividad.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">ACTIVIDAD</a></li>
                      <li class="breadcrumb-item fw-bold"><a href="/informes/anexos.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">ANEXOS</a></li>
                  </ol>
              </nav>
          </div>
      </div>

      <!--RESUMEN-->
      <div class="row">
        <div class="col-12 mt-2" id="containerActividad" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
          <label class="form-label">Actividades</i></label>
          <!-- ITEM ACTIVIDADES -->
          <div class="input-group mt-1" data-id="actividadId">
            <p class="mb-0" id="actividadId" style="text-align: justify;"><?php echo htmlspecialchars($informe->actividad); ?></p>
            <div class="input-grop-icons">
              <span class="input-group-text"><i class="bi bi-pencil-square" onclick="fnEditarActividad(<?php echo htmlspecialchars($informe->id); ?>)"></i></span>
            </div>
          </div>
        </div>

        <!-- ITEM ANTECEDENTES -->
        <div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
          <label class="form-label">Antecedentes <i class="bi bi-plus-lg" onclick="abrirModalAgregar()"></i></label>
          <div class="input-group mt-1">
            <?php foreach($antecedentes as $antecedente) : ?>
            <div class="d-flex">
              <span class="vineta"></span>
              <p class="mb-0" id="antecedenteId" style="text-align: justify;"><?php echo htmlspecialchars($antecedente['actividad']); ?></p>
            </div>
            <div class="input-grop-icons">
              <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar()"></i></span>
              <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar()"></i></span>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <!-- ITEM CONCLUSION -->
        <div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
          <label class="form-label">Conclusiones <i class="bi bi-plus-lg" onclick="abrirModalAgregar()()"></i></label>
          <div class="input-group mt-1">
            <?php foreach($conclusiones as $conclusion) : ?>
            <div class="d-flex">
              <span class="vineta"></span>
              <p class="mb-0" id="conclusionId" style="text-align: justify;"><?php echo htmlspecialchars($conclusion['actividad']); ?></p>
            </div>
            <div class="input-grop-icons">
              <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar()()"></i></span>
              <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar()()"></i></span>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <!-- ITEM RECOMENDACIÓN -->
        <div class="col-12 mt-2" style="border: 0.5px solid #0000005e; padding: 1px 8px 9px 8px; border-radius: 4px;">
          <label class="form-label">Recomendaciones <i class="bi bi-plus-lg" onclick="abrirModalAgregar()()"></i></label>
          <div class="input-group mt-1">
            <?php foreach($recomendaciones as $recomendacion) :?>
            <div class="d-flex">
              <span class="vineta"></span>
              <p class="mb-0" id="recomendacionId" style="text-align: justify;"><?php echo htmlspecialchars($recomendacion['actividad']); ?></p>
            </div>
            <div class="input-grop-icons">
              <span class="input-group-text"><i class="bi bi-pencil-square" onclick="abrirModalEditar()"></i></span>
              <span class="input-group-text"><i class="bi bi-trash3" onclick="abrirModalEliminar()"></i></span>
            </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>

    <!-- M O D A L E S -->
    <!-- ACTIVIDAD -->
    <div class="modal fade" id="modalEditarActividad" tabindex="-1" aria-labelledby="modalActividadLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title text-uppercase" id="modalActividadLabel">Modificar Actividad</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formActividad">
              <textarea type="text" class="form-control" id="editarActividadInput" name="actividad" row=3 placeholder="Ingresar nueva ctividad"></textarea>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-uppercase fw-light" onclick="FnModificarActividad()"><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- ANTECEDENTE -->
    <div class="modal fade" id="modalAntecedente" tabindex="-1" aria-labelledby="modalAntecedenteLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title text-uppercase" id="modalAntecedenteLabel">Agregar Antecedente</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formAntecedente">
              <textarea type="text" class="form-control" id="modalAntecedenteInput" name="antecedente" row=3 placeholder="Ingresar nuevo antecedente"></textarea>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-uppercase fw-light" onclick="FnAgregarAntecedente();"><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- CONCLUSIÓN -->
    <div class="modal fade" id="modalConclusion" tabindex="-1" aria-labelledby="modalConclusionLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title text-uppercase" id="modalConclusionLabel">Agregar Conclusión</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formConclusion">
              <textarea type="text" class="form-control" id="modalConclusionInput" name="conclusion" row=3 placeholder="Ingresar nueva conclusión"></textarea>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-uppercase fw-light" onclick="FnAgregarConclusion();"><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- RECOMENDACIÓN -->
    <div class="modal fade" id="modalRecomendacion" tabindex="-1" aria-labelledby="modalRecomendacionLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title text-uppercase" id="modalRecomendacionLabel">Agregar Recomendación</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formRecomendacion">
              <textarea type="text" class="form-control" id="modalRecomendacionInput" name="recomendacion" placeholder="Ingresar nueva recomendación"></textarea>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary text-uppercase fw-light" onclick="FnAgregarRecomendacion();"><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="js/resumen.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  </body>
</html>
