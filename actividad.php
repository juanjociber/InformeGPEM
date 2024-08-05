<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/informes/gesman/connection/ConnGesmanDb.php";
	$Id=$_GET['informe'];
	$Nombre='';
	$Estado=0;

	$clsHide=' d-none';
	$tablaHTML ='';

	function construirArbol($registros, $padreId = 0) {
		$arbol = array();
		foreach ($registros as $registro) {
			if ($registro['ownid'] == $padreId) {
				$hijos = construirArbol($registros, $registro['id']);
				if (!empty($hijos)) {
					$registro['hijos'] = $hijos;
				}					
				$arbol[] = $registro;
			}
		}			
		return $arbol;
	}

	function FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide, $nivel = 0, $indice ='1') {
		$html='';
		$contador=1;		

		foreach ($arbol as $key=>$nodo) {
      //ASIGNANDO VALOR A NODOGLOBAL
			$indiceActual = $nivel==0?$contador++:$indice.'.'.($key+1);
			$html.='<div class="accordion-item" id="'.$nodo['id'].'">';
			$html.='
				<h2 class="accordion-header" id="accordion-header-'.$nodo['id'].'">
          <div class="cabecera">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-accordion-'.$nodo['id'].'" aria-expanded="true" aria-controls="collapse-accordion-'.$contador.'">
						'.$indiceActual.' - '.$nodo['actividad'].'
            </button>
            <div class="accordion-botones">
              <i class="bi bi-plus-lg icono" onclick="fnCrearSubActividad('.$nodo['id'].')"></i>
              <i class="bi bi-pencil-square icono" onclick="fnEditarActividad('.$nodo['id'].')"></i>
              <i class="bi bi-paperclip icono" onclick="fnAbrirModalRegistrarImagen('.$nodo['id'].')"></i>
              <i class="bi bi-trash3 icono" onclick="fnEliminarActividad('.$nodo['id'].')"></i>
            </div>
          </div>
				</h2>
				<div id="collapse-accordion-'.$nodo['id'].'" class="accordion-collapse collapse show" aria-labelledby="accordion-header-'.$nodo['id'].'">
					<div class="accordion-body">
						<div class="row">
							<div class="col-6">
                <label class="form-label mb-0">Diagnóstico</label>
                <p class="mb-1 text-secondary text-uppercase fw-bold" style="font-size=15px" id="diagnostico-'.$nodo['id'].'">'.$nodo['diagnostico'].'</p>
              </div>
							<div class="col-6">
                <label class="form-label mb-0">Trabajos</label>
                <p class="mb-1 text-secondary text-uppercase fw-bold" style="font-size=15px" id="trabajo-'.$nodo['id'].'">'.$nodo['trabajos'].'</p>
              </div>
							<div class="col-12">
                <label class="form-label mb-0">Observaciones</label>
                <p class="mb-1 text-secondary text-uppercase fw-bold" style="font-size=15px" id="observacion-'.$nodo['id'].'">'.$nodo['observaciones'].'</p>
              </div>
						</div>
						<div class="row m-0 mt-2 mb-2 p-0 d-flex justify-content-evenly" id="'.$nodo['id'].'">';
							if(isset($imagenes[$nodo['id']])){
								foreach($imagenes[$nodo['id']] as $elemento){
									$html.='
                    <div class="col-5 col-lg-4 col-xl-3 border border-secondary border-opacity-50 position-relative" id="archivo-'.$elemento['id'].'">
                      <p class="text-center mt-4 mb-1 text-secondary text-uppercase fw-bold">'.$elemento['titulo'].'</p>
                        <i class="bi bi-x-lg" style="position: absolute; font-size: 23px;color: tomato;top: 40px;left: 5px; top:5px" onclick="fnEliminarImagen('.$elemento['id'].')"></i>
                        <img src="/mycloud/gesman/files/'.$elemento['nombre'].'" class="img-fluid" alt="">
                      <p class="text-center text-secondary text-uppercase fw-bold">'.$elemento['descripcion'].'</p>
                    </div>';
								}
							}
						$html.='</div>';
			if (!empty($nodo['hijos'])) {
				$html.='<div class="accordion" id="accordion-container-'.$nodo['id'].'">';
				$html.=FnGenerarInformeHtmlAcordeon($nodo['hijos'], $imagenes, $nivel+1, $indiceActual, $clsHide);
				$html.='</div>';
			}
			$html.='</div>';
			$html.='</div>';
			$html.='</div>';
		}
		return $html;
	}

	function FnGenerarInformeHtml($arbol, $imagenes, $nivel = 0, $indice ='1') {
		$html='<table width="100%" style="border: #b2b2b2 1px solid">';
		$contador=1;		

		foreach ($arbol as $key=>$nodo) {
			$indiceActual = $nivel==0?$contador++:$indice.'.'.($key+1);
			$html.='<tr><td colspan="2" style="border: red 1px solid">'.$indiceActual.' - '.$nodo['actividad'].'</td></tr>';
			
			$imagen=array();
			if(isset($imagenes[$nodo['id']])){
				$html.='<tr><td><table width="100%" style="border: #b2b2b2 1px solid; color:red">';
				$i=1;
				foreach($imagenes[$nodo['id']] as $elemento){
					if($i==2){
						$html.='<td style="border: black 1px solid">'.$elemento['nombre'].'</td></tr>';
						$i=1;
					}else{
						$html.='<tr><td style="border: black 1px solid">'.$elemento['nombre'].'</td>';
						$i+=1;
					}
				}
				if($i==2){$html.='</tr>';}
				$html.='</table></td></tr>';
			}			
			if (!empty($nodo['hijos'])) {
				$html.='<tr><td colspan="2" style="border: blue 1px solid">';
				$html.=FnGenerarInformeHtml($nodo['hijos'], $imagenes, $nivel+1, $indiceActual);
				$html.='</td></tr>';
			}
		}
		$html.='</table>';
		return $html;
	}

	try{
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select id, nombre, cli_nombre, estado  from tblinforme where id=:Id;");
		$stmt->execute(array(':Id'=>$Id));
		$row=$stmt->fetch();
		if($row){
			$Id = $row['id'];
			$Nombre = $row['nombre'];
			$Estado = $row['estado'];
      $ClienteNombre = $row['cli_nombre'];
		}
		if($Estado==2){$clsHide='';}

		$stmt2 = $conmy->prepare("select id, ownid, tipo, actividad, diagnostico, trabajos, observaciones from tbldetalleinforme where infid=:InfId;");
		$stmt2->bindParam(':InfId', $Id, PDO::PARAM_INT);
		$stmt2->execute();
		$actividades = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		$arbol = construirArbol($actividades);

		$ids = array_map(function($elemento) {
			return $elemento['id'];
		}, $actividades);

		$cadenaIds = implode(',', $ids);
		$imagenes=array();

		$stmt3 = $conmy->prepare("select id, refid, nombre, descripcion, titulo from tblarchivos where refid IN(".$cadenaIds.") and tabla=:Tabla and tipo=:Tipo;");				
		$stmt3->execute(array(':Tabla'=>'INFD', ':Tipo'=>'IMG'));
		while($row3=$stmt3->fetch(PDO::FETCH_ASSOC)){
			$imagenes[$row3['refid']][]=array(
				'id'=>(int)$row3['id'],
				'nombre'=>$row3['nombre'],
				'descripcion'=>$row3['descripcion'],
        'titulo'=>$row3['titulo'],
			);
		}
		$tablaHTML.='<div class="accordion" id="accordion-container-'.$nodo['id'].'">';
			$tabla=FnGenerarInformeHtmlAcordeon($arbol, $imagenes, $clsHide);
			$tablaHTML .=$tabla;
		$tablaHTML.='</div>';
		//echo $tablaHTML ;
	}catch(PDOException $ex){
		$conmy=null;
		echo $ex;
	};
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/main.css">
	<title>Document</title>
  <style>
      html{
        box-sizing: border-box;
      }
      img{
        width: 100%;
      }
      ::placeholder{
        color: #cecccc !important;
        font-weight: 300;
        font-size:15px;
      }
      .form-label{
        color:#212529;
        font-weight:300; 
      }
      .accordion-body{
        padding-right: 0px;
        padding-left: 10px;
      }
      .accordion-header{
        position: relative;
      }
      .accordion-button::after{
        width: 0;
      }
      .accordion-botones{
        position:absolute;
        top:5px;
        right: 0;
        z-index: 1000;
        display:flex;
      }
      .accordion-botones i{
        font-size:20px;
        margin-right: 1rem;
        cursor: pointer;
      }
      #canvas{
        width: 100%;
      }
    </style>
</head>
<body>
  <input type="hidden" id="idInforme" value="<?php echo htmlspecialchars($Id); ?>">
	<div class="container">
      <div class="row border-bottom mb-3 fs-5">
        <div class="col-12 fw-bold d-flex justify-content-between">
          <p class="m-0 p-0 text-secondary"><?php echo htmlspecialchars($ClienteNombre); ?></p>
            <input type="text" class="d-none" value="" readonly/>
          <p class="m-0 p-0 text-center text-secondary"><?php echo htmlspecialchars($Nombre); ?></p>
        </div>
      </div>
    <div class="row">
      <div class="col-12">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item fw-bold"><a href="/informes/datoGeneral.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">INFORME</a></li>
            <li class="breadcrumb-item fw-bold"><a href="/informes/datoEquipo.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">EQUIPO</a></li>
            <li class="breadcrumb-item fw-bold"><a href="/informes/resumen.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">RESUMEN</a></li>
            <li class="breadcrumb-item active fw-bold" aria-current="page">ACTIVIDAD</li>
            <li class="breadcrumb-item fw-bold"><a href="/informes/anexos.php?informe=<?php echo htmlspecialchars($Id) ?>" class="text-decoration-none">ANEXOS</a></li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row mb-1 border-bottom">
      <div class="col-5 col-lg-2 mb-2">
          <button type="button" class="btn btn-outline-primary form-control text-uppercase" data-bs-toggle="modal" data-bs-target="#modalNuevaActividad"><i class="bi bi-plus-lg"></i> Agregar</button>
      </div>
    </div>    

		<div class="row">
			<div class="col-12">
        <?php
          echo $tablaHTML;
        ?>
      </div>
		</div>

    <!-- START AGREGAR ACTIVIDAD - M O D A L -->
    <div class="modal fade" id="modalNuevaActividad" tabindex="-1" aria-labelledby="modalNuevaActividadLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5 text-uppercase" id="modalNuevaActividadLabel">Crear Actividad</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="guardarActividadInput" value="<?php echo $Id ?>">
            <div class="row">
              <div class="col-12">
                <label for="guardarNombreActividadInput" class="form-label mb-0">Nombre de la Actividad</label>
                <textarea type="text" name="actividad" class="form-control" id="guardarNombreActividadInput" row=3 placeholder="Ingresar nombre de actividad."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarDiagnosticoInput" class="form-label mb-0">Diagnóstico</label>
                <textarea type="text" name="diagnostico" class="form-control" ro=3 id="guardarDiagnosticoInput" placeholder="Ingresar diagnositico."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarTrabajoInput" class="form-label mb-0">Trabajos</label>
                <textarea type="text" name="trabajo" class="form-control" id="guardarTrabajoInput" row=3 placeholder="Ingresar diagnositico."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarObservacionInput" class="form-label mb-0">Observación</label>
                <textarea type="text" name="observacion" class="form-control" id="guardarObservacionInput" row=3 placeholder="Ingresar observación."></textarea>
              </div>
              <div class="col-6 col-lg-3 mt-2">
                <button id="guardarActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick="fnCrearActividad()" ><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- END GUARDAR ACTIVIDAD - M O D A L -->

    <!-- START AGREGAR SUBACTIVIDAD - M O D A L -->
    <div class="modal fade" id="modalNuevaSubActividad" tabindex="-1" aria-labelledby="modalNuevaSubActividadLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5 text-uppercase" id="modalNuevaSubActividadLabel">Crear SubActividad</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="guardarSubActividadInput" value="<?php echo $Id ?>">
            <input type="hidden" id="cabeceraIdInput">
            <div class="row">
              <div class="col-12">
                <label for="guardarNombreSubActividadInput" class="form-label mb-0">Nombre de la Actividad</label>
                <textarea type="text" name="actividad" class="form-control" id="guardarNombreSubActividadInput" row=3 placeholder="Ingresar nombre de subactividad."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarDiagnosticoSubActividad" class="form-label mb-0">Diagnóstico</label>
                <textarea type="text" name="diagnostico" class="form-control" ro=3 id="guardarDiagnosticoSubActividadInput" placeholder="Ingresar diagnositico."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarTrabajoSubActividadInput" class="form-label mb-0">Trabajos</label>
                <textarea type="text" name="trabajo" class="form-control" id="guardarTrabajoSubActividadInput" row=3 placeholder="Ingresar diagnositico."></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="guardarObservacionSubActividadInput" class="form-label mb-0">Observación</label>
                <textarea type="text" name="observacion" class="form-control" id="guardarObservacionSubActividadInput" row=3 placeholder="Ingresar observación."></textarea>
              </div>
              <div class="col-6 mt-2">
                <button id="guardarSubActividad" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick="fnGuardarSubActividad()" ><i class="bi bi-floppy"></i> Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- END GUARDAR ACTIVIDAD - M O D A L -->

    <!-- START EDITAR ACTIVIDAD - M O D A L -->
    <div class="modal fade" id="modalEditarActividad" tabindex="-1" aria-labelledby="modalEditarActividadLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5 text-uppercase" id="modalEditarActividadLabel">Editar Actividad</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editarActividadInput">
            <div class="row">
              <div class="col-12">
                <label for="editarNombreActividadInput" class="form-label mb-0">Nombre de la Actividad</label>
                <textarea type="text" name="actividad" class="form-control" id="editarNombreActividadInput" row=3></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="editarDiagnosticoInput" class="form-label mb-0">Diagnóstico</label>
                <textarea type="text" name="diagnostico" class="form-control" ro=3 id="editarDiagnosticoInput"></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="editarTrabajoInput" class="form-label mb-0">Trabajos</label>
                <textarea type="text" name="trabajo" class="form-control" id="editarTrabajoInput" row=3></textarea>
              </div>
              <div class="col-12 mt-2">
                <label for="editarObservacionInput" class="form-label mb-0">Observación</label>
                <textarea type="text" name="observacion" class="form-control" id="editarObservacionInput" row=3></textarea>
              </div>
              <div class="col-6 mt-2">
                <button id="editarActividadBtn" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick="FnModificarActividad()"><i class="bi bi-pencil-square"></i> Editar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- END EDITAR ACTIVIDAD - M O D A L -->

    <!-- START IMAGENES - M O D A L -->
    <div class="modal fade" id="modalAgregarImagen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable ">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5 text-uppercase" id="modalAgregarImagenLabel">Agregar Imagen </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pb-1">
          <input type="hidden" id="cabeceraIdInput">
            <div class="row">
              <div class="col-12 mb-2">
                <label class="form-label mb-0">Título</label>
                <input type="text" class="form-control" id="txtTitulo">
              </div>
              <div class="col-12 mb-2">
                <label class="form-label mb-0">Descripción</label>
                <input type="text" class="form-control" id="txtDescripcion">
              </div>                        
              <div class="col-12">
                <label for="adjuntarImagenInput" class="form-label mb-0">Imagen</label>
                <input id="fileImagen" type="file" accept="image/*,.pdf" class="form-control mb-2"/>
              </div>
              <div class="col-12 m-0">
                  <div class="col-md-12 text-center" id="divImagen"><i class="fas fa-images fs-2"></i></div>
              </div>
            </div>
          </div>
          <div id="msjAgregarImagen" class="modal-body pt-1"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-uppercase pt-2 pb-2 col-12" onclick="FnAgregarImagen(); return false;"><i class="bi bi-floppy"></i>  Guardar</button>
          </div>
        </div>
      </div>
    </div><!-- END IMAGENES - M O D A L -->
	</div>

  <div class="container-loader-full">
    <div class="loader-full"></div>
  </div>

</body>
  <!-- <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script> -->
  <script src="js/actividad.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</html>